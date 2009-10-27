<?php
/**
 * I created this custom class to perform user authentication automatically
 *
 * @since   r64
 */
class sfGuardTestFunctional extends sfTestFunctional
{
    const LOGIN_OK      = "demo";       // set a valid login
    const PASSWORD_OK   = "demo";       // set a valid password


    /**
     * Custom Ctor, overriding parent ctor
     *
     * @param           $browser
     * @param boolean   $login      (optional) Do we have to perform user login
     * @param           $lime		(optional)
     * @param           $testers	(optional)
     */
    public function __construct($browser, $login = true, $lime = null, $testers = array())
    {
        parent::__construct($browser, $lime, $testers);

        if ($login)
        {
            $this->signin(array('username' => self::LOGIN_OK, 'password' => self::PASSWORD_OK));
        }
    }

    /**
     * Perform user athentication
     *
     * @param   array of String         $user_data
     * @return  sfGuardTestFunctional   $this
     */
    public function signin($user_data)
    {
        return  $this->info(sprintf('Connection with login: "%s" and password: "%s".', $user_data['username'], $user_data['password']))->
        get('/association/login')->
        click("S'identifier", array('login' => $user_data))->

        with('form')->begin()->
            hasErrors(false)->
        end()->

        with('user')->begin()->
            isCulture('fr_FR')->
            isAuthenticated(true)->
        end()->

        with('request')->begin()->
            isParameter('module', 'association')->
            isParameter('action', 'login')->
        end()->

        isRedirected()->
        followRedirect();
    }
}

?>