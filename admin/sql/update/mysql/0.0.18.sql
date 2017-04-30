ALTER TABLE `#__ddc_vendor_products` ADD COLUMN `product_type` int(11) NOT NULL DEFAULT '0' AFTER `product_id`;
ALTER TABLE `#__ddc_vendor_products` ADD COLUMN `distrib_cat_id` int(11) NOT NULL DEFAULT '0' AFTER `product_type`;
ALTER TABLE `#__ddc_vendors` ADD COLUMN `allow_bookings` int(3) NOT NULL DEFAULT '0' AFTER `services`;
