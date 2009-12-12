<?php
/**
 * Represents the search form to search members and filter the list
 * according to some criteria
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
    'all'         => '',
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
    'default'     => 'Par défaut',
    '20'          => '20 membres par page',
    'all'         => 'Tout afficher',
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
      'associationId' => new sfWidgetFormInputHidden(),
      'magic'         => new sfWidgetFormJQueryAutocompleter(array(
                        'url'    => $this->getOption('ajaxUrl'),
                        'config' => '{ extraParams: { association_id: function() { return jQuery("#search_associationId").val(); } },
                                       scrollHeight: 250 ,
                                       autoFill: true
                                     }')),
    ));


    $this->setValidators(array(
      'due_state'     => new sfValidatorChoice(array('choices' => self::$dueOptions)),
      'by_page'       => new sfValidatorChoice(array('choices' => self::$membersByPage)),
      'magic'         => new sfValidatorString(array('required' => true)),
      'associationId' => new sfValidatorInteger(array('required' => true)),
    ));
    
    $this->widgetSchema->setLabels(array(
      'due_state'     => 'Cotisation',
      'by_page'       => 'Membres par page',
    ));

    $this->setDefault('associationId', $this->getOption('associationId'));
    $this->widgetSchema->setNameFormat('search[%s]');
  }
}
?>