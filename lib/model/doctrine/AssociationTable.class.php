<?php
/**
 * Implements operations on Association table
 *
 * @package     piwam
 * @subpackage  model
 * @author      Adrien Mogenet
 * @since       1.2
 */
class AssociationTable extends Doctrine_Table
{
    /**
     * Value of state field when disabled
     *
     * @var integer
     */
    const STATE_DISABLED    = 0;

    /**
     * Value of state field when enabled
     *
     * @var integer
     */
    const STATE_ENABLED     = 1;

    /**
     * Count existing associations
     *
     * @return  integer
     */
    public static function doCount()
    {
        $q = Doctrine_Query::create()
                ->select('count(a.id) AS n')
                ->from('Association a')
                ->groupBy('a.id');

        return $q->count();
    }
}