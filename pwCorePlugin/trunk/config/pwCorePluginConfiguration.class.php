<?php
/**
 * Configure the Piwam pwCorePlugin, declaring available modules and helpers.
 *
 * @author  Nicolas Charlot
 * @since   1.2
 */
class pwCorePluginConfiguration extends sfPluginConfiguration
{  
  protected static
    /**
     * Modules to be enabled
     *
     * @var array
     */
    $modules = array(
      'account', 'activity', 'admin', 'association', 'bookkeeping', 
      'config_member', 'due', 'duetype', 'error', 'expense', 'export', 'income',
      'install', 'login', 'mailing', 'member', 'status', 'update' , 'menus'
    ),

    /**
     * Helpers to be enabled
     *
     * @var array
     */
    $helpers = array('Boolean', 'Member', 'Phone', 'Plural', 'Tooltip',
      'Website');
  
  /**
   * Initializes the plugin.
   * 
   * @see     sfPluginConfiguration
   * @return  boolean|null
   */
  public function initialize()
  {
    $this->enableModules();
    $this->enableHelpers();
   
    if (sfConfig::get('app_default_layout', true))
    {
      sfConfig::set('sf_app_template_dir', sfConfig::get('sf_plugins_dir') . '/pwCorePlugin/templates');
    }
    
    sfConfig::set('secure_module', 'error');
    sfConfig::set('secure_action', 'credentials');    
    
    sfConfig::set('sf_login_module', 'login');
    sfConfig::set('sf_login_action', 'login');

    sfValidatorBase::setDefaultMessage('required', 'Requis');
    sfValidatorBase::setDefaultMessage('invalid', 'Invalide');
    
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