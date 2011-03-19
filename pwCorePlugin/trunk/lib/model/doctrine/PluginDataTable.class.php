<?php
/**
 * Manage operations on table 'data'
 *
 * @package     Piwam
 * @subpackage  model
 * @author      Adrien Mogenet
 * @since       1.2
 */
abstract class PluginDataTable extends Doctrine_Table
{
  private $_fixeValues = array('dbversion');
  /**
   * Retrieve a value by its key
   *
   * @param   string  $key
   * @return  string or null if key doesn't exist
   */
  public static function getByKey($key)
  {
    $q = Doctrine_Query::create()
          ->select('d.value')
          ->from('Data d')
          ->where('d.config_key = ?', $key);
    $row = $q->fetchOne();
    return ($row != null ? $row->getValue() : null);
  }
  /**
   * update global variable value, throw exception if value can't be updated
   * @param string $key unique key
   * @param string $value value associated to key
   */
  public static function updateByKey($key,$value)
  {
    if(isset($_fixeValue[$key]))
    {
      throw new InvalidArgumentException("Key ".$key." can't be updated.");
    }
    $q = Doctrine_Query::create()->from('Data d')->where('d.config_key = ?', $key);
    $obj = $q->fetchOne();
    if($obj == null)
    {
      $obj = new Data();
      $obj->setConfigKey($key);
    }
    else{
      $obj->setValue($value);
    }
    $obj->save();
  }
}