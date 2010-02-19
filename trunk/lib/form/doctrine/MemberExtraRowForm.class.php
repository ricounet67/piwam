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
   * Define possible types of customizable rows
   *
   * @var array
   */
  var $types = array(
    'string'    => 'Chaine de caractères',
    'number'    => 'Nombre entier',
    'float'     => 'Nombre décimal',
    'choices'   => 'Liste de choix',
    'boolean'   => 'Case à cocher',
  );

  /**
   * Customize form widgets
   */
  public function configure()
  {
    $a = $this->types;
    $this->widgetSchema['type'] = new sfWidgetFormChoice(array('choices' => $a));
    $this->setLabels();
  }

  /*
   * Set widget labels
   */
  private function setLabels()
  {
    $this->widgetSchema->setLabels(array(
      'label'           => 'Nom du champ',
      'default_value'   => 'Valeur par défaut'
    ));
  }
}
