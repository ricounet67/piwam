-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Sam 06 Juin 2009 à 13:29
-- Version du serveur: 5.0.67
-- Version de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `piwam`
--

-- --------------------------------------------------------

--
-- Structure de la table `acl_action`
--

CREATE TABLE IF NOT EXISTS `acl_action` (
  `id` int(11) NOT NULL auto_increment,
  `acl_module_id` int(11) default NULL,
  `libelle` varchar(255) NOT NULL,
  `code` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `acl_action_FI_1` (`acl_module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `acl_credential`
--

CREATE TABLE IF NOT EXISTS `acl_credential` (
  `id` int(11) NOT NULL auto_increment,
  `membre_id` int(11) default NULL,
  `acl_action_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `acl_credential_FI_1` (`membre_id`),
  KEY `acl_credential_FI_2` (`acl_action_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `acl_module`
--

CREATE TABLE IF NOT EXISTS `acl_module` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

CREATE TABLE IF NOT EXISTS `activite` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) NOT NULL,
  `actif` tinyint(4) default '1',
  `association_id` int(11) NOT NULL,
  `enregistre_par` int(11) default NULL,
  `mis_a_jour_par` int(11) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `activite_FI_1` (`association_id`),
  KEY `activite_FI_2` (`enregistre_par`),
  KEY `activite_FI_3` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `association`
--

CREATE TABLE IF NOT EXISTS `association` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(120) NOT NULL,
  `description` varchar(255) default NULL,
  `site_web` varchar(255) default NULL,
  `enregistre_par` int(11) default NULL,
  `mis_a_jour_par` int(11) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `association_FI_1` (`enregistre_par`),
  KEY `association_FI_2` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE IF NOT EXISTS `compte` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) NOT NULL,
  `association_id` int(11) NOT NULL,
  `reference` varchar(64) NOT NULL,
  `actif` tinyint(4) default '1',
  `enregistre_par` int(11) default NULL,
  `mis_a_jour_par` int(11) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `compte_FI_1` (`association_id`),
  KEY `compte_FI_2` (`enregistre_par`),
  KEY `compte_FI_3` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cotisation`
--

CREATE TABLE IF NOT EXISTS `cotisation` (
  `id` int(11) NOT NULL auto_increment,
  `compte_id` int(11) NOT NULL,
  `cotisation_type_id` int(11) NOT NULL,
  `membre_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `enregistre_par` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `mis_a_jour_par` int(11) NOT NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `cotisation_FI_1` (`compte_id`),
  KEY `cotisation_FI_2` (`cotisation_type_id`),
  KEY `cotisation_FI_3` (`membre_id`),
  KEY `cotisation_FI_4` (`enregistre_par`),
  KEY `cotisation_FI_5` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cotisation_type`
--

CREATE TABLE IF NOT EXISTS `cotisation_type` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) NOT NULL,
  `association_id` int(11) NOT NULL,
  `valide` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `actif` tinyint(4) default '1',
  `enregistre_par` int(11) NOT NULL,
  `mis_a_jour_par` int(11) NOT NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `cotisation_type_FI_1` (`association_id`),
  KEY `cotisation_type_FI_2` (`enregistre_par`),
  KEY `cotisation_type_FI_3` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

CREATE TABLE IF NOT EXISTS `depense` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `association_id` int(11) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `activite_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `payee` tinyint(4) NOT NULL default '1',
  `enregistre_par` int(11) NOT NULL,
  `mis_a_jour_par` int(11) NOT NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `depense_FI_1` (`association_id`),
  KEY `depense_FI_2` (`compte_id`),
  KEY `depense_FI_3` (`activite_id`),
  KEY `depense_FI_4` (`enregistre_par`),
  KEY `depense_FI_5` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `pseudo` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `statut_id` int(11) NOT NULL,
  `date_inscription` date NOT NULL,
  `exempte_cotisation` tinyint(4) NOT NULL,
  `rue` varchar(255) default NULL,
  `cp` varchar(8) default NULL,
  `ville` varchar(255) default NULL,
  `pays` varchar(8) default NULL,
  `email` varchar(255) default NULL,
  `website` varchar(255) default NULL,
  `tel_fixe` varchar(16) default NULL,
  `tel_portable` varchar(16) default NULL,
  `actif` tinyint(4) default '1',
  `association_id` int(11) NOT NULL,
  `enregistre_par` int(11) default NULL,
  `mis_a_jour_par` int(11) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `membre_U_1` (`pseudo`),
  KEY `membre_FI_1` (`statut_id`),
  KEY `membre_FI_2` (`association_id`),
  KEY `membre_FI_3` (`enregistre_par`),
  KEY `membre_FI_4` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

CREATE TABLE IF NOT EXISTS `recette` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) NOT NULL,
  `association_id` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `activite_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `percue` tinyint(4) NOT NULL default '1',
  `enregistre_par` int(11) NOT NULL,
  `mis_a_jour_par` int(11) NOT NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `recette_FI_1` (`association_id`),
  KEY `recette_FI_2` (`compte_id`),
  KEY `recette_FI_3` (`activite_id`),
  KEY `recette_FI_4` (`enregistre_par`),
  KEY `recette_FI_5` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE IF NOT EXISTS `statut` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(255) NOT NULL,
  `association_id` int(11) NOT NULL,
  `actif` tinyint(4) default '1',
  `enregistre_par` int(11) default NULL,
  `mis_a_jour_par` int(11) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `statut_FI_1` (`association_id`),
  KEY `statut_FI_2` (`enregistre_par`),
  KEY `statut_FI_3` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `acl_action`
--
ALTER TABLE `acl_action`
  ADD CONSTRAINT `acl_action_FK_1` FOREIGN KEY (`acl_module_id`) REFERENCES `acl_module` (`id`);

--
-- Contraintes pour la table `acl_credential`
--
ALTER TABLE `acl_credential`
  ADD CONSTRAINT `acl_credential_FK_1` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id`),
  ADD CONSTRAINT `acl_credential_FK_2` FOREIGN KEY (`acl_action_id`) REFERENCES `acl_action` (`id`);

--
-- Contraintes pour la table `activite`
--
ALTER TABLE `activite`
  ADD CONSTRAINT `activite_FK_1` FOREIGN KEY (`association_id`) REFERENCES `association` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activite_FK_2` FOREIGN KEY (`enregistre_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activite_FK_3` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `association`
--
ALTER TABLE `association`
  ADD CONSTRAINT `association_FK_1` FOREIGN KEY (`enregistre_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `association_FK_2` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `compte`
--
ALTER TABLE `compte`
  ADD CONSTRAINT `compte_FK_1` FOREIGN KEY (`association_id`) REFERENCES `association` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compte_FK_2` FOREIGN KEY (`enregistre_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compte_FK_3` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cotisation`
--
ALTER TABLE `cotisation`
  ADD CONSTRAINT `cotisation_FK_1` FOREIGN KEY (`compte_id`) REFERENCES `compte` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotisation_FK_2` FOREIGN KEY (`cotisation_type_id`) REFERENCES `cotisation_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotisation_FK_3` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotisation_FK_4` FOREIGN KEY (`enregistre_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotisation_FK_5` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cotisation_type`
--
ALTER TABLE `cotisation_type`
  ADD CONSTRAINT `cotisation_type_FK_1` FOREIGN KEY (`association_id`) REFERENCES `association` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotisation_type_FK_2` FOREIGN KEY (`enregistre_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotisation_type_FK_3` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `depense`
--
ALTER TABLE `depense`
  ADD CONSTRAINT `depense_FK_1` FOREIGN KEY (`association_id`) REFERENCES `association` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `depense_FK_2` FOREIGN KEY (`compte_id`) REFERENCES `compte` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `depense_FK_3` FOREIGN KEY (`activite_id`) REFERENCES `activite` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `depense_FK_4` FOREIGN KEY (`enregistre_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `depense_FK_5` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `membre`
--
ALTER TABLE `membre`
  ADD CONSTRAINT `membre_FK_1` FOREIGN KEY (`statut_id`) REFERENCES `statut` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `membre_FK_2` FOREIGN KEY (`association_id`) REFERENCES `association` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `membre_FK_3` FOREIGN KEY (`enregistre_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `membre_FK_4` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `recette`
--
ALTER TABLE `recette`
  ADD CONSTRAINT `recette_FK_1` FOREIGN KEY (`association_id`) REFERENCES `association` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recette_FK_2` FOREIGN KEY (`compte_id`) REFERENCES `compte` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recette_FK_3` FOREIGN KEY (`activite_id`) REFERENCES `activite` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recette_FK_4` FOREIGN KEY (`enregistre_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recette_FK_5` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `statut`
--
ALTER TABLE `statut`
  ADD CONSTRAINT `statut_FK_1` FOREIGN KEY (`association_id`) REFERENCES `association` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `statut_FK_2` FOREIGN KEY (`enregistre_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `statut_FK_3` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `membre` (`id`) ON DELETE CASCADE;

  

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