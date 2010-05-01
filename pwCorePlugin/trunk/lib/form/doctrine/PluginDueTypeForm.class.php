<?php

/**
 * DueType form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginDueTypeForm extends BaseDueTypeForm
{
  public function setup()
  {
    parent::setup();    

    $context = $this->getOption('context');
    unset($this['created_at'], $this['updated_at']);
    unset($this['created_by'], $this['updated_by']);
    unset($this['state'], $this['association_id']);
    unset($this['start_period'],$this['end_period']);

    if ($this->getObject()->isNew())
    {
      $this->widgetSchema['created_by'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['association_id'] = new sfWidgetFormInputHidden();
      $this->validatorSchema['association_id'] = new sfValidatorInteger();
      $this->validatorSchema['created_by'] = new sfValidatorInteger();
    }
    else
    {
      $this->widgetSchema['updated_by'] = new sfWidgetFormInputHidden();
      $this->validatorSchema['updated_by'] = new sfValidatorInteger();
    }

    $this->widgetSchema['state'] = new sfWidgetFormInputHidden();
    $this->setDefault('state', 1);
    $this->validatorSchema['state'] = new sfValidatorBoolean();

    $this->setDefault('valide', 12);
    $this->widgetSchema['amount']->setAttribute('class', 'formInputShort');
    $this->widgetSchema['period']->setAttribute('class', 'formInputShort');
    $this->widgetSchema['label']->setAttribute('class', 'formInputLarge');

    $context->getConfiguration()->loadHelpers("Asset");
    $this->widgetSchema['start_period'] = new sfWidgetFormJQueryDate(array(
    'image'       => image_path('/pwCorePlugin/images/calendar.gif'),
    'config'      => '{}',
    'culture'     => 'fr_FR',
    'date_widget' => new sfWidgetFormDate(array(
      'format' => '%day%.%month%.%year%',
      'years'  => DateTools::rangeOfYears(date('Y'), 1900)
      )),
    ));
    $this->widgetSchema['end_period'] = new sfWidgetFormJQueryDate(array(
    'image'       => image_path('/pwCorePlugin/images/calendar.gif'),
    'config'      => '{}',
    'culture'     => 'fr_FR',
    'date_widget' => new sfWidgetFormDate(array(
      'format' => '%day%.%month%.%year%',
      'years'  => DateTools::rangeOfYears(date('Y'), 1900)
      )),
    ));

    $this->validatorSchema['amount'] = new sfValidatorNumber(array('min' => 0), array('min' => 'ne peut être négatif'));
    $this->validatorSchema['period'] = new sfValidatorInteger(array('min' => 0, 'required' => false), array('min' => 'ne peut être négatif'));
    $this->validatorSchema['start_period'] = new sfValidatorDate(array('required' => false));
    $this->validatorSchema['end_period'] = new sfValidatorDate(array('required' => false));
    $this->setLabels();
  }

  /**
   * Set labels for each widgets
   */
  protected function setLabels()
  {
    $this->widgetSchema->setLabels(array(
      'amount'        => 'Montant',
      'period'        => 'Valide',
      'label'         => 'Libellé',
      'start_period'  => 'Début de la période',
      'end_period'    => 'Fin de la période',
    ));
  }
}
