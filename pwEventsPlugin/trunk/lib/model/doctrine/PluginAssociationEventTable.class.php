<?php

/**
 * PluginAssociationEventTable
 * @package    pwEventsPlugin
 * @subpackage model
 * @author     Jerome Fouilloy
 * @version    SVN: $Rev$
 */
class PluginAssociationEventTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PluginAssociationEventTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PluginAssociationEvent');
    }
}