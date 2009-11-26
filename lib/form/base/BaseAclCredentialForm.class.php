<?php

/**
 * AclCredential form base class.
 *
 * @method AclCredential getObject() Returns the current form's model object
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseAclCredentialForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'membre_id'     => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => false)),
      'acl_action_id' => new sfWidgetFormPropelChoice(array('model' => 'AclAction', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'AclCredential', 'column' => 'id', 'required' => false)),
      'membre_id'     => new sfValidatorPropelChoice(array('model' => 'Membre', 'column' => 'id')),
      'acl_action_id' => new sfValidatorPropelChoice(array('model' => 'AclAction', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('acl_credential[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AclCredential';
  }


}
