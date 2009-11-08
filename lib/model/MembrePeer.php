<?php

class MembrePeer extends BaseMembrePeer
{
    const PICTURE_DIR = 'uploads/trombinoscope';
    const IS_ACTIF = 1;
    const IS_PENDING = 2;

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
        if (! in_array($column, array('NOM', 'PRENOM', 'PSEUDO', 'STATUT_ID', 'VILLE')))
        {
            $column = self::PSEUDO;
        }

        $c = new Criteria();
        $c->addAscendingOrderByColumn($column);
        $c->add(self::ASSOCIATION_ID, $associationId);
        $c->addAnd(self::ACTIF, self::IS_ACTIF);

        $associationId  = sfContext::getInstance()->getUser()->getAttribute('association_id', null, 'user');
        $pager          = new sfPropelPager('Membre', Configurator::get('users_by_page', $associationId, 20));
        $pager->setCriteria($c);
        $pager->setPage($page);
        $pager->init();

        return $pager;
    }

    /**
     * Retrieve the member who have a pending subscription
     *
     * @param   integer $associationId
     * @return  array of Membre
     * @since   r160
     */
    public static function doSelectPending($associationId)
    {
        $c = new Criteria();
        $c->add(self::ACTIF, self::IS_PENDING);
        $c->addAnd(self::ASSOCIATION_ID, $associationId);
        $c->addDescendingOrderByColumn(self::CREATED_AT);

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

    /**
     * Retrieve a Membre according to his pseudo
     *
     * @param 	string	$pseudo
     * @return 	Membre
     * @since	r16
     */
    public static function retrieveByPseudo($pseudo)
    {
        $c = new Criteria();
        $c->add(self::PSEUDO, $pseudo);

        return self::doSelectOne($c);
    }

    /**
     * Retrieve all members who belongs to the association in parameter.
     * This is different from the method `doSelectOrderBy` which selects
     * members within a sfPropelPager.
     *
     * @param 	integer	$id
     * @return 	array of Membre
     * @since	r17
     */
    public static function doSelectForAssociation($id)
    {
        $c = new Criteria();
        $c->add(self::ASSOCIATION_ID, $id);

        return self::doSelect($c);
    }

    /**
     * Return a Criteria to select only data which belong to the association
     * in argument
     *
     * @param 	integer	$id
     * @return 	Criteria
     * @since	r23
     */
    public static function getCriteriaForAssociationId($id)
    {
        $c = new Criteria();
        $c->add(self::ASSOCIATION_ID, $id);

        return $c;
    }

    /**
     * Retrieve Membre who have an email address that had been set and who
     * belong to association in argument
     *
     * @param 	integer	$associationId
     * @return 	array of Membre
     * @since	r25
     */
    public static function doSelectWithEmailForAssociation($associationId)
    {
        $c = new Criteria();
        $c->add(self::ASSOCIATION_ID, $associationId);
        $c->addAnd(self::EMAIL, null, Criteria::ISNOTNULL);
        $c->addAnd(self::EMAIL, "", Criteria::NOT_EQUAL);

        return self::doSelect($c);
    }
}
