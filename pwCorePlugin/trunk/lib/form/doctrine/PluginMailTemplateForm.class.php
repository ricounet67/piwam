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
		
		$this->widgetSchema['content'] = new sfWidgetFormTextareaTinyMCE(array(
        'width'       => 550,
        'height'      => 350,
        'config'      => '	theme_advanced_buttons1 : "bold,italic,underline,fontsizeselect,fontselect,forecolorpicker,image,link,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,indent,outdent",
                            theme_advanced_buttons2 : "",
                            theme_advanced_buttons3 : "",
                            theme_advanced_statusbar_location : "none"'
        ),
      	array('rows' => 40, 'cols' => 10)
    );
      
		$this->widgetSchema['subject']->setAttribute('class', 'formInputXtraLarge');
		$this->widgetSchema->setLabels(array(
  		'subject' => 'Sujet',
  		'content' => 'Contenu',
  	));
	}
}
