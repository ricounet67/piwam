<?php

class CotisationPeer extends BaseCotisationPeer
{
	public static function doSelectJoinMembreId($associationId)
	{
		$c = new Criteria();
		$c->addJoin(self::MEMBRE_ID, MembrePeer::ID);
		$c->addAnd(MembrePeer::ASSOCIATION_ID, $associationId);
		
		return self::doSelect($c);
	}
	
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
    
    /**
     * Retrieve Cotisation paid by user $userId
     * 
     * @param 	integer	$userId
     * @return 	array of Cotisation
     * @since	r14
     */
    public static function doSelectForUser($userId)
    {
    	$c = new Criteria();
    	$c->add(self::MEMBRE_ID, $userId);
    	
    	return self::doSelect($c);
    }
}
