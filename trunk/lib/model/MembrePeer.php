<?php

class MembrePeer extends BaseMembrePeer
{
	const IS_ACTIF = 1;

	/**
	 * Retrieve all the members. Order the list according to the first
	 * parameter.
	 *
	 * r9 : we check the validity of the field name given as argument
	 *
	 * @author  Adrien Mogenet <adrien@frenchcomp.net>
	 * @param	integer	$associationId
	 * @param   string  $column
	 * @return  sfPropelPager
	 * @since   r1
	 */
	public static function doSelectOrderBy($associationId, $page = 1, $column = self::PSEUDO)
	{
		if (! in_array($column, array('NOM', 'PRENOM', 'PSEUDO', 'STATUT_ID', 'VILLE'))) {
			$column = self::PSEUDO;
		}
		 
		$c = new Criteria();
		$c->addAscendingOrderByColumn($column);
		$c->add(self::ASSOCIATION_ID, $associationId);
		$c->addAnd(self::ACTIF, self::IS_ACTIF);

		$pager = new sfPropelPager('Membre', sfConfig::get('sf_users_users_by_page', 10));
		$pager->setCriteria($c);
		$pager->setPage($page);
		$pager->init();

		return $pager;
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

	
	/**
	 * Display Membre matching our query (actually this may
	 * only be AJAX query for autompleted fields)
	 * 
	 * @param	string	$q : query
	 * @param	integer	$limit
	 * @return 	array of Membre
	 * @since	r15\
	 */
	static public function retrieveForSelect($q, $limit)
	{
		$criteria = new Criteria();
		$criteria->add(self::PRENOM, '%'.$q.'%', Criteria::LIKE);
		$criteria->addAscendingOrderByColumn(self::PRENOM);
		$criteria->setLimit($limit);
		$membres = self::doSelect($criteria);
		$aMembres = array();
		
		foreach ($membres as $membre)
		{
			$aMembres[$membre->getId()] = (string) $membre;
		}

		return $aMembres;
	}

}
