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


