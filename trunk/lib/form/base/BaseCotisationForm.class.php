<?php

/**
 * Cotisation form base class.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseCotisationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'compte_id'          => new sfWidgetFormPropelChoice(array('model' => 'Compte', 'add_empty' => false)),
      'cotisation_type_id' => new sfWidgetFormPropelChoice(array('model' => 'CotisationType', 'add_empty' => false)),
      'membre_id'          => new sfWidgetFormInput(),
      'date'               => new sfWidgetFormDate(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorPropelChoice(array('model' => 'Cotisation', 'column' => 'id', 'required' => false)),
      'compte_id'          => new sfValidatorPropelChoice(array('model' => 'Compte', 'column' => 'id')),
      'cotisation_type_id' => new sfValidatorPropelChoice(array('model' => 'CotisationType', 'column' => 'id')),
      'membre_id'          => new sfValidatorInteger(),
      'date'               => new sfValidatorDate(),
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
