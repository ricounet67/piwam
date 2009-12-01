<?php
/**
 * membre actions.
 *
 * @package    piwam
 * @subpackage membre
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class membreActions extends sfActions
{
  /**
   * Lists members who belongs to the current association. By default we sort
   * the list by pseudo, and if another column is specified we use it.
   *
   * r14 : pagination system
   *
   * @param 	sfWebRequest	$request
   * @since	r1
   */
  public function executeIndex(sfWebRequest $request)
  {
    if (! $this->getUser()->hasCredential('list_membre'))
    {
      $this->redirect('@member_show?id=' . $this->getUser()->getUserId());
    }

    $this->orderByColumn = $request->getParameter('orderby', 'lastname');
    $associationId = $this->getUser()->getAssociationId();
    $page          = $request->getParameter('page', 1);
    $this->members = MemberTable::getPagerOrderBy($associationId, $page, $this->orderByColumn);
    $this->pending = MemberTable::getPendingMembers($associationId);
    $ajaxUrl       = $this->getController()->genUrl('@ajax_search_members');
    $this->searchForm = new SearchUserForm(null, array('associationId' => $this->getUser()->getAssociationId(), 'ajaxUrl' => $ajaxUrl));
  }

  /**
   * Display images
   *
   * @param   sfWebRequest $request
   * @since   r139
   */
  public function executeFaces(sfWebRequest $request)
  {
    $this->members = MemberTable::getEnabledForAssociation($this->getUser()->getAssociationId());
  }

  /**
   * Perform a research and return results
   *
   * @param   sfWebRequest    $request
   * @since   r211
   */
  public function executeSearch(sfWebRequest $request)
  {
    $params = $request->getParameter('search');
    $magicField  = $request->getParameter('autocomplete_search[magic]');
    $params['magic'] = $magicField;

    if (strlen($params['magic']) > 0)
    {
      $this->members = MemberTable::doSearch($params);

      if (count($this->members) === 1)
      {
        $this->redirect('@member_show?id=' . $this->members[0]->getId());
      }
    }
    else
    {
      $this->members = array();
    }

    $ajaxUrl = $this->getController()->genUrl('@ajax_search_members');
    $this->searchForm = new SearchUserForm(null, array('associationId' => $this->getUser()->getAssociationId(),
                                                       'ajaxUrl'       => $ajaxUrl));
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

    if ($this->isAllowedToManageProfile($profile, 'show_membre'))
    {
      $this->cotisations = DueTable::getForUser($member_id);
      $this->credentials = AclCredentialTable::getForMember($member_id);
      $this->member = $profile;
    }
    else
    {
      $this->redirect('@error_credentials');
    }
  }

  /**
   * Export the list of member within a file
   *
   * @param   sfWebRequest    $request
   * @since   r19
   */
  public function executeExport(sfWebRequest $request)
  {
    $csv = new FileExporter('liste-membres.csv');
    $members = MemberTable::doSelectForAssociation($this->getUser()->getAssociationId());

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
      $member->getPrenom(),
      $member->getNom(),
      $member->getPseudo(),
      $member->getEmail(),
      $member->getTelFixe(),
      $member->getTelPortable(),
      $member->getRue(),
      $member->getCp(),
      $member->getVille(),
      $member->getPays(),
      $member->getStatut(),
      $member->getDateInscription(),
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
    $request->checkCSRFProtection();
    $id = $request->getParameter('id');
    $member = MemberTable::retrieveByPk($id);
    $this->forward404Unless($member);

    if ($member->getAssociationId() != $this->getUser()->getAssociationId())
    {
      $this->redirect('@error_credentials');
    }

    $member->delete();
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
    $members = MemberTable::search($query, $limit, $id);

    return $this->renderText(json_encode($members));
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
    $GMapKey = Configurator::get('googlemap_key', $associationId);
    $map = new PhoogleMap();
    $map->setApiKey($GMapKey);
    $map->zoomLevel = 12;
    $map->setWidth(600);
    $map->setHeight(400);
    $members = MemberTable::getEnabledForAssociation($associationId);

    foreach ($members as $member)
    {
      if (strlen($member->getCity()) > 0)
      {
        $map->addAddress($member->getCompleteAddress(), $member->getInfoForGmap());
      }
    }

    $this->GMapKey = $GMapKey;
    $this->map = $map;
  }

  /**
   * Allows the user to manager ACL for each member. Once the form is submit,
   * the existing credentials are deleted and we created new ones.
   * The AclCredentialForm is also put on member/edit view. If we reach the
   * form through this action, this is because we are registering a NEW user
   *
   * @param   sfWebRequest    $request
   * @since   r60
   */
  public function executeAcl(sfWebRequest $request)
  {
    $this->form = new AclCredentialForm();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('rights', array()));

      if ($this->form->isValid())
      {
        $values = $request->getParameter('rights', array());
        $member = MemberTable::getById($values['user_id']);
        $member->resetAcl();

        // Browse the list of rights... first we get the 'modules' level

        if (isset($values['rights']))
        {
          foreach ($values['rights'] as $mid => $acls)
          {
            // Then, foreach module, we get the list of enabled
            // checkboxes. "$state" is normally always set to "ON"
            // because we only have checked elements

            foreach ($acls as $code => $state)
            {
              $member->addCredential($code);
            }
          }
        }

        $this->redirect('@members_list');
      }
    }
    else
    {
      $this->user_id  = $request->getParameter('id');
      $member = MemberTable::getById($this->user_id);

      if (($member->getAssociationId() != $this->getUser()->getAssociationId()) ||
          ($this->getUser()->hasCredential('edit_acl') == false))
      {
        $this->redirect('@error_credentials');
      }

      $this->form->setUserId($this->user_id);
      $this->form->automaticCheck();
    }
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
    $this->form = new MemberForm(null, array('associationId' => $aId, 'context' => $ctxt));
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
    $aId = $request->getParameter('member[association_id]');
    $ctxt = $this->getContext();
    $this->form = new MemberForm(null, array('associationId' => $aId, 'context' => $ctxt));
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

    if (false === $this->isAllowedToManageProfile($member, 'edit_membre'))
    {
      $this->redirect('@error_credentials');
    }

    $aId = $member->getAssociationId();
    $ctxt = $this->getContext();
    $this->form = new MemberForm($member, array('associationId' => $aId, 'context' => $ctxt));
    $this->aclForm  = new AclCredentialForm();
    $this->canEditRight = $this->getUser()->hasCredential('edit_acl');
    $this->form->setDefault('updated_by', $this->getUser()->getUserId());
    $this->aclForm->setUserId($this->user_id);
    $this->aclForm->automaticCheck();
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

    if (false === $this->isAllowedToManageProfile($user, 'edit_membre'))
    {
      $this->redirect('@error_credentials');
    }

    $request->getParameter('member[association_id]');
    $this->form = new MemberForm($user, array('associationId' => $associationId,
                                              'context' => $this->getContext()));
    $this->aclForm  = new AclCredentialForm();
    $this->canEditRight = $this->getUser()->hasCredential('edit_acl');
    $this->aclForm->setUserId($this->user_id);
    $this->aclForm->automaticCheck();
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
  }

  /**
   * Register a new pending user which requested a subscription to an existing
   * association
   *
   * @param   sfWebRequest    $request
   */
  public function executeCreatepending(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $association_id = $request->getParameter("member[association_id]");
    $this->form = new MemberForm(null, array('associationId' => $association_id,
                                             'context' => $this->getContext()));
    $request->setAttribute('pending', true);
    $this->processForm($request, $this->form);
    $this->setTemplate('requestsubscription');
  }

  /**
   * Once subscription request form has been completed, we display a
   * message to the user
   *e
   */
  public function executePending()
  {
    // do nothing, just display template
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

      if ($member->getEmail() && $member->getPseudo())
      {
        $mailer  = MailerFactory::get($this->getUser()->getAssociationId(), $this->getUser());
        $message = new Swift_Message('Activation du compte', "Bonjour {$member}, votre compte a bien &eacute;t&eacute; activ&eacute;. Vous pouvez d&egrave;s maintenant vous identifier en tant que '{$member->getPseudo()}'", 'text/html');
        $from    = Configurator::get('address', $member->getAssociationId(), 'info-association@piwam.org');

        try
        {
          $mailer->send($message, $member->getEmail(), $from);
        }
        catch(Swift_ConnectionException $e)
        {
          // do nothing
        }
      }

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
    $associationId = $this->getUser()->getAttribute('association_id', null, 'temp');

    if (is_null($associationId))
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
  }

  /**
   * Performed action when registering the first user
   *
   * @param 	sfWebRequest	$request
   * @since	r16
   */
  public function executeFirstcreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new MemberForm(null, array('associationId' => $this->getUser()->getTemporaryAssociationId(),
                                             'context'       => $this->getContext(),
                                             'first'         => true));
    $request->setAttribute('first', true);
    $this->processForm($request, $this->form);
    $this->setTemplate('newfirst');
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
    if ($form->isValid())
    {
      $member = $form->save();

      if ($member->getPicture())
      {
        $img = new sfImage(MemberTable::PICTURE_DIR . '/' . $member->getPicture(), 'image/jpg');
        $img->thumbnail(sfConfig::get('app_picture_width', 116), sfConfig::get('app_picture_height', 116), 'top');
        $img->saveAs(MemberTable::PICTURE_DIR . '/' . $member->getPicture());
      }
      if ($request->getAttribute('first') == true)
      {
        $association = AssociationTable::getById($member->getAssociationId());
        $association->setCreatedBy($member->getId());
        $association->save();
        $this->getUser()->setTemporarUserInfo($member);
        $credentials = AclActionTable::getAll();

        // we don't need to clear existing credentials before,
        // because we are sure the user doesn't have anyone

        foreach ($credentials as $credential)
        {
          $member->addCredential($credential->getCode());
        }

        // We check if we can warn the author that this association
        // is using Piwam

        if ($this->getUser()->getAttribute('ping_piwam', false, 'temp'))
        {
          $swiftMailer  = new Swift(new Swift_Connection_NativeMail());
          $subject      = '[Piwam] '    . $association->getNom() . ' utilise Piwam';
          $content      = 'Site web : ' . $association->getSiteWeb() . '<br />';
          $content     .= 'Email :    ' . $member->getEmail() . '<br />';
          $content     .= 'Pseudo :   ' . $member->getPseudo();
          $from         = 'info-association@piwam.org';
          $swiftMessage = new Swift_Message($subject, $content, 'text/html');

          try
          {
            $swiftMailer->send($swiftMessage, 'adrien@frenchcomp.net', $from);
          }
          catch(Swift_ConnectionException $e)
          {
            //
          }
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
        $data = $request->getParameter('member');

        if ((isset($data['created_by'])) && ($member->getPseudo() && $member->getPassword()))
        {
          $this->redirect('@member_acl?id=' . $member->getId());
        }
        else
        {
          $this->redirect('@members_list');
        }
      }
    }
  }

  /**
   * Checks if we are allowed to edit/show profile of $user
   *
   * @param   Member    $user
   * @return  boolean
   */
  protected function isAllowedToManageProfile(Member $user, $globalCredential = null)
  {
    if (($user->getAssociationId() != $this->getUser()->getAssociationId()))
    {
      return false;
    }
    else
    {
      if (! is_null($globalCredential))
      {
        if ($this->getUser()->hasCredential($globalCredential) == true)
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
}
