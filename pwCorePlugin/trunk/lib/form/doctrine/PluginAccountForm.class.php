<?php
/**
 * Account form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginAccountForm extends BaseAccountForm
{
  /**
   * Configure form widgets. Only the 'label' widget is displayed in any ways.
   */
  public function setup()
  {
    parent::setup();
    $this->useFields(array('code', 'label'));

    if (! $user = $this->getOption('user'))
    {
      throw new InvalidArgumentException('You must provide a myUser object');
    }

    if (! $associationId = $this->getOption('associationId'))
    {
      $associationId = $user->getAssociationId();
    }

    if ($this->getObject()->isNew())
    {
      $this->widgetSchema['created_by'] = new sfWidgetFormInputHidden();
      $this->setDefault('created_by', $user->getUserId());
      $this->validatorSchema['created_by'] = new sfValidatorInteger();
      $this->widgetSchema['parent_id'] = new sfWidgetFormInputHidden();
      $this->validatorSchema['parent_id'] = new sfValidatorInteger();
    }

    // We always need association_id because a check is performed on this field
    $this->widgetSchema['association_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('association_id', $associationId);
    $this->validatorSchema['association_id'] = new sfValidatorInteger();

    $this->validatorSchema->setPostValidator(new sfValidatorDoctrineUnique(array('model' => 'Account', 'column' => array('code', 'association_id')), array('invalid' => 'Ce code existe déjà')));
    $this->validatorSchema['code'] = new sfValidatorInteger(
      array(),
      array('invalid' => '"%value%" n\'est pas un nombre')
    );

    $this->widgetSchema['label']->setAttribute('class', 'formInputLarge');
    $this->widgetSchema->setLabels(array(
      'code'  => 'Nomenclature',
      'label' => 'Libellé',
    ));
  }
}
