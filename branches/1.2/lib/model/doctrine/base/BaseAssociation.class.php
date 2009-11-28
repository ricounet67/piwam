<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Association', 'doctrine');

/**
 * BaseAssociation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $website
 * @property integer $created_by
 * @property integer $updated_by
 * @property Doctrine_Collection $Activity
 * @property Doctrine_Collection $Account
 * @property Doctrine_Collection $ConfigValue
 * @property DueType $DueType
 * @property Doctrine_Collection $Expense
 * @property Doctrine_Collection $Income
 * @property Doctrine_Collection $Status
 * @property Doctrine_Collection $Member
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getName()        Returns the current record's "name" value
 * @method string              getDescription() Returns the current record's "description" value
 * @method string              getWebsite()     Returns the current record's "website" value
 * @method integer             getCreatedBy()   Returns the current record's "created_by" value
 * @method integer             getUpdatedBy()   Returns the current record's "updated_by" value
 * @method Doctrine_Collection getActivity()    Returns the current record's "Activity" collection
 * @method Doctrine_Collection getAccount()     Returns the current record's "Account" collection
 * @method Doctrine_Collection getConfigValue() Returns the current record's "ConfigValue" collection
 * @method DueType             getDueType()     Returns the current record's "DueType" value
 * @method Doctrine_Collection getExpense()     Returns the current record's "Expense" collection
 * @method Doctrine_Collection getIncome()      Returns the current record's "Income" collection
 * @method Doctrine_Collection getStatus()      Returns the current record's "Status" collection
 * @method Doctrine_Collection getMember()      Returns the current record's "Member" collection
 * @method Association         setId()          Sets the current record's "id" value
 * @method Association         setName()        Sets the current record's "name" value
 * @method Association         setDescription() Sets the current record's "description" value
 * @method Association         setWebsite()     Sets the current record's "website" value
 * @method Association         setCreatedBy()   Sets the current record's "created_by" value
 * @method Association         setUpdatedBy()   Sets the current record's "updated_by" value
 * @method Association         setActivity()    Sets the current record's "Activity" collection
 * @method Association         setAccount()     Sets the current record's "Account" collection
 * @method Association         setConfigValue() Sets the current record's "ConfigValue" collection
 * @method Association         setDueType()     Sets the current record's "DueType" value
 * @method Association         setExpense()     Sets the current record's "Expense" collection
 * @method Association         setIncome()      Sets the current record's "Income" collection
 * @method Association         setStatus()      Sets the current record's "Status" collection
 * @method Association         setMember()      Sets the current record's "Member" collection
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6716 2009-11-12 19:26:28Z jwage $
 */
abstract class BaseAssociation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('piwam_association');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 120, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '120',
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('website', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('created_by', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('updated_by', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Activity', array(
             'local' => 'id',
             'foreign' => 'association_id'));

        $this->hasMany('Account', array(
             'local' => 'id',
             'foreign' => 'association_id'));

        $this->hasMany('ConfigValue', array(
             'local' => 'id',
             'foreign' => 'association_id'));

        $this->hasOne('DueType', array(
             'local' => 'id',
             'foreign' => 'association_id type: many'));

        $this->hasMany('Expense', array(
             'local' => 'id',
             'foreign' => 'association_id'));

        $this->hasMany('Income', array(
             'local' => 'id',
             'foreign' => 'association_id'));

        $this->hasMany('Status', array(
             'local' => 'id',
             'foreign' => 'association_id'));

        $this->hasMany('Member', array(
             'local' => 'id',
             'foreign' => 'association_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}