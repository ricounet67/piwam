<?php

/**
 * PluginEntry form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginEntryForm extends BaseEntryForm
{
  /**
   * Setup form widgets and behaviour
   */
  public function setup()
  {
    parent::setup();
    $this->useFields(array('date', 'label'));

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
      $this->widgetSchema['association_id'] = new sfWidgetFormInputHidden();
      $this->setDefault('created_by', $user->getUserId());
      $this->setDefault('association_id', $associationId);
      $this->validatorSchema['association_id'] = new sfValidatorInteger();
      $this->validatorSchema['created_by'] = new sfValidatorInteger();
    }

    $this->widgetSchema['updated_by'] = new sfWidgetFormInputHidden();
    $this->setDefault('updated_by', $user->getUserId());
    $this->validatorSchema['updated_by'] = new sfValidatorInteger();

    $this->object['Debits'][] = new Debit();
    foreach ($this->object['Debits'] as $key => $debit)
    {
      $this->embedForm('debit' . $index, new DebitForm());
    }

    $this->object['Credits'][] = new Credit();
    foreach ($this->object['Credits'] as $key => $credit)
    {
      $creditForm = new CreditForm();
      $fieldName = 'credit_' . $credit->getId();
      $this->embedForm($fieldName, $creditForm);

      // Last item ?
      if (count($this->object['Credits']) -1 == $key)
      {
        $label = 'Crédit <input type="submit" name="submit" value="+">';
      }

      $this->widgetSchema->setLabel($fieldName, $label);
    }

    $this->setLabels();
  }

  /**
   * Set labels of the form's widgets
   */
  public function setLabels()
  {
    $this->widgetSchema->setLabels(array(
      'date'    => 'Date',
      'label'   => 'Libellé'
    ));
  }
}
