-- Create new table to store sent mails


CREATE TABLE piwam_sent_mail (id INT AUTO_INCREMENT, association_id INT NOT NULL, sent_by INT, object VARCHAR(255) NOT NULL, message TEXT NOT NULL, recipients TEXT NOT NULL, success INT NOT NULL, errors INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX association_id_idx (association_id), INDEX sent_by_idx (sent_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
ALTER TABLE piwam_sent_mail ADD CONSTRAINT piwam_sent_mail_sent_by_piwam_member_id FOREIGN KEY (sent_by) REFERENCES piwam_member(id) ON DELETE SET NULL;
ALTER TABLE piwam_sent_mail ADD CONSTRAINT piwam_sent_mail_association_id_piwam_association_id FOREIGN KEY (association_id) REFERENCES piwam_association(id) ON DELETE CASCADE;