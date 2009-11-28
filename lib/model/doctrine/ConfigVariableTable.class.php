<?php
/**
 * Implements operations on ConfigVariable table
 *
 * @package     piwam
 * @subpackage  model
 * @author      Adrien Mogenet
 * @since       1.2
 */
class ConfigVariableTable extends Doctrine_Table
{
  /**
   * Get a ConfigVariable by its code
   *
   * @param   string  $code
   * @return  ConfigVariable
   */
  public static function getByCode($code)
  {
    $q = Doctrine_Query::create()
          ->from('ConfigVariable v')
          ->where('v.code = ?', $code);

    return $q->fetchOne();
  }
}