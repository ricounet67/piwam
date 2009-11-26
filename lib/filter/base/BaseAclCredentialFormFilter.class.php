<?php

/**
 * AclCredential filter form base class.
 *
 * @package    piwam
 * @subpackage filter
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseAclCredentialFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'membre_id'     => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'acl_action_id' => new sfWidgetFormPropelChoice(array('model' => 'AclAction', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'membre_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Membre', 'column' => 'id')),
      'acl_action_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AclAction', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('acl_credential_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AclCredential';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'membre_id'     => 'ForeignKey',
      'acl_action_id' => 'ForeignKey',
    );
  }
}
