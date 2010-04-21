ALTER TABLE `piwam_due_type` ADD `start_period` DATE NOT NULL AFTER `updated_by` ,
ADD `end_period` DATE NOT NULL AFTER `start_period` ;