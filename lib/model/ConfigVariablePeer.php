<?php

class ConfigVariablePeer extends BaseConfigVariablePeer
{
    /**
     * Retrieve a row according to the code $code
     *
     * @param   string  $code
     * @return  ConfigVariable
     */
    public static function retrieveByCode($code)
    {
        $c = new Criteria();
        $c->add(self::CODE, $code);

        return self::doSelectOne($c);
    }
}
