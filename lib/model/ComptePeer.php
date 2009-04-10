<?php

class ComptePeer extends BaseComptePeer
{
	public static function doSelectEnabled($associationId)
	{
		$c = new Criteria();
		$c->add(self::ACTIF, 1);
		$c->addAnd(self::ASSOCIATION_ID, $associationId);
			
		return self::doSelect($c);
	}
}
