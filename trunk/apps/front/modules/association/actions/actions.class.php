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
		$this->comptes 		= ComptePeer::doSelectForOverview();
		$this->activites	= ActivitePeer::doSelectForOverview();
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
	}
	
	
	public function executeIndex(sfWebRequest $request)
	{
		$this->association_list = AssociationPeer::doSelect(new Criteria());
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new AssociationForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));

		$this->form = new AssociationForm();

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
