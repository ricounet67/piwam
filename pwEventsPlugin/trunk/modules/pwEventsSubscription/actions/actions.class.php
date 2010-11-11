<?php

/**
 * Events subscription.
 *
 * @package    pwEventsPlugin
 * @subpackage pwEventsSubscription
 * @author     Jerome Fouilloy
 * @version    SVN: $Rev$
 */
class pwEventsSubscriptionActions extends sfActions
{
  /**
   * register subscription for event, if user has already registered we edit that else we go new form
   *
   * @param sfRequest $request A request object
   */
  public function executeRegister(sfWebRequest $request)
  {
    $eventId = $request->getParameter('event_id',-1);
    $memberId = $request->getParameter('member_id',$this->getUser()->getUserId());
    // if user not registered we redirrect to new
    $subscrip = EventSubscriptionTable::getByEventIdAndMemberId($eventId,$memberId);
    if($subscrip == null)
    {
      $this->forward('pwEventsSubscription','new');
    }
    else{
      $this->forward('pwEventsSubscription','edit');
    }
  }

  public function executeNew(sfWebRequest $request)
  {
    $myMemberId = $this->getUser()->getUserId();
    $eventId = $request->getParameter('event_id',-1);
    $memberId = $request->getParameter('member_id',$myMemberId);
    $this->event = AssociationEventTable::getById($eventId);
    $this->form = new EventSubscriptionForm(null,array('user'=>$this->getUser(),'textFirstPerson'=>$this->_isEditMySubscription($memberId)));
    $this->form->setDefault('member_id',$memberId);
    $this->form->setDefault('event_id',$eventId);
    $this->linkCancel = $this->getUser()->getCurrentReferer('@events_list');
    // register other member and not current user
    if($memberId != $myMemberId)
    {
      $this->titlePerson = ' de '.MemberTable::getNameForMemberId($memberId);
    }
    else{
      $this->titlePerson ='';
    }
  }
  
  public function executeCreate(sfWebRequest $request)
  {
    //	$eventId = $request->getParameter('event_id',-1);
    //	$memberId = $request->getParameter('member_id',$this->getUser()->getUserId());
    //	$subscrip = EventSubscriptionTable::getByEventIdAndMemberId($eventId,$memberId);

    $this->form = new EventSubscriptionForm(null,array('user'=>$this->getUser()));
    $this->processForm($request,$this->form);
     
    $eventId = $request->getParameter($this->form['event_id']->getName(),-1);
    $this->event = AssociationEventTable::getById($eventId);
    $this->setTemplate('new');
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $myMemberId = $this->getUser()->getUserId();
    $eventId = $request->getParameter('event_id',-1);
    $memberId = $request->getParameter('member_id',$myMemberId);
    $subscrip = EventSubscriptionTable::getByEventIdAndMemberId($eventId,$memberId);
    $this->event = AssociationEventTable::getById($eventId);
    $this->form = new EventSubscriptionForm($subscrip,array('user'=>$this->getUser(),'textFirstPerson'=>$this->_isEditMySubscription($memberId)));
    $this->linkCancel = $this->getUser()->getCurrentReferer('@events_list');
    // register other member and not current user
    if($memberId != $myMemberId)
    {
      $this->titlePerson = ' de '.MemberTable::getNameForMemberId($memberId);
    }
    else{
      $this->titlePerson ='';
    }
  }
  
  public function executeUpdate(sfWebRequest $request)
  {
    /*	$eventId = $request->getParameter('event_id',-1);
     $memberId = $request->getParameter('member_id',$this->getUser()->getUserId());
     $subscrip = EventSubscriptionTable::getByEventIdAndMemberId($eventId,$memberId);*/
     
    $this->form = new EventSubscriptionForm(null,array('user'=>$this->getUser()));
    $this->processForm($request,$this->form);
     
    $eventId = $request->getParameter($this->form['event_id']->getName(),-1);
    $this->event = AssociationEventTable::getById($eventId);
    $this->setTemplate('edit');
  }
  /**
   * Return true if member is editing its subscription
   * @param integer $memberId
   */
  private function _isEditMySubscription($memberId)
  {
    return $this->getUser()->getUserId() == $memberId;
  }
  protected function processForm(sfWebRequest $request,sfFormDoctrine $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if($form->isValid())
    {
      $form->updateObject();
      $subscripNew = $form->getObject();
      $subscripOld = EventSubscriptionTable::getByEventIdAndMemberId($subscripNew->getEventId(),$subscripNew->getMemberId());
      if($subscripOld != null)
      {
        $subscripNew->setCreatedAt($subscripOld->getCreatedAt());
        $subscripOld->delete();
      }
      $subscripNew->save();

      $this->redirect($this->getUser()->getCurrentReferer('@events_list'));
    }
  }
}
