<?php

/**
 * Membre form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MembreForm extends BaseMembreForm
{
    public function configure()
    {
        $this->setDefault('dateinscription', '01-01-2008');
    }
}
