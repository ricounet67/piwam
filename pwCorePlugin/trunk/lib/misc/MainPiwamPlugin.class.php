<?php
/**
 * Class implemented by piwam plugins
 * @author Jerome Fouilloy
 *
 */
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
   * TODO: not call yet
   * Install plugin during piwam installation
   * @param sfLoggerInterface $logInstall logger in case error
   * @return true if success or false if error occured
   */
  public function pluginInstall()
  {
    
  }
  /**
   * Call night tasks from plugin
   */
  public function pluginNightTasksForAssociation(Association $association)
  {
    
  }
  /**
   * Notify plugin of creation new association
   * @param Association $association
   */
  public function pluginAssociationCreated(Association $association)
  {
    
  }
  /**
   * Notify plugin of creation new member
   * @param Member $member
   */
  public function pluginMemberCreated(Member $member)
  {
    
  }
  
  public function log($message,$level=sfLogger::INFO)
  {
    $context = sfContext::getInstance();
    $context->getLogger()->log(sprintf("%s: %s",$this->getPluginName(),$message),$level);
  }
}