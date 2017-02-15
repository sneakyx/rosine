# FROM 2016-02-11 to 2016-02-13
CREATE TABLE IF NOT EXISTS `rosine_drafts` (
  `DRaFT_ID` int(11) NOT NULL AUTO_INCREMENT,
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

INSERT IGNORE INTO `rosine_config` (`config`, `user_id`, `value`) VALUES
			('draft_change_form',0, '0'),
			('draft_list_form',0,'0'),
			('print_template_draft', 0, 'print_paperwork.html'),
			('insert_draft_into_paperwork', '0', '100');


# FROM 2016-12-30 to 2017-01-02

INSERT INTO `rosine_config` (`config`, `user_id`, `value`) VALUES
('overwrite_templates', 0, 'no');

# FROM 2017-01-02 to 2017-01-14

INSERT INTO `egroupware`.`rosine_notes` (`NOTE_ID` , `LANGUAGE` , `NOTE_TEXT`) VALUES
 ( '100', 'de.php', '%SINGULAR1% %ID1% vom %date%:'), 
('100', 'en.php', '%SINGULAR1% %ID1% from %date%:');

INSERT INTO `egroupware`.`rosine_config` (`config` ,`user_id` ,`value`) VALUES 
('insert_delivery_into_paperwork', '0', '100'), 
('insert_offer_into_paperwork', '0', '100'),
('insert_order_into_paperwork', '0', '100'), 
('insert_invoice_into_paperwork', '0', '100');


