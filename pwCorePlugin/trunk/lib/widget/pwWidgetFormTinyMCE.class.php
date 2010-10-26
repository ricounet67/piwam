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

    $options['width']  = 450;
    $options['height'] = 250;
    $options['config'] = 'theme_advanced_buttons1 : "bold,italic,underline,fontsizeselect,fontselect,forecolorpicker,image,link,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,indent,outdent",
                          theme_advanced_buttons2 : "",
                          theme_advanced_buttons3 : "",
                          theme_advanced_statusbar_location : "none"';
    if($this->hasMediaBrowserPlugin)
    {
      $options['config'] .= ',file_browser_callback: "sfMediaBrowserWindowManager.tinymceCallback"';
    }
    $attributes['rows'] = 40;
    $attributes['cols'] = 10;
    parent::__construct($options, $attributes);
  }
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