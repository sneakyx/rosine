# FROM 2016-12-30 to 2017-01-02

INSERT IGNORE INTO `rosine_config` (`config`, `user_id`, `value`) VALUES
('overwrite_templates', 0, 'no');

# FROM 2017-01-02 to 2017-01-14

INSERT IGNORE INTO `egroupware`.`rosine_notes` (`NOTE_ID` , `LANGUAGE` , `NOTE_TEXT`) VALUES
 ( '100', 'de.php', '%SINGULAR1% %ID1% vom %date%:'), 
('100', 'en.php', '%SINGULAR1% %ID1% from %date%:');

INSERT IGNORE INTO `egroupware`.`rosine_config` (`config` ,`user_id` ,`value`) VALUES 
('insert_delivery_into_paperwork', '0', '100'), 
('insert_offer_into_paperwork', '0', '100'),
('insert_order_into_paperwork', '0', '100'), 
('insert_invoice_into_paperwork', '0', '100');

# FROM 2017-02-11 to 2017-02-13
CREATE TABLE IF NOT EXISTS `rosine_drafts` (
  `DRAFT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `DRAFT_DATE` date DEFAULT NULL,
  `DRAFT_CUSTOMER` int(11) DEFAULT NULL,
  `DRAFT_CUSTOMER_PRIVATE` tinyint(4) NOT NULL DEFAULT '1',
  `DRAFT_AMMOUNT` decimal(8,2) DEFAULT NULL,
  `DRAFT_AMMOUNT_BRUTTO` decimal(8,2) DEFAULT NULL,
  `DRAFT_NOTE` text,
  `DRAFT_STATUS` varchar(10) NOT NULL,
  `DRAFT_PRINTED` tinyint(4) NOT NULL DEFAULT '0',
  `GENERATED` varchar(100) DEFAULT NULL,
  `CHANGED` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`DRAFT_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

CREATE TABLE IF NOT EXISTS `rosine_drafts_positions` (
  `DRAFT_ID` int(11) NOT NULL,
  `POSI_ID` int(11) NOT NULL,
  `ART_NUMBER` varchar(40) NOT NULL,
  `POSI_AMMOUNT` decimal(9,3) DEFAULT NULL,
  `POSI_UNIT` varchar(20) DEFAULT NULL,
  `POSI_PRICE` decimal(8,2) DEFAULT NULL,
  `POSI_LOCATION` smallint(6) DEFAULT NULL,
  `POSI_SERIAL` varchar(40) DEFAULT NULL,
  `POSI_TEXT` varchar(1255) DEFAULT NULL,
  `POSI_TAX` tinyint(4) NOT NULL,
  `DONE` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`DRAFT_ID`,`POSI_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# FROM 2017-02-13 to 2017-02-16
INSERT IGNORE INTO `rosine_config` (`config`, `user_id`, `value`) VALUES
			('invoice_bcc',0, ''),
			('delivery_bcc',0,''),
			('order_bcc', 0, ''),
			('offer_bcc', 0, '');
INSERT IGNORE INTO `rosine_config` (`config`, `user_id`, `value`) VALUES
			('invoice_cc',0, 'your@email.adress'),
			('delivery_cc',0,'your@email.adress'),
			('order_cc', 0, 'your@email.adress'),
			('offer_cc', 0, 'your@email.adress');


INSERT IGNORE INTO `rosine_config` (`config`, `user_id`, `value`) VALUES
			('draft_change_form',0, '0'),
			('draft_list_form',0,'0'),
			('print_template_draft', 0, 'print_paperwork.html'),
			('insert_draft_into_paperwork', '0', '101');
			
# FROM 2017-02-16 to 2017-02-18
INSERT IGNORE INTO `egroupware`.`rosine_notes` (`NOTE_ID` , `LANGUAGE` , `NOTE_TEXT`) VALUES
 ( '101', 'de.php', ''), 
('101', 'en.php', '');			
			
# FROM 2017-02-18 to 2017-02-20
INSERT IGNORE INTO `rosine_config` (`config`, `user_id`, `value`) VALUES
			('email_template_delivery',0, 'email_delivery.txt');



# FROM 2017-02-22 to 2017-07-15
INSERT IGNORE INTO `egroupware`.`rosine_config` (`config` ,`user_id` ,`value`) VALUES 
	('invoice_sort_list', '0', 'sorted_in_alphabetic_order'),
	('delivery_sort_list', '0', 'sorted_in_alphabetic_order'),
	('order_sort_list', '0', 'sorted_in_alphabetic_order'),
	('offer_sort_list', '0', 'sorted_in_alphabetic_order')	;
	
ALTER TABLE `rosine_deliveries` ADD `DELIVERY_TEMPLATE` VARCHAR( 250 ) NULL DEFAULT NULL AFTER `DELIVERY_STATUS`;
ALTER TABLE `rosine_invoices` ADD `INVOICE_TEMPLATE` VARCHAR( 250 ) NULL DEFAULT NULL AFTER `INVOICE_STATUS` ;
ALTER TABLE `rosine_offers` ADD `OFFER_TEMPLATE` VARCHAR( 250 ) NULL DEFAULT NULL AFTER `OFFER_STATUS` ;
ALTER TABLE `rosine_orders` ADD `ORDER_TEMPLATE` VARCHAR( 250 ) NULL DEFAULT NULL AFTER `ORDER_STATUS` ;

ALTER TABLE `rosine_drafts` ADD `DRAFT_TEMPLATE` VARCHAR( 250 ) NULL DEFAULT NULL AFTER `DRAFT_STATUS` ;
ALTER TABLE `rosine_drafts` CHANGE `DRAFT_ID` `DRAFT_ID` INT( 11 ) NOT NULL AUTO_INCREMENT ;

INSERT IGNORE INTO `rosine_config` (`config`, `user_id`, `value`) VALUES
			('draft_change_form',0, '0'),
			('draft_list_form',0,'0'),
			('print_template_draft', 0, 'print_paperwork.html'),
			('insert_draft_into_paperwork', '0', '100');

# FROM 2017-02-20 to 2017-02-22
INSERT IGNORE INTO `rosine_config` (`config`, `user_id`, `value`) VALUES
			('email_delivery',0, 'txt'),
			('email_invoice',0, 'none'),
			('email_order',0, 'none'),
			('email_offer',0, 'none'),
			('email_draft',0, 'none');

# FROM 2017-02-22 to 2018-01-06
UPDATE `egw_applications` SET `app_tables` = 'rosine_articles,rosine_config,rosine_deliveries,rosine_deliveries_positions,rosine_invoices,rosine_invoices_positions,rosine_locations,rosine_notes,rosine_offers,rosine_offers_positions,rosine_orders,rosine_orders_positions,rosine_payments,rosine_payments_methods,rosine_taxes,rosine_drafts,rosine_drafts_positions', `app_version` = '2018-01-06' WHERE `egw_applications`.`app_id` = 58;

INSERT INTO `egroupware`.`rosine_config` (`config` ,`user_id` ,`value`) VALUES 
( 'company', '0', '1');

ALTER TABLE `rosine_deliveries` ADD `COMPANY_ID` TINYINT NOT NULL DEFAULT '1' FIRST ;
ALTER TABLE `rosine_deliveries` CHANGE `DELIVERY_ID` `DELIVERY_ID` INT( 11 ) NOT NULL ;
ALTER TABLE `rosine_deliveries` DROP PRIMARY KEY , ADD PRIMARY KEY ( `COMPANY_ID` , `DELIVERY_ID` ) ;

ALTER TABLE `rosine_drafts` ADD `COMPANY_ID` TINYINT NOT NULL DEFAULT '1' FIRST ;
ALTER TABLE `rosine_drafts` CHANGE `DRAFT_ID` `DRAFT_ID` INT( 11 ) NOT NULL ;
ALTER TABLE `rosine_drafts` DROP PRIMARY KEY , ADD PRIMARY KEY ( `COMPANY_ID` , `DRAFT_ID` ) ;

ALTER TABLE `rosine_invoices` ADD `COMPANY_ID` TINYINT NOT NULL DEFAULT '1' FIRST ;
ALTER TABLE `rosine_invoices` CHANGE `INVOICE_ID` `INVOICE_ID` INT( 11 ) NOT NULL ;
ALTER TABLE `rosine_invoices` DROP PRIMARY KEY , ADD PRIMARY KEY ( `COMPANY_ID` , `INVOICE_ID` ) ;

ALTER TABLE `rosine_offers` ADD `COMPANY_ID` TINYINT NOT NULL DEFAULT '1' FIRST ;
ALTER TABLE `rosine_offers` CHANGE `OFFER_ID` `OFFER_ID` INT( 11 ) NOT NULL ;
ALTER TABLE `rosine_offers` DROP PRIMARY KEY , ADD PRIMARY KEY ( `COMPANY_ID` , `OFFER_ID` ) ;

ALTER TABLE `rosine_orders` ADD `COMPANY_ID` TINYINT NOT NULL DEFAULT '1' FIRST ;
ALTER TABLE `rosine_orders` CHANGE `ORDER_ID` `ORDER_ID` INT( 11 ) NOT NULL ;
ALTER TABLE `rosine_orders` DROP PRIMARY KEY , ADD PRIMARY KEY ( `COMPANY_ID` , `ORDER_ID` ) ;

ALTER TABLE `rosine_payments` ADD `COMPANY_ID` TINYINT NOT NULL DEFAULT '1' FIRST ;
ALTER TABLE `rosine_payments` CHANGE `PAYMENT_ID` `PAYMENT_ID` INT( 11 ) NOT NULL ;
ALTER TABLE `rosine_payments` DROP PRIMARY KEY , ADD PRIMARY KEY ( `COMPANY_ID` , `PAYMENT_ID` ) ;

ALTER TABLE `rosine_deliveries_positions` ADD `COMPANY_ID` TINYINT NOT NULL DEFAULT '1' FIRST ;
ALTER TABLE `rosine_deliveries_positions` CHANGE `DELIVERY_ID` `DELIVERY_ID` INT( 11 ) NOT NULL ;
ALTER TABLE `rosine_deliveries_positions` DROP PRIMARY KEY , ADD PRIMARY KEY ( `COMPANY_ID` , `DELIVERY_ID`, `POSI_ID` ) ;

ALTER TABLE `rosine_drafts_positions` ADD `COMPANY_ID` TINYINT NOT NULL DEFAULT '1' FIRST ;
ALTER TABLE `rosine_drafts_positions` CHANGE `DRAFT_ID` `DRAFT_ID` INT( 11 ) NOT NULL ;
ALTER TABLE `rosine_drafts_positions` DROP PRIMARY KEY , ADD PRIMARY KEY ( `COMPANY_ID` , `DRAFT_ID`, `POSI_ID` ) ;

ALTER TABLE `rosine_invoices_positions` ADD `COMPANY_ID` TINYINT NOT NULL DEFAULT '1' FIRST ;
ALTER TABLE `rosine_invoices_positions` CHANGE `INVOICE_ID` `INVOICE_ID` INT( 11 ) NOT NULL ;
ALTER TABLE `rosine_invoices_positions` DROP PRIMARY KEY , ADD PRIMARY KEY ( `COMPANY_ID` , `INVOICE_ID`, `POSI_ID` ) ;

ALTER TABLE `rosine_offers_positions` ADD `COMPANY_ID` TINYINT NOT NULL DEFAULT '1' FIRST ;
ALTER TABLE `rosine_offers_positions` CHANGE `OFFER_ID` `OFFER_ID` INT( 11 ) NOT NULL ;
ALTER TABLE `rosine_offers_positions` DROP PRIMARY KEY , ADD PRIMARY KEY ( `COMPANY_ID` , `OFFER_ID`, `POSI_ID` ) ;

ALTER TABLE `rosine_orders_positions` ADD `COMPANY_ID` TINYINT NOT NULL DEFAULT '1' FIRST ;
ALTER TABLE `rosine_orders_positions` CHANGE `ORDER_ID` `ORDER_ID` INT( 11 ) NOT NULL ;
ALTER TABLE `rosine_orders_positions` DROP PRIMARY KEY , ADD PRIMARY KEY ( `COMPANY_ID` , `ORDER_ID`, `POSI_ID` ) ;

ALTER TABLE `rosine_drafts` CHANGE `DRAFTS_TEMPLATE` `DRAFT_TEMPLATE` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
