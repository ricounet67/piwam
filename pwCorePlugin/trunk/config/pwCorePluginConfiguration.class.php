<?php

class pwCorePluginConfiguration extends sfPluginConfiguration
{
  
  protected static
    $modules = array(
      'account', 'activity', 'admin', 'association', 'config_member', 'due',
      'duetype', 'error', 'expense', 'export', 'income', 'install', 'login',
      'mailing', 'member', 'status', 'update'
    ),
    $helpers = array('Boolean', 'Member', 'Phone', 'Plural', 'Tooltip', 'Website');  
  
  /**
   * Initializes the plugin.
   * 
   * @see sfPluginConfiguration
   * 
   * @return boolean|null
   */
  public function initialize()
  {
    $this->enableModules();
    $this->enableHelpers();
   
    if (sfConfig::get('app_default_layout', true))
    {
      sfConfig::set('sf_app_template_dir', sfConfig::get('sf_plugins_dir').'/pwCorePlugin/templates');
    }

    return true;
  }
  
  /**
   * Enables modules.
   *
   */
  protected function enableModules()
  {
    sfConfig::set('sf_enabled_modules', array_unique(array_merge(self::$modules, sfConfig::get('sf_enabled_modules', array()))));
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