<?php

/**
 * install actions.
 *
 * @package    piwam
 * @subpackage install
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class installActions extends sfActions
{
    private $_messages 		= array();
    private $_canContinue	= true;
    const STATE_ERROR		= 1;
    const STATE_WARNING		= 2;
    const STATE_SUCCESS		= 3;

    /**
     * Executes index action
     *
     * @param 	sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->forward('install', 'checkConfig');
    }

    /**
     * Check system of configuration before installing Piwam
     *
     * @param 	sfWebRequest $request
     */
    public function executeCheckConfig(sfWebRequest $request)
    {
        $this->_checkConfiguration();
        $this->messages = $this->_messages;
        $this->displayButton = $this->_canContinue;
    }

    /**
     * DIsplay a form which allows to configure database access
     *
     * @param  sfWebRequest $request
     * @since  r82
     */
    public function executeConfigDatabase(sfWebRequest $request)
    {
        $this->form = new DatabaseConfigForm();

        if ($request->isMethod('post'))
        {
            $this->form->bind($request->getParameter('dbconfig'));
            if ($this->form->isValid())
            {
                $config 	= $request->getParameter('dbconfig');
                $host 		= $config['mysql_server'];
                $username 	= $config['mysql_username'];
                $password 	= $config['mysql_password'];
                $dbname 	= $config['mysql_dbname'];

                if (DbTools::checkMySQLConnection($host, $username, $password, $dbname))
                {
                    $this->_generateConfigFile($host, $username, $password, $dbname);
                    $this->getContext()->getConfigCache()->clear();
                    DbTools::executeSQLFile('../doc/piwam-install.sql');
                    $this->redirect('install/end');
                }
                else {
                    $this->getUser()->setFlash('error', 'Impossible de se connecter à la base de données');
                }
            }
        }
    }

    /**
     * Display end view, once configuration is complete.
     *
     * @param 	sfWebRequest $request
     * @since	r83
     */
    public function executeEnd(sfWebRequest $request)
    {
        // just display static template
    }

    /*
     * Write new content of config file. Search occurences of string we want
     * to match, and then replace the line by a new one.
     * We flush the new content to the file at the end
     *
     * @todo extend to others DBMS
     */
    private function _generateConfigFile($server, $username, $password, $dbname)
    {
        $fileManager = new FileModifier('../config/databases.yml');
        $line = $fileManager->searchLineBeginningBy('dsn:');
        $fileManager->setLineContent($line, "dsn:      mysql:dbname={$dbname};host={$server}", true);
        $line = $fileManager->searchLineBeginningBy('username:');
        $fileManager->setLineContent($line, "username: {$username}", true);
        $line = $fileManager->searchLineBeginningBy('password:');
        $fileManager->setLineContent($line, "password: {$password}", true);
        $fileManager->flush();
    }

    /*
     * Check the current system configuration
     */
    private function _checkConfiguration()
    {
        $this->_addMessage(is_writable('../cache'), 				'isCacheFolderWritable');
        $this->_addMessage(is_writable('../log'),					'isLogFolderWritable');
        $this->_addMessage(is_writable('../config/databases.yml'),	'isDatabasesFileWritable');
        $this->_addMessage(extension_loaded('smtp'), 				'isPhpSmtpLoaded',				true);
        $this->_addMessage(extension_loaded('openssl'),				'isPhpOpenSSLLoaded',			true);
        $this->_addMessage($this->_checkMemoryLimit('128M'),		'isMemoryLimitHighEnough');
        $this->_addMessage($this->_isApacheModuleEnabled('mod_rewrite'),	'isModRewriteEnabled');
    }

    /*
     * Check if memory_limit setting is high enough
     */
    private function _checkMemoryLimit($required)
    {
        $currentLimit = $this->_return_bytes(ini_get('memory_limit'));
        $minimumLimit = $this->_return_bytes($required);

        return $currentLimit >= $minimumLimit;
    }

    /*
     * Check if an Apache module is enabled
     */
    private function _isApacheModuleEnabled($module)
    {
        $enabledModules = apache_get_modules();

        return in_array($module, $enabledModules);
    }

    /*
     * Add a new message into the messages array.
     */
    private function _addMessage($bool, $partial, $onlyWarning = false)
    {
        $state = $this->_boolean2state($bool, $onlyWarning);

        switch ($state)
        {
            case self::STATE_SUCCESS:
                $cssClass = 'test_success';
                $error = false;
                break;

            case self::STATE_WARNING:
                $cssClass = 'test_warning';
                $error = true;
                break;

            case self::STATE_ERROR:
                $cssClass = 'test_error';
                $error = true;
                break;
        }

        $newEntry = array(
			'state'		=> $state,
			'partial'	=> $partial,
			'cssClass'	=> $cssClass,
			'error'		=> $error,
        );

        $this->_messages[] = $newEntry;
    }

    /*
     * Convert a boolean to a state
     */
    private function _boolean2state($bool, $warning = false)
    {
        if ($bool) {
            return self::STATE_SUCCESS;
        }
        else {
            if ($warning) {
                return self::STATE_WARNING;
            }
            else {
                $this->_canContinue = false;
                return self::STATE_ERROR;
            }
        }
    }

    /*
     * Return a memory size into bytes
     */
    private function _return_bytes($val)
    {
        $val = trim($val);
        $last = strtolower(substr($val, -1));

        if($last == 'g')
        $val = $val * 1024 * 1024 * 1024;
        if($last == 'm')
        $val = $val * 1024 * 1024;
        if($last == 'k')
        $val = $val * 1024;

        return $val;
    }
}