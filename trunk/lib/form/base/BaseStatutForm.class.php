<?php

/**
 * Statut form base class.
 *
 * @method Statut getObject() Returns the current form's model object
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseStatutForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'nom'            => new sfWidgetFormInputText(),
      'association_id' => new sfWidgetFormPropelChoice(array('model' => 'Association', 'add_empty' => false)),
      'actif'          => new sfWidgetFormInputCheckbox(),
      'enregistre_par' => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'mis_a_jour_par' => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'Statut', 'column' => 'id', 'required' => false)),
      'nom'            => new sfValidatorString(array('max_length' => 255)),
      'association_id' => new sfValidatorPropelChoice(array('model' => 'Association', 'column' => 'id')),
      'actif'          => new sfValidatorBoolean(array('required' => false)),
      'enregistre_par' => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id', 'required' => false)),
      'mis_a_jour_par' => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id', 'required' => false)),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('statut[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Statut';
  }


}
