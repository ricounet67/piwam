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
   * @todo    Customize number of results per page, add filters
   */
  public static function getPagerForAssociation($id, $page = 1)
  {
    $q = Doctrine_Query::create()
          ->from('Expense e')
          ->where('e.association_id = ?', $id);

    $pager = new sfDoctrinePager('Expense', 20);
    $pager->setQuery($q);
    $pager->setPage($page);

    return $pager;
  }

  /**
   * Retrieve an expense by its id
   *
   * @param   integer $id
   *
   * @return  Expense
   */
  public static function getById($id)
  {
    $q = Doctrine_Query::create()
          ->from('Expense e')
          ->where('e.id = ?', $id);

    return $q->fetchOne();
  }

  /**
   * Get the amount of unpaid expenses by association $id
   *
   * @param   integer     $id
   * @return  integer
   */
  public static function getAmountOfDebtsForAssociation($id)
  {
    $q = Doctrine_Query::create()
          ->select('SUM(e.amount) AS total')
          ->from('Expense e')
          ->where('e.association_id = ?', $id)
          ->andWhere('e.paid = ?', false)
          ->groupBy('e.association_id');

    $row = $q->fetchArray();

    if (count($row))
    {
      return $row[0]['total'];
    }
    else
    {
      return 0;
    }
  }
}