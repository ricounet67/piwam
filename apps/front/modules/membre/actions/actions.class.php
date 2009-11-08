<?php

/**
 * membre actions.
 *
 * @package    piwam
 * @subpackage membre
 * @author     Your name here
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
            $this->redirect('membre/show?id=' . $this->getUser()->getUserId());
        }

        $orderByColumn = $request->getParameter('orderby', MembrePeer::PSEUDO);
        $this->membresPager = MembrePeer::doSelectOrderBy($this->getUser()->getAssociationId(),
                                                            $request->getParameter('page', 1),
                                                            $orderByColumn
                                                          );

        $this->pending = MembrePeer::doSelectPending($this->getUser()->getAssociationId());
    }

    /**
     * Provide all information about the member to the view. We check if we have
     * the right to see profile of someone else
     *
     * @param 	sfWebRequest	$request
     */
    public function executeShow(sfWebRequest $request)
    {
        $membre_id = $request->getParameter('id');
        $this->membre = MembrePeer::retrieveByPk($membre_id);

        if (($this->membre->getAssociationId() == $this->getUser()->getAssociationId()) &&
                (($this->getUser()->hasCredential('show_membre')) ||
                ($this->getUser()->getUserId() == $membre_id))
            )
        {
            $this->cotisations = CotisationPeer::doSelectForUser($membre_id);
            $this->credentials = AclCredentialPeer::doSelectForMembreId($membre_id);
            $this->forward404Unless($this->membre);
        }
        else
        {
            $this->forward('error', 'credentials');
        }
    }

    /**
     *
     * @param $request
     * @return unknown_type
     */
    public function executeRequestsubscription(sfWebRequest $request)
    {
        if (sfConfig::get('app_multi_association'))
        {
            $associationId = $request->getParameter('id', null);
            $this->forward404Unless($association = AssociationPeer::retrieveByPK($associationId), sprintf("L'association %s n'existe pas.", $associationId));
        }
        else
        {
            $association = AssociationPeer::doSelectOne(new Criteria());
            $associationId = $association->getId();
        }

        $this->form = new MembreForm(null, array('associationId' => $associationId));
        $this->form->setDefault('association_id', $associationId);
        $this->form->setDefault('actif', MembrePeer::IS_PENDING);
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
     * Registration of a new Membre
     *
     * @param   sfWebRequest    $request
     */
    public function executeNew(sfWebRequest $request)
    {
        $this->form = new MembreForm(null, array('associationId' => $this->getUser()->getAssociationId()));
        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());
    }

    /**
     * Register a new Membre - and the first one ! - for an
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
            $this->form = new MembreForm(null, array('associationId' => $associationId));
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
        $this->form = new MembreForm(null, array('associationId' => $this->getUser()->getTemporaryAssociationId()));
        $request->setAttribute('first', true);
        $this->processForm($request, $this->form);
        $this->setTemplate('newfirst');
    }

    /**
     * Display information about the just finished registration. We use
     * keyword 'instanceof' because getTemporaryUserInfo() returns
     * unserialized object - which can be null.
     *
     * @param 	sfWebRequest	$request
     * @see 	getTemporaryUserInfo()
     * @since	r16
     */
    public function executeEndregistration(sfWebRequest $request)
    {
        $membre = $this->getUser()->getTemporaryUserInfo();

        if ($membre instanceof Membre)
        {
            // here you can access to $membre properties
            // and methods
        }
    }

    /**
     * Register a new pending user which requested a subscription to an existing
     * association
     *
     * @param   sfWebRequest    $request
     */
    public function executeCreatepending(sfWebRequest $request)
    {
        if (sfConfig::get('app_multi_association'))
        {
            $associationId = $request->getParameter('id', null);
            $this->forward404Unless($association = AssociationPeer::retrieveByPK($associationId), sprintf("L'association %s n'existe pas.", $associationId));
        }
        else
        {
            $association = AssociationPeer::doSelectOne(new Criteria());
            $associationId = $association->getId();
        }

        $this->forward404Unless($request->isMethod('post'));
        $this->form = new MembreForm(null, array('associationId' => $associationId));
        $request->setAttribute('pending', true);
        $this->processForm($request, $this->form);
        $this->setTemplate('requestsubscription');
    }

    /**
     * Validate a pending subscription
     *
     * @param   sfWebRequest    $request
     * @since   r160
     */
    public function executeValidate(sfWebRequest $request)
    {
        $membre_id = $request->getParameter('id');
        $membre = MembrePeer::retrieveByPk($membre_id);

        if ($membre->getAssociationId() == $this->getUser()->getAssociationId())
        {
            $membre->setActif(MembrePeer::IS_ACTIF);
            $membre->save();
            $this->redirect('membre/index');
        }
        else
        {
            $this->forward('error', 'credentials');
        }
    }

    /**
     * Perform the creation of the Membre object in database
     *
     * @param   sfWebRequest    $request
     */
    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new MembreForm(null, array('associationId' => $request->getParameter('membre[association_id]')));
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
        $associationId  = $this->getUser()->getAssociationId();
        $this->user_id  = $request->getParameter('id');
        $this->forward404Unless($membre = MembrePeer::retrieveByPk($this->user_id));
        $this->form     = new MembreForm($membre, array('associationId' => $membre->getAssociationId()));
        $this->aclForm  = new AclCredentialForm();
        $membre         = MembrePeer::retrieveByPk($this->user_id);
        $this->canEditRight = $this->getUser()->hasCredential('edit_acl');

        if (($membre->getAssociationId() != $associationId) ||
                (($this->getUser()->hasCredential('edit_membre') == false) &&
                ($this->getUser()->getUserId() != $this->user_id))
            )
        {
            $this->redirect('error/credentials');
        }

        $this->form->setDefault('mis_a_jour_par', $this->getUser()->getUserId());
        $this->aclForm->setUserId($this->user_id);
        $this->aclForm->automaticCheck();
    }

    /**
     * Perform the update of the Membre
     *
     * @param   sfWebRequest    $request
     */
    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $this->forward404Unless($membre = MembrePeer::retrieveByPk($request->getParameter('id')), sprintf('Member does not exist (%s).', $request->getParameter('id')));
        $associationId  = $this->getUser()->getAssociationId();
        $this->user_id  = $request->getParameter('id');
        $this->form     = new MembreForm($membre, array('associationId' => $request->getParameter('membre[association_id]')));
        $this->aclForm  = new AclCredentialForm();
        $membre         = MembrePeer::retrieveByPk($this->user_id);
        $this->canEditRight = $this->getUser()->hasCredential('edit_acl');

        if (($membre->getAssociationId() != $associationId) ||
                (($this->getUser()->hasCredential('edit_membre') == false) &&
                ($this->getUser()->getUserId() != $request->getParameter('id')))
            )
        {
            $this->redirect('error/credentials');
        }

        $this->aclForm->setUserId($this->user_id);
        $this->aclForm->automaticCheck();

        $this->processForm($request, $this->form);
        $this->setTemplate('edit');
    }

    /**
     * Export the list of Membre within a file
     *
     * @param   sfWebRequest    $request
     * @since   r19
     */
    public function executeExport(sfWebRequest $request)
    {
        $csv = new FileExporter('liste-membres.csv');
        $membres = MembrePeer::doSelectForAssociation($this->getUser()->getAssociationId());

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

        foreach ($membres as $membre)
        {
            echo $csv->addLineCSV(array(
            $membre->getPrenom(),
            $membre->getNom(),
            $membre->getPseudo(),
            $membre->getEmail(),
            $membre->getTelFixe(),
            $membre->getTelPortable(),
            $membre->getRue(),
            $membre->getCp(),
            $membre->getVille(),
            $membre->getPays(),
            $membre->getStatut(),
            $membre->getDateInscription(),
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
        $this->forward404Unless($membre = MembrePeer::retrieveByPk($request->getParameter('id')), sprintf('Le membre n\'existe pas (%s).', $request->getParameter('id')));
        $associationId  = $this->getUser()->getAttribute('association_id', null, 'user');

        if ($membre->getAssociationId() != $associationId) {
            $this->redirect('error/credentials');
        }

        $membre->delete();
        $this->redirect('membre/index');
    }

    /**
     * Called method to display list of Membre within an autocompleted
     * form field.
     *
     * @param 	sfWebRequest	$request
     * @since	r15
     * @unused
     */
    public function executeAjaxlist(sfWebRequest $request)
    {
        $this->getResponse()->setContentType('application/json');
        $membres = MembrePeer::retrieveForSelect($request->getParameter('q'), $request->getParameter('limit'));
        return $this->renderText(json_encode($membres));
    }

    /**
     * Display images
     *
     * @param 	sfWebRequest $request
     * @since	r139
     */
    public function executeFaces(sfWebRequest $request)
    {
        $this->membres = MembrePeer::doSelectForAssociation($associationId = $this->getUser()->getAttribute('association_id', null, 'user'));
    }

    /**
     * If this is a the first Membre that we registered, we redirect
     * to the `end` action to display success message about registration.
     *
     * r62 :    We give all the credentials to the user if this is the
     *          first user
     *
     * r139 :	resize pictures
     *
     * @param 	sfWebRequest	$request
     * @param 	sfForm			$form
     */
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $membre = $form->save();

            if ($membre->getPicture())
            {
                $img = new sfImage(MembrePeer::PICTURE_DIR . '/' . $membre->getPicture(), 'image/jpg');
                $img->thumbnail(sfConfig::get('app_picture_width', 120), sfConfig::get('app_picture_height', 150));
                $img->saveAs(MembrePeer::PICTURE_DIR . '/' . $membre->getPicture());
            }
            if ($request->getAttribute('first') == true)
            {
                $association = AssociationPeer::retrieveByPK($membre->getAssociationId());
                $association->setEnregistrePar($membre->getId());
                $association->save();
                $this->getUser()->removeTemporaryData();
                $this->getUser()->setTemporarUserInfo($membre);
                $credentials = AclActionPeer::doSelect(new Criteria());

                // we don't need to clear existing credentials before,
                // because we are sure the user doesn't have anyone

                foreach ($credentials as $credential)
                {
                    $membre->addCredential($credential->getCode());
                }

                $this->redirect('membre/endregistration');
            }
            elseif ($request->getAttribute('pending') == true)
            {
                $this->redirect('membre/pending');
            }
            else
            {
                $data = $request->getParameter('membre');

                if ((isset($data['enregistre_par'])) && ($membre->getPseudo() && $membre->getPassword()))
                {
                    $this->redirect('membre/acl?id=' . $membre->getId());
                }
                else
                {
                    $this->redirect('membre/index');
                }
            }
        }
    }

    /**
     * Geo-localize members within a map thanks to Google MAP
     * API.
     *
     * @param 	sfWebRequest	$request
     * @since	r17
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
        $membres = MembrePeer::doSelectForAssociation($associationId);

        foreach ($membres as $membre)
        {
            if (strlen($membre->getVille()) > 0)
            {
                $map->addAddress($membre->getCompleteAddress(), $membre->getInfoForGmap());
            }
        }

        $this->GMapKey = $GMapKey;
        $this->map = $map;
    }

    /**
     * Allows the user to manager ACL for each Membre. Once the form is submit,
     * the existing credentials are deleted and we created new ones.
     * The AclCredentialForm is also put on membre/edit view. If we reach the
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
                $membre = MembrePeer::retrieveByPk($values['user_id']);
                $membre->resetAcl();

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
                            $membre->addCredential($code);
                        }
                    }
                }
                $this->redirect('membre/index');
            }
        }
        else
        {
            $this->user_id  = $request->getParameter('id');
            $membre         = MembrePeer::retrieveByPk($this->user_id);

            if (($membre->getAssociationId() != $this->getUser()->getAssociationId()) ||
                ($this->getUser()->hasCredential('edit_acl') == false))
            {
                $this->forward('error', 'credentials');
            }

            $this->form->setUserId($this->user_id);
            $this->form->automaticCheck();
        }
    }
}
