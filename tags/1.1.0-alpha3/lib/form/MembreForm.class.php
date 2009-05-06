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
	private $_firstRegistration = false;

	/**
	 * Determines if we are performing the registration of the
	 * first user or not
	 *
	 * @return 	boolean
	 * @since	r33
	 */
	public function isFirstRegistration()
	{
		return $this->_firstRegistration;
	}

	/**
	 * Customizes the Member form. There is a lot of fields to unset in order
	 * to re-create them from scratch with custom behaviour, especially the
	 * hidden references (association, granted user id...)
	 *
	 * r33 : At the beginning of the process we determine if we are registering
	 * 		 the first Membre of a new association or not
	 *
	 * @since	r7
	 */
	public function configure()
	{
		if (sfContext::getInstance()->getUser()->getAttribute('association_id', null, 'temp')) {
			$this->_firstRegistration = true;
		}
		else {
			$this->_firstRegistration = false;
		}

		unset($this['created_at'], 		$this['updated_at']);
		unset($this['enregistre_par'], 	$this['mis_a_jour_par']);
		unset($this['actif'], 			$this['association_id']);

		if ($this->getObject()->isNew()) {

			// If this is the user is not the one who
			// is currently registering a new Association
			if (! $this->_firstRegistration) {
				$this->widgetSchema['enregistre_par'] = new sfWidgetFormInputHidden();
				$this->setDefault('enregistre_par', sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'user'));
				$this->validatorSchema['enregistre_par'] = new sfValidatorInteger(array('required' => false));
			}

			$this->widgetSchema['association_id'] = new sfWidgetFormInputHidden();
			$this->setDefault('association_id', sfContext::getInstance()->getUser()->getAttribute('association_id', null, 'user'));
			$this->validatorSchema['association_id'] = new sfValidatorInteger();

		} // new object
		$this->widgetSchema['mis_a_jour_par'] = new sfWidgetFormInputHidden();
		$this->validatorSchema['mis_a_jour_par'] = new sfValidatorInteger();

		$this->widgetSchema['actif'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['statut_id']->setOption('criteria', StatutPeer::getCriteriaForEnabled());
		$this->setDefault('date_inscription', date('d-m-Y'));
		$this->setDefault('pays', 'FRANCE');
		$this->setDefault('actif', 1);

		// Customize Password field
		unset($this['password']);
		$this->widgetSchema['password'] = new sfWidgetFormInputPassword();

		/*
		 * if this is not the registration of the first user who is
		 * setting up a new Association, password can be empty (and
		 * the user won't be able to log in)
		 * Otherwise, user MUST give a passsword and pseudo
		 */

		if (! $this->_firstRegistration) {
			$this->validatorSchema['password'] = new sfValidatorString(array('required' => false));
			$this->validatorSchema['pseudo'] = new sfValidatorString(array('required' => false));
		}
		else {
			$this->validatorSchema['password'] = new sfValidatorString(array('required' => true));
			$this->validatorSchema['pseudo'] = new sfValidatorString(array('required' => true));
		}

		// New validators for Email and Website fields
		unset($this->validatorSchema['email']);
		unset($this->validatorSchema['website']);
		$this->validatorSchema['email'] = new sfValidatorEmail(array('required' => false));
		$this->validatorSchema['website'] = new sfValidatorUrl(array('required' => false));

		$this->validatorSchema['actif'] = new sfValidatorBoolean();
		$this->widgetSchema['statut_id']->setOption('criteria', StatutPeer::getCriteriaForEnabled());

		unset ($this->widgetSchema['pays']);
		$countries = array('FR', 'BE', 'ES', 'DE', 'NL', 'CH', 'LU');
		$this->widgetSchema['pays'] = new sfWidgetFormI18nSelectCountry(array('culture' => 'fr', 'countries' => $countries));
		$this->setDefault('pays', 'FR');

		unset ($this->widgetSchema['date_inscription']);
		$this->widgetSchema['date_inscription'] = new sfWidgetFormJQueryDate(array(
			'image'		=> '/images/calendar.gif',
  			'config' 	=> '{}',
			'culture'	=> 'fr_FR'
			));

		$this->_setCssClasses();
	}

	/*
	 * Set an appropriate CSS class to each form element
	 */
	private function _setCssClasses()
	{
		$this->widgetSchema['nom']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['prenom']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['pseudo']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['password']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['rue']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['cp']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['ville']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['website']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['email']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['tel_fixe']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['tel_portable']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['statut_id']->setAttribute('class', 'formInputNormal');
		$this->widgetSchema['pays']->setAttribute('class', 'formInputNormal');
	}
}
