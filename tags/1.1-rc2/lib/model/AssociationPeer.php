<?php

class AssociationPeer extends BaseAssociationPeer
{
    /**
     * Get the _FIRST_ Association which is named $name
     *
     * @param   string  $name
     * @return  Association
     */
    public static function retrieveByName($name)
    {
        $c = new Criteria();
        $c->add(self::NOM, $name);

        return self::doSelectOne($c);
    }
}
