<?php

/**
 * Association events
 *
 * @package    pwEventsPlugin
 * @subpackage pwEvents
 * @author     Jerome Fouilloy
 * @version    SVN: $Rev$
 */
class pwEventsActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->events = AssociationEventTable::getAllForAssociationId($this->getUser()->getAssociationId());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new AssociationEventForm();
    $this->form->setDefault('organized_by',$this->getUser()->getUserId());
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new AssociationEventForm();
    $this->form->setDefault('organized_by',$this->getUser()->getUserId());
    $this->processForm($request,$this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $eventId = $request->getParameter('id',-1);
    $this->forward404Unless($event = AssociationEventTable::getById($eventId));
    $this->forward404Unless($event->isNotValidated());
    $this->form= new AssociationEventForm($event);
     
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $eventId = $request->getParameter('id',-1);
    $this->forward404Unless($event = AssociationEventTable::getById($eventId));
    $this->forward404Unless($event->isNotValidated());
    $this->form = new AssociationEventForm($event);
    $this->processForm($request,$this->form);
    $this->setTemplate('edit');
  }

  public function executeShow(sfWebRequest $request)
  {
    $eventId = $request->getParameter('id',-1);
    $this->event = AssociationEventTable::getById($eventId);
    $this->forward404Unless($this->event);
    $this->canValidateAndEdit = $this->hasRightValidateEvent() && $this->event->isNotValidated();
    $this->canSeePrivate = $this->getUser()->hasCredential(pwEventsPluginUtil::RIGHT_SEE_PRIVATE_FIELDS);
    $this->canManage = $this->hasRightValidateEvent();
    $this->canAddMember = $this->hasRightValidateEvent();

    $dateEvent = strtotime($this->event->getDateBegin());
    $dateNow = time();
    $this->canRegister = ($dateNow <= $dateEvent && $this->event->isAccepted());


    $form = new sfForm();
    $form->setWidget('member_id',new pwWidgetFormMemberSelect());
    $this->formAddMember = $form;
    $this->getUser()->setCurrentReferer('@event_show?id='.$eventId);

    //if($this->event->isAccepted())
    {
      $this->membersRegister = EventSubscriptionTable::getAllMemberComeForEventId($eventId);
      /*
       * Carpool map
       */
      $registersCarpool = EventSubscriptionTable::getMemberCarpoolForEventId($eventId);
      $this->carpool_map = null;
      $this->carpool_registers_need = array();
      $this->carpool_registers_offer = array();

      $this->createCarpoolEvent($registersCarpool,$this->event);
    }
  }
  /**
   * Create carpool map and offers / needs
   * @param Collection<EventSubscription> $registersCarpool
   * @param AssociationEvent $event
   */
  private function createCarpoolEvent($registersCarpool,AssociationEvent $event)
  {
    $assoId = $this->getUser()->getAssociationId();

    $apiKey = Configurator::get('googlemap_key',$assoId);

    $carpoolMap = new GMap();
    $client = $carpoolMap->getGMapClient($apiKey);
    $carpoolMap->setZoom(11);
    // for resolve image path
    $this->getContext()->getConfiguration()->loadHelpers('Asset');
    $currentMember = null;
    $firstMemberGeoloc = null;
    $membersCarpoolNeed = array();
    $membersCarpoolOffer = array();

    $iconNeed = new GMapMarkerImage(
    pwEventsPluginUtil::getImagePath('flag_blue.png'),
    array(
        'width' => 36,
        'height' => 36,
    )
    );
    $iconOffer = new GMapMarkerImage(
    pwEventsPluginUtil::getImagePath('flag_green.png'),
    array(
        'width' => 36,
        'height' => 36,
    )
    );
    $iconHome = new GMapMarkerImage(
    pwEventsPluginUtil::getImagePath('home.png'),
    array(
        'width' => 36,
        'height' => 36,
    )
    );
    $iconEvent = new GMapMarkerImage(
    pwEventsPluginUtil::getImagePath('end_flag.png'),
    array(
        'width' => 48,
        'height' => 48,
    )
    );

    foreach ($registersCarpool as $register)
    {
      $member = $register->getMember();
      $iconMarker = null;
      $text_carpool = '';
      if($register->getCarpoolType() == EventSubscriptionTable::CARPOOL_ID_NEED)
      {
        $membersCarpoolNeed[] = $register;
        $iconMarker = $iconNeed;
        $text_carpool = '<div class="textCarpoolNeed">Cherche '.$register->getNumberPersons().' places</div>';
      }
      else
      {
        $membersCarpoolOffer[] = $register;
        $iconMarker = $iconOffer;
        $text_carpool = '<div class="textCarpoolOffer">Propose '.$register->getCarpoolPlaces().' places</div>';
      }
      if($member->hasGeolocAddress())
      {
        // store the current user for center the map
        if($member->getId() == $this->getUser()->getUserId())
        {
          $currentMember = $member;
          $iconMarker = $iconHome;
        }

        $carpoolMap->addMarker($this->createMapMarker($member,$iconMarker,$text_carpool));
        // used if the current user doesn't participate to carpool
        if($firstMemberGeoloc == null)
        {
          $firstMemberGeoloc = $member;
        }

      }
      else{
        $membersWithoutGeoloc[] = $member;
      }
    }
    // current user not found on carpool members we add it
    if($currentMember == null)
    {
      $member = MemberTable::getById($this->getUser()->getUserId());
      if($member->hasGeolocAddress())
      {
        $carpoolMap->addMarker($this->createMapMarker($member,$iconHome,''));
      }
    }
    // add event marker
    if($event->getAddress() != null && trim($event->getAddress()) != '')
    {
      $event_address = new GMapGeocodedAddress($event->getAddress());
      $event_address->geocode($carpoolMap->getGMapClient());
      $gMapMarker = new GMapMarker($event_address->getLat(),$event_address->getLng(),
      array('title'=>'"'.$event->getName().'"','icon'=>$iconEvent),
        'map_marker_event');

      $time = strtotime($event->getTimeBegin());
      $info_window = new GMapInfoWindow('<b>Arrivée</b><br/>'.$event->getName().'<br/><b>Commence à '.date('H:i',$time).'h</b>',
      array('maxWidth'=>'"200px"'));
      $gMapMarker->addHtmlInfoWindow($info_window,array(),'map_window_event');
      $carpoolMap->addMarker($gMapMarker);
    }
    $carpoolMap->centerAndZoomOnMarkers(0.5);

    $this->carpool_map = $carpoolMap;
    $this->carpool_registers_need = $membersCarpoolNeed;
    $this->carpool_registers_offer = $membersCarpoolOffer;
  }
  
  /**
   * Create new map marker
   * @param Member $member
   * @param GMapMarkerImage $icon
   * @param string $text_carpool
   */
  private function createMapMarker(Member $member,GMapMarkerImage  $icon,$text_carpool ='')
  {
    $gMapMarker = new GMapMarker($member->getLatitude(),$member->getLongitude(),
    array('title'=>'"'.$member->getName().'"','icon'=>$icon),
            'map_marker_member_'.$member->getId());

    $info_window = new GMapInfoWindow($member->getInfoForGmap().'<br/>'.$text_carpool,
    array(),'map_window_member_'.$member->getId());
    $gMapMarker->addEvent(new GMapEvent('click','carpoolMapOpenWindow('.$member->getId().');'));
    $gMapMarker->addHtmlInfoWindow($info_window);
    return $gMapMarker;
  }

  public function executeValidate(sfWebRequest $request)
  {
    $eventId = $request->getParameter('id',-1);
    $this->forward404Unless($event = AssociationEventTable::getById($eventId));
    $this->forward404Unless($event->isNotValidated());
     
    $event->setAcceptedBy($this->getUser()->getUserId());
    $event->setStatus(AssociationEventTable::STATUS_VALIDATED);
    $event->save();
    $this->redirect("@events_list");
  }

  public function executeCalendar(sfWebRequest $request)
  {
    $year = intval($request->getParameter('year',date('Y')));
    $month = intval($request->getParameter('month',date('m')));
    $day = intval(date('d'));
    $time = mktime(0,0,1,$month,$day,$year);
     
    $calendar = new sfEventCalendar('month',date('c',$time));
    $events = AssociationEventTable::getAllValidatedForAssociationId($this->getUser()->getAssociationId());
    foreach ($events as $event)
    {
      $calendar->addEvent($event->getDateBegin(),array('event'=>$event));
    }
    $this->calendar = $calendar->getEventCalendar();
     
    $monthsName = array(1=>'Janvier',2=>'Février',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',
    7=>'Juillet',8=>'Août',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Décembre');
     
    $nextMonth = ($month == 12 ? 1 : $month+1);
    $prevMonth = ($month == 1 ? 12 : $month-1);

    if($month == 12)
    {
      $this->nextMonth = 1;
      $this->nextYear = $year+1;
      $this->nextTitle = $monthsName[intval($this->nextMonth)].' '.$this->nextYear;
      $this->prevMonth = 11;
      $this->prevYear = $year;
      $this->prevTitle = $monthsName[intval($this->prevMonth)].' '.$this->prevYear;
    }
    else if($month == 1)
    {
      $this->nextMonth = 2;
      $this->nextYear = $year;
      $this->nextTitle = $monthsName[intval($this->nextMonth)].' '.$this->nextYear;
      $this->prevMonth = 12;
      $this->prevYear = $year-1;
      $this->prevTitle = $monthsName[intval($this->prevMonth)].' '.$this->prevYear;
    }
    else{
      $this->nextMonth = $month+1;
      $this->nextYear = $year;
      $this->nextTitle = $monthsName[intval($this->nextMonth)].' '.$this->nextYear;
      $this->prevMonth = $month-1;
      $this->prevYear = $year;
      $this->prevTitle = $monthsName[intval($this->prevMonth)].' '.$this->prevYear;
    }
    $this->currentTitle = $monthsName[intval($month)].' '.$year;
    $this->currentMonth = $month;
    $this->firstWeekMonth = date('W',mktime(0,0,1,$month,1,$year));
    $this->maxiWeekYear = date('W',mktime(0,0,1,12,31,$year));
    // TODO: gerer changement année pour numéro semaine
  }
  /**
   * Return current member has right manage event 
   * @return boolean return true if current user can validate and edit events, false otherwise
   */
  protected function hasRightValidateEvent()
  {
    return $this->getUser()->hasCredential(pwEventsPluginUtil::RIGHT_EDIT_AND_VALIDATE_EVENT);
  }

  protected function processForm(sfWebRequest $request,sfFormDoctrine $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if($form->isValid())
    {
      $form->updateObject();
      $event = $form->getObject();
      $userId = $this->getUser()->getUserId();
      $textNotice = '';
      if($event->isNew())
      {
        $event->setCreatedBy($userId);
        $event->setStatus(AssociationEventTable::STATUS_NOT_VALIDATED);
        $event->setOrganizedBy($userId);
        $event->setAssociationId($this->getUser()->getAssociationId());

        // notify member for validate event
        $membersValidatedEvent = MemberTable::getMembersForAclRight(pwEventsPluginUtil::RIGHT_EDIT_AND_VALIDATE_EVENT);
        $values = array();
        $values['event.title'] = $event->getName();
        $values['event.description'] = html_entity_decode($event->getDescriptionPublic());
        $time = strtotime($event->getDateBegin().' '.$event->getTimeBegin());
        $values['event.datetime'] = date('d/m/y à H:i',$time);
        $values['organizer.name'] = MemberTable::getNameForMemberId($event->getOrganizedBy());
        foreach($membersValidatedEvent as $member)
        {
          MailerFactory::loadTemplateAndSend($this->getUser()->getUserId(),$member,pwEventsPluginUtil::EMAIL_EVENT_CREATED,$values);
        }
        $textNotice = ', une validation doit être réalisé avant parution sur le site';
      }

      $event->save();
      $this->getUser()->setFlash('notice','Evénement enregistré'.$textNotice.'.');
      if($this->hasRightValidateEvent())
      {
        $this->redirect("@events_list");
      }
      else{
        $this->redirect("@homepage");
      }
    }
  }
}
