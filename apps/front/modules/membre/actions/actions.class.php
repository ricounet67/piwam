<?php

/**
 * membre actions.
 *
 * @package    piwam
 * @subpackage membre
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class membreActions extends sfActions
{
	/**
	 * Lists members who belongs to the current association. By default we sort
	 * the list by pseudo, and if another column is specified we use it.
	 *
	 * r14 : pagination system
	 *
	 * @param 	sfWebRequest	$request
	 * @since	r1
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$orderByColumn = $request->getParameter('orderby', MembrePeer::PSEUDO);
		$this->membresPager = MembrePeer::doSelectOrderBy($this->getUser()->getAttribute('association_id', null, 'user'),
		$request->getParameter('page', 20),
		$orderByColumn);
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->membre = MembrePeer::retrieveByPk($request->getParameter('id'));
		$this->cotisations = CotisationPeer::doSelectForUser($request->getParameter('id'));
		$this->forward404Unless($this->membre);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new MembreForm();
	}
	
	/**
	 * Register a new Membre - and the first one ! - for an
	 * Association. This is a special method which use the temporary
	 * AssociationID instead of using an already-registered AssociationID
	 * 
	 * @param 	sfWebRequest	$request
	 * @since	r16
	 */
	public function executeNewfirst(sfWebRequest $request)
	{
		$this->form = new MembreForm();
		$associationId = $this->getUser()->getAttribute('association_id', null, 'temp');
		if (is_null($associationId)) {
			throw new sfException('Erreur lors de la première étape d\'enregistrement');
		}
		$this->form->setDefault('association_id', $associationId);
	}

	/**
	 * 
	 * @param 	sfWebRequest	$request
	 * @since	r16
	 */
	public function executeFirstcreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new MembreForm();
		$request->setAttribute('first', true);
		$this->processForm($request, $this->form);
		$this->setTemplate('newfirst');
	}
	
	/**
	 * Display information about the just finished registration. We use
	 * keyword 'instanceof' because getTemporaryUserInfo() returns
	 * unserialized object - which can be null.
	 * 
	 * @param 	sfWebRequest	$request
	 * @see 	getTemporaryUserInfo()
	 * @since	r16
	 */
	public function executeEndregistration(sfWebRequest $request)
	{
		$membre = $this->getUser()->getTemporaryUserInfo();
		
		if ($membre instanceof Membre)
		{
			$this->prenom 	= $membre->getPrenom();
			$this->nom 		= $membre->nom();
		}
	}
	
	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new MembreForm();
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($membre = MembrePeer::retrieveByPk($request->getParameter('id')), sprintf('Object membre does not exist (%s).', $request->getParameter('id')));
		$this->form = new MembreForm($membre);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($membre = MembrePeer::retrieveByPk($request->getParameter('id')), sprintf('Object membre does not exist (%s).', $request->getParameter('id')));
		$this->form = new MembreForm($membre);
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		$this->forward404Unless($membre = MembrePeer::retrieveByPk($request->getParameter('id')), sprintf('Object membre does not exist (%s).', $request->getParameter('id')));
		$membre->delete();
		$this->redirect('membre/index');
	}

	/**
	 * Called method to display list of Membre within an autocompleted
	 * form field.
	 *
	 * @param 	sfWebRequest	$request
	 * @since	r15
	 */
	public function executeAjaxlist(sfWebRequest $request)
	{
		$this->getResponse()->setContentType('application/json');
		$membres = MembrePeer::retrieveForSelect($request->getParameter('q'), $request->getParameter('limit'));
		return $this->renderText(json_encode($membres));
		 
	}

	/**
	 * If this is a the first Membre that we registered, we redirect
	 * to the `end` action to display success message about registration.
	 * 
	 * @param 	sfWebRequest	$request
	 * @param 	sfForm			$form
	 */
	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$membre = $form->save();
			
			if ($request->getAttribute('first') == true) {
				$this->getUser()->removeTemporaryData();
				$this->getUser()->setTemporarUserInfo($user);
				$this->redirect('membre/endregistration');
			}
			else {
				$this->redirect('membre/index');
			}
		}
	}
}
