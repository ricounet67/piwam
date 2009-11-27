<?php
/**
 * Implements operations on AclAction table
 *
 * @package     piwam
 * @subpackage  model
 * @since       1.2
 * @author      Adrien Mogenet
 */
class AclActionTable extends Doctrine_Table
{
  public static function getAll()
  {
    $q = Doctrine_Query::create()
          ->from('AclAction a')
          ->fetchArray();

    return $q;
  }
}