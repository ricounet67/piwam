<?php

class StatutPeer extends BaseStatutPeer
{
    const IS_ACTIF = 1;
    
    public static function doSelectEnabled()
    {
        $c = new Criteria();
        $c->add(self::ACTIF, self::IS_ACTIF);
        
        return parent::doSelect($c);
    }
    
    
    /**
     * Build a specific Criteria to get only enabled statuts. It is
     * useful to customize our forms
     * 
     * @return  Criteria
     *
     */
    public static function getCriteriaForEnabled()
    {
        $c = new Criteria();
        $c->add(self::ACTIF, self::IS_ACTIF);
        
        return $c;
    }
}
