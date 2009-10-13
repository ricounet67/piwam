<?php

/**
 * association actions.
 *
 * @package    piwam
 * @subpackage association
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class associationActions extends sfActions
{
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
            $ph = $request->getParameterHolder();
            $data = $ph->getAll();
            foreach ($data['config'] as $key => $value)
            {
                if (strlen($value) > 0)
                {
                    $associationId  = sfContext::getInstance()->getUser()->getAttribute('association_id', null, 'user');
                    Configurator::set($key, $value, $associationId);
                }
            }
            $this->getUser()->setFlash('notice', 'Les préférences ont bien été prises en compte.');
        }

        $this->form = new ConfigForm();
    }

    /**
     * Provides a view to allows current user to export the different data
     * he wants to export
     *
     * @param 	sfWebRequest	$request
     * @since	r19
     */
    public function executeExport(sfWebRequest $request)
    {
        // do nothing
        // content is set in the template file
    }

    /**
     * Login action
     *
     * @param 	sfWebRequest $request
     * @since	r7
     */
    public function executeLogin(sfWebRequest $request)
    {
        $this->form = new LoginForm();

        if ($request->isMethod('post'))
        {
            $this->form->bind($request->getParameter('login'));
            if ($this->form->isValid())
            {
                $user = MembrePeer::doSelectByUsernameAndPassword($request->getParameter('login[username]'), $request->getParameter('login[password]'));
                if (! is_null($user))
                {
                    $this->getUser()->login($user);
                    $this->redirect('membre/index');
                }
            }
        }
    }


    /**
     * Logout action
     *
     * @param 	sfWebRequest	$request
     * @since	r7
     */
    public function executeLogout(sfWebRequest $request)
    {
        $this->getUser()->logout();
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
        $associationId			= $this->getUser()->getAttribute('association_id', null, 'user');
        $this->comptes 			= ComptePeer::doSelectEnabled($associationId);
        $this->activites		= ActivitePeer::doSelectEnabled($associationId);
        $this->totalCotisations = CotisationPeer::doSeletSumForAssociationId($associationId);
        $this->totalDettes      = DepensePeer::getAmountOfDettes($associationId);
        $this->totalCreances    = RecettePeer::getAmountOfCreances($associationId);
        $this->totalPrevu       = $this->totalCreances - $this->totalDettes;
    }


    /**
     * Mailing action
     *
     * @param 	sfWebRequest	$request
     * @since	r10
     */
    public function executeMailing(sfWebRequest $request)
    {
        $this->form = new MailingForm(array(), array('url' => $this->getController()->genUrl('membre/ajaxlist')));
        if ($request->isMethod('post'))
        {
            $this->form->bind($request->getParameter('mailing'));
            if ($this->form->isValid())
            {
                $associationId  = $this->getUser()->getAttribute('association_id', null, 'user');
                $data 	= $this->form->getValues();
                $sentOk = 0; 	// these are 2 counters of
                $sentKo = 0;	// succeed/failed messages

                // mail users
                // r11
                try
                {
                    /*
                     * The user is able to select the method he prefers to use
                     * for sending emails.
                     *
                     * By default we use the mail() php function
                     */
                    switch (Configurator::get('method', $associationId, 'mail'))
                    {
                        case 'gmail': // yes this is just a special case for smtp ;-)
                            $methodObject = new Swift_Connection_SMTP('smtp.gmail.com', Swift_Connection_SMTP::PORT_SECURE, Swift_Connection_SMTP::ENC_TLS);
                            $methodObject->setUsername(Configurator::get('gmail_username', $associationId));
                            $methodObject->setPassword(Configurator::get('gmail_password', $associationId));

                            if (!extension_loaded('openssl')) {
                                $this->getUser()->setFlash('error', 'Le module "openssl" n\'est pas activé. Veuillez l\'activer ou changer la méthode d\'envoi de mails');
                            }
                            break;

                        case 'smtp':
                            $smtpServer = Configurator::get('smtp_server', $associationId);
                            $smtpPort = null;
                            $smtpEncryption = null;
                            $smtpUsername = Configurator::get('smtp_username', $associationId);
                            $smtpPassword = Configurator::get('smtp_password', $associationId);
                            $methodObject = new Swift_Connection_SMTP($smtpServer, $smtpPort, $smtpEncryption);
                            $methodObject->setUsername($smtpUsername);
                            $methodObject->setPassword($smtpPassword);

                            break;

                        case 'sendmail':
                            $sendmailPath = Configurator::get('sendmail_path', $associationId, '/usr/bin/sendmail');
                            $methodObject = new Swift_Connection_Sendmail($sendmailPath);
                            break;

                        case 'mail':
                            $methodObject = new Swift_Connection_NativeMail();
                            break;

                        default:
                            $methodObject = new Swift_Connection_NativeMail();
                            break;
                    }

                    $mailer 	= new Swift($methodObject);
                    $message	= new Swift_Message($data['subject'], $data['mail_content'], 'text/html');
                    $from		= Configurator::get('address', $associationId, 'info-association@piwam.org');
                    $membres	= MembrePeer::doSelectWithEmailForAssociation($this->getUser()->getAttribute('association_id', null, 'user'));

                    foreach ($membres as $membre)
                    {
                        try {
                            $mailer->send($message, $membre->getEmail(), $from);
                            $sentOk++;
                        }
                        catch(Swift_ConnectionException $e) {
                            $sentKo++;
                        }
                    }

                    $mailer->disconnect();
                    sfContext::getInstance()->getConfiguration()->loadHelpers('Plural');
                    $this->getUser()->setFlash('notice', 'Votre message a été envoyé à ' . $sentOk . plural_word($sentOk, ' destinataire') . ' (' . $sentKo . plural_word($sentKo, ' erreur') . ')');
                    $this->content = $data['mail_content'];
                }
                catch (Exception $e) {
                    //
                }
            }
        }
    }


    /**
     * We don't have any way to list the associations
     *
     * @param   sfWebRequest    $request
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->forward('error', 'credentials');
        $this->association_list = AssociationPeer::doSelect(new Criteria()); // not executed
    }

    /**
     * Display creation form to register a new Assocation
     *
     * @param   sfWebRequest    $request
     */
    public function executeNew(sfWebRequest $request)
    {
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

        if ($this->processForm($request, $this->form)) {
            $this->_association->initialize();
            $this->getUser()->setTemporaryAssociationId($this->_association->getId());
            $this->redirect('membre/newfirst');
        }
        else {
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
        $this->forward404Unless($association = AssociationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object association does not exist (%s).', $request->getParameter('id')));
        $this->form = new AssociationForm($association);
    }

    /**
     * Perform update of fields
     *
     * @param   sfWebRequest    $request
     */
    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $this->forward404Unless($association = AssociationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object association does not exist (%s).', $request->getParameter('id')));
        $this->form = new AssociationForm($association);
        if ($this->processForm($request, $this->form)) {
            $this->redirect('membre/index');
        }
        else {
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
        $this->forward404Unless($association = AssociationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object association does not exist (%s).', $request->getParameter('id')));
        $association->delete();
        $this->redirect('association/index');
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $this->_association = $form->save();
            return true;
        }
        return false;
    }
}
