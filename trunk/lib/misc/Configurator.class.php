<?php
/**
 * The aim of this class is to deal with configuration variables
 *
 * @since   r74
 */
class Configurator
{
    /**
     * Get the value of the configuration variable $v
     *
     * @param   string      $variable
     * @return  string      Value of the configuration variable, stored as
     *                      string in the database
     * @throw   Exception   if $v is invalid
     */
    public static function get($v)
    {
        $context        = sfContext::getInstance();
        $associationId  = $context->getUser()->getAttribute('association_id', null, 'user');
        $configValue    = ConfigValuePeer::retrieveByCode($v, $associationId);

        if (is_null($configValue)) {
            $configVariable = ConfigVariablePeer::retrieveByCode($v);
            if (is_null($configVariable)) {
                throw new Exception('Invalid configuration variable ' . $v);
            }
            return $configVariable->getDefaultValue();
        }
        else {
            return $configValue->getCustomValue();
        }
    }
}
?>