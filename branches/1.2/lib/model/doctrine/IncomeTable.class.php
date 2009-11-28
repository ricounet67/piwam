<?php
/**
 * Implements operations on Income table
 *
 * @package     piwam
 * @subpackage  model
 * @author      Adrien Mogenet
 * @since       1.2
 */
class IncomeTable extends Doctrine_Table
{
  /**
   * Get the amount of unpaid expenses by association $id
   *
   * @param   integer     $id
   * @return  integer
   */
  public static function getAmountOfDebtsForAssociation($id)
  {
    $q = Doctrine_Query::create()
          ->select('SUM(i.amount) AS total')
          ->from('Income i')
          ->where('i.association_id = ?', $id)
          ->andWhere('i.received = ?', false)
          ->groupBy('i.association_id');

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