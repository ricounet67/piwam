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
    /**
     * Called by AJAX updater in 'cotisation/new' action.
     *
     * @param $request
     * @return unknown_type
     */
    public function executeAjaxgetamountfor(sfWebRequest $request)
    {
        $id = $request->getParameter('id', false);

        if (!$id) {
            echo 'Pas de montant';
        }
        else {
            echo CotisationTypePeer::getAmountForTypeId($id);
        }

        return sfView::NONE;
    }

    /**
     * List existing CotisationType
     *
     * @param   sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request)
	{
		$this->cotisation_type_list = CotisationTypePeer::doSelectEnabled($this->getUser()->getAttribute('association_id', null, 'user'));
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->cotisation_type = CotisationTypePeer::retrieveByPk($request->getParameter('id'));

		if ($this->cotisation_type->getAssociationId() == $this->getUser()->getAttribute('association_id', null, 'user')) {
    		$this->forward404Unless($this->cotisation_type);
		}
		else {
		    $this->forward('error', 'credentials');
		}
	}

	/**
	 * r20 : If `first` attribute has been set, we want
	 * 		 to create our first type. We will set a default
	 * 		 value in label field
	 *
	 * @param 	sfWebRequest	$request
	 * @see		modules/cotisation/templates/indexSuccess.php
	 */
	public function executeNew(sfWebRequest $request)
	{
		$this->form = new CotisationTypeForm();
		$this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
		if ($request->getParameter('first', false)) {
			$this->form->setDefault('libelle', 'Cotisation annuelle ' . date('Y'));
		}
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new CotisationTypeForm();
		$this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	/**
	 * Edit an existing CotisationType
	 *
	 * @param  sfWebRequest $request
	 */
	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($cotisation_type = CotisationTypePeer::retrieveByPk($request->getParameter('id')), sprintf('Object cotisation_type does not exist (%s).', $request->getParameter('id')));

	    if ($cotisation_type->getAssociationId() !== $this->getUser()->getAttribute('association_id', null, 'user')) {
            $this->forward('error', 'credentials');
        }

		$this->form = new CotisationTypeForm($cotisation_type);
		$this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($cotisation_type = CotisationTypePeer::retrieveByPk($request->getParameter('id')), sprintf('Object cotisation_type does not exist (%s).', $request->getParameter('id')));
		$this->form = new CotisationTypeForm($cotisation_type);
		$this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	/**
	 * Delete a CotisationType if user has required credentials
	 *
	 * @param sfWebRequest $request
	 */
	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		$this->forward404Unless($cotisation_type = CotisationTypePeer::retrieveByPk($request->getParameter('id')), sprintf('Object cotisation_type does not exist (%s).', $request->getParameter('id')));

	    if ($cotisation_type->getAssociationId() == $this->getUser()->getAttribute('association_id', null, 'user')) {
            $this->forward('error', 'credentials');
        }

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
