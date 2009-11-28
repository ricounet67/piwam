<?php
/**
 * Implements operations on Expense table
 *
 * @package     piwam
 * @subpackage  model
 * @author      Adrien Mogenet
 * @since       1.2
 */
class ExpenseTable extends Doctrine_Table
{
  /**
   * Retrieve enabled expenses for association $id
   *
   * @param   integer           $id
   * @return  array of Expense
   */
  public static function getPagerForAssociation($id, $page = 1)
  {
    $q = Doctrine_Query::create()
          ->from('Expense e')
          ->where('e.association_id = ?', $id);

    /**
     * @todo
     * FIXME
     */
    $pager = new sfDoctrinePager('Expense', 20);
    $pager->setQuery($q);
    $pager->setPage($page);

    return $pager;
  }
}