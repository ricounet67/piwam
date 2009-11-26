<?php

/**
 * ConfigCategorie form base class.
 *
 * @method ConfigCategorie getObject() Returns the current form's model object
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseConfigCategorieForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'code'    => new sfWidgetFormInputHidden(),
      'libelle' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'code'    => new sfValidatorPropelChoice(array('model' => 'ConfigCategorie', 'column' => 'code', 'required' => false)),
      'libelle' => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('config_categorie[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ConfigCategorie';
  }


}
