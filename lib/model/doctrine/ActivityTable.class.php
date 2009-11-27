<?php
/**
 * Implements operations of activity table
 *
 * @package     piwam
 * @subpackage  model
 * @since       1.2
 * @author      Adrien Mogenet <adrien.mogenet@gmail.com
 */
class ActivityTable extends Doctrine_Table
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
}