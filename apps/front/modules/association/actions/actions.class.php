<?php
/**
 * association actions.
 *
 * @package    piwam
 * @subpackage association
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class associationActions extends sfActions
{
  /*
   * Make some operations easier
   *
   * @var Association
   */
  private $_association = null;

  /**
   * Display config form to edit Association's configuration
   *
   * @param   sfWebRequest    $request
   * @since   r75
   */
  public function executeConfig(sfWebRequest $request)
  {
    if ($request->isMethod('post'))
    {
      $data = $request->getParameter('config');

      foreach ($data as $key => $value)
      {
        Configurator::set($key, $value, $this->getUser()->getAssociationId());
      }
      $this->getUser()->setFlash('notice', 'Les préférences ont bien été prises en compte.', false);
    }

    $this->form = new ConfigForm();
  }

  /**
   * Login action. This is the default action if we are not authenticated.
   * If we can't perform the Propel operations, we consider the database
   * settings are not correct and we redirect to /install automatically
   *
   * @param 	sfWebRequest $request
   * @since	  r7
   * @todo    Manage cookies
   */
  public function executeLogin(sfWebRequest $request)
  {
    $this->form = new LoginForm();
    $this->displayRegisterLink = $this->_canRegisterAnotherAssociation();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('login'));
      $login = $request->getParameter('login');

      if ($this->form->isValid())
      {
        $user = MemberTable::getByUsernameAndPassword($login['username'], $login['password']);

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
            $this->redirect('@member_by_id?id=' . $user->getId());
          }
        }
        else
        {
          if (null != MemberTable::getByUsername($login['username']))
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
  }

  /**
   * Logout action. Redirect to homepage once credentials and cookies
   * have been removed.
   *
   * @param 	sfWebRequest	$request
   * @since	  r7
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

            $message    = Swift_Message::newInstance('Votre mot de passe')
            ->setBody($content)
            ->setContentType('text/html')
            ->setFrom(array($from_email => $from_label))
            ->setTo(array($user->getEmail() => $user->getFirstname()));
            try
            {
              $mailer->send($message);
            }
            catch(Swift_ConnectionException $e)
            {
              $this->getUser()->setFlash('error', 'Le mot de passe n\'a pu être envoyé par e-mail', false);
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

  /**
   * Display the current overview of the association, for each Compte and
   * each Activite.
   * We provide the lists of the Compte and Activite to the view.
   *
   * @param 	sfWebRequest	$request
   * @since	r9
   */
  public function executeBilan(sfWebRequest $request)
  {
    $associationId         = $this->getUser()->getAssociationId();
    $this->accounts        = AccountTable::getEnabledForAssociation($associationId);
    $this->activities      = ActivityTable::getEnabledForAssociation($associationId);
    $this->totalDues       = DueTable::getSumForAssociation($associationId);
    $this->totalUnpaid     = ExpenseTable::getAmountOfDebtsForAssociation($associationId);
    $this->totalUnreceived = IncomeTable::getAmountOfDebtsForAssociation($associationId);
    $this->totalDebts      = $this->totalUnreceived - $this->totalUnpaid;
  }

  /**
   * We don't have any way to list the associations
   *
   * @param   sfWebRequest    $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->associationsPager = AssociationTable::doSelectActiveAssociations($request->getParameter('page', 1));
  }

  /**
   * Display creation form to register a new Assocation
   *
   * @param   sfWebRequest    $request
   */
  public function executeNew(sfWebRequest $request)
  {
    if (! $this->_canRegisterAnotherAssociation())
    {
      $this->redirect('@error_credentials');
    }

    $this->getUser()->removeTemporaryData();
    $this->form = new AssociationForm();
  }

  /**
   * Perform the creation of the new Association
   *
   * @param   sfWebRequest    $request
   */
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new AssociationForm();
    if ($this->processForm($request, $this->form))
    {
      $this->_association->initialize();
      $this->getUser()->setTemporaryAssociationId($this->_association->getId());
      $this->redirect('@register_first_member');
    }
    else
    {
      $this->setTemplate('new');
    }
  }

  /**
   * Display form to edit Association's information
   *
   * @param   sfWebRequest    $request
   */
  public function executeEdit(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $association = AssociationTable::getById($id);
    $this->forward404Unless($association, "L'association {$id} n'existe pas.");
    $this->form = new AssociationForm($association);
  }

  /**
   * Perform update of fields. Name of the association is also updated for the
   * session of the current user
   *
   * @param   sfWebRequest    $request
   */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $id = $request->getParameter('id');
    $association = AssociationTable::getById($id);
    $this->forward404Unless($association, "L'association {$id} n'existe pas.");
    $this->form = new AssociationForm($association);

    if ($this->processForm($request, $this->form))
    {
      $this->getUser()->setAttribute('association_name', $association->getName(), 'user');
      $this->redirect('@homepage');
    }
    else
    {
      $this->setTemplate('edit');
    }
  }

  /**
   * Perform the deletion
   *
   * @param   sfWebRequest    $request
   */
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $id = $request->getParameter('id');
    $association = AssociationTable::getById($id);
    $this->forward404Unless($association, "L'association {$id} n'existe pas.");
    $association->delete();
    $this->redirect('@associations_list');
  }

  /*
   * Process data sent from the form
   */
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid())
    {
      $this->_association = $form->save();
      $params = $request->getParameter('association');

      if (isset($params['ping_piwam']) && $params['ping_piwam'] == 1)
      {
        $this->getUser()->setAttribute('ping_piwam', '1', 'temp');
      }

      return true;
    }
    return false;
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
