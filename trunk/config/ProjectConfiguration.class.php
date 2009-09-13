<?php
/*
 * Configuration
 * -------------
 * Set up the correct path to reach sfCoreAutoload.class.php using your
 * own Symfony path
 */

require_once '/Users/adrien/Development/Symfony/1.2/lib/autoload/sfCoreAutoload.class.php';
//require_once 'C:\Development\Workspace\Symfony-1.2\lib\autoload\sfCoreAutoload.class.php';

sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
    public function setup()
    {

        /*
         * Configuration
         * -------------
         * If you want to set your own /cache and /logs folders,
         * un comment the 2 following lines and set values with your owns
         */
        //$this->setCacheDir('/tmp/symfony_cache');
        //$this->setLogDir('/tmp/symfony_logs');

        // End of editable area. Do NOT edit following lines

        // for compatibility / remove and enable only the plugins you want
        $this->enableAllPluginsExcept(array('sfDoctrinePlugin', 'sfCompat10Plugin'));
    }
}
