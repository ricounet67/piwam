<?php

class RecettePeer extends BaseRecettePeer
{
	public static function doSelectForAssociation($associationId)
	{
		$c = new Criteria();
		$c->add(self::ASSOCIATION_ID, $associationId);
		
		return self::doSelect($c);
	}
}
