<?php
/**
 * Login actions.
 *
 * @package    piwam
 * @subpackage login
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class loginActions extends sfActions
{
  /**
   * Login action. This is the default action if we are not authenticated.
   * If we can't perform the Propel operations, we consider the database
   * settings are not correct and we redirect to /install automatically
   *
   * @param   sfWebRequest $request
   * @todo    Manage cookies
   */
  public function executeLogin(sfWebRequest $request)
  {
    if (MemberTable::doCount() == 0)
    {
      $this->redirect('@association_new');
    }

    $this->form = new LoginForm();
    $this->displayRegisterLink = $this->_canRegisterAnotherAssociation();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('login'));
      $login = $request->getParameter('login');

      if ($this->form->isValid())
      {
        $username = $login['username'];
        $password = $login['password'];
        $user = MemberTable::getByUsernameAndPassword($username, $password);

        if ($user instanceof Member)
        {
          $this->getUser()->login($user);

          // Unused cookie, fake value is set
          $this->getResponse()->setCookie(myUser::COOKIE_NAME, '1', time() + 60 * 60 * 24 * 15, '/');

          if (! $request->getCookie(myUser::COOKIE_NAME))
          {
            $this->getUser()->setFlash('error', 'Les cookies doivent être activés');
          }

          if ($this->getUser()->hasCredential('list_membre'))
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
          if (null != MemberTable::getByUsername($username))
          {
            $this->getUser()->setFlash('error', "Le mot de passe est invalide", false);
          }
          else
          {
            $this->getUser()->setFlash('error', "Le nom d'utilisateur est invalide", false);
          }
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
      $password = $request->getParameter('password');

      if ($this->form->isValid())
      {
        $user = MemberTable::getByUsername($password['username']);

        if ($user)
        {
          if ($user->getEmail())
          {
            $email = $user->getEmail();
            $newPassword = StringTools::generatePassword(8);
            $user->setPassword($newPassword);
            $user->save();

            $mailer     = MailerFactory::get($user->getAssociationId(), $this->getUser());
            $content    = 'Bonjour, votre nouveau mot de passe pour acc&eacute;der au gestionnaire d\'association est ' . $newPassword;
            $from_email = Configurator::get('address', $user->getAssociationId(), 'info-association@piwam.org');
            $from_label = $this->getUser()->getAssociationName('Piwam');

            $message = Swift_Message::newInstance('Votre mot de passe');
            $message->setBody($content);
            $message->setContentType('text/html');
            $message->setFrom(array($from_email => $from_label));
            $message->setTo(array($user->getEmail() => $user->getFirstname()));

            try
            {
              $mailer->send($message);
            }
            catch(Swift_ConnectionException $e)
            {
              $this->getUser()->setFlash('error', 'Le mot de passe n\'a pas pu être envoyé par e-mail', false);
            }

            $this->getUser()->setFlash('notice', 'Le nouveau mot de passe a été envoyé par e-mail', false);
          }
          else
          {
            $this->getUser()->setFlash('error', 'L\'utilisateur ne possède pas d\'adresse e-mail', false);
          }
        }
        else
        {
          $this->getUser()->setFlash('error', 'Le nom d\'utilisateur n\'existe pas', false);
        }
      }
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
      if (AssociationTable::doCount() === 0)
      {
        return true;
      }
      else
      {
        if (sfConfig::get('app_multi_association'))
        {
          return true;
        }

        return false;
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
