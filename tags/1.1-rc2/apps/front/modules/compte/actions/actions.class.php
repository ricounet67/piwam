<?php

/**
 * compte actions.
 *
 * @package    piwam
 * @subpackage compte
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class compteActions extends sfActions
{
    /**
     * List existing Compte
     *
     * @param  sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->compte_list = ComptePeer::doSelectEnabled($this->getUser()->getAttribute('association_id', null, 'user'));
    }

    /**
     * Show details about a particular Compte
     * @param   sfWebRequest $request
     */
    public function executeShow(sfWebRequest $request)
    {
        $this->compte = ComptePeer::retrieveByPk($request->getParameter('id'));

        if ($this->compte->getAssociationId() == $this->getUser()->getAttribute('association_id', null, 'user')) {
            $this->forward404Unless($this->compte);
        }
        else {
            $this->forward('error', 'credentials');
        }
    }

    public function executeNew(sfWebRequest $request)
    {
        $this->form = new CompteForm();
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
    }

    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new CompteForm();
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->forward404Unless($compte = ComptePeer::retrieveByPk($request->getParameter('id')), sprintf('Object compte does not exist (%s).', $request->getParameter('id')));

        if ($compte->getAssociationId() != $this->getUser()->getAttribute('association_id', null, 'user')) {
            $this->forward('error', 'credentials');
        }

        $this->form = new CompteForm($compte);
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
    }

    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $this->forward404Unless($compte = ComptePeer::retrieveByPk($request->getParameter('id')), sprintf('Object compte does not exist (%s).', $request->getParameter('id')));
        $this->form = new CompteForm($compte);
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getAttribute('user_id', null, 'user'));
        $this->processForm($request, $this->form);
        $this->redirect('compte/index');
    }

    /**
     * Delete a Compte if user has enough credentials
     *
     * @param   sfWebRequest $request
     */
    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();
        $this->forward404Unless($compte = ComptePeer::retrieveByPk($request->getParameter('id')), sprintf('Object compte does not exist (%s).', $request->getParameter('id')));

        if ($this->compte->getAssociationId() != $this->getUser()->getAttribute('association_id', null, 'user')) {
            $this->forward('error', 'credentials');
        }

        $compte->delete();
        $this->redirect('compte/index');
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $compte = $form->save();
            $this->redirect('compte/index');
        }
    }
}
