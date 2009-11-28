<?php
/**
 * Implements operations on Status table
 *
 * @package     piwam
 * @subpackage  model
 * @author      adrien
 * @since       1.2
 */
class StatusTable extends Doctrine_Table
{
  /**
   * Value of state field when disabled
   *
   * @var integer
   */
  const STATE_DISABLED    = 0;

  /**
   * Value of state field when enabled
   *
   * @var integer
   */
  const STATE_ENABLED     = 1;

  /**
   * Retrieve existing status for association $id
   *
   * @param   integer         $id
   * @return  array of Status
   */
  public static function getEnabledForAssociation($id)
  {
    $q = Doctrine_Query::create()
          ->from('Status s')
          ->where('s.association_id = ?',  $id)
          ->andWhere('s.state = ?', self::STATE_ENABLED);

    return $q->execute();
  }

}