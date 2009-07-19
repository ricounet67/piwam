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
	/**
	 * Export the list of Depense within a file
	 *
	 * @param 	sfWebRequest	$request
	 * @since	r39
	 */
	public function executeExport(sfWebRequest $request)
	{
		sfContext::getInstance()->getConfiguration()->loadHelpers('Number');
		$csv = new FileExporter('liste-recettes.csv');
		$recettes = RecettePeer::doSelectForAssociation($this->getUser()->getAttribute('association_id', null, 'user'));

		echo $csv->addLineCSV(array(
			'Libellé',
			'Montant (euros)',
			'Compte',
			'Activité',
			'Date',
		));

		foreach ($recettes as $recette)
		{
			echo $csv->addLineCSV(array(
				$recette->getLibelle(),
				format_currency($recette->getMontant()),
				$recette->getCompte(),
				$recette->getActivite(),
				$recette->getDate(),
			));
		}
		$csv->exportContentAsFile();
	}

	/**
	 * List Recettes
	 *
	 * @param  sfWebRequest $request
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->recettesPager = RecettePeer::doSelectForAssociation($this->getUser()->getAttribute('association_id', null, 'user'),
		                                                              $request->getParameter('page', 1));
	}

	/**
	 * Show details about a particular Recette
	 *
	 * @param  sfWebRequest $request
	 */
	public function executeShow(sfWebRequest $request)
	{
		$this->recette = RecettePeer::retrieveByPk($request->getParameter('id'));

		if ($this->recette->getAssociationId() == $this->getUser()->getAttribute('association_id', null, 'user')) {
    		$this->forward404Unless($this->recette);
		}
		else {
		    $this->forward('error', 'credentials');
		}
	}

	/**
	 * Display the form to record a new Recette
	 *
	 * @param  sfWebRequest $request
	 */
	public function executeNew(sfWebRequest $request)
	{
		$this->form = new RecetteForm();
		$this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
	}

	/**
	 * Display form if error or record the new Recette
	 *
	 * @param  sfWebRequest $request
	 */
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

		if ($recette->getAssociationId() != $this->getUser()->getAttribute('association_id', null, 'user')) {
            $this->forward('error', 'credentials');
        }

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

	/**
	 * Delete an existing Recette. Check if user has required credentials
	 *
	 * @param sfWebRequest $request
	 */
	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		$this->forward404Unless($recette = RecettePeer::retrieveByPk($request->getParameter('id')), sprintf('Object recette does not exist (%s).', $request->getParameter('id')));

    	if ($recette->getAssociationId() != $this->getUser()->getAttribute('association_id', null, 'user')) {
            $this->forward('error', 'credentials');
        }

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
