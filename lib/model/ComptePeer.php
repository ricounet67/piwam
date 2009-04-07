<?php

class ComptePeer extends BaseComptePeer
{
	public static function doSelectForOverview()
	{
		$c = new Criteria();
		$c->add(self::ACTIF, 1);
			
		return self::doSelect($c);
	}
}
