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
   * Home of bookkeeping module
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
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
   * Add a new Credit form
   *
   * @param sfWebRequest $request
   */
  public function executeAddCreditForm(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());

    if ($entry = EntryTable::getById($request->getParameter('id')))
    {
      $form = new EntryForm($credit, array('user' => $this->getUser()));
    }
    else
    {
      $form = new EntryForm(null, array('user' => $this->getUser()));
    }

    $number = $request->getParameter('num') + 1;
    $key = 'credit_' . $number;
    $form->addCreditForm($key);

    //return $this->renderText($this->renderPartial('addCreditForm',array('form' => $form['credits'][$key], 'num' => $number)));
    return $this->renderPartial('addCreditForm', array('form' => $form['credits'][$key], 'num' => $number));
  }
}
?>
