<?php

/**
 * sfEmailTemplateAdmin actions.
 *
 * @package    project
 * @subpackage sfEmailTemplateAdmin
 * @author     voznyaknazar@gmail.com
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class mail_templateActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->templates = MailTemplateTable::getInstance()->findByAssociationId($this->getUser()->getAssociationId());
	}
	public function executeEdit(sfWebRequest $request)
	{
		$id = $request->getParameter('id',-1);
		$this->template = MailTemplateTable::getInstance()->find($id);
		$this->form = new MailTemplateForm($this->template);
		$this->templateVariables = MailTemplateVariableTable::getInstance()->findByTemplateKey($this->template->getTemplateKey());
	}
	public function executeUpdate(sfWebRequest $request)
	{
		
		$template = MailTemplateTable::getInstance()->find($request->getParameter('id'));
		$form = new MailTemplateForm($template);
		$form->bind($request->getParameter($form->getName()));
		if($form->isValid())
		{
			$values = $form->getValues();
			
			$template->setSubject($values['subject']);
			$template->setContent($values['content']);
			$template->save();
			$this->redirect('@mail_templates_list');
		}
		$this->template = $template;
		$this->form = $form;
		$this->setTemplate('edit');
	}


}
