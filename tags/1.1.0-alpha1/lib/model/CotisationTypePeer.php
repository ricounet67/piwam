<?php

class CotisationTypePeer extends BaseCotisationTypePeer
{
	/**
	 * Retrieve CotisationType only for the $associationId in argument
	 * 
	 * @param 	integer	$associationId
	 * @return 	array of CotisationType
	 * @since 	r14
	 */
	public static function doSelectEnabled($associationId)
	{
		$c = new Criteria();
		$c->add(self::ACTIF, ENABLED);
		$c->addAnd(self::ASSOCIATION_ID, $associationId);
		
		return self::doSelect($c);
	}
	
	/**
	 * Indicates if at least one type has already been set or not
	 * for the associationId in argument
	 * 
	 * @param 	integer	$associationId
	 * @return	boolean
	 * @since	r20
	 */
	public static function doesOneTypeExist($associationId)
	{
		$c = new Criteria();
		$c->add(self::ACTIF, ENABLED);
		$c->addAnd(self::ASSOCIATION_ID, $associationId);
		$numberOfTypes = self::doCount($c);
		
		return $numberOfTypes > 0;
	}
}
