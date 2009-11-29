<?php
/**
 * Expense form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ExpenseForm extends BaseExpenseForm
{
  /**
   * Customizes the Recette form. There is a lot of fields to unset in order
   * to re-create them from scratch with custom behaviour, especially the
   * hidden references (association, granted user id...)
   */
  public function configure()
  {
    unset($this['created_at'], $this['updated_at']);
    unset($this['created_by'], $this['updated_by']);
    unset($this['state'], $this['association_id']);

    if ($this->getObject()->isNew())
    {
      $this->widgetSchema['created_by'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['association_id'] = new sfWidgetFormInputHidden();
      $this->setDefault('created_by', sfContext::getInstance()->getUser()->getUserId());
      $this->setDefault('association_id', sfContext::getInstance()->getUser()->getAssociationId());
      $this->validatorSchema['association_id'] = new sfValidatorInteger();
      $this->validatorSchema['created_by'] = new sfValidatorInteger();
    }

    $this->widgetSchema['updated_by'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['state'] = new sfWidgetFormInputHidden();
    $this->setDefault('state', 1);

    $this->validatorSchema['updated_by'] = new sfValidatorInteger();
    $this->validatorSchema['state'] = new sfValidatorBoolean();
    $this->validatorSchema['amount'] = new sfValidatorAmount(array('min' => 0), array('min' => 'ne peut être négatif'));

    // select only Membre, CotisationType and account which
    // belong to the association id

    $id = sfContext::getInstance()->getUser()->getAssociationId();
    $this->widgetSchema['account_id']->setOption('query', AccountTable::getQueryEnabledForAssociation($id));
    $this->widgetSchema['activity_id']->setOption('query', ActivityTable::getQueryEnabledForAssociation($id));

    // r19 : customize the appearance
    $this->widgetSchema['label']->setAttribute('class', 'formInputLarge');
    $this->widgetSchema['amount']->setAttribute('class', 'formInputShort');

    sfContext::getInstance()->getConfiguration()->loadHelpers("Asset");
    $this->widgetSchema['date'] = new sfWidgetFormJQueryDate(array(
      'image'   => image_path('calendar.gif'),
      'config'  => '{}',
      'culture' => 'fr_FR',
      'format'  => '%day%.%month%.%year%',
    ));

    $this->setDefault('date', date('y-m-d'));
    $this->widgetSchema['account_id']->setAttribute('class', 'formInputLarge');
    $this->widgetSchema['activity_id']->setAttribute('class', 'formInputLarge');
  }
}
