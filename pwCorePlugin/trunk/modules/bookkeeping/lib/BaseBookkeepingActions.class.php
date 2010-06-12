<?php
/*
 * This file is part of the piwam package.
 * (c) Adrien Mogenet <adrien.mogenet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


/**
 * Bookkeeping actions.
 *
 * @package    piwam
 * @subpackage association
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12474 2010-05-11 10:41:27Z adrien $
 * @since      1.2
 */
class BaseBookkeepingActions extends sfActions
{
  /**
   * Home of bookkeeping module. List last entries
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->entries = EntryTable::getLastEntries($this->getUser()->getAssociationId());
  }

  /**
   * Display form to add a new entry
   *
   * @param sfWebRequest $request 
   */
  public function executeNewEntry(sfWebRequest $request)
  {
    $this->form = new EntryForm(null, array('user' => $this->getUser()));
  }

  /**
   * Check form and insert a new Entry
   *
   * @param sfWebRequest $request 
   */
  public function executeCreateEntry(sfWebRequest $request)
  {
    $this->setTemplate('newEntry');
    $this->form = new EntryForm(null, array('user' => $this->getUser()));
    $this->processForm($request, $this->form);
  }

  /**
   * Display a form, to edit an existing entry
   *
   * @param sfWebRequest $request
   */
  public function executeEditEntry(sfWebRequest $request)
  {
    $entry = EntryTable::getById($request->getParameter('id'));
    $this->forward404Unless($entry);
    $this->form = new EntryForm($entry, array('user' => $this->getUser()));
    $this->setTemplate('newEntry');
  }

  /**
   * Process data provided by EntryForm
   *
   * @param   sfWebRequest  $request
   */
  public function executeUpdateEntry(sfWebRequest $request)
  {
    $this->form = new EntryForm(null, array('user' => $this->getUser()));
    $this->processForm($request, $this->form);
    $this->setTemplate('newEntry');
  }

  /**
   * Add a new Credit form. Ajax call from the newEntry template, when user
   * clicks on "add credit" button
   *
   * @param sfWebRequest $request
   */
  public function executeAddCreditForm(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());

    if (null !== $request->getParameter('id', null))
    {
      $entry = EntryTable::getById($request->getParameter('id', null));
      $form = new EntryForm($entry, array('user' => $this->getUser()));
    }
    else
    {
      $form = new EntryForm(null, array('user' => $this->getUser()));
    }

    $number = $request->getParameter('num') + 1;
    $key = 'credit_' . $number;
    $form->addCreditForm($key);

    return $this->renderPartial('addCreditForm', array('form' => $form['credits'][$key], 'num' => $number));
  }

  /**
   * Add a new Debit form. Ajax call from the newEntry template, when user
   * clicks on "add debit" button
   *
   * @param sfWebRequest $request
   */
  public function executeAddDebitForm(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());

    if (null !== $request->getParameter('id', null))
    {
      $entry = EntryTable::getById($request->getParameter('id', null));
      $form = new EntryForm($entry, array('user' => $this->getUser()));
    }
    else
    {
      $form = new EntryForm(null, array('user' => $this->getUser()));
    }

    $number = $request->getParameter('num') + 1;
    $key = 'debit_' . $number;
    $form->addDebitForm($key);

    return $this->renderPartial('addDebitForm', array('form' => $form['debits'][$key], 'num' => $number));
  }

  /**
   * Process data provided by EntryForm, and all the embedded forms.
   * Redirects to the index view if everything went fine.
   *
   * @param   sfWebRequest    $request
   * @param   EntryForm       $form
   */
  protected function processForm(sfWebRequest $request, EntryForm $form)
  {
    $form->bind($q = $request->getParameter($form->getName()));

    if ($form->isValid())
    {
      $form->save();
      $this->redirect('@bk_overview');
    }
  }
}
?>
