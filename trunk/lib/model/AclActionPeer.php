<?php

class AclActionPeer extends BaseAclActionPeer
{
    /**
     * Retrieve the list of actions related to the module
     * given in argument
     *
     * @param   integer $moduleId
     * @return  array of AclAction
     */
    public static function doSelectForModuleId($moduleId)
    {
        $c = new Criteria();
        $c->add(self::ACL_MODULE_ID, $moduleId);

        return self::doSelect($c);
    }
}
