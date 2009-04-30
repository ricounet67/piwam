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
	
	/**
	 * NEW
	 * @param $id
	 * @return unknown_type
	 */
	public static function getCriteriaForAssociationId($id)
	{
		$c = new Criteria();
		$c->add(self::ASSOCIATION_ID, $id);
		
		return $c;
	}
}
