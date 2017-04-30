ALTER TABLE `#__ddc_user_vendor_interests` 
CHANGE COLUMN `ddc_vendor_1` `ddc_vendor` INT(11) NULL DEFAULT '0' ,
CHANGE COLUMN `ddc_vendor_2` `ip_address` VARCHAR(60) NULL DEFAULT NULL ,
CHANGE COLUMN `ddc_vendor_3` `user_id` INT(11) NULL DEFAULT '0' ;