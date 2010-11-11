<?php
/**
 * Send automatically futur events validated to all active members
 * @package    pwEventsPlugin
 * @subpackage task
 * @author     Jerome Fouilloy
 * @version    SVN: $Rev$
 */
class pwEventsNightTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {

    $this->addOptions(array(
    new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', 'backend'),
    new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
    new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),

    ));

    $this->namespace = 'pwEventsPlugin';
    $this->name = 'night-tasks';
    $this->briefDescription = 'Do automatic events mailing';

    $this->detailedDescription = <<<EOF
The [pwEventsPlugin:night-tasks] send list of events to all members with time period set in configuration
EOF;
  }

  /**
   * @see sfTask
   */
  public function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $context = sfContext::createInstance($this->configuration);

    $associations = AssociationTable::getInstance()->findAll();
    foreach($associations as $asso)
    {
      $this->logSection('pwEventsPlugin:', sprintf('Night tasks for association %s', $asso->getName()));
      $this->execForAssociation($asso);
    }
  }
  
  public function execForAssociation(Association $asso)
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
      $this->logSection('pwEventsPlugin: '.$asso->getname().': no events mailing because it is disabled in configuration.'); 
    }
    else if($delay == '1_month' && $dayInMonth == 1){
      $mustSendMail = true;
      $dateStart = date('Y-m-d',mktime(0,0,1,$month,1,$year));
      $dateEnd = date('Y-m-d',mktime(0,0,1,$month,31,$year));
      $textTimePeriod = StringTools::monthNameFR($month);
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
      //FUNC: Move table html for custom config, where can I to move that ?
      $htmlEvents = '<table>';
      foreach($events as $event)
      {
        $time = strtotime($event->getDateBegin().' '.$event->getTimeBegin());
        $datetime = sprintf("Le %s %s à %s",date('j',$time),StringTools::monthNameFR(date('m',$time)),date('H:i',$time));
        
        $htmlEvents .= '<tr><td width="600px"><table style="border: solid 1px black" width="100%">';
        $htmlEvents .= '<tr><td style="background-color: #E5E5E5">'.$datetime.' : ' .$event->getName().'</td></tr>';
        $htmlEvents .= '<tr><td>'.$event->getDescriptionPublic().'</td></tr>';
        $htmlEvents .= '</table></td></tr>';
      }
      $htmlEvents .= '</table>';
      $values = array();
      $values['events.list'] = $htmlEvents;
      $values['title.timeperiod'] = $textTimePeriod;
      $sent = true;
      foreach($members as $member)
      {
        $sent = $sent && MailerFactory::loadTemplateAndSend($member->getId(),$member,pwEventsPluginUtil::EMAIL_EVENTS_AUTOMATIC_MAILING,$values);
      }
      $strError = 'without errors.';
      if(!$sent)
      {
        $strError = 'with error on some member';
      }
      $this->logSection('pwEventsPlugin: '.$asso->getname().':', sprintf('%d events send to %d active members %s', count($events),count($members),$strError));
      
    }
  }
}