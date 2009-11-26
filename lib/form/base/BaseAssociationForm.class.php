<?php

/**
 * Association form base class.
 *
 * @method Association getObject() Returns the current form's model object
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseAssociationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'nom'               => new sfWidgetFormInputText(),
      'description'       => new sfWidgetFormInputText(),
      'site_web'          => new sfWidgetFormInputText(),
      'enregistre_par'    => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'mis_a_jour_par'    => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'config_value_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'ConfigVariable')),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorPropelChoice(array('model' => 'Association', 'column' => 'id', 'required' => false)),
      'nom'               => new sfValidatorString(array('max_length' => 120)),
      'description'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'site_web'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'enregistre_par'    => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id', 'required' => false)),
      'mis_a_jour_par'    => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id', 'required' => false)),
      'created_at'        => new sfValidatorDateTime(array('required' => false)),
      'updated_at'        => new sfValidatorDateTime(array('required' => false)),
      'config_value_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'ConfigVariable', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('association[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Association';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['config_value_list']))
    {
      $values = array();
      foreach ($this->object->getConfigValues() as $obj)
      {
        $values[] = $obj->getConfigVariableId();
      }

      $this->setDefault('config_value_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveConfigValueList($con);
  }

  public function saveConfigValueList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['config_value_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ConfigValuePeer::ASSOCIATION_ID, $this->object->getPrimaryKey());
    ConfigValuePeer::doDelete($c, $con);

    $values = $this->getValue('config_value_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ConfigValue();
        $obj->setAssociationId($this->object->getPrimaryKey());
        $obj->setConfigVariableId($value);
        $obj->save();
      }
    }
  }

}
