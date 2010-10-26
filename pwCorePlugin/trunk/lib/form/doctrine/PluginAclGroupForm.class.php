<?php

/**
 * PluginAclGroup form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginAclGroupForm extends BaseAclGroupForm
{
	public function setup()
  {
  	parent::setup();
  	
  	$this->useFields(array('id','selected_new_member'));
  	
  	$this->widgetSchema['name'] = new sfWidgetFormInputText();
  	$this->widgetSchema['description'] = new sfWidgetFormTextarea();
  	$this->setDefault('name',$this->getObject()->getName());
  	$this->setDefault('description',$this->getObject()->getDescription());
  	
  	$this->validatorSchema['name']       = new sfValidatorString(array('max_length' => 255, 'required' => true));
   	$this->validatorSchema['description']        = new sfValidatorString(array('max_length' => 1000, 'required' => true));
   	
   	$this->widgetSchema['name']->setAttribute('class', 'formInputLarge');
    $this->widgetSchema['description']->setAttribute('class', 'formInputLarge');
    
  	$this->widgetSchema->setLabels(array(
  		'name' => 'Nom',
  		'description' => 'Description',
  		'selected_new_member' => 'Selectionné par défaut',
  	));
  	
  }
}
