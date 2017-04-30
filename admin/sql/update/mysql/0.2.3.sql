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
