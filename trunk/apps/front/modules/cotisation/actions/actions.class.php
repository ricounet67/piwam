<?php

/**
 * cotisation actions.
 *
 * @package    piwam
 * @subpackage cotisation
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class cotisationActions extends sfActions
{
	/**
	 * r20 : provides to the view the number of cotisation types that
	 * 		 have been set
	 *
	 * @param 	sfWebRequest	$request
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->cotisation_list = CotisationPeer::doSelectJoinMembreId($this->getUser()->getAttribute('association_id', null, 'user'));
		$this->typesExist = CotisationTypePeer::doesOneTypeExist($this->getUser()->getAttribute('association_id', null, 'user'));
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->cotisation = CotisationPeer::retrieveByPk($request->getParameter('id'));
		
		if ($this->cotisation->getCotisationType()->getAssociationId() == $this->getUser()->getAttribute('association_id', null, 'user')) {
    		$this->forward404Unless($this->cotisation);
		}
		else {
		    $this->forward('association', 'credentials');
		}
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new CotisationForm();
		$this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new CotisationForm();
		$this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($cotisation = CotisationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object cotisation does not exist (%s).', $request->getParameter('id')));
		$this->form = new CotisationForm($cotisation);
		$this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($cotisation = CotisationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object cotisation does not exist (%s).', $request->getParameter('id')));
		$this->form = new CotisationForm($cotisation);
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		$this->forward404Unless($cotisation = CotisationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object cotisation does not exist (%s).', $request->getParameter('id')));
		$cotisation->delete();
		$this->redirect('cotisation/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$cotisation = $form->save();
			$this->redirect('cotisation/index');
		}
	}
}
