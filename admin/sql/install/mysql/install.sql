CREATE TABLE IF NOT EXISTS `#__ddc_bookings` (
  `ddc_booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `vendor_product_id` int(11) NOT NULL,
  `checkin_date` date NOT NULL default '0000-00-00',
  `checkin_time` time NOT NULL default '00:00:00',
  `timeframe` double NOT NULL default '0',
  `checkout_date` date NOT NULL default '0000-00-00',
  `checkout_time` time NOT NULL default '00:00:00',
  `terms` tinyint(3) NOT NULL,
  `first_name` varchar(20),
  `last_name` varchar(20),
  `contact_tel` varchar(20),
  `contact_email` varchar(80),
  `num_adults` int(3) NOT NULL,
  `num_children` int(3) NOT NULL,
  `company` varchar(30),
  `flight` varchar(30),
  `airport` varchar(30),
  `arrival_time` time default '00:00:00',
  `representative` varchar(30),
  `source` varchar(100),
  `booked_price` double NOT NULL,
  `notes` text,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(3) NOT NULL,
  PRIMARY KEY (`ddc_booking_id`),
  KEY `user_id` (`user_id`),
  KEY `vendor_id` (`vendor_id`),
  KEY `vendorproduct_id` (`vendorproduct_id`),
  KEY `checkin` (`checkin`),
  KEY `checkout` (`checkout`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_coupons` (
  `ddc_coupon_id` INT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vendor_id` INT(1) UNSIGNED NOT NULL,
  `coupon_code` char(32) NOT NULL DEFAULT '',
  `percent_or_total` varchar(20) NOT NULL DEFAULT 'value',
  `coupon_type` varchar(20) NOT NULL DEFAULT 'gift',
  `coupon_value` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `coupon_start_date` datetime,
  `coupon_expiry_date` datetime,
  `coupon_value_valid` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `coupon_used` varchar(200) NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(1) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(1) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(1) NOT NULL DEFAULT '0',
   PRIMARY KEY (`ddc_coupon_id`),
   KEY `vendor_id` (`vendor_id`),
   KEY `coupon_code` (`coupon_code`),
   KEY `coupon_type` (`coupon_type`),
   KEY `published` (`published`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='Used to store coupon codes' ;

CREATE TABLE IF NOT EXISTS `#__ddc_countries` (
  `ddc_country_id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `worldzone_id` tinyint(1) NOT NULL DEFAULT '1',
  `country_name` char(64),
  `country_3_code` char(3),
  `country_2_code` char(2),
  `ordering` int(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_country_id`),
  KEY `country_3_code` (`country_3_code`),
  KEY `country_2_code` (`country_2_code`),
  KEY `country_name` (`country_name`),
  KEY `ordering` (`ordering`),
  KEY `published` (`published`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='Country records' ;

CREATE TABLE IF NOT EXISTS `#__ddc_currencies` (
  `ddc_currency_id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vendor_id` int(1) UNSIGNED NOT NULL DEFAULT '1',
  `currency_name` char(64),
  `currency_code_2` char(2),
  `currency_code_3` char(3),
  `currency_numeric_code` int(4),
  `currency_exchange_rate` decimal(10,5),
  `currency_symbol` char(4),
  `currency_decimal_place` char(4),
  `currency_decimal_symbol` char(4),
  `currency_thousands` char(4),
  `currency_positive_style` char(64),
  `currency_negative_style` char(64),
  `ordering` int(1) NOT NULL DEFAULT '0',
  `shared` tinyint(1) NOT NULL DEFAULT '1',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_currency_id`),
  KEY `ordering` (`ordering`),
  KEY `currency_name` (`currency_name`),
  KEY `published` (`published`),
  KEY `shared` (`shared`),
  KEY `vendor_id` (`vendor_id`),
  UNIQUE KEY `currency_code_3` (`currency_code_3`),
  KEY `currency_numeric_code` (`currency_numeric_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='Used to store currencies';

CREATE TABLE IF NOT EXISTS `#__ddc_images` (
  `ddc_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `linked_table` text NOT NULL,
  `link_id` int(11) NOT NULL,
  `image_link` text NOT NULL,
  `details` text NOT NULL,
  `state` tinyint(3) NOT NULL,
  `created_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddc_image_id`),
  KEY `link_id` (`link_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Table structure for table `#__ddc_orders`
--

CREATE TABLE IF NOT EXISTS `#__ddc_orders` (
  `ddc_order_id` INT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `ddc_vendor_id` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `order_number` varchar(64),
  `customer_number` varchar(32),
  `order_pass` varchar(34),
  `order_create_invoice_pass` varchar(32),
  `order_total` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `order_salesPrice` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `order_billTaxAmount` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `order_billTax` varchar(400),
  `order_billDiscountAmount` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `order_discountAmount` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `order_subtotal` decimal(15,5),
  `order_tax` decimal(10,5),
  `order_shipment` decimal(10,5),
  `order_shipment_tax` decimal(10,5),
  `order_payment` decimal(10,2),
  `order_payment_tax` decimal(10,5),
  `coupon_discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `coupon_code` char(32),
  `order_discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `order_currency` smallint(1),
  `order_status` char(1),
  `user_currency_id` smallint(1),
  `user_currency_rate` DECIMAL(10,5) NOT NULL DEFAULT '1.00000',
  `ddc_paymentmethod_id` int(1) UNSIGNED,
  `ddc_shipmentmethod_id` int(1) UNSIGNED,
  `delivery_date` varchar(200),
  `order_language` varchar(7),
  `ip_address` char(15) NOT NULL DEFAULT '',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(1) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(1) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_order_id`),
  KEY `user_id` (`user_id`),
  KEY `ddc_vendor_id` (`ddc_vendor_id`),
  KEY `order_number` (`order_number`),
  KEY `ddc_paymentmethod_id` (`ddc_paymentmethod_id`),
  KEY `ddc_shipmentmethod_id` (`ddc_shipmentmethod_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Used to store all orders' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `#__ddc_order_histories`
--

CREATE TABLE IF NOT EXISTS `#__ddc_order_histories` (
  `ddc_order_history_id` INT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ddc_order_id` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `order_status_code` char(1) NOT NULL DEFAULT '0',
  `customer_notified` tinyint(1) NOT NULL DEFAULT '0',
  `comments` varchar(21000),
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(1) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(1) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_order_history_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Stores all actions and changes that occur to an order' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `#__ddc_order_items`
--

CREATE TABLE IF NOT EXISTS `#__ddc_order_items` (
  `ddc_order_item_id` INT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ddc_order_id` int(1),
  `ddc_vendor_id` int(1) NOT NULL DEFAULT '1',
  `ddc_product_id` int(1),
  `order_item_sku` varchar(255) NOT NULL DEFAULT '',
  `order_item_name` varchar(4096) NOT NULL DEFAULT '',
  `product_quantity` int(1),
  `product_item_price` decimal(15,5),
  `product_priceWithoutTax` decimal(15,5),
  `product_tax` decimal(15,5),
  `product_basePriceWithTax` decimal(15,5),
  `product_discountedPriceWithoutTax` decimal(15,5),
  `product_final_price` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `product_subtotal_discount` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `product_subtotal_with_tax` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `order_item_currency` INT(1),
  `order_status` char(1),
  `product_attribute` mediumtext,
  `delivery_date` varchar(200),
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(1) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(1) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_order_item_id`),
  KEY `ddc_product_id` (`ddc_product_id`),
  KEY `ddc_order_id` (`ddc_order_id`),
  KEY `ddc_vendor_id` (`ddc_vendor_id`),
  KEY `order_status` (`order_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Stores all items (products) which are part of an order' AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- Table structure for table `#__ddc_order_calc_rules`
--

CREATE TABLE IF NOT EXISTS `#__ddc_order_calc_rules` (
  `ddc_order_calc_rule_id` INT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ddc_calc_id` int(1),
  `ddc_order_id` int(1),
  `ddc_vendor_id` int(1) NOT NULL DEFAULT '1',
  `ddc_order_item_id` int(1),
  `calc_rule_name`  varchar(64) NOT NULL DEFAULT '' COMMENT 'Name of the rule',
  `calc_kind` varchar(16) NOT NULL DEFAULT '' COMMENT 'Discount/Tax/Margin/Commission',
  `calc_mathop` varchar(16) NOT NULL DEFAULT '' COMMENT 'Discount/Tax/Margin/Commission',
  `calc_amount` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `calc_result` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `calc_value` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `calc_currency` int(1),
  `calc_params` varchar(18000) NOT NULL DEFAULT '',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(1) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(1) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_order_calc_rule_id`),
  KEY `ddc_calc_id` (`ddc_calc_id`),
  KEY `ddc_order_id` (`ddc_order_id`),
  KEY `ddc_vendor_id` (`ddc_vendor_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Stores all calculation rules which are part of an order' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `#__ddc_orderstates`
--

CREATE TABLE IF NOT EXISTS `#__ddc_orderstates` (
  `ddc_orderstate_id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ddc_vendor_id` int(1) NOT NULL DEFAULT '1',
  `order_status_code` char(1) NOT NULL DEFAULT '',
  `order_status_name` varchar(64),
  `order_status_description` varchar(20000),
  `order_stock_handle` char(1) NOT NULL DEFAULT 'A',
  `ordering` int(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(1) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(1) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_orderstate_id`),
  KEY `ordering` (`ordering`),
  KEY `ddc_vendor_id` (`ddc_vendor_id`),
  KEY `published` (`published`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='All available order statuses' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__ddc_paymentmethods` (
  `ddc_paymentmethod_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ddc_vendor_id` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `paymentmethod_name` varchar(100) NOT NULL DEFAULT '',
  `paymentmethod_alias` varchar(100) NOT NULL DEFAULT '',
  `payment_element` varchar(50) NOT NULL DEFAULT '',
  `payment_params` varchar(5000) NOT NULL DEFAULT '',
  `currency_id` int(1) UNSIGNED,
  `shared` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'valide for all vendors?',
  `ordering` int(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(1) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(1) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_paymentmethod_id`),
	KEY `ddc_vendor_id` (`ddc_vendor_id`),
	KEY `payment_element` (payment_element,`ddc_vendor_id`),
	KEY `ordering` (`ordering`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='The payment methods of your store' AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `#__ddc_payments` (
  `ddc_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(100) NOT NULL,
  `ref_id` int(11) NOT NULL,
  `token` TEXT NOT NULL,
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_by` int(11) NOT NULL default'0',
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `state` tinyint(3) NOT NULL,
  PRIMARY KEY (`ddc_payment_id`),
  KEY `ref_id` (`ref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_postings` (
  `ddc_posting_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `posting_parent` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `lastip` varchar(50) NOT NULL,
  `created_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_by` int(11) NOT NULL default'0',
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `state` tinyint(3) NOT NULL,
  PRIMARY KEY (`ddc_posting_id`),
  KEY `vendor_id` (`vendor_id`),
  KEY `product_id` (`product_id`),
  KEY `posting_parent` (`posting_parent`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_products` (
  `ddc_product_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_parent_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `category_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `product_sku` varchar(120),
  `product_gtin` varchar(64),
  `product_mpn` varchar(64),
  `product_name` varchar(120),
  `product_alias` varchar(120),
  `product_description_small` text,
  `product_description` text,
  `product_weight` decimal(10,4),
  `product_weight_uom` varchar(7),
  `product_length` decimal(10,4),
  `product_width` decimal(10,4),
  `product_height` decimal(10,4),
  `product_lwh_uom` varchar(7),
  `product_url` varchar(255),
  `metarobot` varchar(400),
  `metaauthor` varchar(400),
  `layout` char(16),
  `published` tinyint(1),
  `pordering` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(1) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(1) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_product_id`),
  KEY `product_parent_id` (`product_parent_id`),
  KEY `published` (`published`),
  KEY `pordering` (`pordering`),
  KEY `created_on` (`created_on`),
  KEY `modified_on` (`modified_on`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='All products are stored here.' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__ddc_product_prices` (
  `ddc_product_price_id` INT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `shoppergroup_id` int(1) UNSIGNED  NOT NULL DEFAULT '0',
  `product_price` decimal(15,6),
  `override` tinyint(1),
  `product_override_price` decimal(15,5),
  `product_tax_id` int(1),
  `product_discount_id` int(1),
  `product_currency` smallint(1),
  `product_price_publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `product_price_publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `price_quantity_start` int(1) unsigned NOT NULL default '0',
  `price_quantity_end` int(1) unsigned NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(1) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(1) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_product_price_id`),
  KEY `product_id` (`product_id`),
  KEY `product_price` (`product_id`),
  KEY `shoppergroup_id` (`shoppergroup_id`),
  KEY `product_price_publish_up` (`product_price_publish_up`),
  KEY `product_price_publish_down` (`product_price_publish_down`),
  KEY `price_quantity_start` (`price_quantity_start`),
  KEY `price_quantity_end` (`price_quantity_end`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Holds price records for a product' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__ddc_recipe_headers` (
  `ddc_recipe_header_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100),
  `description` varchar(1000),
  `prep_time` INT(4) NOT NULL default '0',
  `cook_time` INT(4) NOT NULL default '0',
  `serving_qty` int(11) NULL,
  `method` varchar(2000) default NULL,
  `author` varchar(50) default NULL,
  `author_id` INT(11) NOT NULL default '0',
  `published_up` varchar(150) default NULL,
  `catid` int(11) NOT NULL default '0',
  `created_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `state` tinyint(3) NOT NULL default '0',
  PRIMARY KEY (`ddc_recipe_header_id`),
  KEY `catid` (`catid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_recipe_details` (
  `ddc_recipe_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_header_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` double default '0.00',
  `weight` double default '0.00',
  `weight_uom` int(11) default '0',
  `volume` double default '0.00',
  `volume_uom` int(11) default '0',
  `item_detail` varchar(100) default NULL,
  `created_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `state` tinyint(3) NOT NULL default '0',
  PRIMARY KEY (`ddc_recipe_detail_id`),
  KEY `recipe_header_id` (`recipe_header_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_service_headers` (
  `ddc_service_header_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL default 0,
  `session_id` varchar(100),
  `vendor_id` INT(11) NOT NULL default '0',
  `first_name` varchar(50),
  `last_name` varchar(50),
  `payment_method` int(11) NULL,
  `email_to` varchar(150) default NULL,
  `mobile_no` varchar(150) default NULL,
  `book_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `planned_start_time` TIME default '0:00:00',
  `planned_end_time` TIME default '0:00:00',
  `actual_start_time` TIME default '0:00:00',
  `actual_end_time` TIME default '0:00:00',
  `catid` int(11) NOT NULL default '0',
  `created_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `state` tinyint(3) NOT NULL default '0',
  PRIMARY KEY (`ddc_service_header_id`),
  KEY `user_id` (`user_id`),
  KEY `book_date` (`book_date`),
  KEY `planned_start_time` (`planned_start_time`),
  KEY `planned_end_time` (`planned_end_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_service_details` (
  `ddc_service_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_header_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` double default '0.00',
  `product_pack` double default '0.00',
  `product_base_uom` int(11) default '0',
  `product_price` double default '0.00',
  `currency` int(11) default '0',
  `discount` double default '0.00',
  `discount_end_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `state` tinyint(3) NOT NULL,
  `created_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `hits` int(10) NOT NULL,
  PRIMARY KEY (`ddc_service_detail_id`),
  KEY `service_header_id` (`service_header_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_shoppingcart_headers` (
  `ddc_shoppingcart_header_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL default 0,
  `session_id` varchar(100),
  `shipping_cost` double default '0.00',
  `delivery_type` int(11) NULL,
  `delivery_time` TIME default '0:00:00',
  `delivery_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `first_name` varchar(50),
  `last_name` varchar(50),
  `address_line_1` varchar(100),
  `address_line_2` varchar(100),
  `address_line_3` varchar(100),
  `town` varchar(100),
  `county` varchar(100),
  `post_code` varchar(10) default NULL,
  `country` int(11) NOT NULL default '222',
  `payment_method` int(11) NULL,
  `email_to` varchar(150) default NULL,
  `mobile_no` varchar(150) default NULL,
  `telephone_no` varchar(150) default NULL,
  `catid` int(11) NOT NULL default '0',
  `state` tinyint(3) NOT NULL,
  `created_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddc_shoppingcart_header_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_shoppingcart_details` (
  `ddc_shoppingcart_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `shoppingcart_header_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` double default '0.00',
  `price` double default '0.00',
  `discount` double default '0.00',
  `discount_end_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `catid` int(11) NOT NULL default '0',
  `state` tinyint(3) NOT NULL,
  `created_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `hits` int(10) NOT NULL,
  PRIMARY KEY (`ddc_shoppingcart_detail_id`),
  KEY `shoppingcart_header_id` (`shoppingcart_header_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_social_links` (
  `ddc_social_link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_url` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `vendor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `description` varchar(255) NULL,
  `state` tinyint(3) NOT NULL DEFAULT '1',
  `created_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `hits` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_social_link_id`),
  KEY `vendor_id` (`vendor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS #__ddc_outcodes (
    ddc_outcode_id INT(11) NOT NULL AUTO_INCREMENT,
    postcode VARCHAR(9) NOT NULL,
    eastings INT(7) NOT NULL,
    northings INT(7) NOT NULL,
    latitude DECIMAL(10, 8) NOT NULL,
    longitude DECIMAL(11, 8) NOT NULL,
    town VARCHAR(255) NULL,
    region VARCHAR(255) NULL,
    uk_region VARCHAR(255) NULL,
    country VARCHAR(3) NULL,
    country_string VARCHAR(255) NULL,
    PRIMARY KEY(ddc_outcode_id),
    UNIQUE INDEX `postcode` (`postcode` ASC)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------
--
-- Table structure for table `#__virtuemart_userinfos`
--

CREATE TABLE IF NOT EXISTS `#__ddc_userinfos` (
  `ddc_userinfo_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `address_type` char(2) NOT NULL DEFAULT '',
  `address_type_name` varchar(32) NOT NULL DEFAULT '',
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  `company` varchar(64),
  `title` varchar(32),
  `last_name` varchar(96),
  `first_name` varchar(96),
  `middle_name` varchar(96),
  `phone_1` varchar(32),
  `phone_2` varchar(32),
  `fax` varchar(32),
  `address_1` varchar(96) NOT NULL DEFAULT '',
  `address_2` varchar(64),
  `city` VARCHAR(90) NULL DEFAULT '',
  `county` varchar(60) NULL DEFAULT '',
  `country_id` int(11) NOT NULL DEFAULT '0',
  `zip` varchar(32) NOT NULL DEFAULT '',
  `agreed` tinyint(1) NOT NULL DEFAULT '0',
  `tos` tinyint(1) NOT NULL DEFAULT '0',
  `customer_note` varchar(5000) NOT NULL DEFAULT '',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(1) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(1) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_userinfo_id`),
  KEY `i_ddc_user_id` (`ddc_userinfo_id`,`user_id`),
  KEY `ddc_user_id` (`user_id`,`address_type`),
  KEY `address_type` (`address_type`),
  KEY `address_type_name` (`address_type_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='Customer Information, BT = BillTo and ST = ShipTo';

-- --------------------------------------------------------
--
-- Table structure for table `#__virtuemart_order_userinfos`
--

CREATE TABLE IF NOT EXISTS `#__ddc_order_userinfos` (
  `ddc_order_userinfo_id` INT(11) NOT NULL AUTO_INCREMENT,
  `ddc_order_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `address_type` char(2),
  `address_type_name` varchar(32),
  `company` varchar(64),
  `title` varchar(32),
  `last_name` varchar(96),
  `first_name` varchar(96),
  `middle_name` varchar(96),
  `phone_1` varchar(32),
  `phone_2` varchar(32),
  `fax` varchar(32),
  `address_1` varchar(96) NOT NULL DEFAULT '',
  `address_2` varchar(64) ,
  `city` VARCHAR(60) NULL DEFAULT '',
  `county` varchar(60) NULL DEFAULT '',
  `country_id` int(11) NOT NULL DEFAULT '0',
  `email` varchar(128),
  `agreed` tinyint(1) NOT NULL DEFAULT '0',
  `tos` tinyint(1) NOT NULL DEFAULT '0',
  `customer_note` varchar(5000)  NOT NULL DEFAULT '',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(1) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(1) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_order_userinfo_id`),
  KEY `ddc_order_id` (`ddc_order_id`),
  KEY `user_id` (`user_id`,`address_type`),
  KEY `address_type` (`address_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Stores the BillTo and ShipTo Information at order time' AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `#__ddc_user_vendor_interests` (
  `ddc_user_vendor_interest_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(60) NOT NULL,
  `lastname` VARCHAR(60) NOT NULL,
  `email_to` VARCHAR(100) NOT NULL,
  `town` VARCHAR(60) NOT NULL,
  `ddc_vendor` VARCHAR(60) NULL,
  `ip_address` VARCHAR(60) NULL,
  `field_3` VARCHAR(60) NULL,
  `comment` TEXT NULL,
  `state` tinyint(3) NOT NULL,
  `created_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddc_user_vendor_interest_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS `#__ddc_user_vendor` (
  `ddc_user_vendor_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `state` tinyint(3) NOT NULL,
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddc_user_vendor_id`),
  KEY `user_id` (`user_id`),
  KEY `vendor_id` (`vendor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_vendor_products` (
  `ddc_vendor_product_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `product_type` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `distrib_cat_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `vendor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `vendor_product_sku` varchar(120),
  `product_gtin` varchar(64),
  `product_mpn` varchar(64),
  `vendor_product_name` varchar(120),
  `vendor_product_alias` varchar(120),
  `product_description_small` text,
  `product_description` text,
  `product_weight` decimal(10,4),
  `product_weight_uom` varchar(7),
  `product_length` decimal(10,4),
  `product_width` decimal(10,4),
  `product_height` decimal(10,4),
  `product_lwh_uom` varchar(7),
  `low_stock_notification` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `product_available_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `product_availability` char(32),
  `product_special` tinyint(1),
  `product_base_uom` tinyint(3),
  `product_packaging` decimal(8,4) UNSIGNED,
  `product_params` varchar(2000) NOT NULL DEFAULT '',
  `hits` int(1) unsigned,
  `intnotes` varchar(2000),
  `metarobot` varchar(400),
  `metaauthor` varchar(400),
  `layout` char(16),
  `published` tinyint(1),
  `pordering` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(1) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(1) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_vendor_product_id`),
  KEY `vendor_id` (`vendor_id`),
  KEY `published` (`published`),
  KEY `pordering` (`pordering`),
  KEY `created_on` (`created_on`),
  KEY `modified_on` (`modified_on`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='All products are stored here.' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__ddc_vendors` (
  `ddc_vendor_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `vendor_currency` int(11) NOT NULL DEFAULT '52',
  `vendor_accepted_currencies` varchar(1536) NOT NULL DEFAULT '52',
  `introduction` text NULL,
  `description` text NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `images` text NULL,
  `address1` varchar(60) NOT NULL DEFAULT '',
  `address2` varchar(60) NULL,
  `city` VARCHAR(60) NULL DEFAULT '',
  `county` varchar(60) NULL DEFAULT '',
  `post_code` varchar(10) NOT NULL DEFAULT '',
  `country` int(11) NOT NULL DEFAULT '222',
  `contact_numbers` varchar(500) NOT NULL DEFAULT '{}',
  `vendor_details` text NULL DEFAULT '',
  `allow_bookings` int(3) NOT NULL DEFAULT '0',
  `state` tinyint(3) NOT NULL DEFAULT '1',
  `created_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `hits` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_vendor_id`),
  KEY `post_code` (`post_code`),
  KEY `owner` (`owner`),
  KEY `vendor_currency` (`vendor_currency`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddc_vendor_stations` (
  `ddc_vendor_station_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `vendor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `introduction` text NULL,
  `description` text NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `images` text NULL,
  `latitude` DECIMAL(10, 8) NOT NULL,
  `longitude` DECIMAL(11, 8) NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '1',
  `created_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified_on` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `hits` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddc_vendor_station_id`),
  KEY `vendor_id` (`vendor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


