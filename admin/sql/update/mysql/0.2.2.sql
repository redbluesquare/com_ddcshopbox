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