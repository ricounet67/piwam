<?php
switch ($_SERVER['SERVER_NAME'])
{
	case 'piwam.adrien':
		require_once 'C:\wamp\bin\php\php5.2.9-1\PEAR\symfony\autoload\sfCoreAutoload.class.php';
		break;
		
	case 'piwam.com':
		require_once '/Users/adrien/Development/Symfony/1.2/lib/autoload/sfCoreAutoload.class.php';
		break;
		
	default:
		require_once 'C:\wamp\bin\php\php5.2.9-1\PEAR\symfony\autoload\sfCoreAutoload.class.php';
		break;
}
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    // for compatibility / remove and enable only the plugins you want
    $this->enableAllPluginsExcept(array('sfDoctrinePlugin', 'sfCompat10Plugin'));
  }
}
