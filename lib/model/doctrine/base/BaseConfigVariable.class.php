<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('ConfigVariable', 'doctrine');

/**
 * BaseConfigVariable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $code
 * @property string $category_code
 * @property string $label
 * @property string $description
 * @property string $type
 * @property string $default_value
 * @property ConfigCategory $ConfigCategory
 * @property Doctrine_Collection $ConfigValue
 * 
 * @method integer             getId()             Returns the current record's "id" value
 * @method string              getCode()           Returns the current record's "code" value
 * @method string              getCategoryCode()   Returns the current record's "category_code" value
 * @method string              getLabel()          Returns the current record's "label" value
 * @method string              getDescription()    Returns the current record's "description" value
 * @method string              getType()           Returns the current record's "type" value
 * @method string              getDefaultValue()   Returns the current record's "default_value" value
 * @method ConfigCategory      getConfigCategory() Returns the current record's "ConfigCategory" value
 * @method Doctrine_Collection getConfigValue()    Returns the current record's "ConfigValue" collection
 * @method ConfigVariable      setId()             Sets the current record's "id" value
 * @method ConfigVariable      setCode()           Sets the current record's "code" value
 * @method ConfigVariable      setCategoryCode()   Sets the current record's "category_code" value
 * @method ConfigVariable      setLabel()          Sets the current record's "label" value
 * @method ConfigVariable      setDescription()    Sets the current record's "description" value
 * @method ConfigVariable      setType()           Sets the current record's "type" value
 * @method ConfigVariable      setDefaultValue()   Sets the current record's "default_value" value
 * @method ConfigVariable      setConfigCategory() Sets the current record's "ConfigCategory" value
 * @method ConfigVariable      setConfigValue()    Sets the current record's "ConfigValue" collection
 * 
 * @package    piwam
 * @subpackage model
 * @author     Adrien Mogenet
 * @version    SVN: $Id: Builder.php 7021 2010-01-12 20:39:49Z lsmith $
 */
abstract class BaseConfigVariable extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('piwam_config_variable');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('code', 'string', 25, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '25',
             ));
        $this->hasColumn('category_code', 'string', 25, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '25',
             ));
        $this->hasColumn('label', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '255',
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('type', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '255',
             ));
        $this->hasColumn('default_value', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '255',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('ConfigCategory', array(
             'local' => 'category_code',
             'foreign' => 'code',
             'onDelete' => 'CASCADE'));

        $this->hasMany('ConfigValue', array(
             'local' => 'id',
             'foreign' => 'config_variable_id'));
    }
}