<?php

class myUser extends sfBasicSecurityUser
{
	/**
	 * Performs all the required actions when user just
	 * logged in
	 * 
	 * @param	Membre	$user
	 * @since	r6
	 */
	public function login(Membre $user)
	{
		$this->setAuthenticated(true);
		$this->setCulture('fr_FR');
		$this->setAttribute('association_id', 	$user->getAssociationId());
		$this->setAttribute('association_name', $user->getAssociation()->getNom());
		$this->setAttribute('user_id',			$user->getId());
		$this->setAttribute('user_name', 		$user->getPseudo());
	}
	
	/**
	 * Performs all required actions when user would like to log out
	 * or when we force him to log out
	 * 
	 * @since	r6
	 */
	public function logout()
	{
		$this->setAuthenticated(false);
	}
}
