
-- Fixe les types des champs de montant

ALTER TABLE `cotisation` ADD `montant` DECIMAL( 10, 2 ) NOT NULL AFTER `cotisation_type_id` ;
ALTER TABLE `depense` ADD `montant` DECIMAL( 10, 2 ) NOT NULL AFTER `libelle` ;
ALTER TABLE `recette` ADD `montant` DECIMAL( 10, 2 ) NOT NULL AFTER `libelle` ;

-- Rajoute 2 nouveaux champs dans les tables recettes et depenses

ALTER TABLE `depense` ADD `payee` TINYINT( 4 ) NOT NULL DEFAULT '1' AFTER `date` ;
ALTER TABLE `recette` ADD `percue` TINYINT( 4 ) NOT NULL DEFAULT '1' AFTER `date` ;

-- Tables permettant de gerer les droits utilisateur

CREATE TABLE IF NOT EXISTS `acl_action` (
  `id` int(11) NOT NULL auto_increment,
  `acl_module_id` int(11) default NULL,
  `libelle` varchar(255) NOT NULL,
  `code` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `acl_action_FI_1` (`acl_module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `acl_credential` (
  `id` int(11) NOT NULL auto_increment,
  `membre_id` int(11) default NULL,
  `acl_action_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `acl_credential_FI_1` (`membre_id`),
  KEY `acl_credential_FI_2` (`acl_action_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `acl_module` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

ALTER TABLE `acl_action`
  ADD CONSTRAINT `acl_action_FK_1` FOREIGN KEY (`acl_module_id`) REFERENCES `acl_module` (`id`);

ALTER TABLE `acl_credential`
  ADD CONSTRAINT `acl_credential_FK_1` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id`),
  ADD CONSTRAINT `acl_credential_FK_2` FOREIGN KEY (`acl_action_id`) REFERENCES `acl_action` (`id`);
  
  
-- Modules et droits accordables aux utilisateurs

  INSERT INTO `acl_module` (`id`, `libelle`) VALUES
(1, 'Association'),
(2, 'Membre'),
(3, 'Compte'),
(4, 'Activité'),
(5, 'Dépense'),
(6, 'Recette'),
(7, 'Cotisations'),
(8, 'Statuts');


INSERT INTO `acl_action` (`id`, `acl_module_id`, `libelle`, `code`) VALUES
(1, 1, 'Éditer l''association', 'edit_association'),
(2, 1, 'Utiliser l''outil de mailing', 'mailing'),
(3, 1, 'Utiliser l''outil d''export', 'export'),
(4, 1, 'Voir les bilans', 'bilan'),
(5, 4, 'Enregistrer une activité', 'add_activite'),
(6, 4, 'Éditer une activité', 'edit_activite'),
(7, 4, 'Supprimer une activité', 'del_activite'),
(8, 4, 'Lister les activités', 'list_activite'),
(9, 4, 'Voir les détails d''une activités', 'show_activite'),
(10, 2, 'Enregistrer un membre', 'add_membre'),
(11, 2, 'Éditer un membre', 'edit_membre'),
(12, 2, 'Supprimer un membre', 'del_membre'),
(13, 2, 'Lister les membres', 'list_membre'),
(14, 2, 'Afficher les détails d''un membre', 'show_membre'),
(15, 8, 'Ajouter un statut', 'add_statut'),
(16, 8, 'Éditer un statut', 'edit_statut'),
(17, 8, 'Supprimer un statut', 'del_statut'),
(18, 8, 'Lister les statuts', 'list_statut'),
(19, 7, 'Enregistrer une cotisation', 'add_cotisation'),
(20, 7, 'Éditer une cotisation', 'edit_cotisation'),
(21, 7, 'Supprimer une cotisation', 'del_cotisation'),
(22, 7, 'Lister les cotisations', 'list_cotisation'),
(23, 7, 'Gérer les types de cotisations', 'config_cotisations'),
(24, 3, 'Enregistrer un compte', 'add_compte'),
(25, 3, 'Éditer un compte', 'edit_compte'),
(26, 3, 'Supprimer un compte', 'del_compte'),
(27, 3, 'Lister les comptes', 'list_compte'),
(28, 6, 'Enregistrer une recette', 'add_recette'),
(29, 6, 'Éditer une recette', 'edit_recette'),
(30, 6, 'Supprimer une recette', 'del_recette'),
(31, 6, 'Lister les recettes', 'list_recette'),
(32, 5, 'Enregistrer une dépense', 'add_depense'),
(33, 5, 'Éditer une dépense', 'edit_depense'),
(34, 5, 'Supprimer une dépense', 'del_depense'),
(35, 5, 'Lister les dépenses', 'list_depense');
