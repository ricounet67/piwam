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
  const STATE_DISABLED = 0;

  /**
   * Value of state field when enabled
   *
   * @var integer
   */
  const STATE_ENABLED = 1;

  /**
   * Value of state field for a standard system account
   * that is required by Piwam
   *
   * @var integer
   */
  const STATE_SYSTEM  = 3;

  /**
   * Retrieve an Account by its $id
   *
   * @param   integer   $id
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
   * Retrieve an Account by its $code
   * 
   * @param   integer   $code
   * @return  Account
   */
  public static function getByCode($code, $associationId)
  {
    $q = Doctrine_Query::create()
      ->from('Account a')
      ->where('a.code = ?', $code)
      ->andWhere('a.association_id = ?', $associationId);

    return $q->fetchOne();
  }

  /**
   * Insert a new account according to give codes (for the account and for
   * its parent if any)
   *
   * @param   integer   $reference : Reference of the new Account
   * @param   integer   $parent : Reference of the parent Account
   * @param   string    $label
   * @param   integer   $associationId
   * @param   integer   $state
   * @return  Account   The resulting Account object
   */
  public static function add($code, $parent, $label, $associationId, $state = null)
  {
    $account = new Account();
    $account->setCode($code);

    if ($parent)
    {
      $parentAccount = self::getByCode($parent, $associationId);
      $account->setParentId($parentAccount->getId());
    }

    if ($state === null)
    {
      $state = self::STATE_SYSTEM;
    }
    
    $account->setAssociationId($associationId);
    $account->setLabel($label);
    $account->setState($state);
    $account->save();

    return $account;
  }

  /**
   * Retrieve list of root accounts (without parent accounts)
   *
   * @param   integer   $associationId
   * @return  array
   */
  public static function getRootAccounts($associationId)
  {
    $q = Doctrine_Query::create()
      ->from('Account a')
      ->where('a.parent_id IS NULL');

    return $q->execute();
  }
}