<?php

/**
 * PluginCredit form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginCreditForm extends BaseCreditForm
{
  /**
   * Configure form widgets
   */
  public function setup()
  {
    parent::setup();
    $this->useFields(array('amount', 'credited_account', 'label'));
    $this->setLabels();
  }

  /**
   * Set forms widget labels
   */
  protected function setLabels()
  {
    $this->widgetSchema->setLabels(array(
      'amount'           => 'Montant',
      'label'            => 'Libellé',
      'credited_account' => 'Compte crédité'
    ));
  }
}
