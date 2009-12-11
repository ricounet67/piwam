<?php
/**
 * New actions provided by the pwSandboxPlugin
 *
 * @package     pwSandboxPlugin
 * @subpackage  actions
 * @author      adrien
 * @since       1.2
 */
class pwSandboxActions extends sfActions
{
  /**
   * A method called `executeFoobar` declares a `foobar` action.
   * You can access to your action through URL `yourModule/foobar`
   * if no action is provided (e.g.: `yourModule`) the index action
   * will be called by default.
   *
   * Here, the 'index' action will list the existing debts for the
   * current association.
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    /*
     * Method ->getUser() returns a myUser instance, which represents
     * the session of the current user.
     * That myUser object can provide some useful information as
     * described in the documentation (User ID, username...)
     */
    $associationId = $this->getUser()->getAssociationId();

    /*
     * Now, we retrieve the list of existing debts thanks to the
     * method we implemented in DebtTable
     */
    $debts = DebtTable::getAllForAssociation($associationId);

    /*
     * And finally, we give the variable to the view to be able
     * to display them. Open `indexSuccess.php` to discover how
     * to use these variables.
     */
    $this->debts = $debts;
  }

  /**
   * The action `new` will display the form to add a new debt
   * for a member
   * 
   * @param sfWebRequest $request
   */
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new DebtForm();
  }
}
?>
