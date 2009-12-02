<?php
/**
 * Login actions.
 *
 * @package    piwam
 * @subpackage login
 * @author     Adrien Mogenet
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class loginActions extends sfActions
{
    public function executeLogin(sfWebRequest $request)
    {
      $this->setLayout(false);
    }
}
