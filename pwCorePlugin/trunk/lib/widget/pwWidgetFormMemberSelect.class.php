<?php
/**
 * Field with autocompleter for member of association
 *
 * @package    piwam/lib
 * @subpackage widget
 * @author     Jerome Fouilloy
 * @version    SVN: $Rev$
 */
class pwWidgetFormMemberSelect extends sfWidgetFormJQueryAutocompleter
{
  /**
   * @see sfWidgetFormJQueryAutocompleter
   */
  public function __construct($options = array(), $attributes = array())
  {
    $options['value_callback'] = array($this, 'valueCallback');
		$options['url'] = sfContext::getInstance()->getController()->genUrl('@ajax_search_members');
    $options['config'] = '{ width: 260, scrollHeight: 250 ,autoFill: true, minChars: 2 }';
    $attributes['style'] = 'width: 260px';

    parent::__construct($options, $attributes);
  }
    
   /**
   * Returns the text representation of a foreign key.
   *
   * @param string $value The primary key
   */
  protected function valueCallback($value)
  {
  	if($value == '')
  		return '';
  	return MemberTable::getNameForMemberId(intval($value));

  }
  
}