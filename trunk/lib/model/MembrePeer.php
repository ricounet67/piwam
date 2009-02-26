<?php

class MembrePeer extends BaseMembrePeer
{
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
        
        return self::doSelect($c);
    }
}
