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
  public function executeIndex(sfWebRequest $request)
  {
    $this->membre_list = MembrePeer::doSelect(new Criteria());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->membre = MembrePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->membre);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new MembreForm();
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

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $membre = $form->save();

      $this->redirect('membre/edit?id='.$membre->getId());
    }
  }
}
