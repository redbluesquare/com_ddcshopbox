ALTER TABLE `#__ddc_shoppingcart_details` 
CHANGE COLUMN `modified` `modified_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ;
ALTER TABLE `#__ddc_shoppingcart_details` 
CHANGE COLUMN `created` `created_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ;
ALTER TABLE `#__ddc_shoppingcart_details` 
ADD COLUMN `product_quantity` DOUBLE NOT NULL DEFAULT '0.00' AFTER `price`;