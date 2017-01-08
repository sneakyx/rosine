<?php 
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2017-01-08  										    *
 \**************************************************************************/
$oProc->query("
			INSERT IGNORE INTO `rosine_config` (`config`, `user_id`, `value`) VALUES
			('articles_per_page', 0, '10'),
			('articles_per_page', 1, '11'),
			('company_bic', 0, 'GENODEM1BB1'),
			('company_city', 0, 'City'),
			('company_country', 0, 'Deutschland'),
			('company_iban', 0, 'IBAN'),
			('company_name', 0, 'Company'),
			('company_street', 0, 'Street 1'),
			('company_tax_nr', 0, '342/XXXX/XXXXX'),
			('company_ust_idnr', 0, 'DE123456123'),
			('company_zip', 0, '57319'),
			('currency', 0, 'Euro'),
			('customers_per_page', 0, '10'),
			('delivery_change_form', 0, '0'),
			('delivery_list_form', 0, '0'),
			('delivery_prefix', 0, 'L-'),
			('delivery_unit_change', 0, 'kg'),
			('favorite_articles', 0, '5'),
			('favorite_payment_selected', 0, '2'),
			('invoice_change_form', 0, '0'),
			('invoice_list_form', 0, '0'),
			('invoice_prefix', 0, 'R-'),
			('items_per_page', 0, '10'),
			('language', 0, 'de.php'),
			('norm_stock', 0, '0'),
			('norm_stock', 14, '1'),
			('norm_stock', 15, '2'),
			('note_delivery', 0, '7'),
			('note_invoice', 0, '1'),
			('note_offer', 0, '4'),
			('note_order', 0, '6'),
			('offer_change_form', 0, '0'),
			('offer_list_form', 0, '0'),
			('offer_prefix', 0, 'A-'),
			('order_change_form', 0, '0'),
			('order_list_form', 0, '0'),
			('order_prefix', 0, 'B-'),
			('print_template_delivery', 0, 'print_paperwork_without_money.html'),
			('print_template_invoice', 0, 'print_paperwork.html'),
			('print_template_offer', 0, 'print_paperwork.html'),
			('print_template_order', 0, 'print_paperwork.html'),
			('overwrite_templates',0,'no')
		");
$oProc->query("
			INSERT IGNORE INTO `rosine_locations` (`LOC_ID`, `LOC_NAME`, `LOC_NOTE`, `GENERATED`, `CHANGED`) VALUES
			(0, 'Hauptlager', '', '', '2016-07-02-14-59-23'),
			(1, 'Lager 1', '', '', '2016-07-02-14-59-31')
		");
$oProc->query("
			INSERT IGNORE INTO `rosine_taxes` (`TAX_ID`, `TAX_NAME`, `TAX_PERCENTAGE`, `GENERATED`, `CHANGED`) VALUES
			(0, '0 Prozent', 0.00, '', '2016-01-12-08-52-59'),
			(1, 'normale MwSt', 19.00, '2016-01-12', '2016-04-23-07-56-23'),
			(3, 'verminderte MwSt.', 7.00, '', '2016-04-23-07-56-33')
		");
$oProc->query("
			INSERT IGNORE INTO `rosine_notes` (`NOTE_ID`, `LANGUAGE`, `NOTE_TEXT`) VALUES
			(1, 'de.php', ' Betrag zahlbar ohne Abzug innerhalb von 14 Tagen'),
			(2, 'de.php', 'Betrag dankend erhalten'),
			(3, 'de.php', 'Betrag wird mit der Gläubiger-ID DE26ZZZ von Ihrem Konto abgebucht. Die Mandatsnummer entspricht Ihrer\nKundennummer.'),
			(4, 'de.php', 'Angebot ist 7 Tage gültig.'),
			(5, 'de.php', 'Angebot ist 28 Tage gültig.'),
			(6, 'de.php', 'Lieferung innerhalb 7 Tagen.'),
			(7, 'de.php', 'Lieferung frei Haus.'),
			(1,'en.php','free shipment')	
		");
$oProc->query("
	INSERT IGNORE INTO `rosine_payments_methods` (`METH_ID`, `METH_NAME`, `METH_NOTE`, `GENERATED`, `CHANGED`) VALUES
	(1, 'bar', 'Barzahlung', NULL, NULL),
	(2, 'Überweisung Firmenkonto', NULL, NULL, NULL)
		");

$oProc->query("
	INSERT IGNORE INTO `rosine_articles` (`ART_NUMBER`, `ART_NAME`, `ART_UNIT`, `ART_PRICE`, `ART_TAX`, `ART_STOCKNR`, `ART_INSTOCK`, `ART_NOTE`, `GENERATED`, `CHANGED`) VALUES
	('01', 'Bio-Eier', 'Stück', 0.35, 3, 2, 0, '', '2016-04-2308:08:05', '2016-05-10-19-16-46'),
	('02', 'Bio- Hähnchen', 'Stück', 10.00, 3, 1, 0, '', '2016-04-2308:08:05', '2016-05-04-14-01-11')	
		");

?>