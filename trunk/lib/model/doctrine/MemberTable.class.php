<?php
/**
 * Doctrine class to retrieve rows of Member table
 *
 * @author  Adrien Mogenet
 * @since   1.2
 */
class MemberTable extends Doctrine_Table
{
  /**
   * Defines folder where pictures will be stored
   *
   * @var string
   */
  const PICTURE_DIR = 'uploads/trombinoscope';

  /**
   * Value of state if user account is disabled
   *
   * @var integer
   */
  const STATE_DISABLED  = 0;

  /**
   * Value of state if user account is enabled
   *
   * @var integer
   */
  const STATE_ENABLED   = 1;

  /**
   * Value of state if user account is pending
   *
   * @var integer
   */
  const STATE_PENDING   = 2;

  /**
   * Retrieve list of Member who belong to association $id
   *
   * @param   integer $id
   * @return  Member
   */
  public static function getEnabledForAssociation($id)
  {
    $q = self::getQueryEnabledForAssociation($id);

    return $q->execute();
  }

  /**
   * Get the query to retrieve Members of association $id
   *
   * @param   integer       $id
   * @return  Doctrine_Query
   */
  public static function getQueryEnabledForAssociation($id)
  {
    $q = Doctrine_Query::create()
          ->from('Member m')
          ->where('m.association_id = ?', $id)
          ->andWhere('m.state = ?', self::STATE_ENABLED)
          ->orderBy('m.firstname ASC');

    return $q;
  }

  /**
   * Build a Doctrine_Query object according to criteria given by
   * parameter $params.
   * Supported params :
   *    - association_id
   *    - magic (search on several fields)
   *    - state
   *
   * @param   array           $params
   * @return  Doctrine_Query
   */
  public static function getQuerySearch($params)
  {
    $q = Doctrine_Query::create()
          ->from('Member m');

    if (isset ($params['association_id']))
    {
      $q->andWhere('m.association_id = ?', $params['association_id']);
    }
    if (isset ($params['state']))
    {
      $q->andWhere('m.state = ?', $params['state']);
    }
    if (isset ($params['magic']))
    {
      $query = '%' . $params['magic'] . '%';
      $q->andWhere("concat(concat(m.firstname, ' '), m.lastname) LIKE ?", $query);
    }

    return $q;
  }

  /**
   * Get the list of active members who belong to the
   * association $id
   *
   * @param   integer           $association_id
   * @param   integer           $page
   * @param   string            $column
   * @return  sfDoctrinePager
   */
  public static function getPagerOrderBy($association_id, $page = 1, $column = 'lastname')
  {
    $sortable_columns = array('lastname', 'firstname', 'username', 'city', 'status_id');

    if (! in_array($column, $sortable_columns))
    {
      $column = 'lastname';
    }

    $q = self::getQueryEnabledForAssociation($association_id)
                ->orderBy('m.' . $column . ' ASC');

    $n = Configurator::get('users_by_page', $association_id, 20);
    $pager = new sfDoctrinePager('Member', $n);
    $pager->setQuery($q);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  /**
   * Retrieve pending user accounts
   *
   * @param   integer           $association_id
   * @return  array of Member
   */
  public static function getPendingMembers($association_id)
  {
    $q = Doctrine_Query::create()
          ->select('m.*')
          ->from('Member m')
          ->where('m.association_id = ?', $association_id)
          ->andWhere('state = ?', self::STATE_PENDING);

    return $q->execute();
  }

  /**
   * Try to select users matching $username and $password.
   *
   * @param   string    $username
   * @param   string    $password
   * @return  Member
   */
  public static function getByUsernameAndPassword($username, $password)
  {
    $q = Doctrine_Query::create()
          ->select('m.id')
          ->from('Member m')
          ->where('m.username = ?', $username)
          ->andWhere('m.password = ?', sha1($password))
          ->andWhere('m.state = ?', self::STATE_ENABLED)
          ->limit(1);

    return $q->fetchOne();
  }

  /**
   * Retrieve a member by his username
   *
   * @param   string  $username
   * @return  Member
   */
  public static function getByUsername($username)
  {
    $q = Doctrine_Query::create()
          ->select('m.id')
          ->from('Member m')
          ->where('m.username = ?', $username)
          ->limit(1);

    return $q->fetchOne();
  }

  /**
   * Retrieve a member by his username
   *
   * @param   string  $username
   * @return  Member
   */
  public static function getById($id)
  {
    $q = Doctrine_Query::create()
          ->from('Member m')
          ->where('m.id= ?', $id)
          ->limit(1);

    return $q->fetchOne();
  }

  /**
   * Display Membre matching our query. $query is going to be set as a
   * magic criteria that the engine will try to match after comparison
   * on several fields.
   *
   * @param   string      $query
   * @param   integer     $limit
   * @param   integer     $associationId
   * @return  array of Member
   */
  static public function search($query, $limit, $associationId)
  {
    $params = array('association_id' => $associationId,
                    'state' => self::STATE_ENABLED,
                    'magic'=> $query);

    $q = self::getQuerySearch($params);
    $q->limit($limit);

    return $q->execute();
  }

  /**
   * Retrieve list of users who have an email and belong to association $id
   *
   * @param   integer         $id
   * @return  array of Member
   */
  public static function getHavingEmailForAssociation($id)
  {
    $q = Doctrine_Query::create()
          ->from('Member m')
          ->where('m.association_id = ?', $id)
          ->andWhere('m.state = ?', self::STATE_ENABLED)
          ->andWhere('m.email IS NOT NULL')
          ->andWhere('m.email != ""');

    return $q->execute();
  }

  /**
   * Count existing Member
   *
   * @return  integer
   */
  public static function doCount()
  {
    $q = Doctrine_Query::create()
          ->select('m.id')
          ->from('Member m');

    return $q->count();
  }
}