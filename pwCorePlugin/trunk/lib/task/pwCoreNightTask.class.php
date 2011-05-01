<?php
/**
 * Send automatically futur events validated to all active members
 * @package    pwEventsPlugin
 * @subpackage task
 * @author     Jerome Fouilloy
 * @version    SVN: $Rev$
 */
class pwCoreNightTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'backend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));

    $this->namespace = 'pwCorePlugin';
    $this->name = 'night-tasks';
    $this->briefDescription = 'Do automatic night tasks for Piwam';

    $this->detailedDescription = <<<EOF
The [pwCorePlugin:night-tasks] launch night tasks for Piwam and its plugins
EOF;
  }
    /**
   * @see sfTask
   */
  public function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $context = sfContext::createInstance($this->configuration);

    // for moment piwam doesn't need night task but plugins need it
    $plugins = PiwamPluginsRegister::getPlugins();
    $associations = AssociationTable::getInstance()->findAll();
    foreach($plugins as $plugin)
    {
      $this->log("Launch night tasks for plugin ".$plugin->getPluginName()." on all associations.");
      foreach($associations as $asso)
      {
        //$plugin->pluginNightTasksForAssociation($asso);
      }
    }
  }
  
}