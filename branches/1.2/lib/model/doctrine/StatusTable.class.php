<?php
/**
 * Implements operations on Status table
 *
 * @package     piwam
 * @subpackage  model
 * @author      adrien
 * @since       1.2
 */
class StatusTable extends Doctrine_Table
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