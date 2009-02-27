<?php

/**
 * Membre form base class.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseMembreForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'nom'             => new sfWidgetFormInput(),
      'prenom'          => new sfWidgetFormInput(),
      'pseudo'          => new sfWidgetFormInput(),
      'password'        => new sfWidgetFormInput(),
      'statut_id'       => new sfWidgetFormPropelChoice(array('model' => 'Statut', 'add_empty' => false)),
      'dateinscription' => new sfWidgetFormDate(),
      'exemptecotis'    => new sfWidgetFormInputCheckbox(),
      'rue'             => new sfWidgetFormInput(),
      'cp'              => new sfWidgetFormInput(),
      'ville'           => new sfWidgetFormInput(),
      'pays'            => new sfWidgetFormInput(),
      'email'           => new sfWidgetFormInput(),
      'website'         => new sfWidgetFormInput(),
      'telfixe'         => new sfWidgetFormInput(),
      'telportable'     => new sfWidgetFormInput(),
      'actif'           => new sfWidgetFormInputCheckbox(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id', 'required' => false)),
      'nom'             => new sfValidatorString(array('max_length' => 255)),
      'prenom'          => new sfValidatorString(array('max_length' => 255)),
      'pseudo'          => new sfValidatorString(array('max_length' => 255)),
      'password'        => new sfValidatorString(array('max_length' => 255)),
      'statut_id'       => new sfValidatorPropelChoice(array('model' => 'Statut', 'column' => 'id')),
      'dateinscription' => new sfValidatorDate(),
      'exemptecotis'    => new sfValidatorBoolean(),
      'rue'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cp'              => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'ville'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'pays'            => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'email'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'website'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'telfixe'         => new sfValidatorString(array('max_length' => 16, 'required' => false)),
      'telportable'     => new sfValidatorString(array('max_length' => 16, 'required' => false)),
      'actif'           => new sfValidatorBoolean(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('membre[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Membre';
  }


}
