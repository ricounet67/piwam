<?php
/**
 * Field with tiny MCE editor
 *
 * @package    piwam/lib
 * @subpackage widget
 * @author     Jerome Fouilloy
 * @version    SVN: $Rev$
 */
class pwWidgetFormTinyMCE extends sfWidgetFormTextareaTinyMCE
{
  private $hasMediaBrowserPlugin = false;
  /**
   * @see sfWidgetFormJQueryAutocompleter
   */
  public function __construct($options = array(), $attributes = array())
  {
    $plugins = sfContext::getInstance()->getConfiguration()->getPlugins();
    //	$this->hasMediaBrowserPlugin = array_key_exists('sfMediaBrowserPlugin', $plugins);
    $def_options = array();
    $def_options['width']  = 450;
    $def_options['height'] = 250;
    $def_options['config'] = 'theme_advanced_buttons1 : "bold,italic,underline,fontsizeselect,fontselect,forecolorpicker,image,link,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,indent,outdent",
      theme_advanced_buttons2 : "",
      theme_advanced_buttons3 : "",
      theme_advanced_statusbar_location : "none",
      language: "fr"';
    if($this->hasMediaBrowserPlugin)
    {
      $def_options['config'] .= ',file_browser_callback: "sfMediaBrowserWindowManager.tinymceCallback"';
    }
    $def_attributes = array();
    $def_attributes['rows'] = 40;
    $def_attributes['cols'] = 10;
    
    parent::__construct(array_merge($def_options,$options), array_merge($def_attributes,$attributes));
  }
  /**
   * Add tiny mce javascripts for forms and french translation
   * 
   * @see lib/vendor/symfony-1.3.5/lib/widget/sfWidget#getJavaScripts()
   */
  public function getJavaScripts()
  {
    $array = parent::getJavaScripts();
    $array[] = '/pwCorePlugin/js/tiny_mce/tiny_mce.js';
    if($this->hasMediaBrowserPlugin)
    {
      $array[] = '/sfMediaBrowserPlugin/js/WindowManager.js';
    }
    return $array;
  }

}