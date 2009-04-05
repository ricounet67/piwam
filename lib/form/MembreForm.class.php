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
    	unset($this['created_at'], $this['updated_at']);
        $this->widgetSchema['statut_id']->setOption('criteria', StatutPeer::getCriteriaForEnabled());        
        $this->setDefault('dateinscription', date('d-m-Y'));
        $this->setDefault('pays', 'FRANCE');
    }
}
