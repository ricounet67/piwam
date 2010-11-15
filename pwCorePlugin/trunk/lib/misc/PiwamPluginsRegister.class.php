<?php
/**
 * Class manages all plugins in current Piwam installation
 * @author Jerome Fouilloy
 *
 */
class PiwamPluginsRegister
{
  private static $_plugins = array();
  
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
    return self::$_plugins;
  }
}