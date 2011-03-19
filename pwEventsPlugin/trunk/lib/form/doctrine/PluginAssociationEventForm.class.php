<?php

/**
 * PluginAssociationEvent form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginAssociationEventForm extends BaseAssociationEventForm
{
  public function setup()
  {
    parent::setup();
    $this->useFields(array('id','name','description_public','description_private','address','organized_by','date_begin','time_begin'));

    // only member with validate right can attach activity
    $canAffectActivity = $this->getOption('can_affect_activity',false);

    $this->widgetSchema['description_public'] = new pwWidgetFormTinyMCE();
    $this->widgetSchema['organized_by'] = new pwWidgetFormMemberSelect();
    $this->widgetSchema['date_begin'] = new pwWidgetFormJQueryDatePicker(date('Y'), date('Y')+1,false);

    $this->widgetSchema['time_begin']->setOption('hours',DateTools::rangeOfYears(8,23));
    $this->widgetSchema['time_begin']->setOption('minutes',array(0 => '00',15 => '15',30 => '30',45 => '45'));
    $this->widgetSchema['time_begin']->setOption('can_be_empty',false);
     
    $this->widgetSchema['description_private']->setAttribute('class', 'formInputXtraLarge');
    $this->widgetSchema['address']->setAttribute('class', 'formInputXtraLarge');
    $this->widgetSchema['name']->setAttribute('class', 'formInputXtraLarge');

    if($this->isNew())
    {
      // default date is tomorrow
      $tomorrow = time()+24*60*60;
      $this->setDefault('date_begin',$tomorrow);
    }

    $this->widgetSchema->setLabels(array(
      'name' => 'Titre*',
      'description_public' => 'Description*',
      'description_private' => 'Détails privée',
      'address' => 'Adresse',
      'date_begin' => "Date de l'événement *",
      'time_begin' => 'Heure début *',		
      'organized_by' => 'Organisateur*'
    ));
    $this->widgetSchema->setHelps(array(
      'description_public'  => 'Visible sur le site web, même par les non adhérents',
      'description_private' => 'Visible seulement pour les adhérents ',
      'address'             => "Pour afficher sur une carte, exemple: 15 rue de blagnac, toulouse",
      
    ));
  }
}
