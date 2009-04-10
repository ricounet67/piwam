<?php

class DepensePeer extends BaseDepensePeer
{
	/**
	 * Retrieve data only for the association referenced by $associationId
	 * 
	 * @param 	integer	$associationId
	 * @return 	array of Depense
	 * @since	r14
	 */
	public static function doSelectForAssociation($associationId)
	{
		$c = new Criteria();
		$c->add(self::ASSOCIATION_ID, $associationId);
		
		return self::doSelect($c);
	}
}
