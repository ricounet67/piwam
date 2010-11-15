<?php
/**
 * Provides some DB operations that ORM can't do
 *
 * @author  adrien
 * @since   r100
 */
class DbTools
{
  /**
   * Launch a SQL file (execute all the queries).
   * This is a very simple SQL file executor
   *
   * @param   string          $file
   * @param   PDO             $propelConnection
   * @throw   PDOException    If an error occured in a query
   * @todo    Improve
   */
  public static function executeSQLFile($file, $propelConnection = null)
  {
    $content = file_get_contents($file);
    $queries = explode(';', $content);
    $decode = false;

    if (is_null($propelConnection))
    {
      if (false === mysql_set_charset('utf8'))
      {
        $decode = true;
      }
    }

    foreach ($queries as $query)
    {
      if (trim($query) !== '')
      {
        if (is_null($propelConnection))
        {
          if ($decode)
          {
            mysql_query(utf8_decode($query));
          }
          else
          {
            mysql_query($query);
          }
        }
        else
        {
          $statement = $propelConnection->prepare($query);
          $statement->execute();
        }
      }
    }
  }

  /**
   * Check if MySQL settings are allright or not
   *
   * @param   string  $host
   * @param   string  $user
   * @param   string  $password
   * @param   string  $dbname
   * @return  boolean
   * @todo extend to others DBMS
   */
  public static function checkMySQLConnection($host, $user, $password, $dbname)
  {
    $link = mysql_connect($host, $user, $password);

    if (! $link)
    {
      return false;
    }
    else
    {
      $isConnected = mysql_select_db($dbname, $link);

      if ($isConnected)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
  }

  /**
   * Load yml data for one association, replace all %%ASSOCIATION_ID%% in file
   * and load data in database. Use temporary file in cache directory before
   * load in database
   * 
   * @param string $yml_path file path for yml
   * @param integer $asso_id association id
   */
  public static function loadYmlFileForAssociation($yml_path, $asso_id)
  {
    if (file_exists($yml_path))
    {
      $file_yml = file_get_contents($yml_path);
      $file_yml = str_replace("%%ASSOCIATION_ID%%", "" . $asso_id, $file_yml);
      // tempnam() can be use because Doctrine::loadData() needs filepath ending by .yml
      $temp_file = sfConfig::get('sf_cache_dir') . '/tmpdata.yml';
      $file = fopen($temp_file, "wb");
      fwrite($file, $file_yml, strlen($file_yml));
      fclose($file);
      sfContext::getInstance()->getLogger()->debug('load=' . $temp_file);
      Doctrine::loadData($temp_file, true);
      unlink($temp_file);
    }
    else
    {
      throw new InvalidArgumentException("YML file '" . $yml_path . "' in argument doesn't exist");
    }
  }
}
?>