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