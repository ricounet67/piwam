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
abstract class AclGroupPermissionTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object sfGuardGroupPermission
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sfGuardGroupPermission');
    }
	/**
	 * Return true if the group has the specified credential, otherwise return false
	 * @param integer $group_id
	 * @param integer $right_code
	 */
	public static function groupHasPermission($group_id,$right)
	{
		$q = Doctrine_Query::create()
			->from('sfGuardGroupPermission gr')
			->andWhere('gr.group_id = ?', $group_id)
			->andWhere('gr.Permission.name = ?', $right);
		return ($q->fetchOne() ? true : false);
	}
 /**
   * Retrieve all existing AclActions in sfGuardGroup
   *
   * @return  array of AclAction
   */
  public static function getAllPermissionsByGroupId($group_id)
  {
    $q = Doctrine_Query::create()
          ->from('sfGuardPermission p');
		$q->leftJoin('sfGuardGroupPermission gr');
		$q->where('gr.group_id = ?',$group_id);
    return $q->execute();
  }
	/**
	 * Get credential for group id specified
	 * @param $group_id
	 * @return DoctrineCollection of AclCredential
	 */
	public static function permissionsByGroupId($group_id)
	{
		$q = Doctrine_Query::create()
			->from('sfGuardGroupPermission gr')
			->andWhere('gr.group_id = ?', $group_id);
		return $q->execute();
	}
	public static function removePermissionsByGroupId($group_id)
	{
		$q = Doctrine_Query::create()
			->delete()
			->from('sfGuardGroupPermission gr')
			->andWhere('gr.group_id = ?', $group_id);
		return $q->execute();
	}
}