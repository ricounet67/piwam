<?php
/**
 * Provide some widget to filter members list
 *
 * @package     piwam
 * @subpackage  form
 * @since       1.2
 * @author      Adrien Mogenet
 */
class FilterUserForm extends sfForm
{
  /**
   * Possible options for due_state field
   * 
   * @var array
   */
  static public $dueOptions = array(
    'ok'          => 'À jour',
    'ko'          => 'Pas à jour',
    'month'       => 'Expire ce mois ci'
  );

  /**
   * Possible options for by_page field
   * 
   * @var array
   */
  static public $membersByPage = array(
    'all'         => 'Tout',
    '20'          => '20',
    'default'     => 'Par défaut',
  );

  /**
   * Configure the form's widgets to filter list of members to display
   */
  public function configure()
  {
    $this->setWidgets(array(
      'due_state' => new sfWidgetFormChoice(array('choices' => self::$dueOptions)),
      'by_page'   => new sfWidgetFormChoice(array('choices' => self::$membersByPage)),
    ));

    $this->setValidators(array(
      'due_state' => new sfValidatorChoice(array('choices' => self::$dueOptions)),
      'by_page'   => new sfValidatorChoice(array('choices' => self::$membersByPage)),
    ));

    $this->widgetSchema->setLabels(array(
      'due_state' => 'Cotisation',
      'by_page'   => 'Membres par page',
    ));

    $this->widgetSchema['due_state']->setAttribute('class', 'formInputShort');
    $this->widgetSchema['by_page']->setAttribute('class', 'formInputShort');
  }
}
?>
