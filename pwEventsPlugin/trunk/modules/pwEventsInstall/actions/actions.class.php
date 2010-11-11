<?php
/**
 * Manage installations of events plugin for piwam
 *
 * @package    pwEventsPlugin
 * @subpackage pwEventsInstall
 * @author     Jerome Fouilloy
 * @version    SVN: $Rev$
 */
class pwEventsInstallActions extends sfActions
{
  /**
   * Executes install action
   *
   * @param sfRequest $request A request object
   */
  public function executeInstall(sfWebRequest $request)
  {
     
    $assoId = $this->getUser()->getAssociationId();
    $template = MailTemplateTable::getInstance()->findOneByTemplateKey(pwEventsPluginUtil::EMAIL_EVENT_CREATED);
    //lets manager already installed
    if($template != null)
    {
      $this->getUser()->setFlash('notice',"Installation du gestionnaire d'événements déjà fait");
      $this->redirect('@homepage');
    }
    Doctrine::loadData(sfConfig::get('sf_plugins_dir').'/pwEventsPlugin/data/fixtures/configuration.yml',true);

    $config2 = file_get_contents(sfConfig::get('sf_plugins_dir').'/pwEventsPlugin/data/fixtures/configuration2.yml');
    DbTools::loadYmlFileForAssociation($config2,$assoId);
    
    //FUNC: update admin acl group with new rights ?

    $this->setTemplate('endInstall');
  }

}
