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

    $credit_forms = new sfForm();

    //we only need the form container for embedding form via ajax,
    if (false === sfContext::getInstance()->getRequest()->isXmlHttpRequest())
    {
      $credits = $this->getObject()->getCredits();

      // If no credits, we add one input by default
      if (count($credits) == 0)
      {
        $credit = new Credit();
        $credit->setEntry($this->getObject());
        $credits[] = $credit;
      }

      foreach ($credits as $key => $c)
      {
        $creditForm = new CreditForm($c);
        $credit_forms->embedForm('credit_' . ($key + 1), $creditForm);
        $credit_forms->widgetSchema['credit_' . ($key + 1)]->setLabel('Crédit #' . ($key + 1));
      }
    }
    
    $this->embedForm('credits', $credit_forms);
    $this->setLabels();
  }

  /**
   * Called from bookkeeping/addCreditForm action, which is called by
   * ajax call from the newEntry template.
   * A new CreditForm is embeding into the embedded forms of the current
   * EntryForm.
   * 
   * @param   string  $key : The name of new form, eg: credit_42
   */
  public function addCreditForm($key)
  {
    $credit = new Credit();
    $credit->setEntry($this->getObject());
    $this->embeddedForms['credits']->embedForm($key, new CreditForm($credit));
    $this->embedForm('credits', $this->embeddedForms['credits']);
  }

  /**
   * Required overriding to manage embedded credits and debits forms
   */
  public function bind($taintedValues = null, $taintedFiles = null)
  {
    foreach ($taintedValues['credits'] as $key => $form)
    {
       if (false === $this->embeddedForms['credits']->offsetExists($key))
       {
    	   $this->addCreditForm($key);
       }
    }
    
    parent::bind($taintedValues, $taintedFiles);
  }

  /**
   * Set labels of the form's widgets
   */
  protected function setLabels()
  {
    $this->widgetSchema->setLabels(array(
      'date'    => 'Date',
      'label'   => 'Libellé',
      'credits' => 'Crédits',
    ));
  }
}
