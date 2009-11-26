<?php

/**
 * ConfigVariable filter form base class.
 *
 * @package    piwam
 * @subpackage filter
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseConfigVariableFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'code'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'categorie_code'    => new sfWidgetFormPropelChoice(array('model' => 'ConfigCategorie', 'add_empty' => true)),
      'libelle'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'       => new sfWidgetFormFilterInput(),
      'type'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'default_value'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'config_value_list' => new sfWidgetFormPropelChoice(array('model' => 'Association', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'code'              => new sfValidatorPass(array('required' => false)),
      'categorie_code'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'ConfigCategorie', 'column' => 'code')),
      'libelle'           => new sfValidatorPass(array('required' => false)),
      'description'       => new sfValidatorPass(array('required' => false)),
      'type'              => new sfValidatorPass(array('required' => false)),
      'default_value'     => new sfValidatorPass(array('required' => false)),
      'config_value_list' => new sfValidatorPropelChoice(array('model' => 'Association', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('config_variable_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addConfigValueListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(ConfigValuePeer::CONFIG_VARIABLE_ID, ConfigVariablePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ConfigValuePeer::ASSOCIATION_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ConfigValuePeer::ASSOCIATION_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'ConfigVariable';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'code'              => 'Text',
      'categorie_code'    => 'ForeignKey',
      'libelle'           => 'Text',
      'description'       => 'Text',
      'type'              => 'Text',
      'default_value'     => 'Text',
      'config_value_list' => 'ManyKey',
    );
  }
}
