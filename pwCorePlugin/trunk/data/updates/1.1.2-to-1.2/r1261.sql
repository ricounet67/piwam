-- Set date fields as nullable

ALTER TABLE `piwam_due_type` CHANGE `start_period` `start_period` DATE NULL DEFAULT NULL ,
CHANGE `end_period` `end_period` DATE NULL DEFAULT NULL