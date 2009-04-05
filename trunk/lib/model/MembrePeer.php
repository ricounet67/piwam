<?php

class MembrePeer extends BaseMembrePeer
{
    const IS_ACTIF = 1;
    
    /**
     * Retrieve all the members. Order the list according to the first
     * parameter
     * 
     * @author  Adrien Mogenet <adrien@frenchcomp.net>
     * @param	integer	$associationId
     * @param   string  $column
     * @return  Array Of Membre
     * @since   r1
     */
    public static function doSelectOrderBy($associationId, $column = self::PSEUDO)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn($column);
        $c->add(self::ASSOCIATION_ID, $associationId);
        $c->addAnd(self::ACTIF, self::IS_ACTIF);
        
        return self::doSelect($c);
    }
    
    
    /**
     * Try to select users matching $username and $password.
     * 
     * @param 	string	$username
     * @param 	string	$password
     * @return 	Membre
     * @since	r7
     */
    public static function doSelectByUsernameAndPassword($username, $password)
    {
    	$c = new Criteria();
    	$c->add(self::PSEUDO, $username);
    	$c->addAnd(self::PASSWORD, sha1($password));
    	
    	return self::doSelectOne($c);
    }
}
