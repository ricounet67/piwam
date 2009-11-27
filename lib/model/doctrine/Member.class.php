<?php

/**
 * Member
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    piwam
 * @subpackage model
 * @author     Adrien Mogenet
 * @version    SVN: $Id: Builder.php 6716 2009-11-12 19:26:28Z jwage $
 */
class Member extends BaseMember
{
  /**
   * Overrides the setPassword to encrypt it
   *
   * @see   lib/model/doctrine/base/BaseMember#setPassword()
   * @param string  $v
   */
  public function setPassword($v)
  {
    return $this->_set('password', sha1($v));
  }

  /**
   * Returns the whole URI of user's picture, or 'no-picture' image
   * if he doesn't have one
   *
   * @return string
   */
  public function getPictureURI()
  {
    return $this->picture;
  }
}