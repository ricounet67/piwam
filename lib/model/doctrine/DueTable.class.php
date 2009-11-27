<?php
/**
 * Implements operations on Due table
 *
 * @package     piwam
 * @subpackage  model
 * @since       1.2
 * @author      adrien
 */
class DueTable extends Doctrine_Table
{
  /**
   * Retrieve Dues paid by member $id
   *
   * @param   integer $id
   * @return  array of Due
   */
  public static function getForUser($id)
  {
    $q = Doctrine_Query::create()
          ->from('Due d')
          ->where('d.member_id = ?', $id);

    return $q->fetchArray();
  }
}