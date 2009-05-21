<?php

class RecettePeer extends BaseRecettePeer
{
	/**
	 * Select only data which belong to the association
	 * in argument
	 *
	 * @param 	integer	$id
	 * @return 	array of Recette
	 * @since	r23
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
	 * @return 	array of Recette
	 * @since	r57
	 */
	public static function doSelectForActiviteId($id)
	{
		$c = new Criteria();
		$c->add(self::ACTIVITE_ID, $id);

		return self::doSelect($c);
	}
}
