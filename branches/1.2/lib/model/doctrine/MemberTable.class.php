<?php
/**
 * Doctrine class to retrieve rows of Member table
 *
 * @author  Adrien Mogenet
 * @since   1.2
 */
class MemberTable extends Doctrine_Table
{
  /**
   * Get the list of active members who belong to the
   * association $id
   *
   * @param   integer         $id
   * @return  array of Membre
   */
  public static function getForAssociation($id)
  {
    $q = Doctrine_Query::create()
          ->select('m.*')
          ->from('Member m')
          ->where('m.association_id = ?', $id)
          ->execute();

    return $q;
  }
}