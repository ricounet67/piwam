<?php

/**
 * PluginMailTemplate form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginMailTemplateForm extends BaseMailTemplateForm
{
	public function setup()
	{
		parent::setup();
		$this->useFields(array('subject','content','id'));
		
		$this->widgetSchema['content'] = new pwWidgetFormTinyMCE();
      
		$this->widgetSchema['subject']->setAttribute('class', 'formInputXtraLarge');
		$this->widgetSchema->setLabels(array(
  		'subject' => 'Sujet',
  		'content' => 'Contenu',
  	));
	}
}
