ALTER TABLE `#__ddc_shoppingcart_details` 
ADD COLUMN `created_by` INT(11) NOT NULL DEFAULT '0' AFTER `created_on`,
ADD COLUMN `modified_by` INT(11) NOT NULL DEFAULT '0' AFTER `modified_on`;