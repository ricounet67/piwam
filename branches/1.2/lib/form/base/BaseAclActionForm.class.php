<?php

/**
 * AclAction form base class.
 *
 * @method AclAction getObject() Returns the current form's model object
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseAclActionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'acl_module_id' => new sfWidgetFormPropelChoice(array('model' => 'AclModule', 'add_empty' => false)),
      'libelle'       => new sfWidgetFormInputText(),
      'code'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'AclAction', 'column' => 'id', 'required' => false)),
      'acl_module_id' => new sfValidatorPropelChoice(array('model' => 'AclModule', 'column' => 'id')),
      'libelle'       => new sfValidatorString(array('max_length' => 255)),
      'code'          => new sfValidatorString(array('max_length' => 100)),
    ));

    $this->widgetSchema->setNameFormat('acl_action[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AclAction';
  }


}
