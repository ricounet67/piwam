<?php

class ActivitePeer extends BaseActivitePeer
{
	/**
	 * Retrieve list of Activite for the Association/bilan action
	 * 
	 * @param	integer	$associationId
	 * @return	array of Activite
	 */
	public static function doSelectEnabled($associationId)
	{
		$c = new Criteria();
		$c->add(self::ACTIF, ENABLED);
		$c->addAnd(self::ASSOCIATION_ID, $associationId);
			
		return self::doSelect($c);
	}
}
