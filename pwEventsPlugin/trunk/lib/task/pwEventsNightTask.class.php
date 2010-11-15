<?php
/**
 * Send automatically futur events validated to all active members
 * @package    pwEventsPlugin
 * @subpackage task
 * @author     Jerome Fouilloy
 * @version    SVN: $Rev$
 */
class pwEventsNightTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {

    $this->addOptions(array(
    new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', 'backend'),
    new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
    new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),

    ));

    $this->namespace = 'pwEventsPlugin';
    $this->name = 'night-tasks';
    $this->briefDescription = 'Do automatic events mailing';

    $this->detailedDescription = <<<EOF
The [pwEventsPlugin:night-tasks] send list of events to all members with time period set in configuration
EOF;
  }

  /**
   * @see sfTask
   */
  public function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $context = sfContext::createInstance($this->configuration);

    $associations = AssociationTable::getInstance()->findAll();
    foreach($associations as $asso)
    {
      $this->logSection('pwEventsPlugin:', sprintf('Night tasks for association %s', $asso->getName()));
      $this->execForAssociation($asso);
    }
  }
  

}