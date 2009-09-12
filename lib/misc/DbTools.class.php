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
}
?>