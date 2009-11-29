<?php
/**
 * Association
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    piwam
 * @subpackage model
 * @author     Adrien Mogenet
 * @version    SVN: $Id: Builder.php 6716 2009-11-12 19:26:28Z jwage $
 */
class Association extends BaseAssociation
{
  /**
   * Ctor
   *
   * @param $table
   * @param $isNewEntry
   * @return unknown_type
   */
  public function __construct($table = null, $isNewEntry = false)
  {
    parent::__construct($table, $isNewEntry);
  }

  /**
   * Add all the default linked entities (Status, Activite...). This method
   * should be called when we register a new Association.
   */
  public function initialize()
  {

    $statutPresident = new Status();
    $statutPresident->setState(StatusTable::STATE_ENABLED);
    $statutPresident->setAssociationId($this->getId());
    $statutPresident->setLabel('Président');
    $statutPresident->save();

    $statutTresorier = new Status();
    $statutTresorier->setState(StatusTable::STATE_ENABLED);
    $statutTresorier->setAssociationId($this->getId());
    $statutTresorier->setLabel('Trésorier');
    $statutTresorier->save();

    $statutSecretaire = new Status();
    $statutSecretaire->setState(StatusTable::STATE_ENABLED);
    $statutSecretaire->setAssociationId($this->getId());
    $statutSecretaire->setLabel('Secrétaire');
    $statutSecretaire->save();

    $statutMembreActif = new Status();
    $statutMembreActif->setState(StatusTable::STATE_ENABLED);
    $statutMembreActif->setAssociationId($this->getId());
    $statutMembreActif->setLabel('Membre actif');
    $statutMembreActif->save();

    $statutMembreDhonneur = new Status();
    $statutMembreDhonneur->setState(StatusTable::STATE_ENABLED);
    $statutMembreDhonneur->setAssociationId($this->getId());
    $statutMembreDhonneur->setLabel('Membre d\'honneur');
    $statutMembreDhonneur->save();

    $activiteGeneral = new Activity();
    $activiteGeneral->setState(ActivityTable::STATE_ENABLED);
    $activiteGeneral->setLabel("Fonctionnement général de l'association");
    $activiteGeneral->setAssociationId($this->getId());
    $activiteGeneral->save();

    $compteMonnaie = new Account();
    $compteMonnaie->setAssociationId($this->getId());
    $compteMonnaie->setLabel("Caisse de monnaie");
    $compteMonnaie->setReference("CAISSE_MONNAIE");
    $compteMonnaie->setState(AccountTable::STATE_ENABLED);
    $compteMonnaie->save();

  }
}