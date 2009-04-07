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
	public function executeIndex(sfWebRequest $request)
	{
		$this->cotisation_list = CotisationPeer::doSelect(new Criteria());
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->cotisation = CotisationPeer::retrieveByPk($request->getParameter('id'));
		$this->forward404Unless($this->cotisation);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new CotisationForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new CotisationForm();
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($cotisation = CotisationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object cotisation does not exist (%s).', $request->getParameter('id')));
		$this->form = new CotisationForm($cotisation);
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
