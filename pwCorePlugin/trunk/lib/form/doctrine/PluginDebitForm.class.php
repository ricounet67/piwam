<?php

/**
 * PluginDebit form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginDebitForm extends BaseDebitForm
{
  /**
   * Configure form widgets
   */
  public function setup()
  {
    parent::setup();
    $this->useFields(array('amount', 'debited_account', 'label'));
    $this->setLabels();
  }

  /**
   * Set forms widget labels
   */
  protected function setLabels()
  {
    $this->widgetSchema->setLabels(array(
      'amount'          => 'Montant',
      'label'           => 'Libellé',
      'debited_account' => 'Compte débité'
    ));
  }
}
