<?php
/**
 * Field with jquery date picker and french translation
 *
 * @package    piwam/lib
 * @subpackage widget
 * @author     Jerome Fouilloy
 * @version    SVN: $Rev$
 */
class pwWidgetFormJQueryDatePicker extends sfWidgetFormJQueryDate
{
  /**
   * @see sfWidgetFormJQueryDate
   * @param integer $yearStart
   * @param integer $yearEnd
   * @param string $mont_format 'name'(default) or 'short_name' or 'number'
   * @param boolean $can_be_empty true or false
   * @param array $attributesHtml
   */
  public function __construct($startYear,$endYear,$can_be_empty = true,$mont_format = 'name', $attributesHtml = array())
  {
   
    sfContext::getInstance()->getConfiguration()->loadHelpers("Asset");
    $options['image'] = image_path('/pwCorePlugin/images/calendar.gif');
    $options['config'] = '{}';
    $options['culture'] = 'fr';
   
    $options['date_widget'] = new sfWidgetFormi18nDate(array(
        'culture' => 'fr',
        'format' => '%day%.%month%.%year%',
        'years'  => DateTools::rangeOfYears($startYear, $endYear),
        'can_be_empty' => $can_be_empty,
        'month_format' => $mont_format,
      ));
    parent::__construct($options, $attributesHtml);
  }
  public function getJavaScripts()
  {
    $array = parent::getJavaScripts();
    $array[] = '/pwCorePlugin/js/jquery-tools/jquery.ui.datepicker-fr.js';
    return $array;
  }
  
}