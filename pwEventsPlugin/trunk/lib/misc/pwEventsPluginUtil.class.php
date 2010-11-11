<?php
/**
 * Class stores all constants used in plugin
 * @author Jerome Fouilloy
 *
 */
class pwEventsPluginUtil
{
  /** can see private fields for events */
  const RIGHT_SEE_PRIVATE_FIELDS = 'event_see_private_fields';
  
  /** can edit and validate events, receive email for each new event created */
  const RIGHT_EDIT_AND_VALIDATE_EVENT = 'event_edit_validate';
  
  /** can create new event */
  const RIGHT_CREATE_EVENT = 'event_create';
  
  /** can add subscription and manage carpooling on events validated */
  const RIGHT_MANAGE_EVENT= 'event_manage';

  /*
   * EMAIL KEY
   */
  
  const EMAIL_EVENT_CREATED = 'event_created';
  
  const EMAIL_EVENTS_AUTOMATIC_MAILING = 'events_automatic_mailing';
  
  /*
   * CONFIG PLUGIN
   */
  const CONFIG_AUTOMATIC_MAILING = 'event_automatic_mailing';
  
  const IMAGES_PATH = '/pwEventsPlugin/images/';

  public static function  getImagePath($image)
  {
    return image_path(self::IMAGES_PATH . $image);
  }
  /**
   * Extract automatic mailing delay from Piwam configuration
   * @param $asso_id
   * @return string delay on format X_Y with x is number of Y period, now return no|1_month|2week
   */
  public static function getAutomaticMailingDelay($asso_id)
  {
    $returnval = 'no';
    $textPeriod = Configurator::get(self::CONFIG_AUTOMATIC_MAILING,$asso_id,null);
    if($textPeriod == 'Chaque mois')
    {
      $returnval = '1_month';
    }
    else if($textPeriod == 'Tous les 2 semaines')
    {
      $returnval = '2_week';
    }
    else{
      
    }
    return $returnval;
  }
}