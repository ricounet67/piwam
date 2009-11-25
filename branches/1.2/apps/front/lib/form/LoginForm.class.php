<?php
/**
 * Represents the login form
 *
 * @author 	Adrien Mogenet
 * @since	r7
 */
class LoginForm extends BaseForm
{
    public function configure()
    {
        $this->setWidgets(array(
	      'username' => new sfWidgetFormInputText(), 
	      'password' => new sfWidgetFormInputPassword() 
        ));

        $this->widgetSchema->setNameFormat('login[%s]');

        $this->setValidators(array(
	      'username' => new sfValidatorString(array('required' => true)), 
	      'password' => new sfValidatorString(array('required' => true)),
        ));
    }
}
?>