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
    $this->useFields(array('label'));


    if (! $user = $this->getOption('user'))
    {
      throw new InvalidArgumentException('You must provide a myUser object');
    }

    if (! $associationId = $this->getOption('associationId'))
    {
      $associationId = $user->getAssociationId();
    }

    if (! $parentId = $this->getOption('parentId'))
    {
      throw new InvalidArgumentException('You must provide a parent account ID');
    }

    if ($this->getObject()->isNew())
    {
      $this->widgetSchema['created_by'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['association_id'] = new sfWidgetFormInputHidden();
      $this->setDefault('created_by', $user->getUserId());
      $this->setDefault('association_id', $associationId);
      $this->validatorSchema['association_id'] = new sfValidatorInteger();
      $this->validatorSchema['created_by'] = new sfValidatorInteger();
      $this->widgetSchema['parent_id'] = new sfWidgetFormInputHidden();
      $this->validatorSchema['parent_id'] = new sfValidatorInteger();
    }

    $this->setDefault('parent_id', $parentId);
    $this->widgetSchema['label']->setAttribute('class', 'formInputLarge');

    $this->widgetSchema->setLabels(array(
      'label'     => 'Libellé',
    ));
  }
}
