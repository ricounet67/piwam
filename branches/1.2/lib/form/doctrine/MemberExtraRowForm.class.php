<?php
/**
 * MemberExtraRow form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MemberExtraRowForm extends BaseMemberExtraRowForm
{
  /**
   * Define possible types of customizable rows. Labels and help for the
   * 'Parameters' field are customized in the _form template
   *
   * @var array
   */
  var $types = array(
    ''          => 'Choisissez...',
    'string'    => 'Chaine de caractères',
    'number'    => 'Nombre entier',
    'date'      => 'Date',
    'choices'   => 'Liste de choix',
    'text'      => 'Zone de texte',
    'boolean'   => 'Case à cocher',
  );

  /**
   * Customize form widgets. Defines an additionnal widget `parameters` which
   * won't be stored in database directly but defines parameters for the type
   * (ie: size of a string, list of choices...)
   */
  public function configure()
  {
    $this->useFields(array(
      'label',
      'description',
      'required',
      'default_value',
      'parameters'),
      true);
    
    $types = $this->types;
    $this->widgetSchema['association_id'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['association_id'] = new sfValidatorInteger();
    $this->widgetSchema['type'] = new sfWidgetFormChoice(
      array('choices'  => $types),
      array('onchange' => 'ShowParameters(this.value)')
    );
    $this->validatorSchema['parameters'] = new sfValidatorString(array('required' => false));
    $this->validatorSchema['default_value'] = new sfValidatorString(array('required' => false));
    $this->validatorSchema['type'] = new sfValidatorChoice(array('choices' => array_keys($types)));
    $this->setLabels();
    $this->setStyles();
  }

  /*
   * Set widget labels
   */
  private function setLabels()
  {
    $this->widgetSchema->setLabels(array(
      'label'           => 'Nom du champ',
      'default_value'   => 'Valeur par défaut',
      'required'        => 'Obligatoire'
    ));
  }

  /*
   * Set CSS styles to form widgets
   */
  private function setStyles()
  {
    $this->widgetSchema['label']->setAttribute('class', 'formInputNormal');
    $this->widgetSchema['type']->setAttribute('class', 'formInputNormal');
    $this->widgetSchema['default_value']->setAttribute('class', 'formInputNormal');
    $this->widgetSchema['parameters']->setAttribute('class', 'formInputNormal');
  }
}
