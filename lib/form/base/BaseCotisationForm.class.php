<?php

/**
 * Cotisation form base class.
 *
 * @method Cotisation getObject() Returns the current form's model object
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseCotisationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'compte_id'          => new sfWidgetFormPropelChoice(array('model' => 'Compte', 'add_empty' => false)),
      'cotisation_type_id' => new sfWidgetFormPropelChoice(array('model' => 'CotisationType', 'add_empty' => false)),
      'membre_id'          => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => false)),
      'date'               => new sfWidgetFormDate(),
      'enregistre_par'     => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => false)),
      'montant'            => new sfWidgetFormInputText(),
      'mis_a_jour_par'     => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorPropelChoice(array('model' => 'Cotisation', 'column' => 'id', 'required' => false)),
      'compte_id'          => new sfValidatorPropelChoice(array('model' => 'Compte', 'column' => 'id')),
      'cotisation_type_id' => new sfValidatorPropelChoice(array('model' => 'CotisationType', 'column' => 'id')),
      'membre_id'          => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id')),
      'date'               => new sfValidatorDate(),
      'enregistre_par'     => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id')),
      'montant'            => new sfValidatorNumber(),
      'mis_a_jour_par'     => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id', 'required' => false)),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cotisation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cotisation';
  }


}
