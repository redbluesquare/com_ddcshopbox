ALTER TABLE `#__ddc_vendor_products` 
ADD COLUMN `category_id` INT(11) NOT NULL DEFAULT '0' AFTER `product_description`;