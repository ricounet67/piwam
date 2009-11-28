<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AclCredential', 'doctrine');

/**
 * BaseAclCredential
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $member_id
 * @property integer $acl_action_id
 * @property AclAction $AclAction
 * @property Member $Member
 * 
 * @method integer       getId()            Returns the current record's "id" value
 * @method integer       getMemberId()      Returns the current record's "member_id" value
 * @method integer       getAclActionId()   Returns the current record's "acl_action_id" value
 * @method AclAction     getAclAction()     Returns the current record's "AclAction" value
 * @method Member        getMember()        Returns the current record's "Member" value
 * @method AclCredential setId()            Sets the current record's "id" value
 * @method AclCredential setMemberId()      Sets the current record's "member_id" value
 * @method AclCredential setAclActionId()   Sets the current record's "acl_action_id" value
 * @method AclCredential setAclAction()     Sets the current record's "AclAction" value
 * @method AclCredential setMember()        Sets the current record's "Member" value
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6716 2009-11-12 19:26:28Z jwage $
 */
abstract class BaseAclCredential extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('piwam_acl_credential');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('member_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('acl_action_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('AclAction', array(
             'local' => 'acl_action_id',
             'foreign' => 'id'));

        $this->hasOne('Member', array(
             'local' => 'member_id',
             'foreign' => 'id'));
    }
}