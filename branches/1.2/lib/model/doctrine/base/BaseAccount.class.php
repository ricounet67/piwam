<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Account', 'doctrine');

/**
 * BaseAccount
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $label
 * @property integer $association_id
 * @property string $reference
 * @property integer $state
 * @property integer $created_by
 * @property integer $updated_by
 * @property Association $Association
 * @property Member $Member
 * @property Member $Member_3
 * @property Doctrine_Collection $Due
 * @property Doctrine_Collection $Expense
 * @property Doctrine_Collection $Income
 * 
 * @method integer             getId()             Returns the current record's "id" value
 * @method string              getLabel()          Returns the current record's "label" value
 * @method integer             getAssociationId()  Returns the current record's "association_id" value
 * @method string              getReference()      Returns the current record's "reference" value
 * @method integer             getState()          Returns the current record's "state" value
 * @method integer             getCreatedBy()      Returns the current record's "created_by" value
 * @method integer             getUpdatedBy()      Returns the current record's "updated_by" value
 * @method Association         getAssociation()    Returns the current record's "Association" value
 * @method Member              getMember()         Returns the current record's "Member" value
 * @method Member              getMember3()        Returns the current record's "Member_3" value
 * @method Doctrine_Collection getDue()            Returns the current record's "Due" collection
 * @method Doctrine_Collection getExpense()        Returns the current record's "Expense" collection
 * @method Doctrine_Collection getIncome()         Returns the current record's "Income" collection
 * @method Account             setId()             Sets the current record's "id" value
 * @method Account             setLabel()          Sets the current record's "label" value
 * @method Account             setAssociationId()  Sets the current record's "association_id" value
 * @method Account             setReference()      Sets the current record's "reference" value
 * @method Account             setState()          Sets the current record's "state" value
 * @method Account             setCreatedBy()      Sets the current record's "created_by" value
 * @method Account             setUpdatedBy()      Sets the current record's "updated_by" value
 * @method Account             setAssociation()    Sets the current record's "Association" value
 * @method Account             setMember()         Sets the current record's "Member" value
 * @method Account             setMember3()        Sets the current record's "Member_3" value
 * @method Account             setDue()            Sets the current record's "Due" collection
 * @method Account             setExpense()        Sets the current record's "Expense" collection
 * @method Account             setIncome()         Sets the current record's "Income" collection
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6716 2009-11-12 19:26:28Z jwage $
 */
abstract class BaseAccount extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('piwam_account');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('label', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '255',
             ));
        $this->hasColumn('association_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('reference', 'string', 64, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '64',
             ));
        $this->hasColumn('state', 'integer', 1, array(
             'type' => 'integer',
             'default' => '1',
             'length' => '1',
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
        $this->hasOne('Association', array(
             'local' => 'association_id',
             'foreign' => 'id'));

        $this->hasOne('Member', array(
             'local' => 'created_by',
             'foreign' => 'id'));

        $this->hasOne('Member as Member_3', array(
             'local' => 'updated_by',
             'foreign' => 'id'));

        $this->hasMany('Due', array(
             'local' => 'id',
             'foreign' => 'account_id'));

        $this->hasMany('Expense', array(
             'local' => 'id',
             'foreign' => 'account_id'));

        $this->hasMany('Income', array(
             'local' => 'id',
             'foreign' => 'account_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}