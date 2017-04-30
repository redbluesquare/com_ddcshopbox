ALTER TABLE `#__ddc_vendors` ADD COLUMN `contact_numbers` varchar(500) NOT NULL DEFAULT '{}' AFTER `country`;
ALTER TABLE `#__ddc_vendors` ADD COLUMN `vendor_details` text NULL DEFAULT '' AFTER `contact_numbers`;
