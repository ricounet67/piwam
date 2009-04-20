<?php

/**
 * cotisationtype actions.
 *
 * @package    piwam
 * @subpackage cotisationtype
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class cotisationtypeActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->cotisation_type_list = CotisationTypePeer::doSelectEnabled($this->getUser()->getAttribute('association_id', null, 'user'));
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->cotisation_type = CotisationTypePeer::retrieveByPk($request->getParameter('id'));
		$this->forward404Unless($this->cotisation_type);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new CotisationTypeForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new CotisationTypeForm();
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($cotisation_type = CotisationTypePeer::retrieveByPk($request->getParameter('id')), sprintf('Object cotisation_type does not exist (%s).', $request->getParameter('id')));
		$this->form = new CotisationTypeForm($cotisation_type);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($cotisation_type = CotisationTypePeer::retrieveByPk($request->getParameter('id')), sprintf('Object cotisation_type does not exist (%s).', $request->getParameter('id')));
		$this->form = new CotisationTypeForm($cotisation_type);
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		$this->forward404Unless($cotisation_type = CotisationTypePeer::retrieveByPk($request->getParameter('id')), sprintf('Object cotisation_type does not exist (%s).', $request->getParameter('id')));
		$cotisation_type->delete();
		$this->redirect('cotisationtype/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$cotisation_type = $form->save();
			$this->redirect('cotisationtype/index');
		}
	}
}
