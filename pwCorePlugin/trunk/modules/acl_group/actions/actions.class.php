<?php

/**
 * Acl group actions.
 *
 * @package    piwam
 * @subpackage acl_group
 * @author     jerome fouilloy
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class acl_groupActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->aclGroups = AclGroupTable::getGroupsForAssociation($this->getUser()->getAssociationId());
		// $this->nbMembers = count(MemberTable::getEnabledForAssociation($this->getUser()->getAssociationId()));
		$this->nbAclActions = AclActionTable::doCount();
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new AclGroupForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new AclGroupForm();
		$this->processForm($request, $this->form, new AclGroup());
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$group_id  = $request->getParameter('id');
		$acl_group = AclGroupTable::getById($group_id);
		$this->forward404Unless($acl_group);
		$this->form = new AclGroupForm($acl_group);
		
		$this->logMessage('groupe='.$acl_group->getName(),'debug');
		$this->rightsForm = new AclCredentialForm();
		$this->rightsForm->setGroupId($group_id);
		$this->rightsForm->automaticCheck();
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$acl_group = AclGroupTable::getById($request->getParameter('id'));
		$this->forward404Unless($acl_group);
		$this->form = new AclGroupForm($acl_group);
		$this->processForm($request, $this->form, $acl_group);
		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		$id = $request->getParameter('id');
		$this->forward404Unless($acl_group = AclGroupTable::getById($id));

		if ($acl_group->getAssociationId() != $this->getUser()->getAssociationId())
		{
			$this->redirect('@error_credentials');
		}
		$acl_group->delete();
		$this->redirect('@acl_groups_list');
	}
	/**
	 *
	 * @param   sfWebRequest    $request

	 */
	public function executeRightsEdit(sfWebRequest $request)
	{
		$this->form = new AclCredentialForm();

		$this->group_id  = $request->getParameter('id');
		$aclGroup = AclGroupTable::getById($this->group_id);
		$this->forward404Unless($aclGroup);

		if (($aclGroup->getAssociationId() != $this->getUser()->getAssociationId()) ||
		($this->getUser()->hasCredential('config_acl_group') == false))
		{
			$this->redirect('@error_credentials');
		}

		$this->form->setGroupId($this->group_id);
		$this->form->automaticCheck();
	}

	public function executeRightsSave(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		 
		$values = $request->getParameter('rights', array());
		$group_id  = intval($values['group_id']);
		$aclGroup = AclGroupTable::getById($group_id);
		$this->forward404Unless($aclGroup);

		$aclGroup->resetAcl();

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
					$aclGroup->addCredential(AclActionTable::getByCode($code));
				}
			}
		}
		$this->redirect('@acl_groups_list');
	}

	protected function processForm(sfWebRequest $request, sfForm $form, AclGroup $acl_group)
	{
		$form->bind($request->getParameter($form->getName()));

		if ($form->isValid())
		{
			// copy cleaned values from the form into object
			$form->updateObject();
			$acl_group = $form->getObject();
			$is_creation = false;
			if($acl_group->isNew())
			{
				$acl_group->setAssociationId($this->getUser()->getAssociationId());
				$is_creation = true;
			}
			$acl_group->save();

			if($is_creation == true)
			{
				$this->redirect('@acl_group_rights_edit?id='. $acl_group->getId());
			}
			else
			{
				//$this->redirect('@acl_groups_edit?id='. $acl_group->getId(). '#credentials');
				 $this->redirect('@acl_groups_list');
			}
		}
	}
}
