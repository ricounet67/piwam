<?php

class CotisationPeer extends BaseCotisationPeer
{
    /**
     * Get the date of the last payment of the member in parameter
     * 
     * @param   integer     $id
     * @return  Cotisation
     * @since   r1
     */
    public static function getDerniereDuMembre($id)
    {
        $c = new Criteria();
        $c->add(self::MEMBRE_ID, $id);
        $c->addDescendingOrderByColumn(self::DATE);
        
        return self::doSelectOne($c);
    }
}
