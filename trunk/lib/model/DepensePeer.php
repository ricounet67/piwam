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

	/**
	 * Retrieve data for the association given in argument
	 *
	 * @param 	integer	$id
	 * @return 	array of Depense
	 * @since	r57
	 */
	public static function doSelectForActiviteId($id)
	{
		$c = new Criteria();
		$c->add(self::ACTIVITE_ID, $id);

		return self::doSelect($c);
	}
}
