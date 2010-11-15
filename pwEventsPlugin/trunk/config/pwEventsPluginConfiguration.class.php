<?php
/**
 * Manage the configuration of events plugin
 *
 * @package    letsManager
 * @subpackage config
 * @author     Jerome Fouilloy
 * @version    SVN: $Rev$
 */
class pwEventsPluginConfiguration extends sfPluginConfiguration 
{

  /**
   * Modules to be enabled
   *
   * @var array
   */
  protected static $modules = array('pwEvents','pwEventsSubscription','pwEventsInstall');

  /**
   * Helpers to be enabled
   *
   * @var array
   */
  protected static  $helpers = array();

  /**
   * Initializes the plugin.
   *
   * @see     sfPluginConfiguration
   * @return  boolean|null
   */
  public function initialize()
  {
    sfConfig::set('sf_enabled_modules', array_unique(array_merge(self::$modules, sfConfig::get('sf_enabled_modules', array()))));
    return true;
  }
  /**
   * Enables helpers.
   *
   */
  protected function enableHelpers()
  {
    sfConfig::set('sf_standard_helpers', array_unique(array_merge(self::$helpers, sfConfig::get('sf_standard_helpers', array()))));
  }

}