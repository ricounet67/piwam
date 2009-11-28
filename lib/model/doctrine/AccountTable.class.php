<?php
/**
 * Implements operations on Account table
 *
 * @package     piwam
 * @subpackage  model
 * @since       1.2
 * @author      Adrien Mogenet
 */
class AccountTable extends Doctrine_Table
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
   * Retrieve an unique account by its id
   *
   * @param   integer       $id
   * @return  Account
   */
  public static function getById($id)
  {
    $q = Doctrine_Query::create()
          ->from('Account a')
          ->where('a.id = ?', $id);

    return $q->fetchOne();
  }

  /**
   * Retrieve enabled account for association $id
   *
   * @param   integer         $id
   * @return  array of Account
   */
  public static function getEnabledForAssociation($id)
  {
    $q = Doctrine_Query::create()
          ->from('Account a')
          ->where('a.state = ?', self::STATE_ENABLED)
          ->andWhere('a.association_id = ?', $id);

    return $q->execute();
  }
}