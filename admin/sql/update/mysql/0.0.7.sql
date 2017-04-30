ALTER TABLE `#__ddc_shoppingcart_headers` ADD COLUMN `comment` VARCHAR(250) NULL AFTER `modified_on`;
ALTER TABLE `#__ddc_shoppingcart_details` ADD COLUMN `comment` VARCHAR(250) NULL AFTER `hits`;