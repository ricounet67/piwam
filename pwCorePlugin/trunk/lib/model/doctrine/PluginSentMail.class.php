<?php

/**
 * PluginSentMail
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    pwCorePlugin
 * @subpackage model
 * @author     Adrien Mogenet <adrien@piwam.org>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 * @since      1.2
 */
abstract class PluginSentMail extends BaseSentMail
{
  /**
   * Set addresses, in a serialized form
   *
   * @param   array|Mixed    $addresses
   * @return  SentMail
   */
  public function setAddresses($addresses)
  {
    $this->__set('recipients', serialize($addresses));
    
    return $this;
  }

  /**
   * Return original value of the stored addresses
   *
   * @return  array|mixed
   */
  public function getAddresses()
  {
    return unserialize($this->__get('recipients'));
  }
}