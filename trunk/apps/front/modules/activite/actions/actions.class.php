<?php
/**
 * Compare 2 Depense of Recette according to the date
 *
 * @param 	mixed	$entry1
 * @param 	mixed	$entry2
 * @return 	integer
 */
function compare_money_entries($entry1, $entry2)
{
	if ($entry1->getDate() <= $entry2->getDate()) {
		return -1;
	}
	else {
		return 1;
	}
}


/**
 * activite actions.
 *
 * @package    piwam
 * @subpackage activite
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class activiteActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->activite_list = ActivitePeer::doSelectEnabled($this->getUser()->getAttribute('association_id', null, 'user'));
	}

	public function executeShow(sfWebRequest $request)
	{
		$activiteId	= $request->getParameter('id');
		$depenses 	= DepensePeer::doSelectForActiviteId($activiteId);
		$recettes 	= RecettePeer::doSelectForActiviteId($activiteId);
		$data		= array_merge($depenses, $recettes);
		$isSortOk	= usort($data, 'compare_money_entries');
		$this->data = $data;
		$this->activite = ActivitePeer::retrieveByPk($activiteId);
		$this->forward404Unless($this->activite);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new ActiviteForm();
		$this->form->setDefault('mis_a_jour_par', sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'user'));
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post'));
		$this->form = new ActiviteForm();
		$this->form->setDefault('mis_a_jour_par', sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'user'));
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($activite = ActivitePeer::retrieveByPk($request->getParameter('id')), sprintf('Object activite does not exist (%s).', $request->getParameter('id')));
		$this->form = new ActiviteForm($activite);
		$this->form->setDefault('mis_a_jour_par', sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'user'));
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($activite = ActivitePeer::retrieveByPk($request->getParameter('id')), sprintf('Object activite does not exist (%s).', $request->getParameter('id')));
		$this->form = new ActiviteForm($activite);
		$this->form->setDefault('mis_a_jour_par', sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'user'));
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		$this->forward404Unless($activite = ActivitePeer::retrieveByPk($request->getParameter('id')), sprintf('Object activite does not exist (%s).', $request->getParameter('id')));
		$activite->delete();
		$this->redirect('activite/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$activite = $form->save();
			$this->redirect('activite/index');
		}
	}
}
