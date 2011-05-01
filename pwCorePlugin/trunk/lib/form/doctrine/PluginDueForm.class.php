<?php

/**
 * Due form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginDueForm extends BaseDueForm
{
  /**
   * Customizes the Cotisation form. There is a lot of fields to unset in
   * order to re-create them from scratch with custom behaviour, especially
   * the hidden references (association, granted user id...)
   *
   * @since r9
   */
  public function setup()
  {
    parent::setup();    
    
    unset($this['created_at'], $this['updated_at']);
    unset($this['created_by'], $this['updated_by']);
    unset($this['state'], $this['association_id']);
    unset($this['date']);

    $this->widgetSchema['state'] = new sfWidgetFormInputHidden();
    $this->setDefault('state', 1);

    // select only Members, DueType and Account which
    // belong to the current association

    $id = sfContext::getInstance()->getUser()->getAssociationId();

    if ($this->isActiveMember())
    {
      $this->widgetSchema['member_id'] = new pwWidgetFormMemberSelect();
    }
    else
    {
      unset($this['member_id']);
      $this->widgetSchema['member_id'] = new sfWidgetFormInputHidden();
    }

    $this->widgetSchema['due_type_id']->setOption('query', DueTypeTable::getQueryEnabledForAssociation($id));
    $this->widgetSchema['due_type_id']->setOption('add_empty', true);
    
    $choicesAccounts = AccountTable::getComboChoicesAccounts($id);
    $this->widgetSchema['account_id'] = new sfWidgetFormChoice(array('choices' => $choicesAccounts));

    $accountsId = array_keys($choicesAccounts);
    $this->validatorSchema['account_id'] = new sfValidatorChoice(array('choices' => $accountsId));
    $this->validatorSchema['state'] = new sfValidatorBoolean();
    $this->validatorSchema['amount'] = new sfValidatorAmount(array('min' => 0),
                                                             array('min' => 'ne peut être négatif'));

   // sfContext::getInstance()->getConfiguration()->loadHelpers("Asset");
    $year = date('Y');
    $this->widgetSchema['date'] = new pwWidgetFormJQueryDatePicker($year-1,$year+2);

    $this->setDefault('date', date('y-m-d'));
    $this->validatorSchema['date'] = new sfValidatorDate();

    $this->setLabels();
    $this->setClasses();
  }

  /**
   * Check if the member related to the Due is still active or not. Returns
   * false if form is displayed to create a new Due entry
   *
   * @return  boolean
   */
  public function isActiveMember()
  {
    if (! $this->getObject()->isNew())
    {
      $state = $this->getObject()->getMember()->getState();

      if ($state == MemberTable::STATE_ENABLED)
      {
        return true;
      }
    }
    else
    {
      return true;
    }

    return false;
  }

  /**
   * Set field labels
   */
  protected function setLabels()
  {
    $this->widgetSchema->setLabels(array(
      'account_id'    => 'Compte bénéficiaire',
      'due_type_id'   => 'Type de cotisation',
      'amount'        => 'Montant',
      'member_id'     => 'Membre',
      'date'          => 'Date de versement',
    ));
  }

  /**
   * Set CSS classes for each field
   */
  protected function setClasses()
  {
 //   $this->widgetSchema['account_id']->setAttribute('class', 'formInputLarge');
    $this->widgetSchema['due_type_id']->setAttribute('class', 'formInputLarge');
    $this->widgetSchema['member_id']->setAttribute('class', 'formInputLarge');
    $this->widgetSchema['amount']->setAttribute('class', 'formInputShort');
  }
}
