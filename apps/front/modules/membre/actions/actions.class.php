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
        $orderByColumn = $request->getParameter('orderby', MembrePeer::PSEUDO);
        $this->membresPager = MembrePeer::doSelectOrderBy($this->getUser()->getAttribute('association_id', null, 'user'),
														        $request->getParameter('page', 1),
														        $orderByColumn);
    }

    /**
     * Provide all information about the member to the view
     *
     * @param 	sfWebRequest	$request
     */
    public function executeShow(sfWebRequest $request)
    {
        $membre_id = $request->getParameter('id');
        $this->membre = MembrePeer::retrieveByPk($membre_id);

        if ($this->membre->getAssociationId() == $this->getUser()->getAttribute('association_id', null, 'user')) {
            $this->cotisations = CotisationPeer::doSelectForUser($membre_id);
            $this->credentials = AclCredentialPeer::doSelectForMembreId($membre_id);
            $this->forward404Unless($this->membre);
        }
        else {
            $this->forward('error', 'credentials');
        }
    }

    /**
     * Registration of a new Membre
     *
     * @param   sfWebRequest    $request
     */
    public function executeNew(sfWebRequest $request)
    {
        $this->form = new MembreForm();
        $this->form->setDefault('mis_a_jour_par', sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'user'));
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
        $this->form = new MembreForm();
        $associationId = $this->getUser()->getAttribute('association_id', null, 'temp');
        if (is_null($associationId)) {
            throw new sfException('Erreur lors de la première étape d\'enregistrement');
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
        $this->form = new MembreForm();
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
     * Perform the creation of the Membre object in database
     *
     * @param   sfWebRequest    $request
     */
    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new MembreForm();
        $this->form->setDefault('mis_a_jour_par', sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'user'));
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
        $associationId  = $this->getUser()->getAttribute('association_id', null, 'user');
        $this->user_id  = $request->getParameter('id');
        $this->forward404Unless($membre = MembrePeer::retrieveByPk($this->user_id));
        $this->form     = new MembreForm($membre);
        $this->aclForm  = new AclCredentialForm();
        $membre         = MembrePeer::retrieveByPk($this->user_id);
        $this->canEditRight = $this->getUser()->hasCredential('edit_acl');

        if ($membre->getAssociationId() != $associationId) {
            $this->redirect('error/credentials');
        }

        $this->form->setDefault('mis_a_jour_par', sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'user'));
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
        $this->forward404Unless($membre = MembrePeer::retrieveByPk($request->getParameter('id')), sprintf('Object membre does not exist (%s).', $request->getParameter('id')));
        $this->form = new MembreForm($membre);

        $associationId  = $this->getUser()->getAttribute('association_id', null, 'user');
        $this->user_id  = $request->getParameter('id');
        $this->form     = new MembreForm($membre);
        $this->aclForm  = new AclCredentialForm();
        $membre         = MembrePeer::retrieveByPk($this->user_id);
        $this->canEditRight = $this->getUser()->hasCredential('edit_acl');

        if ($membre->getAssociationId() != $associationId) {
            $this->redirect('error/credentials');
        }

        $this->form->setDefault('mis_a_jour_par', sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'user'));
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
        $membres = MembrePeer::doSelectForAssociation($this->getUser()->getAttribute('association_id', null, 'user'));

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
     * If this is a the first Membre that we registered, we redirect
     * to the `end` action to display success message about registration.
     *
     * r62 :    We give all the credentials to the user if this is the
     *          first user
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

            if ($request->getAttribute('first') == true) {
                $association = AssociationPeer::retrieveByPK($membre->getAssociationId());
                $association->setEnregistrePar($membre->getId());
                $association->save();
                $this->getUser()->removeTemporaryData();
                $this->getUser()->setTemporarUserInfo($membre);
                $this->redirect('membre/endregistration');

                $credentials = AclActionPeer::doSelect(new Criteria());
                foreach ($credentials as $credential) {
                    $membre->addCredential($credential->getCode());
                }
            }
            else {
                $data = $request->getParameter('membre');

                if ((!isset($data['id'])) && ($membre->getPseudo() && $membre->getPassword())) {
                    $this->redirect('membre/acl?id=' . $membre->getId());
                }
                else {
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
        $map = new PhoogleMap();
        $map->setApiKey(sfConfig::get('sf_googlemap_key'));
        $map->zoomLevel = 12;
        $map->setWidth(600);
        $map->setHeight(400);

        $associationId = $this->getUser()->getAttribute('association_id', null, 'user');
        $membres = MembrePeer::doSelectForAssociation($associationId);

        foreach ($membres as $membre) {
            if (strlen($membre->getVille()) > 0) {
                $map->addAddress($membre->getCompleteAddress(), $membre->getInfoForGmap());
            }
        }

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
            $this->form->bind($request->getParameter('rights'));
            if ($this->form->isValid())
            {
                $values = $request->getParameter('rights');
                $membre = MembrePeer::retrieveByPk($values['user_id']);
                $membre->resetAcl();

                // Browse the list of rights... first we get the 'modules' level
                foreach ($values['rights'] as $mid => $acls)
                {
                    // Then, foreach module, we get the list of enabled
                    // checkboxes. "$state" is normally always set to "ON"
                    // because we only have checked elements

                    foreach ($acls as $code => $state) {
                        $membre->addCredential($code);
                    }
                }
                $this->redirect('membre/index');
            }
        }
        else
        {
            $this->user_id  = $request->getParameter('id');
            $associationId  = $this->getUser()->getAttribute('association_id', null, 'user');
            $membre         = MembrePeer::retrieveByPk($this->user_id);

            if (($membre->getAssociationId() != $associationId) ||
                ($this->getUser()->hasCredential('edit_acl') == false)) {
                $this->forward('error', 'credentials');
            }

            $this->form->setUserId($this->user_id);
            $this->form->automaticCheck();
        }
    }
}
