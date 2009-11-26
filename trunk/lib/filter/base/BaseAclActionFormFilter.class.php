<?php

/**
 * AclAction filter form base class.
 *
 * @package    piwam
 * @subpackage filter
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseAclActionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'acl_module_id' => new sfWidgetFormPropelChoice(array('model' => 'AclModule', 'add_empty' => true)),
      'libelle'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'code'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'acl_module_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AclModule', 'column' => 'id')),
      'libelle'       => new sfValidatorPass(array('required' => false)),
      'code'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('acl_action_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AclAction';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'acl_module_id' => 'ForeignKey',
      'libelle'       => 'Text',
      'code'          => 'Text',
    );
  }
}
