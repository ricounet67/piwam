<?php

/**
 * Depense form base class.
 *
 * @method Depense getObject() Returns the current form's model object
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseDepenseForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'libelle'        => new sfWidgetFormInputText(),
      'montant'        => new sfWidgetFormInputText(),
      'association_id' => new sfWidgetFormPropelChoice(array('model' => 'Association', 'add_empty' => false)),
      'compte_id'      => new sfWidgetFormPropelChoice(array('model' => 'Compte', 'add_empty' => false)),
      'activite_id'    => new sfWidgetFormPropelChoice(array('model' => 'Activite', 'add_empty' => false)),
      'date'           => new sfWidgetFormDate(),
      'payee'          => new sfWidgetFormInputCheckbox(),
      'enregistre_par' => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => false)),
      'mis_a_jour_par' => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => false)),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'Depense', 'column' => 'id', 'required' => false)),
      'libelle'        => new sfValidatorString(array('max_length' => 255)),
      'montant'        => new sfValidatorNumber(),
      'association_id' => new sfValidatorPropelChoice(array('model' => 'Association', 'column' => 'id')),
      'compte_id'      => new sfValidatorPropelChoice(array('model' => 'Compte', 'column' => 'id')),
      'activite_id'    => new sfValidatorPropelChoice(array('model' => 'Activite', 'column' => 'id')),
      'date'           => new sfValidatorDate(),
      'payee'          => new sfValidatorBoolean(array('required' => false)),
      'enregistre_par' => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id')),
      'mis_a_jour_par' => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id')),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('depense[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Depense';
  }


}
