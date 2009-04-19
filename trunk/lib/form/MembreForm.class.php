<?php

/**
 * Membre form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MembreForm extends BaseMembreForm
{
	/**
	 * Customizes the Member form. There is a lot of fields to unset in order
	 * to re-create them from scratch with custom behaviour, especially the
	 * hidden references (association, granted user id...)
	 *
	 * @since	r7
	 */
	public function configure()
	{
		unset($this['created_at'], 		$this['updated_at']);
		unset($this['enregistre_par'], 	$this['mis_a_jour_par']);
		unset($this['actif'], 			$this['association_id']);
			
		if ($this->getObject()->isNew()) {
			$this->widgetSchema['enregistre_par'] = new sfWidgetFormInputHidden();
			$this->widgetSchema['association_id'] = new sfWidgetFormInputHidden();
			$this->setDefault('enregistre_par', sfContext::getInstance()->getUser()->getAttribute('user_id'));
			$this->setDefault('association_id', sfContext::getInstance()->getUser()->getAttribute('association_id'));
			$this->validatorSchema['association_id'] = new sfValidatorInteger();
			$this->validatorSchema['enregistre_par'] = new sfValidatorInteger();
		}
			
		$this->widgetSchema['mis_a_jour_par'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['actif'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['statut_id']->setOption('criteria', StatutPeer::getCriteriaForEnabled());
		$this->setDefault('mis_a_jour_par', sfContext::getInstance()->getUser()->getAttribute('user_id'));
		$this->setDefault('date_inscription', date('d-m-Y'));
		$this->setDefault('pays', 'FRANCE');
		$this->setDefault('actif', 1);
		
		// Customize Password field
		unset($this->widgetSchema['password']);
		$this->widgetSchema['password'] = new sfWidgetFormInputPassword();
		
		unset($this->validatorSchema['email']);
		unset($this->validatorSchema['website']);
		
		// Set appearance (CSS classes) for each widget
		$this->validatorSchema['email'] = new sfValidatorEmail(array('required' => false));
		$this->validatorSchema['website'] = new sfValidatorUrl(array('required' => false));
		$this->widgetSchema['nom']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['prenom']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['pseudo']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['password']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['statut_id']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['rue']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['cp']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['ville']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['pays']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['website']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['email']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['tel_fixe']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['tel_portable']->setAttribute('class', 'formInputNormal');
		
		$this->validatorSchema['mis_a_jour_par'] = new sfValidatorInteger();
		$this->validatorSchema['actif'] = new sfValidatorBoolean();
	}
}
