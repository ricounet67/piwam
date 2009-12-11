<?php
/**
 * Debt form. We will discover how to use an existing form,
 * and how to extend it.
 *
 * @package    pwSandboxPlugin
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DebtForm extends PluginDebtForm
{
  /**
   * This is the generic method to set up forms in symfony
   * It will be called automatically when creating a new DebForm()
   */
  public function configure()
  {
    /*
     * We can specify explicitely which fields we want to use.
     * That also defines the order fields will appear.
     *
     * If useFields() is not called, all fields will be used
     * by default, as described in you schema.yml
     */
    $this->useFields(array('member_id'));

    /*
     * Now, we want to include the existing Income form. There are
     * two different ways : we can merge the forms together or embed
     * an existing form into this DebtForm.
     *
     * Here we are merging forms :
     */
    $this->mergeForm(new IncomeForm());

    /*
     * The merged IncomeForm provides a checkbox which is
     * called 'received'.
     * Here, we want to uncheck it by default :
     */
    $this->setDefault('received', false);

    /*
     * But if we wanted to embed the IncomeForm instead of merging
     * two forms, we would write :
     * 
     *    $this->embedForm('income', new IncomeForm());
     *    $this->getEmbeddedForm('income')->setDefault('received', false);
     *
     * The last line uncheck the 'received' checkbox
     */


    /*
     * Finally, this is preferable to set labels of each field (at least
     * to display it in French ;-)
     *
     * You just have to set labels of your own fields, since fields
     * of IncomeForm have been directly set in IncomeForm class.
     */
    $this->widgetSchema->setLabels(array(
      // 'field'  => 'Displayed name',
      'member_id' => 'Membre concerné',
    ));
  }
}
