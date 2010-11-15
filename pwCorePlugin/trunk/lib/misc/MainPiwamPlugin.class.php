<?php
abstract class  MainPiwamPlugin
{
  /**
   * Return unique name for plugin
   * @return string unique name for plugin
   */
  public abstract function getPluginName();
  /**
   * Return description for plugin
   * @return string description
   */
  public abstract function getPluginDescription();
  
  /**
   * Install plugin during piwam installation
   * @param sfLoggerInterface $logInstall logger in case error
   * @return true if success or false if error occured
   */
  public abstract function pluginInstall();
  /**
   * Call night tasks from plugin
   */
  public abstract function pluginNightTasksForAssociation(Association $association);
  /**
   * New association created, update database if need
   * @param Association $association
   */
  //public function associationCreated(Association $association);
  
  public function log($message,$level=sfLogger::INFO)
  {
    $context = sfContext::getInstance();
    $context->getLogger()->log(sprintf("%s: %s",$this->getPluginName(),$message),$level);
  }
}