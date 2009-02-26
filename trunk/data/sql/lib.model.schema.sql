
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- activite
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `activite`;


CREATE TABLE `activite`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`actif` TINYINT default 1,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- compte
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `compte`;


CREATE TABLE `compte`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`reference` VARCHAR(64)  NOT NULL,
	`actif` TINYINT default 1,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
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
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `cotisation_FI_1` (`compte_id`),
	CONSTRAINT `cotisation_FK_1`
		FOREIGN KEY (`compte_id`)
		REFERENCES `compte` (`id`)
		ON DELETE SET NULL,
	INDEX `cotisation_FI_2` (`cotisation_type_id`),
	CONSTRAINT `cotisation_FK_2`
		FOREIGN KEY (`cotisation_type_id`)
		REFERENCES `cotisation_type` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- cotisation_type
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `cotisation_type`;


CREATE TABLE `cotisation_type`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`valide` INTEGER  NOT NULL,
	`montant` DECIMAL  NOT NULL,
	`actif` TINYINT default 1,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- depense
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `depense`;


CREATE TABLE `depense`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`montant` DECIMAL  NOT NULL,
	`compte_id` INTEGER  NOT NULL,
	`activite_id` INTEGER  NOT NULL,
	`date` DATE  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `depense_FI_1` (`compte_id`),
	CONSTRAINT `depense_FK_1`
		FOREIGN KEY (`compte_id`)
		REFERENCES `compte` (`id`)
		ON DELETE SET NULL,
	INDEX `depense_FI_2` (`activite_id`),
	CONSTRAINT `depense_FK_2`
		FOREIGN KEY (`activite_id`)
		REFERENCES `activite` (`id`)
		ON DELETE SET NULL
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
	`pseudo` VARCHAR(255)  NOT NULL,
	`password` VARCHAR(255)  NOT NULL,
	`statut_id` INTEGER  NOT NULL,
	`dateInscription` DATETIME  NOT NULL,
	`exempteCotis` TINYINT  NOT NULL,
	`rue` VARCHAR(255),
	`cp` VARCHAR(8),
	`ville` VARCHAR(255),
	`pays` VARCHAR(8),
	`email` VARCHAR(255),
	`website` VARCHAR(255),
	`telFixe` VARCHAR(16),
	`telPortable` VARCHAR(16),
	`actif` TINYINT default 1,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `membre_FI_1` (`statut_id`),
	CONSTRAINT `membre_FK_1`
		FOREIGN KEY (`statut_id`)
		REFERENCES `statut` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- recette
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `recette`;


CREATE TABLE `recette`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`montant` DECIMAL  NOT NULL,
	`compte_id` INTEGER  NOT NULL,
	`activite_id` INTEGER  NOT NULL,
	`date` DATE  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `recette_FI_1` (`compte_id`),
	CONSTRAINT `recette_FK_1`
		FOREIGN KEY (`compte_id`)
		REFERENCES `compte` (`id`)
		ON DELETE SET NULL,
	INDEX `recette_FI_2` (`activite_id`),
	CONSTRAINT `recette_FK_2`
		FOREIGN KEY (`activite_id`)
		REFERENCES `activite` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- statut
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `statut`;


CREATE TABLE `statut`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(255)  NOT NULL,
	`actif` TINYINT default 1,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
