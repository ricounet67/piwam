<?php
/**
 * Implements operations on DueType table
 *
 * @package     piwam
 * @subpackage  model
 * @author      Adrien Mogenet
 * @since       1.2
 */
abstract class PluginDueTypeTable extends Doctrine_Table
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
  const STATE_ENABLED  = 1;

  /**
   * Retrieve an unique DueType by its id
   *
   * @param   integer $id
   * @return  DueType
   */
  public static function getById($id)
  {
    $q = Doctrine_Query::create()
          ->from('DueType t')
          ->where('t.id = ?', $id);

    return $q->fetchOne();
  }

  /**
   * Returns number of existing types for an association
   *
   * @param   integer     $id
   * @return  integer
   */
  public static function countForAssociation($id)
  {
    $q = Doctrine_Query::create()
          ->select('t.id')
          ->from('DueType t')
          ->where('t.state = ?', self::STATE_ENABLED)
          ->andWhere('t.association_id = ?', $id);

    return $q->count();
  }

  /**
   * Retrieve active types for association $id. If a $date is supplied,
   * only available types are retrieved, according to their period
   * settings
   *
   * @param   integer           $id
   * @param   string            $date
   * @return  array of DueType
   */
  public static function getEnabledForAssociation($id, $date = null)
  {
    $q = self::getQueryEnabledForAssociation($id);

    return $q->execute();
  }

  /**
   * Get Query object to retrieve list of DueType. If a $date is supplied,
   * only available types are retrieved, according to their period
   * settings
   *
   * @param   integer           $id
   * @param   string            $date
   * @return  Doctrine_Query
   */
  public static function getQueryEnabledForAssociation($id, $date = null)
  {
    $q = Doctrine_Query::create()
          ->from('DueType t')
          ->where('t.state = ?', self::STATE_ENABLED)
          ->andWhere('t.association_id = ?', $id);

    if (null !== $date)
    {
      $q->andWhere('(t.start_period <= ? OR t.start_period IS NULL)', $date)
        ->andWhere('(t.end_period >= ? OR t.start_period IS NULL)', $date);
    }

    $q->orderBy('t.start_period DESC');

    return $q;
  }

  /**
   * Get amount of DueType $id
   *
   * @param   integer $id
   * @return  omteger
   */
  public static function getAmountForType($id)
  {
    $q = Doctrine_Query::create()
          ->select('t.amount')
          ->from('DueType t')
          ->where('t.id = ?', $id);

    $type = $q->fetchOne();

    return $type->getAmount();
  }

  /**
   * Count existing DueType
   *
   * @return  integer
   */
  public static function doCount()
  {
    $q = Doctrine_Query::create()
          ->select('t.id')
          ->from('DueType t');

    return $q->count();
  }
}