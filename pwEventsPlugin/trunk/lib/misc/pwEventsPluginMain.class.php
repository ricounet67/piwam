<?php
class pwEventsPluginMain extends MainPiwamPlugin
{

  /**
   * IMPLEMENTS PIWAM PLUGIN INTERFACE
   */
  public function getPluginName()
  {
    return 'pwEventsPlugin';
  }
  public function getPluginDescription()
  {
    return 'Add events manager for association';
  }
  public function pluginInstall()
  {
    
  }
  
  public function pluginNightTasksForAssociation(Association $association)
  {
    $this->eventsMailingForAssociation($association);
  }
  
  public function eventsMailingForAssociation(Association $asso)
  {
    $assoId = $asso->getId();
    $delay = pwEventsPluginUtil::getAutomaticMailingDelay($assoId);
    
    $dayInMonth = intval(date('j'));
    $month = intval(date('m'));
    $year = intval(date('Y'));
    $dateStart ='';
    $dateEnd = '';
    $textTimePeriod = 'Aucune';
    $mustSendMail = false;
    if($delay == 'no' && $dayInMonth == 1)
    {
      $this->log('No events mailing because it is disabled in configuration.'); 
    }
    else if($delay == '1_month' && $dayInMonth == 1){
      $mustSendMail = true;
      $dateStart = date('Y-m-d',mktime(0,0,1,$month,1,$year));
      $dateEnd = date('Y-m-d',mktime(0,0,1,$month,31,$year));
      $textTimePeriod = ' le mois de '.StringTools::monthNameFR($month);
    }
    else if($delay == '2_week' && ($dayInMonth == 1 || $dayInMonth == 16)){
      $mustSendMail = true;
      if($dayInMonth == 1)
      {
        $dateStart = date('Y-m-d',mktime(0,0,1,$month,1,$year));
        $dateEnd = date('Y-m-d',mktime(0,0,1,$month,15,$year));
        $textTimePeriod = 'début '.StringTools::monthNameFR($month);
      }
      else{
        $dateStart = date('Y-m-d',mktime(0,0,1,$month,16,$year));
        $dateEnd = date('Y-m-d',mktime(0,0,1,$month,31,$year));
        $textTimePeriod = 'fin '.StringTools::monthNameFR($month);
      }
    }
    // send email
    if($mustSendMail)
    {
      $members = MemberTable::getHavingEmailForAssociation($assoId);
      $events = AssociationEventTable::getEventsBetweenDates($assoId,$dateStart,$dateEnd);
      if(count($events) == 0)
      {
        return;
      }
      //FUNC: Move table html for custom config, where can I to move that ?
      $htmlEvents = '<table>';
      foreach($events as $event)
      {
        $time = strtotime($event->getDateBegin().' '.$event->getTimeBegin());
        $datetime = sprintf("Le %s %s à %s",date('j',$time),StringTools::monthNameFR(date('m',$time)),date('H\hi',$time));
        
        $htmlEvents .= '<tr><td width="600px"><table style="border: solid 1px black" width="100%">';
        $htmlEvents .= '<tr><td style="background-color: #E5E5E5"><b>'.$datetime.' : ' .$event->getName().'</b></td></tr>';
        $htmlEvents .= '<tr><td>'.$event->getDescriptionPublic().'</td></tr>';
        $htmlEvents .= '<tr><td style="background-color: #E5E5E5">';
        $address = $event->getAddress();
        if($address != '')
        {
          $htmlEvents .= 'Rendez vous : '.$address;
        }
        $htmlEvents .= '</td></tr></table></td></tr>';
      }
      $htmlEvents .= '</table>';
      $values = array();
      $values['events.list'] = $htmlEvents;
      $values['title.timeperiod'] = $textTimePeriod;
      $nbError = 0;
      $mailer = MailerFactory::get($assoId);
      foreach($members as $member)
      {
        $sent = MailerFactory::loadTemplateAndSend(null,$member,pwEventsPluginUtil::EMAIL_EVENTS_AUTOMATIC_MAILING,$values,$mailer);
        if($sent == false)
        {
          $nbError++;
        }
        
      }
      $strError = 'without errors.';
      if($nbError > 0)
      {
        $strError = 'with error on some members.';
      }
      $this->log(sprintf('%d events send to %d active members %s', count($events),count($members),$strError));
      
    }
  }
}