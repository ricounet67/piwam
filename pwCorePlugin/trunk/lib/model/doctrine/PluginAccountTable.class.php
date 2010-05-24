<?php
/**
 * Implements operations on Account table
 *
 * @package     piwam
 * @subpackage  model
 * @since       1.2
 * @author      Adrien Mogenet
 */
abstract class PluginAccountTable extends Doctrine_Table
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
   * Insert a new account
   *
   * @param   string    $label
   * @param   string    $reference
   * @param   integer   $associationId
   * @return  Account   The resulting Account object
   */
  public static function add($code, $parent, $label, $associationId)
  {
    $account = new Account();
    $account->setId($code);
    $account->setParentId($parent);
    $account->setAssociationId($associationId);
    $account->setLabel($label);
    $account->setState(AccountTable::STATE_ENABLED);
    $account->save();

    return $account;
  }
}