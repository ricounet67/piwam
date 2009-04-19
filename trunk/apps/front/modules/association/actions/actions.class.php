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
		$this->comptes 		= ComptePeer::doSelectEnabled($this->getUser()->getAttribute('association_id', null, 'user'));
		$this->activites	= ActivitePeer::doSelectEnabled($this->getUser()->getAttribute('association_id', null, 'user'));
	}


	/**
	 * Mailing action
	 *
	 * @param 	sfWebRequest	$request
	 * @since	r10
	 */
	public function executeMailing(sfWebRequest $request)
	{
		$this->form = new MailingForm();
		if ($request->isMethod('post'))
		{
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
				
				$mailSubject = $request->getParameter('subject');
				$mailBody 	 = $request->getParameter('content');			
				$mailer 	 = new Swift($methodObject);
				$message 	 = new Swift_Message($mailSubject, $mailBody, 'text/html');
				echo 'ok:' . $mailer->send($message, 'mogene_a@epita.fr', 'adrien.mogenet@gmail.com');
				$mailer->disconnect();
			}
			catch (Exception $e) {
				//
			}
			
			// notification
			$this->getUser()->setFlash('notice', 'Votre message a bien été envoyé');
		}
	}


	public function executeIndex(sfWebRequest $request)
	{
		$this->association_list = AssociationPeer::doSelect(new Criteria());
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new AssociationForm();
		$membreForm = new MembreForm();
		$this->form->embedForm('membre', $membreForm);
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new AssociationForm();
		$membreForm = new MembreForm();
		$this->form->embedForm('membre', $membreForm);
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
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
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
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
			$association = $form->save();
			$this->redirect('association/edit?id='.$association->getId());
		}
	}
}
