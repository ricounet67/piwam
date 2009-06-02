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
		$this->setAttribute('association_id', 	$user->getAssociationId(), 			'user');
		$this->setAttribute('association_name', $user->getAssociation()->getNom(), 	'user');
		$this->setAttribute('user_id',			$user->getId(), 					'user');
		$this->setAttribute('user_name', 		$user->getPseudo(), 				'user');
		$this->getAttributeHolder()->removeNamespace('temp');
		$this->setCredentials();
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
		$this->getAttributeHolder()->removeNamespace('user');
		$this->getAttributeHolder()->removeNamespace('temp');
		$this->clearCredentials();
	}

	/**
	 * Store temporary an Association ID in session. It's just usefull
	 * when we want to register a new association, to store easily
	 * the ID between the different steps of registration
	 *
	 * @param 	integer	$id
	 * @since	r16
	 */
	public function setTemporaryAssociationId($id)
	{
		$this->setAttribute('association_id', $id, 'temp');
	}

	/**
	 * Store temporary values about user
	 *
	 * @param 	Membre	$value
	 * @since	r16
	 */
	public function setTemporarUserInfo($user)
	{
		$this->setAttribute('user_info', serialize($user), 'temp');
	}

	/**
	 * Retrieve temporary Membre value
	 *
	 * @return 	Membre
	 * @since	r16
	 */
	public function getTemporaryUserInfo()
	{
		return unserialize($this->getAttribute('user_info', null, 'temp'));
	}

	/**
	 * Remove all data which were stored temporary
	 *
	 * @since	r16
	 */
	public function removeTemporaryData()
	{
		$this->getAttributeHolder()->removeNamespace('temp');
	}

	/*
	 * Retrieve the credentials granted to the user
	 */
    protected function setCredentials()
    {
        $credentials = AclCredentialPeer::doSelectForMembreId($this->getAttribute('user_id', null, 'user'));
        foreach ($credentials as $credential) {
            $this->addCredential($credential->getCode());
        }
    }
}
