<?php
/**
 * Represents the search form to search members and filter the list
 * according to some criteria.
 * There is no 'association_id' widget in this form, since this
 * filter will be overriden by action which includes this form.
 *
 * @package     piwam
 * @subpackage  form
 * @since       1.2
 * @author      Adrien Mogenet
 */
class SearchUserForm extends BaseForm
{
  /**
   * Possible options for due_state field
   *
   * @var array
   */
  static public $dueOptions = array(
    'all'     => '-',
    'ok'      => 'À jour',
    'ko'      => 'Pas à jour',
    'month'   => 'Expire dans 1 mois'
  );

  /**
   * Possible options for by_page field
   *
   * @var array
   */
  static public $membersByPage = array(
    'default' => '-',
    '20'      => '20',
    '50'      => '50',
    'all'     => 'Tout',
  );

  /**
   * Set fields to search a member. Be careful, the name of 'magic'
   * field will be changed because by the sfFormExtraPlugin.
   * The new name will be autocomplete_myform['magic']
   *
   * @see lib/vendor/symfony/1.2/lib/form/sfForm#configure()
   */
  public function configure()
  {
    $this->setWidgets(array(
      'due_state'     => new sfWidgetFormChoice(array('choices' => self::$dueOptions)),
      'by_page'       => new sfWidgetFormChoice(array('choices' => self::$membersByPage)),
      'show_disabled' => new sfWidgetFormInputCheckbox(),
      'magic'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'due_state'     => new sfValidatorChoice(array('choices' => self::$dueOptions)),
      'by_page'       => new sfValidatorChoice(array('choices' => self::$membersByPage)),
      'magic'         => new sfValidatorString(array('required' => false)),
    ));
    
    $this->widgetSchema->setLabels(array(
      'magic'         => 'Prénom / Nom',
      'due_state'     => 'Cotisation',
      'by_page'       => 'Membres par page',
      'show_disabled' => 'Inclure membres désactivés'
    ));
    $this->widgetSchema->setNameFormat('search[%s]');
    $this->_setClasses();
  }

  /*
   * Set CSS styles to apply to each field
   */
  private function _setClasses()
  {
  //  $this->widgetSchema['due_state']->setAttribute('class', 'formInputShort');
  //  $this->widgetSchema['by_page']->setAttribute('class', 'formInputShort');
  }
}
?>