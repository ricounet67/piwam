<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AclAction', 'doctrine');

/**
 * BaseAclAction
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $acl_module_id
 * @property string $label
 * @property string $code
 * @property AclModule $AclModule
 * @property Doctrine_Collection $AclCredential
 * 
 * @method integer             getId()            Returns the current record's "id" value
 * @method integer             getAclModuleId()   Returns the current record's "acl_module_id" value
 * @method string              getLabel()         Returns the current record's "label" value
 * @method string              getCode()          Returns the current record's "code" value
 * @method AclModule           getAclModule()     Returns the current record's "AclModule" value
 * @method Doctrine_Collection getAclCredential() Returns the current record's "AclCredential" collection
 * @method AclAction           setId()            Sets the current record's "id" value
 * @method AclAction           setAclModuleId()   Sets the current record's "acl_module_id" value
 * @method AclAction           setLabel()         Sets the current record's "label" value
 * @method AclAction           setCode()          Sets the current record's "code" value
 * @method AclAction           setAclModule()     Sets the current record's "AclModule" value
 * @method AclAction           setAclCredential() Sets the current record's "AclCredential" collection
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6716 2009-11-12 19:26:28Z jwage $
 */
abstract class BaseAclAction extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('piwam_acl_action');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('acl_module_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('label', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '255',
             ));
        $this->hasColumn('code', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '100',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('AclModule', array(
             'local' => 'acl_module_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('AclCredential', array(
             'local' => 'id',
             'foreign' => 'acl_action_id'));
    }
}