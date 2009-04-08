<?php

class ActivitePeer extends BaseActivitePeer
{
	/**
	 * Retrieve list of Activite for the Association/bilan action
	 * 
	 * @return	array of Activite
	 */
	public static function doSelectForOverview()
	{
		$c = new Criteria();
		$c->add(self::ACTIF, ENABLED);
			
		return self::doSelect($c);
	}
}
