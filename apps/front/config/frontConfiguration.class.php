<?php

class frontConfiguration extends sfApplicationConfiguration
{
	public function configure()
	{
		// Represents the states of `actif` fields
		define('ENABLED',		1);
		define('DISABLED',		0);
		
		// Symbol which is used as CSV separator when exporting files
		define('CSV_SEPARATOR',	',');

		// Define error messages for required/invalid fields
		sfValidatorBase::setRequiredMessage('Requis');
		sfValidatorBase::setInvalidMessage('Invalide');
	}
}
