
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- acl_module
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `acl_module`;


CREATE TABLE `acl_module`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- acl_action
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `acl_action`;


CREATE TABLE `acl_action`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`acl_module_id` INTEGER,
	`libelle` VARCHAR(255)  NOT NULL,
	`code` VARCHAR(100)  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `acl_action_FI_1` (`acl_module_id`),
	CONSTRAINT `acl_action_FK_1`
		FOREIGN KEY (`acl_module_id`)
		REFERENCES `acl_module` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- acl_credential
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `acl_credential`;


CREATE TABLE `acl_credential`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`membre_id` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `acl_credential_FI_1` (`membre_id`),
	CONSTRAINT `acl_credential_FK_1`
		FOREIGN KEY (`membre_id`)
		REFERENCES `membre` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- activite
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `activite`;


CREATE TABLE `activite`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`actif` TINYINT default 1,
	`association_id` INTEGER  NOT NULL,
	`enregistre_par` INTEGER,
	`mis_a_jour_par` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `activite_FI_1` (`association_id`),
	CONSTRAINT `activite_FK_1`
		FOREIGN KEY (`association_id`)
		REFERENCES `association` (`id`)
		ON DELETE CASCADE,
	INDEX `activite_FI_2` (`enregistre_par`),
	CONSTRAINT `activite_FK_2`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE,
	INDEX `activite_FI_3` (`mis_a_jour_par`),
	CONSTRAINT `activite_FK_3`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- association
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `association`;


CREATE TABLE `association`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(120)  NOT NULL,
	`description` VARCHAR(255),
	`site_web` VARCHAR(255),
	`enregistre_par` INTEGER,
	`mis_a_jour_par` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `association_FI_1` (`enregistre_par`),
	CONSTRAINT `association_FK_1`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE,
	INDEX `association_FI_2` (`mis_a_jour_par`),
	CONSTRAINT `association_FK_2`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- compte
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `compte`;


CREATE TABLE `compte`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`association_id` INTEGER  NOT NULL,
	`reference` VARCHAR(64)  NOT NULL,
	`actif` TINYINT default 1,
	`enregistre_par` INTEGER,
	`mis_a_jour_par` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `compte_FI_1` (`association_id`),
	CONSTRAINT `compte_FK_1`
		FOREIGN KEY (`association_id`)
		REFERENCES `association` (`id`)
		ON DELETE CASCADE,
	INDEX `compte_FI_2` (`enregistre_par`),
	CONSTRAINT `compte_FK_2`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE,
	INDEX `compte_FI_3` (`mis_a_jour_par`),
	CONSTRAINT `compte_FK_3`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- cotisation
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `cotisation`;


CREATE TABLE `cotisation`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`compte_id` INTEGER  NOT NULL,
	`cotisation_type_id` INTEGER  NOT NULL,
	`membre_id` INTEGER  NOT NULL,
	`date` DATE  NOT NULL,
	`enregistre_par` INTEGER  NOT NULL,
	`montant` DECIMAL(10,2)  NOT NULL,
	`mis_a_jour_par` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `cotisation_FI_1` (`compte_id`),
	CONSTRAINT `cotisation_FK_1`
		FOREIGN KEY (`compte_id`)
		REFERENCES `compte` (`id`)
		ON DELETE CASCADE,
	INDEX `cotisation_FI_2` (`cotisation_type_id`),
	CONSTRAINT `cotisation_FK_2`
		FOREIGN KEY (`cotisation_type_id`)
		REFERENCES `cotisation_type` (`id`)
		ON DELETE CASCADE,
	INDEX `cotisation_FI_3` (`membre_id`),
	CONSTRAINT `cotisation_FK_3`
		FOREIGN KEY (`membre_id`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE,
	INDEX `cotisation_FI_4` (`enregistre_par`),
	CONSTRAINT `cotisation_FK_4`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE,
	INDEX `cotisation_FI_5` (`mis_a_jour_par`),
	CONSTRAINT `cotisation_FK_5`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- cotisation_type
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `cotisation_type`;


CREATE TABLE `cotisation_type`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`association_id` INTEGER  NOT NULL,
	`valide` INTEGER  NOT NULL,
	`montant` DECIMAL(10,2)  NOT NULL,
	`actif` TINYINT default 1,
	`enregistre_par` INTEGER  NOT NULL,
	`mis_a_jour_par` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `cotisation_type_FI_1` (`association_id`),
	CONSTRAINT `cotisation_type_FK_1`
		FOREIGN KEY (`association_id`)
		REFERENCES `association` (`id`)
		ON DELETE CASCADE,
	INDEX `cotisation_type_FI_2` (`enregistre_par`),
	CONSTRAINT `cotisation_type_FK_2`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE,
	INDEX `cotisation_type_FI_3` (`mis_a_jour_par`),
	CONSTRAINT `cotisation_type_FK_3`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- depense
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `depense`;


CREATE TABLE `depense`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`montant` DECIMAL(10,2)  NOT NULL,
	`association_id` INTEGER  NOT NULL,
	`compte_id` INTEGER  NOT NULL,
	`activite_id` INTEGER  NOT NULL,
	`date` DATE  NOT NULL,
	`enregistre_par` INTEGER  NOT NULL,
	`mis_a_jour_par` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `depense_FI_1` (`association_id`),
	CONSTRAINT `depense_FK_1`
		FOREIGN KEY (`association_id`)
		REFERENCES `association` (`id`)
		ON DELETE CASCADE,
	INDEX `depense_FI_2` (`compte_id`),
	CONSTRAINT `depense_FK_2`
		FOREIGN KEY (`compte_id`)
		REFERENCES `compte` (`id`)
		ON DELETE CASCADE,
	INDEX `depense_FI_3` (`activite_id`),
	CONSTRAINT `depense_FK_3`
		FOREIGN KEY (`activite_id`)
		REFERENCES `activite` (`id`)
		ON DELETE CASCADE,
	INDEX `depense_FI_4` (`enregistre_par`),
	CONSTRAINT `depense_FK_4`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE,
	INDEX `depense_FI_5` (`mis_a_jour_par`),
	CONSTRAINT `depense_FK_5`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- membre
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `membre`;


CREATE TABLE `membre`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(255)  NOT NULL,
	`prenom` VARCHAR(255)  NOT NULL,
	`pseudo` VARCHAR(255),
	`password` VARCHAR(255),
	`statut_id` INTEGER  NOT NULL,
	`date_inscription` DATE  NOT NULL,
	`exempte_cotisation` TINYINT  NOT NULL,
	`rue` VARCHAR(255),
	`cp` VARCHAR(8),
	`ville` VARCHAR(255),
	`pays` VARCHAR(8),
	`email` VARCHAR(255),
	`website` VARCHAR(255),
	`tel_fixe` VARCHAR(16),
	`tel_portable` VARCHAR(16),
	`actif` TINYINT default 1,
	`association_id` INTEGER  NOT NULL,
	`enregistre_par` INTEGER,
	`mis_a_jour_par` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `membre_U_1` (`pseudo`),
	INDEX `membre_FI_1` (`statut_id`),
	CONSTRAINT `membre_FK_1`
		FOREIGN KEY (`statut_id`)
		REFERENCES `statut` (`id`)
		ON DELETE CASCADE,
	INDEX `membre_FI_2` (`association_id`),
	CONSTRAINT `membre_FK_2`
		FOREIGN KEY (`association_id`)
		REFERENCES `association` (`id`)
		ON DELETE CASCADE,
	INDEX `membre_FI_3` (`enregistre_par`),
	CONSTRAINT `membre_FK_3`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE,
	INDEX `membre_FI_4` (`mis_a_jour_par`),
	CONSTRAINT `membre_FK_4`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- recette
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `recette`;


CREATE TABLE `recette`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`association_id` INTEGER  NOT NULL,
	`montant` DECIMAL(10,2)  NOT NULL,
	`compte_id` INTEGER  NOT NULL,
	`activite_id` INTEGER  NOT NULL,
	`date` DATE  NOT NULL,
	`enregistre_par` INTEGER  NOT NULL,
	`mis_a_jour_par` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `recette_FI_1` (`association_id`),
	CONSTRAINT `recette_FK_1`
		FOREIGN KEY (`association_id`)
		REFERENCES `association` (`id`)
		ON DELETE CASCADE,
	INDEX `recette_FI_2` (`compte_id`),
	CONSTRAINT `recette_FK_2`
		FOREIGN KEY (`compte_id`)
		REFERENCES `compte` (`id`)
		ON DELETE CASCADE,
	INDEX `recette_FI_3` (`activite_id`),
	CONSTRAINT `recette_FK_3`
		FOREIGN KEY (`activite_id`)
		REFERENCES `activite` (`id`)
		ON DELETE CASCADE,
	INDEX `recette_FI_4` (`enregistre_par`),
	CONSTRAINT `recette_FK_4`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE,
	INDEX `recette_FI_5` (`mis_a_jour_par`),
	CONSTRAINT `recette_FK_5`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- statut
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `statut`;


CREATE TABLE `statut`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(255)  NOT NULL,
	`association_id` INTEGER  NOT NULL,
	`actif` TINYINT default 1,
	`enregistre_par` INTEGER,
	`mis_a_jour_par` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `statut_FI_1` (`association_id`),
	CONSTRAINT `statut_FK_1`
		FOREIGN KEY (`association_id`)
		REFERENCES `association` (`id`)
		ON DELETE CASCADE,
	INDEX `statut_FI_2` (`enregistre_par`),
	CONSTRAINT `statut_FK_2`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE,
	INDEX `statut_FI_3` (`mis_a_jour_par`),
	CONSTRAINT `statut_FK_3`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
