<?php
/**
 * Class manages all plugins in current Piwam installation
 * @author Jerome Fouilloy
 *
 */
abstract class PiwamPluginsRegister
{
  private static $_plugins = array();
  private static $_isLoaded = false;
  /**
   * Register new plugin
   * @param MainPiwamPlugin $plugin
   */
  public static function addPlugin(MainPiwamPlugin $plugin)
  {
    if(!array_key_exists($plugin->getPluginName(),self::$_plugins))
    {
      self::$_plugins[] = $plugin;
    }
  }
  /**
   * Get plugins registered
   */
  public static function getPlugins()
  {
    if(!self::$_isLoaded)
    {
      self::loadFromConfiguration();
    }
    return self::$_plugins;
  }
  /**
   * Load from config variable piwam_plugins
   */
  private static function loadFromConfiguration()
  {
    $arr = sfConfig::get('app_piwam_plugins',array());
    foreach($arr as $pluginClass)
    {
      self::addPlugin(new $pluginClass);
    }
    self::$_isLoaded = true;
  }
}