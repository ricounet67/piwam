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
		$c->add(self::PERCUE, 1);

		return self::doSelect($c);
	}

    /**
     * Get the amount of creances
     *
     * @param  integer $associationId
     * @return float
     * @since  r66
     */
	public static function getAmountOfCreances($associationId)
	{
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addAsColumn('TOTAL_DETTES', 'SUM(' . self::MONTANT . ')');
        $c->add(self::ASSOCIATION_ID, $associationId);
        $c->addAnd(self::PERCUE, 0);
        $result = RecettePeer::doSelectStmt($c);
        $row = $result->fetch();

        return $row['TOTAL_DETTES'];
	}
}
