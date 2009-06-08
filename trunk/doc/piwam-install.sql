-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 08 Juin 2009 à 22:50
-- Version du serveur: 5.0.67
-- Version de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  `code` varchar(100) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `acl_action_FI_1` (`acl_module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `acl_action`
--

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
(35, 5, 'Lister les dépenses', 'list_depense'),
(36, 2, 'Gérer les droits', 'edit_acl');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `acl_credential`
--


-- --------------------------------------------------------

--
-- Structure de la table `acl_module`
--

CREATE TABLE IF NOT EXISTS `acl_module` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `acl_module`
--

INSERT INTO `acl_module` (`id`, `libelle`) VALUES
(1, 'Association'),
(2, 'Membre'),
(3, 'Compte'),
(4, 'Activité'),
(5, 'Dépense'),
(6, 'Recette'),
(7, 'Cotisations'),
(8, 'Statuts');

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

CREATE TABLE IF NOT EXISTS `activite` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `activite`
--


-- --------------------------------------------------------

--
-- Structure de la table `association`
--

CREATE TABLE IF NOT EXISTS `association` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(120) collate utf8_bin NOT NULL,
  `description` varchar(255) collate utf8_bin default NULL,
  `site_web` varchar(255) collate utf8_bin default NULL,
  `enregistre_par` int(11) default NULL,
  `mis_a_jour_par` int(11) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `association_FI_1` (`enregistre_par`),
  KEY `association_FI_2` (`mis_a_jour_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `association`
--


-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE IF NOT EXISTS `compte` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  `association_id` int(11) NOT NULL,
  `reference` varchar(64) collate utf8_bin NOT NULL,
  `actif` tinyint(4) default '1',
  `enregistre_par` int(11) default NULL,
  `mis_a_jour_par` int(11) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `compte_FI_1` (`association_id`),
  KEY `compte_FI_2` (`enregistre_par`),
  KEY `compte_FI_3` (`mis_a_jour_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `compte`
--


-- --------------------------------------------------------

--
-- Structure de la table `config_categorie`
--

CREATE TABLE IF NOT EXISTS `config_categorie` (
  `code` varchar(25) collate utf8_bin NOT NULL,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `config_categorie`
--

INSERT INTO `config_categorie` (`code`, `libelle`) VALUES
('affichage', 'Affichage'),
('mailing', 'Mailing');

-- --------------------------------------------------------

--
-- Structure de la table `config_value`
--

CREATE TABLE IF NOT EXISTS `config_value` (
  `config_variable_id` int(11) NOT NULL,
  `association_id` int(11) NOT NULL,
  `custom_value` varchar(255) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`config_variable_id`,`association_id`),
  KEY `config_value_FI_2` (`association_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `config_value`
--


-- --------------------------------------------------------

--
-- Structure de la table `config_variable`
--

CREATE TABLE IF NOT EXISTS `config_variable` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(25) collate utf8_bin NOT NULL,
  `categorie_code` varchar(25) collate utf8_bin NOT NULL,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  `description` text collate utf8_bin,
  `type` varchar(255) collate utf8_bin NOT NULL,
  `default_value` varchar(255) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `config_variable_FI_1` (`categorie_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `config_variable`
--

INSERT INTO `config_variable` (`id`, `code`, `categorie_code`, `libelle`, `description`, `type`, `default_value`) VALUES
(1, 'address', 'mailing', 'Adresse expéditeur', 0x4c657320656d61696c7320656e766f79c3a97320617070617261c3ae74726f6e7420636f6d6d6520657870c3a96469c3a973206176656320636574746520616472657373652e, 'EMAIL', 'info@piwam.org'),
(2, 'method', 'mailing', 'Méthode', 0x4dc3a974686f64652061766563206c617175656c6c65207365726f6e7420656e766f79c3a973206c657320652d6d61696c73, '{mail,smtp,gmail,sendmail}', 'mail'),
(3, 'gmail_username', 'mailing', 'Gmail: Identifiant', 0x4164726573736520474d61696c2064616e73206c65206361647265206427756e20656e766f69206176656320474d61696c, 'EMAIL', ''),
(4, 'gmail_password', 'mailing', 'GMail: Password', 0x4d6f7420646520706173736520706f757220656e766f796572206c6573206d61696c732076696120474d61696c, 'VARCHAR', ''),
(5, 'smtp_server', 'mailing', 'SMTP: Serveur', 0x5365727665757220534d5450207574696c6973c3a920706f7572206c27656e766f69206465206d61696c73, 'VARCHAR', ''),
(6, 'smtp_username', 'mailing', 'SMTP: Identifiant', 0x4964656e74696669616e7420706f757220736520636f6e6e6563746572206175207365727665757220534d5450, 'VARCHAR', ''),
(7, 'smtp_password', 'mailing', 'SMTP: Mot de passe', 0x4d6f74206465207061737365207574696c6973c3a920706f757220736520636f6e6e6563746572206175207365727665757220534d54502e, 'VARCHAR', ''),
(8, 'sendmail_path', 'mailing', 'Sendmail', 0x416363c3a8732061752062696e616972652053656e646d61696c, 'VARCHAR', '/usr/bin/sendmail'),
(9, 'users_by_page', 'affichage', 'Membres par page', 0x4e6f6d627265206465206d656d6272657320c3a02061666669636865722070617220706167652064616e73206c65206c697374696e672e, 'INTEGER', '20');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `cotisation`
--


-- --------------------------------------------------------

--
-- Structure de la table `cotisation_type`
--

CREATE TABLE IF NOT EXISTS `cotisation_type` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `cotisation_type`
--


-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

CREATE TABLE IF NOT EXISTS `depense` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `association_id` int(11) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `activite_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `payee` tinyint(4) default '1',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `depense`
--


-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(255) collate utf8_bin NOT NULL,
  `prenom` varchar(255) collate utf8_bin NOT NULL,
  `pseudo` varchar(255) collate utf8_bin default NULL,
  `password` varchar(255) collate utf8_bin default NULL,
  `statut_id` int(11) NOT NULL,
  `date_inscription` date NOT NULL,
  `exempte_cotisation` tinyint(4) NOT NULL,
  `rue` varchar(255) collate utf8_bin default NULL,
  `cp` varchar(8) collate utf8_bin default NULL,
  `ville` varchar(255) collate utf8_bin default NULL,
  `pays` varchar(8) collate utf8_bin default NULL,
  `email` varchar(255) collate utf8_bin default NULL,
  `website` varchar(255) collate utf8_bin default NULL,
  `tel_fixe` varchar(16) collate utf8_bin default NULL,
  `tel_portable` varchar(16) collate utf8_bin default NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `membre`
--


-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

CREATE TABLE IF NOT EXISTS `recette` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  `association_id` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `activite_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `percue` tinyint(4) default '1',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `recette`
--


-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE IF NOT EXISTS `statut` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(255) collate utf8_bin NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `statut`
--


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
-- Contraintes pour la table `config_value`
--
ALTER TABLE `config_value`
  ADD CONSTRAINT `config_value_FK_1` FOREIGN KEY (`config_variable_id`) REFERENCES `config_variable` (`id`),
  ADD CONSTRAINT `config_value_FK_2` FOREIGN KEY (`association_id`) REFERENCES `association` (`id`);

--
-- Contraintes pour la table `config_variable`
--
ALTER TABLE `config_variable`
  ADD CONSTRAINT `config_variable_FK_1` FOREIGN KEY (`categorie_code`) REFERENCES `config_categorie` (`code`);

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
