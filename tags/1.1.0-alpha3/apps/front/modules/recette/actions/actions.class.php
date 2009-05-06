<?php

/**
 * recette actions.
 *
 * @package    piwam
 * @subpackage recette
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class recetteActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->recette_list = RecettePeer::doSelectForAssociation($this->getUser()->getAttribute('association_id', null, 'user'));
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->recette = RecettePeer::retrieveByPk($request->getParameter('id'));
		$this->forward404Unless($this->recette);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new RecetteForm();
		$this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new RecetteForm();
		$this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($recette = RecettePeer::retrieveByPk($request->getParameter('id')), sprintf('Object recette does not exist (%s).', $request->getParameter('id')));
		$this->form = new RecetteForm($recette);
		$this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($recette = RecettePeer::retrieveByPk($request->getParameter('id')), sprintf('Object recette does not exist (%s).', $request->getParameter('id')));
		$this->form = new RecetteForm($recette);
		$this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		$this->forward404Unless($recette = RecettePeer::retrieveByPk($request->getParameter('id')), sprintf('Object recette does not exist (%s).', $request->getParameter('id')));
		$recette->delete();
		$this->redirect('recette/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$recette = $form->save();
			$this->redirect('recette/index');
		}
	}
}
