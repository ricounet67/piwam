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
}
