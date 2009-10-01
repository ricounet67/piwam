<?php
/**
 * Provides some DB operations that ORM can't do
 *
 * @author  adrien
 * @since   r100
 */
class DbTools
{
    /*
     * Launch a SQL file (execute all the queries).
     * This is a very simple SQL file executor
     *
     * @param   string          $file
     * @throw   PDOException    unknown reason
     * @todo    Improve
     */
    public static function executeSQLFile($file, $propelConnection = null)
    {
        $content = file_get_contents($file);
        $queries = explode(';', $content);

        foreach ($queries as $query) {

            if (is_null($propelConnection)) {
                mysql_query($query);
            }
            else {
                $statement = $propelConnection->prepare($query);
                $statement->execute();
            }
        }
    }

    /**
     * Check if MySQL settings are allright or not
     *
     * @todo extend to others DBMS
     */
    public static function checkMySQLConnection($host, $user, $password, $dbname)
    {
        $link = @mysql_connect($host, $user, $password);
        if (! $link) {
            return false;
        }
        else
        {
            $isConnected = mysql_select_db($dbname, $link);
            if ($isConnected)
            {
                return true;
            }
            else {
                return false;
            }
        }
    }
}
?>