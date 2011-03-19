<?php

/**
 * association actions.
 *
 * @package    piwam
 * @subpackage association
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class BaseassociationActions extends sfActions
{
  /*
   * Make some operations easier
   *
   * @var Association
   */
  private $_association = null;

  /**
   * Display config form to edit Association's configuration
   *
   * @param   sfWebRequest    $request
   * @since   r75
   */
  public function executeConfig(sfWebRequest $request)
  {
    if ($request->isMethod('post'))
    {
      $data = $request->getParameter('config');

      foreach ($data as $key => $value)
      {
        Configurator::set($key, $value, $this->getUser()->getAssociationId());
      }
      $this->getUser()->setFlash('notice', 'Les préférences ont bien été prises en compte.', false);
    }

    $this->form = new ConfigForm();
  }

  /**
   * We don't have any way to list the associations
   *
   * @param   sfWebRequest    $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->redirectUnless($this->_canRegisterNewAssociation(),'@login');
    if($this->getUser()->isAnonymous())
    {
      $this->setLayout('no_menu');
    }
    $this->associationsPager = AssociationTable::doSelectAssociations($request->getParameter('page', 1));
  }

  /**
   * Display creation form to register a new Assocation
   *
   * @param   sfWebRequest    $request
   */
  public function executeNew(sfWebRequest $request)
  {
    $this->redirectUnless($this->_canRegisterNewAssociation(),'@login');
    if($this->getUser()->isAnonymous())
    {
      $this->setLayout('no_menu');
    }
    $this->getUser()->removeTemporaryData();
    $this->form = new AssociationForm();
  }

  /**
   * Perform the creation of the new Association
   *
   * @param   sfWebRequest    $request
   */
  public function executeCreate(sfWebRequest $request)
  {
    $this->redirectUnless($this->_canRegisterNewAssociation(),'@login');
    if($this->getUser()->isAnonymous())
    {
      $this->setLayout('no_menu');
    }
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new AssociationForm();
    if ($this->processForm($request, $this->form))
    {
      $this->_association->initialize();
      $this->getUser()->setTemporaryAssociationId($this->_association->getId());
      $this->redirect('@register_first_member');
    }
    else
    {
      $this->setTemplate('new');
    }
  }

  /**
   * Display form to edit Association's information. ID of association
   * to edit is not retrieved from the URI but from the current user's
   * association.
   *
   * @param   sfWebRequest    $request
   */
  public function executeEdit(sfWebRequest $request)
  {
    $id = $this->getUser()->getAssociationId();
    $association = AssociationTable::getById($id);
    $this->forward404Unless($association, "L'association {$id} n'existe pas.");
    $this->form = new AssociationForm($association);
    $this->form->setDefault('updated_by', $this->getUser()->getUserId());
  }

  /**
   * Perform update of fields. Name of the association is also updated for the
   * session of the current user
   *
   * @param   sfWebRequest    $request
   */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $id = $request->getParameter('id');
    $association = AssociationTable::getById($id);
    $this->forward404Unless($association, "L'association {$id} n'existe pas.");
    $this->form = new AssociationForm($association);

    if ($this->processForm($request, $this->form, true))
    {
      $this->getUser()->setAttribute('association_name', $association->getName(), 'user');
      $this->redirect('@homepage');
    }
    else
    {
      $this->setTemplate('edit');
    }
  }

  /**
   * Perform the deletion
   *
   * @param   sfWebRequest    $request
   */
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $id = $request->getParameter('id');
    $association = AssociationTable::getById($id);
    $this->forward404Unless($association, "L'association {$id} n'existe pas.");
    $association->delete();
    $this->redirect('@associations_list');
  }

  /*
   * Process data sent from the form
   */
  protected function processForm(sfWebRequest $request, AssociationForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    $isNew = $form->getObject()->isNew();
    if ($form->isValid())
    {
      $this->_association = $form->save();
      if($isNew)
      {
        DbTools::loadYmlFileForAssociation(
          sfConfig::get('sf_plugins_dir').'/pwCorePlugin/data/fixtures/configuration2.yml',$this->_association->getId(),true);
        // event association created
        $this->dispatcher->notify(new sfEvent($this, 'association.created',array(
          'association'=>$this->_association,
        )));
        
      }
      $params = $request->getParameter('association');
      if (isset($params['ping_piwam']) && $params['ping_piwam'] == 1)
      {
        $this->getUser()->setAttribute('ping_piwam', '1', 'temp');
      }
      return true;
    }
    return false;
  }
  /**
   * Return true if mode multi association is enabled or we are creating first association
   * @return boolean true if current user can create association
   */
  private function _canRegisterNewAssociation()
  {
    $flag1 = sfConfig::get('app_multi_association', false);
    $flag2 = sfConfig::get('app_anonymous_create_association', false);
    
    return (($flag1 && $flag2) || ($this->getUser()->isAuthenticated() && $flag1) || !PiwamOperations::associationIsCreated());
  }
}
