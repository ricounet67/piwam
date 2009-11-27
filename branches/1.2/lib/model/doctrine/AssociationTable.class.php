<?php

class AssociationTable extends Doctrine_Table
{
    public static function doCount()
    {
        $q = Doctrine_Query::create()
                ->select('count(a.id) AS n')
                ->from('Association a')
                ->groupBy('a.id')
                ->execute();

        return $q[0];
    }
}