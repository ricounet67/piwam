<?php
/*
 * Configuration
 * -------------
 * Set up the correct path to reach sfCoreAutoload.class.php using your
 * own Symfony path
 */


$file = '/Users/adrien/Development/Symfony/1.2/lib/autoload/sfCoreAutoload.class.php';

if (file_exists($file))
{
	require_once $file;
}
else
{
    echo '<h2>Oups, on dirait qu\'il y a une erreur...</h2>';
    echo 'Le fichier ' . basename($file) . ' n\'est pas accessible. Éditez le fichier <strong>ProjectConfiguration.class.php</strong> !';
    echo '<p>Vous pouvez demander de l\'aide sur <a href="http://groups.google.com/group/piwam">http://groups.google.com/group/piwam</a>.</p>';
    exit;
}

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
