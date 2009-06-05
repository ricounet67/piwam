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
                    switch (sfConfig::get('sf_mailing_method', 'mail'))
                    {
                        case 'gmail': // yes this is just a special case for smtp ;-)
                            $gmailConfig = sfConfig::get('sf_mailing_gmail');
                            $methodObject = new Swift_Connection_SMTP('smtp.gmail.com', Swift_Connection_SMTP::PORT_SECURE, Swift_Connection_SMTP::ENC_TLS);
                            $methodObject->setUsername($gmailConfig['gmail_username']);
                            $methodObject->setPassword($gmailConfig['gmail_password']);

                            if (!extension_loaded('smtp')) {
                                $this->getUser()->setFlash('error', 'Le module "smtp" n\'est pas activé. Veuillez l\'activer ou changer la méthode d\'envoi de mails dans le fichier settings.yml');
                            }
                            break;

                        case 'smtp':
                            $smtpConfig = sfConfig::get('sf_mailing_smtp');
                            $smtpServer = $smtpConfig['smtp_server'];
                            $smtpPort = null;
                            $smtpEncryption = null;
                            $smtpUsername = $smtpConfig['smtp_username'];
                            $smtpPassword = $smtpConfig['smtp_password'];
                            $methodObject = new Swift_Connection_SMTP($smtpServer, $smtpPort, $smtpEncryption);
                            $methodObject->setUsername($smtpUsername);
                            $methodObject->setPassword($smtpPassword);

                            if (!extension_loaded('smtp')) {
                                $this->getUser()->setFlash('error', 'Le module "smtp" n\'est pas activé. Veuillez l\'activer ou changer la méthode d\'envoi de mails dans le fichier settings.yml');
                            }
                            break;

                        case 'sendmail':
                            $sendmailConfig = sfConfig::get('sf_mailing_sendmail');
                            $methodObject = new Swift_Connection_Sendmail($sendmailConfig['sendmail_path']);
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
                    $from		= sfConfig::get('sf_mailing_address', 'info-association@piwam.org');
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


    public function executeIndex(sfWebRequest $request)
    {
        $this->association_list = AssociationPeer::doSelect(new Criteria());
    }

    public function executeNew(sfWebRequest $request)
    {
        $this->getUser()->removeTemporaryData();
        $this->form = new AssociationForm();
    }

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

    public function executeEdit(sfWebRequest $request)
    {
        $this->forward404Unless($association = AssociationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object association does not exist (%s).', $request->getParameter('id')));
        $this->form = new AssociationForm($association);
    }

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
