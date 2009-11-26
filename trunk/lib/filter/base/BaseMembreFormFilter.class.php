<?php

/**
 * Membre filter form base class.
 *
 * @package    piwam
 * @subpackage filter
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseMembreFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'prenom'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pseudo'             => new sfWidgetFormFilterInput(),
      'password'           => new sfWidgetFormFilterInput(),
      'statut_id'          => new sfWidgetFormPropelChoice(array('model' => 'Statut', 'add_empty' => true)),
      'date_inscription'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'exempte_cotisation' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'rue'                => new sfWidgetFormFilterInput(),
      'cp'                 => new sfWidgetFormFilterInput(),
      'ville'              => new sfWidgetFormFilterInput(),
      'pays'               => new sfWidgetFormFilterInput(),
      'picture'            => new sfWidgetFormFilterInput(),
      'email'              => new sfWidgetFormFilterInput(),
      'website'            => new sfWidgetFormFilterInput(),
      'tel_fixe'           => new sfWidgetFormFilterInput(),
      'tel_portable'       => new sfWidgetFormFilterInput(),
      'actif'              => new sfWidgetFormFilterInput(),
      'association_id'     => new sfWidgetFormPropelChoice(array('model' => 'Association', 'add_empty' => true)),
      'enregistre_par'     => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'mis_a_jour_par'     => new sfWidgetFormPropelChoice(array('model' => 'Membre', 'add_empty' => true)),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'nom'                => new sfValidatorPass(array('required' => false)),
      'prenom'             => new sfValidatorPass(array('required' => false)),
      'pseudo'             => new sfValidatorPass(array('required' => false)),
      'password'           => new sfValidatorPass(array('required' => false)),
      'statut_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Statut', 'column' => 'id')),
      'date_inscription'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'exempte_cotisation' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'rue'                => new sfValidatorPass(array('required' => false)),
      'cp'                 => new sfValidatorPass(array('required' => false)),
      'ville'              => new sfValidatorPass(array('required' => false)),
      'pays'               => new sfValidatorPass(array('required' => false)),
      'picture'            => new sfValidatorPass(array('required' => false)),
      'email'              => new sfValidatorPass(array('required' => false)),
      'website'            => new sfValidatorPass(array('required' => false)),
      'tel_fixe'           => new sfValidatorPass(array('required' => false)),
      'tel_portable'       => new sfValidatorPass(array('required' => false)),
      'actif'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'association_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Association', 'column' => 'id')),
      'enregistre_par'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Membre', 'column' => 'id')),
      'mis_a_jour_par'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Membre', 'column' => 'id')),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('membre_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Membre';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'nom'                => 'Text',
      'prenom'             => 'Text',
      'pseudo'             => 'Text',
      'password'           => 'Text',
      'statut_id'          => 'ForeignKey',
      'date_inscription'   => 'Date',
      'exempte_cotisation' => 'Boolean',
      'rue'                => 'Text',
      'cp'                 => 'Text',
      'ville'              => 'Text',
      'pays'               => 'Text',
      'picture'            => 'Text',
      'email'              => 'Text',
      'website'            => 'Text',
      'tel_fixe'           => 'Text',
      'tel_portable'       => 'Text',
      'actif'              => 'Number',
      'association_id'     => 'ForeignKey',
      'enregistre_par'     => 'ForeignKey',
      'mis_a_jour_par'     => 'ForeignKey',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
    );
  }
}
