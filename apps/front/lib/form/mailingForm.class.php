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
			'mail_content' 	=> new sfWidgetFormTextarea()
		));
		
		$this->setValidators(array(
			'subject'		=> new sfValidatorPass(),
			'mail_content'	=> new sfValidatorPass(),
		));
	}
}
?>