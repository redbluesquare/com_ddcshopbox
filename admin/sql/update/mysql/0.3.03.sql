ALTER TABLE `#__ddc_postings` 
ADD COLUMN `category` INT(11) NOT NULL DEFAULT '0' AFTER `product_id`,
CHANGE COLUMN `ddc_posting_id` `ddc_posting_id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `vendor_id` `vendor_id` INT(11) NOT NULL DEFAULT '0' ,
CHANGE COLUMN `product_id` `product_id` INT(11) NOT NULL DEFAULT '0' ,
CHANGE COLUMN `posting_parent` `posting_parent` INT(11) NOT NULL DEFAULT '0' ,
CHANGE COLUMN `lastip` `lastip` VARCHAR(50) NOT NULL DEFAULT '0' ,
CHANGE COLUMN `state` `state` TINYINT(3) NOT NULL DEFAULT '0' ,
CHANGE COLUMN `modified` `modified_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ;