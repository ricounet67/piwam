<?php

class MembrePeer extends BaseMembrePeer
{
    const IS_ACTIF = 1;
    
    /**
     * Retrieve all the members. Order the list according to the first
     * parameter
     * 
     * @author  Adrien Mogenet <adrien@frenchcomp.net>
     * @param   string  $column
     * @return  Array Of Membre
     * @since   r1
     */
    public static function doSelectOrderBy($column = self::PSEUDO)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn($column);
        $c->addAnd(self::ACTIF, self::IS_ACTIF);
        
        return self::doSelect($c);
    }
}
