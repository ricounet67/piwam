<?php

/**
 * Login actions.
 *
 * @package    piwam
 * @subpackage login
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class BaseloginActions extends sfActions
{
  /**
   * Should be set as default HOMEPAGE in your routing.yml
   * 
   * Login action. This is the default action if we are not authenticated.
   * If we can't perform the Propel operations, we consider the database
   * settings are not correct and we redirect to /install automatically
   * We redirect to 'another homepage' if user is already authenticated
   *
   * @param   sfWebRequest $request
   * @todo    Manage cookies
   */
  public function executeLogin(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
      $this->redirect('@member_show?id=' . $this->getUser()->getUserId());
    }
    
    if (! PiwamOperations::isInstalled())
    {
      $this->redirect('@setup');
    }

    $this->displayCreateAssociationLink = $this->_canRegisterAnotherAssociation();
    $this->displayUserRegisterLink = sfConfig::get('app_anonymous_can_register',false);
    $this->numberOfAssociations = AssociationTable::doCount();
    $this->form = new LoginForm();

    if (MemberTable::doCount() == 0)
    {
      $this->redirect('@association_new');
    }

    if ($this->numberOfAssociations === 1)
    {
      $this->association = AssociationTable::getUnique();
    }

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('login'));
      $login = $request->getParameter('login');

      if ($this->form->isValid())
      {
        $username = $login['username'];
        $password = $login['password'];
        $user = MemberTable::getByUsername($username);

        if($user == null)
        {
            $this->getUser()->setFlash('error', "Le nom d'utilisateur est invalide", false);         
        }
        else if(!$user->isActive())
        {
          $this->getUser()->setFlash('error', "Votre compte est désactivé", false);
        }
        else if ($user->getUserGuard()->checkPassword($password))
        {
          $this->getUser()->login($user);

          // Unused cookie, fake value is set
          $this->getResponse()->setCookie(myUser::COOKIE_NAME, '1', time() + 60 * 60 * 24 * 15, '/');

          if (! $request->getCookie(myUser::COOKIE_NAME))
          {
            $this->getUser()->setFlash('error', 'Les cookies doivent être activés');
          }

          if ($this->getUser()->hasCredential('list_member'))
          {
            $this->redirect('@members_list');
          }
          else
          {
            $this->redirect('@member_show?id=' . $user->getId());
          }
        }
        else
        {
          $this->getUser()->setFlash('error', "Le mot de passe est invalide", false);
        }
      }
    }

    $this->setLayout(false);
  }

  /**
   * Logout action. Redirect to homepage once credentials and cookies
   * have been removed.
   *
   * @param   sfWebRequest  $request
   * @since   r7
   */
  public function executeLogout(sfWebRequest $request)
  {
    $this->getUser()->logout();
    $this->getUser()->setFlash('notice','Déconnexion effectuée');
    $this->redirect('@homepage');
  }

  /**
   * Allows an user to retrieve a forget password. Set flash message if user
   * does not exist or if password has been set correctly
   *
   * @param   sfWebRequest    $request
   */
  public function executeForgottenpassword(sfWebRequest $request)
  {
    $this->form = new ForgottenPasswordForm();
    $this->displayRegisterLink = $this->_canRegisterAnotherAssociation();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('password'));
      $values = $request->getParameter('password');

      if ($this->form->isValid())
      {
        $user = MemberTable::getByUsernameOrEmail($values['username']);

        if ($user != null)
        {
          if ($user->hasEmail())
          {
            $this->_deleteOldUserForgotPasswordRecords($user->getId());

            $forgotPassword = new sfGuardForgotPassword();
            $forgotPassword->user_id = $user->getId();
            $forgotPassword->unique_key = md5(rand() + time());
            $forgotPassword->expires_at = new Doctrine_Expression('NOW()');
            $forgotPassword->save();
            $this->_sendLinkChangePassword($user, $forgotPassword);
          }
          else
          {
            $this->getUser()->setFlash('error', 'L\'utilisateur ne possède pas d\'adresse e-mail', false);
          }
        }
        else
        {
          $this->getUser()->setFlash('error', "Le nom d'utilisateur ou l'email n'existe pas", false);
        }
      }
    }
    
    $this->setLayout('no_menu');
  }
  /**
   * Display form for changin password, use unique token from sfGuardPlugin
   * @param sfWebRequest $request
   */
  public function executeChangepassword(sfWebRequest $request)
  {
    $forgotPassword = null;
    $this->unique_key = $request->getParameter('unique_key',null);
    $this->forward404Unless($this->unique_key,'Unique key est manquant');
    
    $forgotPassword = sfGuardForgotPasswordTable::getInstance()->findOneByUniqueKey($this->unique_key);
    $this->forward404Unless($forgotPassword,'Lien de changement de mot de passe expiré ou invalide');
    $this->user = $forgotPassword->getUser();
    
    $this->form = new sfGuardChangeUserPasswordForm($this->user);
    
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
        $this->form->save();

        $this->_deleteOldUserForgotPasswordRecords($this->user->getId());
        $member = MemberTable::getById($this->user->getId());
        $values = array();
        $values['recipient.password'] = $this->form->getValue('password');
        MailerFactory::loadTemplateAndSend($this->user->getId(),$member,'changed_password',$values);

        $this->getUser()->setFlash('notice', 'Mot de passe modifié avec succés, un email de confirmation vous a été envoyé.');
        $this->redirect('@homepage');
      }
    }
    $this->setLayout('no_menu');
  }
  /**
   * Remove forgotten token in base
   * @param integer $user_id
   */
  private function _deleteOldUserForgotPasswordRecords($user_id)
  {
    Doctrine_Core::getTable('sfGuardForgotPassword')
      ->createQuery('p')
      ->delete()
      ->where('p.user_id = ?', $user_id)
      ->execute();
  }
  /*
   * send email with link to change password page
   * use unique key from sfGuardPlugin 
   */
  private function _sendLinkChangePassword(Member $member,sfGuardForgotPassword $forgotten)
  {
    $values = array();
    $values['link_change_password'] = $this->generateUrl('change_password',array('unique_key'=>$forgotten->getUniqueKey()),true);
    try
    {
      MailerFactory::loadTemplateAndSend($member->getId(),$member,'forgotten_password',$values);
      $this->getUser()->setFlash('notice', 'Un lien pour changer le mot de passe a été envoyé sur votre email.', false);
    }
    catch (Swift_ConnectionException $e)
    {
      $this->getUser()->setFlash('error', "Une erreur c'est produite pour envoyer un email avec le lien de changmeent de mot de passe.", false);
    }
  }

  /*
   * Check if we can register another new association. Because this method
   * is called in the default action, we check if PDO is correctly set up.
   *
   * If not, we redirect to install module
   */
  private function _canRegisterAnotherAssociation()
  {
    try
    {
      if (!PiwamOperations::associationIsCreated())
      {
        return true;
      }
      else
      {
        return sfConfig::get('app_multi_association',false);
      }
    }
    catch (Doctrine_Exception $e)
    {
      $this->redirect('@setup');
    }
    catch (Doctrine_Connection_Exception $e)
    {
      $this->redirect('@setup');
    }
  }
}