--
-- Rajoute des suppressions en cascade pour faciliter la gestion
--

ALTER TABLE  `acl_action` DROP FOREIGN KEY  `acl_action_ibfk_1` ;

ALTER TABLE  `acl_action` ADD FOREIGN KEY (  `acl_module_id` ) REFERENCES  `piwam-test`.`acl_module` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `config_variable` DROP FOREIGN KEY  `config_variable_FK_1` ;

ALTER TABLE  `config_variable` ADD FOREIGN KEY (  `categorie_code` ) REFERENCES  `piwam-test`.`config_categorie` (
`code`
) ON DELETE CASCADE ON UPDATE CASCADE ;