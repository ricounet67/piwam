<?php

/**
 * Cron launch task from external website.
 *
 * @package    piwam
 * @subpackage cron_task
 * @author     Jerome Fouilloy
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cron_taskActions extends sfActions
{
  /**
   * Launch task can be call by every one without login
   * @param sfWebRequest $request
   */
  public function executeNightTasks(sfWebRequest $request)
  {
    
    $key = $request->getParameter('key',null);
    $message = "ERR:UNKNOWN:";
    
    $dateLastSend = DataTable::getByKey('date_night_tasks');
    $values = getdate(strtotime($dateLastSend));
    
    $timeLastSend = mktime(23,59,59,$values['mon'],$values['mday'],$values['year']);
    $today = time();
    
    $validKey = 'piwamKey';
    // laucnh night tasks only one time by day
    if($today <= $timeLastSend)
    {
      $message = "ERR:ALREADY_LAUNCHED:";
    }
    else if($key !== $validKey)
    {
      $message = "ERR:KEY_INVALID:";
    }
    else
    {
      DataTable::updateByKey('date_night_tasks',date('Y-m-d'));
      $message= "OK:";
      
      $plugins = PiwamPluginsRegister::getPlugins();
      $associations = AssociationTable::getInstance()->findAll();
      foreach($plugins as $plugin)
      {
        $this->logMessage("Launch night tasks for plugin ".$plugin->getPluginName()." on all associations.");
        foreach($associations as $asso)
        {
          $plugin->pluginNightTasksForAssociation($asso);
        }
      }
    }
    return $this->renderText($message);
   // $this->setLayout(false);
   // $this->message = $message;
  }
}