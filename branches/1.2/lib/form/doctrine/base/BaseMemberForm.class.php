<?php

/**
 * Member form base class.
 *
 * @method Member getObject() Returns the current form's model object
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseMemberForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'lastname'          => new sfWidgetFormInputText(),
      'firstname'         => new sfWidgetFormInputText(),
      'username'          => new sfWidgetFormInputText(),
      'password'          => new sfWidgetFormInputText(),
      'status_id'         => new sfWidgetFormInputText(),
      'subscription_date' => new sfWidgetFormDate(),
      'due_exempt'        => new sfWidgetFormInputText(),
      'street'            => new sfWidgetFormInputText(),
      'zipcode'           => new sfWidgetFormInputText(),
      'city'              => new sfWidgetFormInputText(),
      'country'           => new sfWidgetFormInputText(),
      'picture'           => new sfWidgetFormInputText(),
      'email'             => new sfWidgetFormInputText(),
      'website'           => new sfWidgetFormInputText(),
      'phone_home'        => new sfWidgetFormInputText(),
      'phone_mobile'      => new sfWidgetFormInputText(),
      'state'             => new sfWidgetFormInputText(),
      'association_id'    => new sfWidgetFormInputText(),
      'created_by'        => new sfWidgetFormInputText(),
      'updated_by'        => new sfWidgetFormInputText(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'lastname'          => new sfValidatorString(array('max_length' => 255)),
      'firstname'         => new sfValidatorString(array('max_length' => 255)),
      'username'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'password'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'status_id'         => new sfValidatorInteger(),
      'subscription_date' => new sfValidatorDate(),
      'due_exempt'        => new sfValidatorInteger(),
      'street'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'zipcode'           => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'city'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'country'           => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'picture'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'website'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone_home'        => new sfValidatorString(array('max_length' => 16, 'required' => false)),
      'phone_mobile'      => new sfValidatorString(array('max_length' => 16, 'required' => false)),
      'state'             => new sfValidatorInteger(array('required' => false)),
      'association_id'    => new sfValidatorInteger(),
      'created_by'        => new sfValidatorInteger(array('required' => false)),
      'updated_by'        => new sfValidatorInteger(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('member[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Member';
  }

}
