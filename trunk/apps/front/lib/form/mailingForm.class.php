<?php 
/**
 * Represents the form which allows us to mail Membre of our Association
 * 
 * @author 	Adrien Mogenet
 * @since	r10
 */
class MailingForm extends sfForm
{
	/**
	 * Set the widgets and validators for the Mailing form
	 */
	public function configure()
	{
		$this->setWidgets(array(
			'subject'		=> new sfWidgetFormInput(),
			'mail_content' 	=> new sfWidgetFormTextareaTinyMCE(array(
			  'width'  => 550,
			  'height' => 350,
			  'config' => '	theme_advanced_buttons1 : "bold,italic,underline,fontsizeselect,fontselect,forecolorpicker,image,link,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,indent,outdent",
			  				theme_advanced_buttons2 : "",
			  				theme_advanced_buttons3 : "",
			  				theme_advanced_statusbar_location : "none"'
			))
		));
		
		$this->setValidators(array(
			'subject'		=> new sfValidatorString(array('required' => true)),
			'mail_content'	=> new sfValidatorString(array('required' => true)),
		));
		
		$this->widgetSchema->setNameFormat('mailing[%s]');
		$this->widgetSchema['subject']->setAttribute('class', 'formInputXtraLarge');

		
		// r19 : autocompleted recipients field
		//       it's currently not displayed
		
		$this->widgetSchema['recipients'] = new sfWidgetFormPropelJQueryAutocompleter(array(
		  	'model' => 'Membre',
  			'url'   => $this->getOption('url'),
		));
		$this->widgetSchema['recipients']->setAttribute('class', 'formInputNormal');
	}
}
?>