<?php

/**
 * statut actions.
 *
 * @package    piwam
 * @subpackage statut
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class statutActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $this->statut_list = StatutPeer::doSelectEnabled($this->getUser()->getAttribute('association_id', null, 'user'));
    }

    public function executeShow(sfWebRequest $request)
    {
        $this->statut = StatutPeer::retrieveByPk($request->getParameter('id'));
        $this->forward404Unless($this->statut);
    }

    public function executeNew(sfWebRequest $request)
    {
        $this->form = new StatutForm();
    }

    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new StatutForm();
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->forward404Unless($statut = StatutPeer::retrieveByPk($request->getParameter('id')), sprintf('Object statut does not exist (%s).', $request->getParameter('id')));
        $this->form = new StatutForm($statut);
    }

    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $this->forward404Unless($statut = StatutPeer::retrieveByPk($request->getParameter('id')), sprintf('Object statut does not exist (%s).', $request->getParameter('id')));
        $this->form = new StatutForm($statut);
        $this->processForm($request, $this->form);
        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();
        $this->forward404Unless($statut = StatutPeer::retrieveByPk($request->getParameter('id')), sprintf('Object statut does not exist (%s).', $request->getParameter('id')));
        $statut->delete();
        $this->redirect('statut/index');
    }

    
    /**
     * If the form had been submit, we immediately set the statut
     * as enabled
     *
     * @param   sfWebRequest    $request
     * @param   sfForm          $form
     */
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {    
            $statut = $form->save();
            $statut->setActif(StatutPeer::IS_ACTIF);
            $statut->save();
            $this->redirect('statut/index');
        }
    }
}
