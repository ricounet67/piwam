RENAME TABLE `piwam_statut`  TO `piwam_status` ;
RENAME TABLE `piwam_recette`  TO `piwam_income` ;
RENAME TABLE `piwam_depense`  TO `piwam_expense` ;
RENAME TABLE `piwam_activite`  TO `piwam_activity` ;
RENAME TABLE `piwam_compte`  TO `piwam_account` ;
RENAME TABLE `piwam_cotisation`  TO `piwam_due` ;
RENAME TABLE `piwam_cotisation_type`  TO `piwam_due_type` ;
RENAME TABLE `piwam_config_categorie`  TO `piwam_config_category` ;
RENAME TABLE `piwam_membre`  TO `piwam_member` ;

ALTER TABLE `piwam_status`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_income`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_expense`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_activity`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_account`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_due`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_due_type`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_config_category`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_member`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_acl_action`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_acl_credential`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_acl_module`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_association`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_data`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_config_value`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `piwam_config_variable`  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;




ALTER TABLE `piwam_due` DROP FOREIGN KEY `cotisation_FK_1` ;
ALTER TABLE `piwam_due` DROP FOREIGN KEY `cotisation_FK_2` ;
ALTER TABLE `piwam_due` DROP FOREIGN KEY `cotisation_FK_3` ;
ALTER TABLE `piwam_due` DROP FOREIGN KEY `cotisation_FK_4` ;
ALTER TABLE `piwam_due` DROP FOREIGN KEY `cotisation_FK_5` ;

ALTER TABLE `piwam_due` CHANGE `compte_id` `account_id` INT( 11 ) NOT NULL;
ALTER TABLE `piwam_due` CHANGE `membre_id` `member_id` INT( 11 ) NOT NULL;
ALTER TABLE `piwam_due` CHANGE `cotisation_type_id` `due_type_id` INT( 11 ) NOT NULL;
ALTER TABLE `piwam_due` CHANGE `enregistre_par` `created_by` INT( 11 ) NOT NULL;
ALTER TABLE `piwam_due` CHANGE `mise_a_jour_par` `updated_by` INT( 11 ) NOT NULL;





ALTER TABLE `piwam_due_type` DROP FOREIGN KEY `cotisation_type_FK_1` ;
ALTER TABLE `piwam_due_type` DROP FOREIGN KEY `cotisation_type_FK_2` ;
ALTER TABLE `piwam_due_type` DROP FOREIGN KEY `cotisation_type_FK_3` ;

ALTER TABLE `piwam_due_type` CHANGE `valide` `period` INT( 11 ) NOT NULL ,
CHANGE `montant` `amount` DECIMAL( 10, 2 ) NOT NULL ,
CHANGE `actif` `state` TINYINT( 4 ) NULL DEFAULT '1',
CHANGE `enregistre_par` `created_by` INT( 11 ) NOT NULL ,
CHANGE `mis_a_jour_par` `updated_by` INT( 11 ) NULL DEFAULT NULL ;





ALTER TABLE `piwam_account` DROP FOREIGN KEY `compte_FK_1` ;
ALTER TABLE `piwam_account` DROP FOREIGN KEY `compte_FK_2` ;
ALTER TABLE `piwam_account` DROP FOREIGN KEY `compte_FK_3` ;

ALTER TABLE `piwam_account` CHANGE `libelle` `label` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
CHANGE `actif` `state` TINYINT( 4 ) NULL DEFAULT '1',
CHANGE `enregistre_par` `created_by` INT( 11 ) NULL DEFAULT NULL ,
CHANGE `mis_a_jour_par` `updated_by` INT( 11 ) NULL DEFAULT NULL ;





ALTER TABLE `piwam_acl_action` CHANGE `libelle` `label` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;
ALTER TABLE `piwam_acl_credential` DROP FOREIGN KEY `piwam_acl_credential_ibfk_1` ;
ALTER TABLE `piwam_acl_credential` CHANGE `membre_id` `member_id` INT( 11 ) NULL DEFAULT NULL ;
ALTER TABLE `piwam_acl_module` CHANGE `libelle` `label` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;

ALTER TABLE `piwam_activity` CHANGE `libelle` `label` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
CHANGE `actif` `state` TINYINT( 4 ) NULL DEFAULT '1',
CHANGE `enregistre_par` `created_by` INT( 11 ) NULL DEFAULT NULL ,
CHANGE `mis_a_jour_par` `updated_by` INT( 11 ) NULL DEFAULT NULL ;



ALTER TABLE `piwam_association` DROP FOREIGN KEY `association_FK_1` ;
ALTER TABLE `piwam_association` DROP FOREIGN KEY `association_FK_2` ;

ALTER TABLE `piwam_association` CHANGE `nom` `name` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
CHANGE `site_web` `website` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL ,
CHANGE `enregistre_par` `created_by` INT( 11 ) NULL DEFAULT NULL ,
CHANGE `mis_a_jour_par` `updated_by` INT( 11 ) NULL DEFAULT NULL ;



ALTER TABLE `piwam_config_category` CHANGE `libelle` `label` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;

ALTER TABLE `piwam_config_variable` CHANGE `categorie_code` `category_code` VARCHAR( 25 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
CHANGE `libelle` `label` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;


ALTER TABLE `piwam_data` CHANGE `key` `config_key` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;
ALTER TABLE `piwam_due` CHANGE `montant` `amount` DECIMAL( 10, 2 ) NOT NULL ;
ALTER TABLE `piwam_due_type` CHANGE `libelle` `label` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;



ALTER TABLE `piwam_expense` DROP FOREIGN KEY `depense_FK_1` ;
ALTER TABLE `piwam_expense` DROP FOREIGN KEY `depense_FK_2` ;
ALTER TABLE `piwam_expense` DROP FOREIGN KEY `depense_FK_3` ;
ALTER TABLE `piwam_expense` DROP FOREIGN KEY `depense_FK_4` ;
ALTER TABLE `piwam_expense` DROP FOREIGN KEY `depense_FK_5` ;

ALTER TABLE `piwam_expense` CHANGE `libelle` `label` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
CHANGE `montant` `amount` DECIMAL( 10, 2 ) NOT NULL ,
CHANGE `compte_id` `account_id` INT( 11 ) NOT NULL ,
CHANGE `activite_id` `activity_id` INT( 11 ) NOT NULL ,
CHANGE `payee` `paid` TINYINT( 4 ) NULL DEFAULT '1',
CHANGE `enregistre_par` `created_by` INT( 11 ) NOT NULL ,
CHANGE `mis_a_jour_par` `updated_by` INT( 11 ) NOT NULL ;




ALTER TABLE `piwam_income` DROP FOREIGN KEY `recette_FK_1` ;
ALTER TABLE `piwam_income` DROP FOREIGN KEY `recette_FK_2` ;
ALTER TABLE `piwam_income` DROP FOREIGN KEY `recette_FK_3` ;
ALTER TABLE `piwam_income` DROP FOREIGN KEY `recette_FK_4` ;
ALTER TABLE `piwam_income` DROP FOREIGN KEY `recette_FK_5` ;

ALTER TABLE `piwam_income` CHANGE `libelle` `label` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
CHANGE `montant` `amount` DECIMAL( 10, 2 ) NOT NULL ,
CHANGE `compte_id` `account_id` INT( 11 ) NOT NULL ,
CHANGE `activite_id` `activity_id` INT( 11 ) NOT NULL ,
CHANGE `percue` `received` TINYINT( 4 ) NULL DEFAULT '1',
CHANGE `enregistre_par` `created_by` INT( 11 ) NOT NULL ,
CHANGE `mis_a_jour_par` `updated_by` INT( 11 ) NOT NULL ;



ALTER TABLE `piwam_member` DROP FOREIGN KEY `membre_FK_1` ;
ALTER TABLE `piwam_member` DROP FOREIGN KEY `membre_FK_2` ;
ALTER TABLE `piwam_member` DROP FOREIGN KEY `membre_FK_3` ;
ALTER TABLE `piwam_member` DROP FOREIGN KEY `membre_FK_4` ;

ALTER TABLE `piwam_member` CHANGE `nom` `lastname` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, 
CHANGE `prenom` `firstname` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL, 
CHANGE `pseudo` `username` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, 
CHANGE `statut_id` `status_id` INT(11) NOT NULL, 
CHANGE `date_inscription` `subscription_date` DATE NOT NULL, 
CHANGE `exempte_cotisation` `due_exempt` TINYINT(4) NOT NULL, 
CHANGE `rue` `street` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL, 
CHANGE `cp` `zipcode` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL, 
CHANGE `ville` `city` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL, 
CHANGE `pays` `country` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL, 
CHANGE `tel_fixe` `phone_home` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL, 
CHANGE `tel_portable` `phone_mobile` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
CHANGE `actif` `state` TINYINT( 4 ) NULL DEFAULT '1',
CHANGE `enregistre_par` `created_by` INT( 11 ) NOT NULL ,
CHANGE `mis_a_jour_par` `updated_by` INT( 11 ) NOT NULL ;




ALTER TABLE `piwam_status` DROP FOREIGN KEY `statut_FK_1` ;
ALTER TABLE `piwam_status` DROP FOREIGN KEY `statut_FK_2` ;
ALTER TABLE `piwam_status` DROP FOREIGN KEY `statut_FK_3` ;

ALTER TABLE `piwam_status` CHANGE `nom` `label` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
CHANGE `actif` `state` TINYINT( 4 ) NULL DEFAULT '1',
CHANGE `enregistre_par` `created_by` INT( 11 ) NULL DEFAULT NULL ,
CHANGE `mis_a_jour_par` `updated_by` INT( 11 ) NULL DEFAULT NULL ;


ALTER TABLE `piwam_due` CHANGE `created_by` `created_by` INT( 11 ) NULL ;
ALTER TABLE `piwam_due_type` CHANGE `created_by` `created_by` INT( 11 ) NULL ;


ALTER TABLE `piwam_expense` CHANGE `created_by` `created_by` INT( 11 ) NULL ,
CHANGE `updated_by` `updated_by` INT( 11 ) NULL ;


ALTER TABLE `piwam_income` CHANGE `created_by` `created_by` INT( 11 ) NULL ,
CHANGE `updated_by` `updated_by` INT( 11 ) NULL ;



ALTER TABLE piwam_account ADD CONSTRAINT piwam_account_updated_by_piwam_member_id FOREIGN KEY (updated_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_account ADD CONSTRAINT piwam_account_created_by_piwam_member_id FOREIGN KEY (created_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_account ADD CONSTRAINT piwam_account_association_id_piwam_association_id FOREIGN KEY (association_id) REFERENCES piwam_association(id) ON DELETE CASCADE;
ALTER TABLE piwam_acl_action ADD CONSTRAINT piwam_acl_action_acl_module_id_piwam_acl_module_id FOREIGN KEY (acl_module_id) REFERENCES piwam_acl_module(id) ON DELETE CASCADE;
ALTER TABLE piwam_acl_credential ADD CONSTRAINT piwam_acl_credential_member_id_piwam_member_id FOREIGN KEY (member_id) REFERENCES piwam_member(id) ON DELETE CASCADE;
ALTER TABLE piwam_acl_credential ADD CONSTRAINT piwam_acl_credential_acl_action_id_piwam_acl_action_id FOREIGN KEY (acl_action_id) REFERENCES piwam_acl_action(id) ON DELETE CASCADE;
ALTER TABLE piwam_activity ADD CONSTRAINT piwam_activity_updated_by_piwam_member_id FOREIGN KEY (updated_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_activity ADD CONSTRAINT piwam_activity_created_by_piwam_member_id FOREIGN KEY (created_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_activity ADD CONSTRAINT piwam_activity_association_id_piwam_association_id FOREIGN KEY (association_id) REFERENCES piwam_association(id) ON DELETE CASCADE;
ALTER TABLE piwam_config_value ADD CONSTRAINT piwam_config_value_config_variable_id_piwam_config_variable_id FOREIGN KEY (config_variable_id) REFERENCES piwam_config_variable(id) ON DELETE CASCADE;
ALTER TABLE piwam_config_value ADD CONSTRAINT piwam_config_value_association_id_piwam_association_id FOREIGN KEY (association_id) REFERENCES piwam_association(id) ON DELETE CASCADE;
ALTER TABLE piwam_config_variable ADD CONSTRAINT piwam_config_variable_category_code_piwam_config_category_code FOREIGN KEY (category_code) REFERENCES piwam_config_category(code) ON DELETE CASCADE;
ALTER TABLE piwam_due ADD CONSTRAINT piwam_due_updated_by_piwam_member_id FOREIGN KEY (updated_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_due ADD CONSTRAINT piwam_due_member_id_piwam_member_id FOREIGN KEY (member_id) REFERENCES piwam_member(id) ON DELETE CASCADE;
ALTER TABLE piwam_due ADD CONSTRAINT piwam_due_due_type_id_piwam_due_type_id FOREIGN KEY (due_type_id) REFERENCES piwam_due_type(id) ON DELETE CASCADE;
ALTER TABLE piwam_due ADD CONSTRAINT piwam_due_created_by_piwam_member_id FOREIGN KEY (created_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_due ADD CONSTRAINT piwam_due_account_id_piwam_account_id FOREIGN KEY (account_id) REFERENCES piwam_account(id) ON DELETE CASCADE;
ALTER TABLE piwam_due_type ADD CONSTRAINT piwam_due_type_updated_by_piwam_member_id FOREIGN KEY (updated_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_due_type ADD CONSTRAINT piwam_due_type_created_by_piwam_member_id FOREIGN KEY (created_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_due_type ADD CONSTRAINT piwam_due_type_association_id_piwam_association_id FOREIGN KEY (association_id) REFERENCES piwam_association(id) ON DELETE CASCADE;
ALTER TABLE piwam_expense ADD CONSTRAINT piwam_expense_updated_by_piwam_member_id FOREIGN KEY (updated_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_expense ADD CONSTRAINT piwam_expense_created_by_piwam_member_id FOREIGN KEY (created_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_expense ADD CONSTRAINT piwam_expense_association_id_piwam_association_id FOREIGN KEY (association_id) REFERENCES piwam_association(id) ON DELETE CASCADE;
ALTER TABLE piwam_expense ADD CONSTRAINT piwam_expense_activity_id_piwam_activity_id FOREIGN KEY (activity_id) REFERENCES piwam_activity(id) ON DELETE CASCADE;
ALTER TABLE piwam_expense ADD CONSTRAINT piwam_expense_account_id_piwam_account_id FOREIGN KEY (account_id) REFERENCES piwam_account(id) ON DELETE CASCADE;
ALTER TABLE piwam_income ADD CONSTRAINT piwam_income_updated_by_piwam_member_id FOREIGN KEY (updated_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_income ADD CONSTRAINT piwam_income_created_by_piwam_member_id FOREIGN KEY (created_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_income ADD CONSTRAINT piwam_income_association_id_piwam_association_id FOREIGN KEY (association_id) REFERENCES piwam_association(id) ON DELETE CASCADE;
ALTER TABLE piwam_income ADD CONSTRAINT piwam_income_activity_id_piwam_activity_id FOREIGN KEY (activity_id) REFERENCES piwam_activity(id) ON DELETE CASCADE;
ALTER TABLE piwam_income ADD CONSTRAINT piwam_income_account_id_piwam_account_id FOREIGN KEY (account_id) REFERENCES piwam_account(id) ON DELETE CASCADE;
ALTER TABLE piwam_member ADD CONSTRAINT piwam_member_updated_by_piwam_member_id FOREIGN KEY (updated_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_member ADD CONSTRAINT piwam_member_status_id_piwam_status_id FOREIGN KEY (status_id) REFERENCES piwam_status(id) ON DELETE CASCADE;
ALTER TABLE piwam_member ADD CONSTRAINT piwam_member_created_by_piwam_member_id FOREIGN KEY (created_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_member ADD CONSTRAINT piwam_member_association_id_piwam_association_id FOREIGN KEY (association_id) REFERENCES piwam_association(id) ON DELETE CASCADE;
ALTER TABLE piwam_status ADD CONSTRAINT piwam_status_updated_by_piwam_member_id FOREIGN KEY (updated_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_status ADD CONSTRAINT piwam_status_created_by_piwam_member_id FOREIGN KEY (created_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_status ADD CONSTRAINT piwam_status_association_id_piwam_association_id FOREIGN KEY (association_id) REFERENCES piwam_association(id) ON DELETE CASCADE;
