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
    public static function get($v, $defaultValue = null)
    {
        $context        = sfContext::getInstance();
        $associationId  = $context->getUser()->getAttribute('association_id', null, 'user');
        $configValue    = ConfigValuePeer::retrieveByCode($v, $associationId);

        if (is_null($configValue)) {
            $configVariable = ConfigVariablePeer::retrieveByCode($v);
            if (is_null($configVariable)) {
                throw new Exception('Invalid configuration variable ' . $v);
            }
            if (is_null($defaultValue)) {
	            return $configVariable->getDefaultValue();
	        }
	        else {
	        	return $defaultValue;
	        }
        }
        else {
            return $configValue->getCustomValue();
        }
    }

    /**
     * Set $v (configuration variable) = $value (new value of this variable).
     * We check if the variable really exists
     *
     * @param 	string	$v
     * @param 	string	$value
     * @throw	Exception	if configuration variable doesn't exist
     */
    public static function set($v, $value)
    {
		$variable = ConfigVariablePeer::retrieveByCode($v);
		$associationId  = sfContext::getInstance()->getUser()->getAttribute('association_id', null, 'user');

		if ($variable == null) {
			throw new Exception('Variable does not exist : ' . $v);
		}

		$configValue = ConfigValuePeer::retrieveByCode($v, $associationId);
		if ($configValue == null)
		{
			$newConfigValue = new ConfigValue();
			$newConfigValue->setConfigVariableId($variable->getId());
			$newConfigValue->setCustomValue($value);
			$newConfigValue->setAssociationId($associationId);
			$newConfigValue->save();
		}
		else {
			$configValue->setCustomValue($value);
			$configValue->save();
		}
    }
}
?>