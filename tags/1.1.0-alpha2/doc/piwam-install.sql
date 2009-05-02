-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Sam 02 Mai 2009 à 22:59
-- Version du serveur: 5.1.33
-- Version de PHP: 5.2.9-2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `piwam`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

CREATE TABLE IF NOT EXISTS `activite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_bin NOT NULL,
  `actif` tinyint(4) DEFAULT '1',
  `association_id` int(11) NOT NULL,
  `enregistre_par` int(11) DEFAULT NULL,
  `mis_a_jour_par` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activite_FI_1` (`association_id`),
  KEY `activite_FI_2` (`enregistre_par`),
  KEY `activite_FI_3` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `association`
--

CREATE TABLE IF NOT EXISTS `association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(120) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `site_web` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `enregistre_par` int(11) DEFAULT NULL,
  `mis_a_jour_par` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `association_FI_1` (`enregistre_par`),
  KEY `association_FI_2` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE IF NOT EXISTS `compte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_bin NOT NULL,
  `association_id` int(11) NOT NULL,
  `reference` varchar(64) COLLATE utf8_bin NOT NULL,
  `actif` tinyint(4) DEFAULT '1',
  `enregistre_par` int(11) DEFAULT NULL,
  `mis_a_jour_par` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `compte_FI_1` (`association_id`),
  KEY `compte_FI_2` (`enregistre_par`),
  KEY `compte_FI_3` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cotisation`
--

CREATE TABLE IF NOT EXISTS `cotisation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `compte_id` int(11) NOT NULL,
  `cotisation_type_id` int(11) NOT NULL,
  `membre_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `enregistre_par` int(11) NOT NULL,
  `mis_a_jour_par` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cotisation_FI_1` (`compte_id`),
  KEY `cotisation_FI_2` (`cotisation_type_id`),
  KEY `cotisation_FI_3` (`membre_id`),
  KEY `cotisation_FI_4` (`enregistre_par`),
  KEY `cotisation_FI_5` (`mis_a_jour_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cotisation_type`
--

CREATE TABLE IF NOT EXISTS `cotisation_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_bin NOT NULL,
  `association_id` int(11) NOT NULL,
  `valide` int(11) NOT NULL,
  `montant` decimal(10,0) NOT NULL,
  `actif` tinyint(4) DEFAULT '1',
  `enregistre_par` int(11) NOT NULL,
  `mis_a_jour_par` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cotisation_type_FI_1` (`association_id`),
  KEY `cotisation_type_FI_2` (`enregistre_par`),
  KEY `cotisation_type_FI_3` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

CREATE TABLE IF NOT EXISTS `depense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_bin NOT NULL,
  `montant` decimal(10,0) NOT NULL,
  `association_id` int(11) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `activite_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `enregistre_par` int(11) NOT NULL,
  `mis_a_jour_par` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `depense_FI_1` (`association_id`),
  KEY `depense_FI_2` (`compte_id`),
  KEY `depense_FI_3` (`activite_id`),
  KEY `depense_FI_4` (`enregistre_par`),
  KEY `depense_FI_5` (`mis_a_jour_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(255) COLLATE utf8_bin NOT NULL,
  `pseudo` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `statut_id` int(11) NOT NULL,
  `date_inscription` date NOT NULL,
  `exempte_cotisation` tinyint(4) NOT NULL,
  `rue` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `cp` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `pays` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `tel_fixe` varchar(16) COLLATE utf8_bin DEFAULT NULL,
  `tel_portable` varchar(16) COLLATE utf8_bin DEFAULT NULL,
  `actif` tinyint(4) DEFAULT '1',
  `association_id` int(11) NOT NULL,
  `enregistre_par` int(11) DEFAULT NULL,
  `mis_a_jour_par` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `membre_U_1` (`pseudo`),
  KEY `membre_FI_1` (`statut_id`),
  KEY `membre_FI_2` (`association_id`),
  KEY `membre_FI_3` (`enregistre_par`),
  KEY `membre_FI_4` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

CREATE TABLE IF NOT EXISTS `recette` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_bin NOT NULL,
  `association_id` int(11) NOT NULL,
  `montant` decimal(10,0) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `activite_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `enregistre_par` int(11) NOT NULL,
  `mis_a_jour_par` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recette_FI_1` (`association_id`),
  KEY `recette_FI_2` (`compte_id`),
  KEY `recette_FI_3` (`activite_id`),
  KEY `recette_FI_4` (`enregistre_par`),
  KEY `recette_FI_5` (`mis_a_jour_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE IF NOT EXISTS `statut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `association_id` int(11) NOT NULL,
  `actif` tinyint(4) DEFAULT '1',
  `enregistre_par` int(11) DEFAULT NULL,
  `mis_a_jour_par` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `statut_FI_1` (`association_id`),
  KEY `statut_FI_2` (`enregistre_par`),
  KEY `statut_FI_3` (`mis_a_jour_par`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contraintes pour les tables exportées
--

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
