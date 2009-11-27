<?php
/**
 * Implements operations on AclCredential table (credentials that are
 * given to a Member)
 *
 * @package     piwam
 * @subpackage  model
 * @author      Adrien Mogenet
 * @since       1.2
 */
class AclCredentialTable extends Doctrine_Table
{
  /**
   * Retrieve Credentials for member $id
   *
   * @param   integer   $id
   * @return  array of AclCredential
   */
  public static function getForMember($id)
  {
    $q = Doctrine_Query::create()
          ->from('AclCredential c')
          ->where('c.member_id = ?', $id);

    return $q->fetchArray();
  }
}