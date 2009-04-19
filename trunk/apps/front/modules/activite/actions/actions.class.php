<?php

/**
 * activite actions.
 *
 * @package    piwam
 * @subpackage activite
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class activiteActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->activite_list = ActivitePeer::doSelectEnabled($this->getUser()->getAttribute('association_id', null, 'user'));
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->activite = ActivitePeer::retrieveByPk($request->getParameter('id'));
		$this->forward404Unless($this->activite);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new ActiviteForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new ActiviteForm();
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($activite = ActivitePeer::retrieveByPk($request->getParameter('id')), sprintf('Object activite does not exist (%s).', $request->getParameter('id')));
		$this->form = new ActiviteForm($activite);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($activite = ActivitePeer::retrieveByPk($request->getParameter('id')), sprintf('Object activite does not exist (%s).', $request->getParameter('id')));
		$this->form = new ActiviteForm($activite);
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		$this->forward404Unless($activite = ActivitePeer::retrieveByPk($request->getParameter('id')), sprintf('Object activite does not exist (%s).', $request->getParameter('id')));
		$activite->delete();
		$this->redirect('activite/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$activite = $form->save();
			$this->redirect('activite/edit?id='.$activite->getId());
		}
	}
}
