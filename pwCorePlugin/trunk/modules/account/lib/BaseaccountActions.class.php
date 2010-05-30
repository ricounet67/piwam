<?php

/**
 * Account actions.
 *
 * @package    piwam
 * @subpackage account
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class BaseaccountActions extends sfActions
{
  /**
   * List existing acciunts
   *
   * @param  sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $associationId = $this->getUser()->getAssociationId();
    $this->accounts = AccountTable::getRootAccounts($associationId);
  }

  /**
   * Show details about a particular Account
   *
   * @param   sfWebRequest $request
   */
  public function executeShow(sfWebRequest $request)
  {
  }

  /**
   * Display a form to register a new account
   *
   * @param 	sfWebRequest	$request
   */
  public function executeNew(sfWebRequest $request)
  {
    $parentId = $request->getParameter('parent_id');
    $this->form = new AccountForm(null, array(
      'user' => $this->getUser(),
      'parentId' => $parentId
    ));
  }

  /**
   * Perform the creation ; display the form again if an error occured
   *
   * @param 	sfWebRequest	$request
   */
  public function executeCreate(sfWebRequest $request)
  {
  }

  /**
   * Display the form to edit an existing account object
   *
   * @param 	sfWebRequest	$request
   */
  public function executeEdit(sfWebRequest $request)
  {
    if ($account->getAssociationId() != $this->getUser()->getAssociationId())
    {
      $this->redirect('@error_credentials');
    }
  }

  /**
   * Perform the update of information
   *
   * @param 	sfWebRequest	$request
   */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }

  /**
   * Delete a Compte if user has enough credentials
   *
   * @param   sfWebRequest $request
   */
  public function executeDelete(sfWebRequest $request)
  {
    if ($account->getAssociationId() != $this->getUser()->getAssociationId())
    {
      $this->redirect('@error_credentials');
    }
  }

  /**
   * Process values got from the form. Redirects to the list of accounts
   * if everything went fine
   *
   * @param   sfWebRequest    $request
   * @param   sfForm          $form
   */
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));

    if ($form->isValid())
    {
      $account = $form->save();
      $this->redirect('@accounts_list');
    }
  }
}