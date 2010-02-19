<?php
/**
 * config_member actions.
 *
 * @package    piwam
 * @subpackage config_member
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class config_memberActions extends sfActions
{
 /**
  * Main screen to customize extra rows. Process form if it has been
  * submit.
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $associationId = $this->getUser()->getAssociationId();
    $this->form = new MemberExtraRowForm();

    if ($request->isMethod('post'))
    {
      $this->_processForm($request, $this->form);
    }
    
    $this->extraRows = MemberExtraRowTable::getForAssociation($associationId);
  }

  /*
   * Process form values
   *
   * @param MemberExtraRowForm $form
   */
  private function _processForm(sfWebRequest $request, MemberExtraRowForm $form)
  {
    $form->bind($request->getParameter($form->getName()));

    if ($form->isValid())
    {
      $row = $form->save();
      $this->getUser()->setFlash('notice', 'Champ ajouté avec succès.');
    }
  }
}
