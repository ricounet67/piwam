<?php
class CheckDBAvailabilityFilter extends sfFilter
{
  public function execute($filterChain)
  {
    $module = 'install';
    $action = 'index';

    if ($this->isFirstCall())
    {
      $context = $this->getContext();

      if (($module != $context->getModuleName()))
      {
        $configuration = sfProjectConfiguration::getActive();
        $db = new sfDatabaseManager($configuration);

        foreach ($db->getNames() as $connection)
        {
          try
          {
            @$db->getDatabase($connection)->getConnection();
          }
          catch(Exception $e)
          {
             $context->getController()->forward($module, $action);
             exit;
          }
        }
      }
    }

    $filterChain->execute();
  }
}
?>
