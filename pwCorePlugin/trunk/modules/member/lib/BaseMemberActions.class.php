<?php

/**
 * Member actions.
 *
 * @package    piwam
 * @subpackage member
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class BaseMemberActions extends sfActions
{
  /**
   * Lists members who belongs to the current association. By default we sort
   * the list by lastname, and if another column is specified we use it.
   *
   * At the beginning we check if the user has to be redirected to his profile
   * page, since credentials are not checked by config.yml to allow this
   * behaviour
   *
   * @param   sfWebRequest	$request
   * @since   r1
   */
  public function executeIndex(sfWebRequest $request)
  {
    if (! $this->getUser()->hasCredential('list_member'))
    {
      $this->redirect('@member_show?id=' . $this->getUser()->getUserId());
    }

    $page = $request->getParameter('page', 1);
    $filterParams = $this->getFilterParams($request);
    $membersPager = MemberTable::search($filterParams, $page);

    /*
     * If the search form has been just submitted and if
     * there is only one matching result, we directly
     * redirect to the unique matched member
     */
    if ((count($membersPager) === 1) && $request->isMethod('post'))
    {
      $members = $membersPager->getResults();
      $this->redirect('@member_show?id=' . $members[0]->getId());
    }

    /*
     * And we finally give all the useful elements to the view
     */
    $aId = $this->getUser()->getAssociationId();
    $this->members = $membersPager;
    $this->page = $page;
    $this->orderByColumn = $filterParams['order_by'];
    $this->pending = MemberTable::getPendingMembers($aId);
    
    $this->searchForm = new SearchUserForm($filterParams);
  }

  /**
   * Display images of members who belong to the current association
   *
   * @param   sfWebRequest $request
   * @since   r139
   */
  public function executeFaces(sfWebRequest $request)
  {
    $associationId = $this->getUser()->getAssociationId();
    $this->members = MemberTable::getEnabledForAssociation($associationId);
  }

  /**
   * Provide all information about the member to the view. We check if we have
   * the right to see profile of someone else
   *
   * @param 	sfWebRequest	$request
   */
  public function executeShow(sfWebRequest $request)
  {
    $member_id = $request->getParameter('id');
    $profile = MemberTable::getById($member_id);
    $this->forward404Unless($profile);
    $this->showExtraRows = $this->getUser()->hasCredential('edit_member');
    if ($this->isAllowedToManageProfile($profile, 'show_member'))
    {
      $this->dues = DueTable::getForUser($member_id);
      $this->credentials = $profile->getUserGuard()->getAllPermissions();
      $this->member = $profile;
    }
    else
    {
      $this->redirect('@error_credentials');
    }
  }

  /**
   * Export the list of members within a CSV file
   *
   * @param   sfWebRequest    $request
   * @since   r19
   */
  public function executeExport(sfWebRequest $request)
  {
    $csv = new FileExporter('liste-membres.csv');
    $associationId = $this->getUser()->getAssociationId();
    $members = MemberTable::getEnabledForAssociation($associationId);

    echo $csv->addLineCSV(array(
      'Prénom',
      'Nom',
      'Pseudo',
      'Email',
      'Tel (fixe)',
      'Tel (mobile)',
      'Rue',
      'CP',
      'Ville',
      'Pays',
      'Statut',
      'Date d\'inscription',
    ));

    foreach ($members as $member)
    {
      echo $csv->addLineCSV(array(
        $member->getFirstname(),
        $member->getLastname(),
        $member->getUsername(),
        $member->getEmail(),
        $member->getPhoneHome(),
        $member->getPhoneMobile(),
        $member->getStreet(),
        $member->getZipcode(),
        $member->getCity(),
        $member->getCountry(),
        $member->getStatus(),
        $member->getSubscriptionDate(),
      ));
    }
    
    $csv->exportContentAsFile();
  }

  /**
   * Perform the deletion
   *
   * @param   sfWebRequest    $request
   */
  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();
    $id = $request->getParameter('id');
    $member = MemberTable::getById($id);
    $this->forward404Unless($member);

    if ($member->getAssociationId() != $this->getUser()->getAssociationId())
    {
      $this->redirect('@error_credentials');
    }

    $member->disable()->save();
    $this->redirect('@members_list');
  }

  /**
   * Called method to display list of member within an autocompleted
   * form field.
   *
   * @param   sfWebRequest    $request
   * @since   r15
   * @return  JSON response
   */
  public function executeAjaxlist(sfWebRequest $request)
  {
    $this->getResponse()->setContentType('application/json');
    $query   = $request->getParameter('q');
    $limit   = $request->getParameter('limit');
    $id      = $request->getParameter('association_id');
    $members = MemberTable::magicSearch($query, $limit, $id);
    $result  = array();

    foreach ($members as $member)
    {
      $key = $member->getId();
      $value = $member->getName();
      $result[$key] = $value;
    }

    if (count($result) === 0)
    {
      $result = null;
    }

    return $this->renderText(json_encode($result));
  }


  /**
   * Geo-localize members within a map thanks to Google MAP
   * API.
   *
   * @param   sfWebRequest    $request
   * @since   r17
   * @todo    Customize size of Map
   */
  public function executeMap(sfWebRequest $request)
  {
    $associationId = $this->getUser()->getAssociationId();
    $apiKey = Configurator::get('googlemap_key',$associationId);

    $gMap = new GMap();
    $client = $gMap->getGMapClient($apiKey);

    $this->getContext()->getConfiguration()->loadHelpers('Asset');

    $members = MemberTable::getEnabledForAssociation($associationId,false);

    foreach ($members as $member)
    {
      if (strlen($member->getCity()) > 0)
      {
        $gMap->addMarker($this->_createMapMarker($member));
      }
    }
    $gMap->centerAndZoomOnMarkers(0.05,14);
    $this->gmap = $gMap;
    $this->memberForm = new sfForm();
    $this->memberForm->setWidget('member_id',new pwWidgetFormMemberSelect());
    
  }
  
  /**
   * Create new map marker
   * @param Member $member
   * @param GMapMarkerImage $icon
   * @param string $text_carpool
   */
  private function _createMapMarker(Member $member)
  {
    $gMapMarker = new GMapMarker($member->getLatitude(),$member->getLongitude(),
      array('title'=>'"'.$member->getName().'"'),
            'map_marker_member_'.$member->getId());
    // lets modif
    $this->getContext()->getConfiguration()->loadHelpers('Phone');
    $info_window = new GMapInfoWindow($member->getInfoForGmap(),
      array('maxWidth'=>"'300px'"),'map_window_member_'.$member->getId());
      
    $gMapMarker->addEvent(new GMapEvent('click','gMapOpenWindow('.$member->getId().');'));
    $gMapMarker->addHtmlInfoWindow($info_window);
    return $gMapMarker;
  }

  /* -------------------------------------------------------------------------
   *
   * Classic user management (creation, edition of existing users)
   * for an existing association
   *
   * ---------------------------------------------------------------------- */

  /**
   * Registration of a new member
   *
   * @param   sfWebRequest    $request
   */
  public function executeNew(sfWebRequest $request)
  {
    $aId = $this->getUser()->getAssociationId();
    $ctxt = $this->getContext();
    $canEditAclGroups = $this->getUser()->hasCredential('edit_member_acl');
    $this->form = new MemberForm(null, array(
      'associationId' => $aId, 
      'context' => $ctxt,
      'editAclGroups' => $canEditAclGroups,
      'editExtraRows' => true,
    ));
    $this->form->setDefault('updated_by', $this->getUser()->getUserId());
  }

  /**
   * Perform the creation of the member object in database
   *
   * @param   sfWebRequest    $request
   */
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $member = $request->getParameter('member');
    $aId = $member['association_id'];
    $ctxt = $this->getContext();
    $canEditAclGroups = $this->getUser()->hasCredential('edit_member_acl');
    $this->canEditExtraRows = $this->getUser()->hasCredential('edit_member');
    $this->form = new MemberForm(null, array('associationId' => $aId, 'context' => $ctxt,
        'editAclGroups' => $canEditAclGroups,'editExtraRows' => $this->canEditExtraRows));
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  /**
   * Manages 2 differents forms :
   *  - profile editing
   *  - rights management
   *
   * @param $request
   * @return unknown_type
   */
  public function executeEdit(sfWebRequest $request)
  {
    $associationId = $this->getUser()->getAssociationId();
    $this->user_id = $request->getParameter('id');
    $this->forward404Unless($member = MemberTable::getById($this->user_id));

    if (false === $this->isAllowedToManageProfile($member, 'edit_member'))
    {
      $this->redirect('@error_credentials');
    }
    $canEditAclGroups = $this->getUser()->hasCredential('edit_member_acl');
    $aId = $member->getAssociationId();
    $mId = $member->getId();
    $ctxt = $this->getContext();
    
    $this->canEditExtraRows = $this->getUser()->hasCredential('edit_member');
    $this->form = new MemberForm($member, array('associationId' => $aId,
                                                'context' => $ctxt, 
                                                'memberId' => $mId, 
                                                'editAclGroups' => $canEditAclGroups,
                                                'editExtraRows' => $this->canEditExtraRows));
    
    $this->canEditRight = $this->getUser()->hasCredential('edit_acl');
    $this->form->setDefault('updated_by', $this->getUser()->getUserId());
  }

  /**
   * Perform the update of the member
   *
   * @param   sfWebRequest    $request
   */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->user_id = $request->getParameter('id');
    $this->forward404Unless($user = MemberTable::getById($this->user_id));

    if (false === $this->isAllowedToManageProfile($user, 'edit_member'))
    {
      $this->redirect('@error_credentials');
    }
    $canEditAclGroups = $this->getUser()->hasCredential('edit_member_acl');
    $canExtraRows = $this->getUser()->hasCredential('edit_member');
    
    $member = $request->getParameter('member');
    $associationId = $member['association_id'];
    $this->form = new MemberForm($user, array('associationId' => $associationId,
                                              'context' => $this->getContext(),
                                              'editAclGroups'=>$canEditAclGroups,
                                              'editExtraRows'=>$canExtraRows));
    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }



  /* -------------------------------------------------------------------------
   *
   * Actions to manage users who are requesting a subscription to an
   * existing association
   *
   * ---------------------------------------------------------------------- */

  /**
   * Display the form to request a new subscription to an existing
   * association. This action is -normally- reachable only if Piwam
   * is not in multi_association_mode, that's why we are selecting
   * with "doSelectOne" method
   *
   * @param   sfWebRequest    $request
   */
  public function executeRequestsubscription(sfWebRequest $request)
  {
    $this->forward404Unless(sfConfig::get('app_anonymous_can_register',false),"Configuration doesn't allow to register account");
    if (sfConfig::get('app_multi_association'))
    {
      $associationId = $request->getParameter('id', null);
      $association = AssociationTable::getById($associationId);
      $this->forward404Unless($association);
    }
    else
    {
      $association = AssociationTable::getUnique();
      $associationId = $association->getId();
    }

    $this->form = new MemberForm(null, array('associationId' => $associationId,
                                             'context'=> $this->getContext()));
    $this->form->setDefault('association_id', $associationId);
    $this->form->setDefault('state', MemberTable::STATE_PENDING);
    $this->setLayout('no_menu');
  }

  /**
   * Register a new pending user which requested a subscription to an existing
   * association
   *
   * @param   sfWebRequest    $request
   */
  public function executeCreatepending(sfWebRequest $request)
  {
    $this->forward404Unless(sfConfig::get('app_anonymous_can_register',false),"Configuration doesn't allow to register account");
    $this->forward404Unless($request->isMethod('post'));
    $member = $request->getParameter("member");
    $associationId = $member['association_id'];
    $this->form = new MemberForm(null, array('associationId' => $associationId,
                                             'context' => $this->getContext()));
    $request->setAttribute('pending', true);
    $this->processForm($request, $this->form);
    $this->setTemplate('requestsubscription');
    $this->setLayout('no_menu');
  }

  /**
   * Once subscription request form has been completed, we display a
   * message to the user
   */
  public function executePending()
  {
    // do nothing, just display template
    $this->setLayout('no_menu');
  }

  /**
   * Validate a pending subscription. Send an email to the member if an
   * email has been given when subscribing
   *
   * @param   sfWebRequest    $request
   * @since   r160
   */
  public function executeValidate(sfWebRequest $request)
  {
    $member_id = $request->getParameter('id');
    $member = MemberTable::getById($member_id);

    if ($member->getAssociationId() == $this->getUser()->getAssociationId())
    {
      $member->setState(MemberTable::STATE_ENABLED);
      $member->setUpdatedBy($this->getUser()->getUserId());
      $member->save();

      // notify member listeners new member
      // we don't know password because it is encrypted in database
      $this->_memberCreatedEvent($member,"(Celui saisi lors de votre inscription)",false);
      
      $this->redirect('@members_list');
    }
    else
    {
      $this->redirect('@error_credentials');
    }
  }


  /* -------------------------------------------------------------------------
   *
   * Actions to manage the creation of the first user (who is registering
   * a new association)
   *
   * ---------------------------------------------------------------------- */

  /**
   * Register a new member - and the first one ! - for an
   * Association. This is a special method which use the temporary
   * AssociationID instead of using an already-registered AssociationID
   *
   * @param 	sfWebRequest	$request
   * @since	r16
   */
  public function executeNewfirst(sfWebRequest $request)
  {
    $this->forward404Unless($this->_canCreateFirstMember(),"There is already members for association.");
    $associationId = $this->getUser()->getTemporaryAssociationId();

    if (null == $associationId)
    {
      throw new sfException('Erreur lors de la première étape d\'enregistrement');
    }
    else
    {
      $this->form = new MemberForm(null, array('associationId' => $associationId,
                                               'context'       => $this->getContext(),
                                               'first'         => true));
    }

    $this->form->setDefault('association_id', $associationId);
    $this->setLayout('no_menu');
  }

  /**
   * Performed action when registering the first user
   *
   * @param 	sfWebRequest	$request
   * @since	r16
   */
  public function executeFirstcreate(sfWebRequest $request)
  {
    $this->forward404Unless($this->_canCreateFirstMember(),"There is already members for association.");
    $this->forward404Unless($request->isMethod('post'));
    $associationId = $this->getUser()->getTemporaryAssociationId();

    $this->form = new MemberForm(null, array('associationId' => $associationId,
                                             'context'       => $this->getContext(),
                                             'first'         => true));
    $request->setAttribute('first', true);
    $this->processForm($request, $this->form);
    $this->setTemplate('newfirst');
    $this->setLayout('no_menu');
  }

  /**
   * Display information about the just finished registration. We use
   * keyword 'instanceof' because getTemporaryUserInfo() returns
   * unserialized object - which can be null.
   *
   * @param 	 sfWebRequest	           $request
   * @see 	   getTemporaryUserInfo()
   * @since	   r16
   */
  public function executeEndregistration(sfWebRequest $request)
  {
    $member = $this->getUser()->getTemporaryUserInfo();

    if ($member instanceof Member)
    {
      // here you can access to $member properties
      // and methods
    }

    $this->setLayout('no_menu');
  }

  /**
   * If this is a the first member that we registered, we redirect
   * to the `end` action to display success message about registration.
   *
   * r62 :    We give all the credentials to the user if this is the
   *          first user
   *
   * r139 :   resize pictures
   *
   * @param   sfWebRequest    $request
   * @param   sfForm          $form
   */
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    $isNew = $form->getObject()->isNew();
    $isPending = $request->getAttribute('pending', false);
    if ($form->isValid())
    {
      $formValues = $this->form->getValues();
      $member = $form->save();


      // not first user we update the acl groups for user
      if(isset($formValues['acl_groups']))
      {
         
        // update acl groups for user
        AclGroupMemberTable::updateGroupsIdByMemberId($member->getId(),$formValues['acl_groups']);
      }
      // pending subscription or it is new but creator doesn't have right to manage rights we use default acl groups
      else if($isPending || $isNew)
      {
        AclGroupMemberTable::updateGroupsIdByMemberId($member->getId(),
          AclGroupTable::getSelectedDefaultIdForAssociation($member->getAssociationId()));
      }
      /*
       * Manage extra row values. We are not using sfFormDoctrine,
       * so we are managing these fields manually.
       *
       * For each row, we check if it already exists or not into
       * the DB. Then we are updating or creating it
       */
      $data = $request->getParameter('member');

      if (isset ($data['extra_rows']))
      {
        $extraValues = $data['extra_rows'];
        $extraRows = MemberExtraRowTable::getForAssociation($member->getAssociationId())->toKeyValueArray('id','type');

        foreach ($extraRows as $rowId => $rowType)
        {
          $extraValue = MemberExtraValueTable::getValueForMember($rowId, $member->getId());

          if (null == $extraValue)
          {
            $extraValue = new MemberExtraValue();
            $extraValue->setRowId($rowId);
            $extraValue->setMemberId($member->getId());
          }

          if (isset($extraValues[$rowId]))
          {
            $extraValue->value = $extraValues[$rowId];
          }
          else
          {
            $extraValue->value = null;
          }

          $extraValue->save();
        }
      }

      /*
       * If user has chosen a picture, we resize and try to upload it. The
       * uploaded picture is overwritten by the new thumbnail
       */
      if ($member->getPicture())
      {
        try
        {
          $width = sfConfig::get('app_picture_width', 116);
          $height = sfConfig::get('app_picture_height', 116);
          $filepath = MemberTable::PICTURE_DIR . '/' . $member->getPicture();
          $img = new sfImage($filepath);
          $img->thumbnail($width, $height, 'top');
          $img->saveAs($filepath);
        }
        catch (Exception $e)
        {
          // do nothing
        }
      }
      // if pending subscription we wait validate before notify member listeners
      if($isNew && !$isPending)
      {
        // provide password from form because encrypted in base
        $this->_memberCreatedEvent($member,$formValues['password'],$request->getAttribute('first',false));
      }
      /*
       * If we are processing the values given by the first member, who has
       * normally just registered a new association
       */
      if ($request->getAttribute('first') == true)
      {
        $association = AssociationTable::getById($member->getAssociationId());
        $association->setCreatedBy($member->getId());
        $association->save();

        $this->getUser()->setTemporarUserInfo($member);
        // create administrator group with all acl actions
        $aclAdminGroup = new AclGroup();
        $aclAdminGroup->setName("Administrateurs");
        $aclAdminGroup->setDescription("Possède tous les droits");
        $aclAdminGroup->setAssociationId($member->getAssociationId());
        $aclAdminGroup->save();
        // the default admin group MUST exists before add credentials and member
        $aclAdminGroup->addMember($member);
        $aclAdminGroup->addCredentials(AclActionTable::getAll());
        // we don't need to clear existing credentials before,
        // because we are sure the user doesn't have anyone


        // We check if we can warn the author that this association
        // is using Piwam

        if ($this->getUser()->getAttribute('ping_piwam', false, 'temp'))
        {
          $this->notifyAuthor($association, $member);
        }

        $this->getUser()->removeTemporaryData();
        $this->redirect('@member_endregistration');
      }
      elseif ($request->getAttribute('pending') == true)
      {
        $this->redirect('@member_pending');
      }
      else
      {
        
        if($isNew)
        {
          $text2 = "il ne possède pas d'email donc vous devez le prévenir de la création de son compte.";
          if($member->hasEmail())
          {
            $text2 = "un email a été envoyé pour l'informer de la création de son compte.";
          }
          $this->getUser()->setFlash('notice','Adhérent '.$member->getName().' créé, '.$text2);
        }
        else{
          $this->getUser()->setFlash('notice','Adhérent '.$member->getName().' modifié.');
        }
        
        $this->redirect('@members_list');
      }
    }
  }

  /**
   * Build the $filterParams array according to the parameters stored
   * in the current session and/or in the $request object. This filters
   * array will be used to get the list of members according to custom
   * criteria.
   *
   * @return  array
   */
  protected function getFilterParams(sfWebRequest $request)
  {
    /*
     * If user has submit some criteria to filter the list,
     * we generate the $filterParams array and store
     * it in session. This array is generated according to
     * the values given by the SearchUserForm's widgets
     */
    if ($request->isMethod('post'))
    {
   //   $autoCompleteParam = $request->getParameter('autocomplete_search');
      $filterParams = $request->getParameter('search');
   //   $filterParams['magic'] = $request->getParameter('magic');//$autoCompleteParam['magic'];
      $this->getUser()->setAttribute('memberSearch', serialize($filterParams));
    }

    /*
     * Reset the filters array if required
     * -----------------------------------
     *
     * If there is no 'page' parameter, but we did not send research,
     * it means that we arereaching the action for the first time, from
     * a link into the menu for instance. So we clear the existing objects
     * previously stored.
     *
     */
    elseif (false === $request->getParameter('page', false))
    {
      $this->getUser()->setAttribute('memberSearch', serialize(array()));
    }

    /*
     * We get the $filterParams array, but we force the value
     * of association_id because it could be empty if no filter
     * has been submitted
     */
    $data = $this->getUser()->getAttribute('memberSearch', array());
    $filterParams = unserialize($data);
    $filterParams['association_id'] = $this->getUser()->getAssociationId();
    $filterParams['order_by'] = $request->getParameter('orderby', 'lastname');
    // we search in enabled and disabled
    if(isset($filterParams['show_disabled']))
    {
      $filterParams['state'] = MemberTable::STATE_VALIDATED;
    }
    else{
      $filterParams['state'] = MemberTable::STATE_ENABLED;
    }
    return $filterParams;
  }

  /**
   * Checks if we are allowed to edit/show profile of $user
   *
   * @param   Member    $user         Profile that user try to access
   * @param   string    $credential   Optional required credential
   * @return  boolean
   */
  protected function isAllowedToManageProfile(Member $user, $credential = null)
  {
    if (($user->getAssociationId() != $this->getUser()->getAssociationId()))
    {
      return false;
    }
    else
    {
      if (null != $credential)
      {
        if ($this->getUser()->hasCredential($credential) == true)
        {
          return true;
        }
      }

      if ($this->getUser()->getUserId() == $user->getId())
      {
        return true;
      }
    }

    return false;
  }

  /**
   * Send a notification to the author that Member uses Piwam to manage
   * an association
   *
   * @param   Association   $association
   * @param   Member        $member
   * @since   1.2
   */
  protected function notifyAuthor(Association $association, Member $member)
  {
    $methodObject = new Swift_MailTransport();
    $swift    = Swift_Mailer::newInstance($methodObject);
    $subject  = '[Piwam] '    . $association->getName() . ' utilise Piwam';
    $content  = 'Site web : ' . $association->getWebsite() . '<br />';
    $content .= 'Email :    ' . $member->getEmail() . '<br />';
    $content .= 'Pseudo :   ' . $member->getUsername();
    $concent .= 'Version :      1.2-dev';
    $from     = 'info-association@piwam.org';
    $message  = Swift_Message::newInstance($subject)
    ->setBody($content)
    ->setContentType('text/html')
    ->setFrom(array($from => 'Piwam'))
    ->setTo(array('adrien@frenchcomp.net' => 'Developer'));

    try
    {
      $swift->send($message);
    }
    catch(Swift_ConnectionException $e)
    {
      //
    }
  }

  /**
   * Call after creating new member or validate pending subscription
   * @param Member $member member created
   * @param string $password password typed in form or text sentence if it is unknown
   * @param boolean $isFirst true if it is first user of association
   */
  private function _memberCreatedEvent(Member $member,$password,$isFirst = false)
  {
    if ($member->getEmail() && $member->getUsername())
    {
      $values = array();
      $values['recipient.password'] = $password;
      try{
        MailerFactory::loadTemplateAndSend($this->getUser()->getUserId(),$member,'member_created',$values);
      }
      catch(Swift_ConnectionException $e)
      {
        $this->getUser()->setFlash('error',"Une erreur c'est produite pour envoyer l'email de nouveau compte à l'adhérent.");
      }
    }
    // notify member listeners
    $this->dispatcher->notify(new sfEvent($this, 'member.created',array(
      'member' => $member,
      'first' => $isFirst,
    )));
  }
  /**
   * Return true if anonymous can create first member of associaiton (there is no member)
   */
  private function _canCreateFirstMember()
  {
    $tmpAssoId = $this->getUser()->getTemporaryAssociationId();
    if($tmpAssoId != null && $tmpAssoId > 0)
    {
       $members = MemberTable::getEnabledForAssociation($tmpAssoId);
       if(count($members) === 0)
       {
         return true;
       }
    }
    return false;
  }
}