<?php

/**
 * MemberExtraValue
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    piwam
 * @subpackage model
 * @author     Adrien Mogenet
 * @version    SVN: $Id: Builder.php 7021 2010-01-12 20:39:49Z lsmith $
 */
class MemberExtraValue extends BaseMemberExtraValue
{
  /**
   * Store any type of value in database (serialized field)
   *
   * @param   Mixed             $value
   * @return  MemberExtraValue
   */
  public function setValue($value)
  {
    $this->_set('value', serialize($value));

    return $this;
  }

  /**
   * Retrieved variable stored in 'value' field
   *
   * @return Mixed
   */
  public function getValue()
  {
    return unserialize($this->_get('value'));
  }

  /**
   * Get a ready-to-display string of 'value' field
   */
  public function getFormattedValue()
  {
    $value = $this->getValue();

    if (is_array($value))
    {
      return implode('/', $value);
    }

    return $value;
  }
}
