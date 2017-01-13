<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2017-01-13  										    *
 \**************************************************************************/

/*
 * Usable variables in templates for invoices
 *
 ***** for every page ***********
 * $month = month of paperwork (2 digits)
 * $year = year of paperwork (4 digits)
 * $day = day of paperwork (2 digits)
 *
 * $sum_all_netto = sum of all articles without tax
 * $sum_all_brutto = sum of all articles with tax
 * $sum_tax = sum of all article_tax
 * $tpl = kind of paperwork (offer, order, etc)
 * $customer_name = the name that should be on the invoice as recipient
 * $customer_org = organisation of customer
 * $customer_street = the name of customers' street
 * $customer_zip = the customers' zip (postal code)
 * $customer_city = the customers' city
 * $customer_country = the customers' country
 * $tpl_id = number of paperwork
 * $tpl_variable = this can be used for many things, for example if you print a 
 * 						delivery and want to use $config[delivery_prefix] just write
 * 						{$config[{$tpl_variable}_prefix]}  
 * $config['company_name'] = name of Your company
 * $config['company_street'] = Street+ number of Your company
 * $config['company_zip'] = postal code of your company
 * $config['company_country'] = country of your company
 * $config['company_iban'] = iban of your company
 * $config['company_tax_nr'] = tax number (not ust idnr!) of your company
 * $config['company_ust_idnr'] = international tax number (european style)
 * other $config variables are also available!
 *
 ****** for every row (item) ******
 * $item_id = position id of article in this paperwork
 * $item_number = article number of item
 * $item_ammount = ammount of item
 * $item_unit = unit of ammount of item
 * $item_price_netto = netto price of 1 item
 * $item_price_netto_all = netto price all items (ammount* price of 1)
 * $item_tax = percentage of tax, written in x.y%
 * $item_tax_one = brutto-netto of 1
 * $item_tax_all = tax of all items (ammount * tax of 1)
 * $item_price_brutto = brutto price of item
 * $item_price_brutto_all = brutto price all items (ammount* price of 1)
 * $item_location = location of item
 * $item_serial = serial_number of item
 * $item_text = text of this position (item)
 *
 * Feel free to tell me if anything is missing!
 */
include ('inc/head.inc.php');

/*function rosine_assign_invoice_fields ($item, $key, $tpl){
	// assign all template-fields in invoice with data
	$tpl->assign($key, $item);
}//endfunction rosine_assign_invoice_fields

* not used, maybe later on
*/

$tpl->load($config['print_template_'.$_GET['paperwork']]);
$lang = $tpl->loadLanguage($lang);
$tpl->assign('paperwork', $lang[$_GET['paperwork']]);

// get fields from database (just the fields for the full page)
$result=rosine_database_query(rosine_correct_query($_GET['paperwork'], 
		$rosine_db_query['get_paperworks']."%singular%_ID=".
		$_GET['paperwork_id']),101);
if ($result!=false) {
	// now the fields can be generated
	$row=$result->fetch_array();
	// goes this paperwork to organisation or to private?
	
	if ($row[strtoupper($_GET['paperwork']."_customer_private")]=="1") {
		$tpl->assign('customer_name',$row['n_fn']);
		$tpl->assign('customer_org',"");
		$nr="two";
	}// customer is private
	else {
		$tpl->assign('customer_name',$row['n_prefix'].' '.$row['n_given'].' '.$row['n_family']);
		$tpl->assign('customer_org',$row['org_name']);
		$nr="one";
	}// customer is organisation
	$tpl->assign('customer_street',$row['adr_one_street']); // depending on private / organisation
	$tpl->assign('customer_zip',$row['adr_'.$nr.'_postalcode']);// depending on private / organisation
	$tpl->assign('customer_city',$row['adr_'.$nr.'_locality']);// depending on private / organisation
	$tpl->assign('customer_country', $row['adr_'.$nr.'_countryname']);// depending on private / organisation
	$tpl->assign('day', substr($row[strtoupper($_GET['paperwork'].'_DATE')], 8,2));
	$tpl->assign('month', substr($row[strtoupper($_GET['paperwork'].'_DATE')], 5,2));
	$tpl->assign('year', substr($row[strtoupper($_GET['paperwork'].'_DATE')], 0,4));
	$tpl->assign('customer_id', $row['contact_id']);
	$tpl->assign("paperwork_terms", $row[strtoupper($_GET['paperwork'].'_NOTE')]);
	$result->close();
	// now get the items
	$result=rosine_database_query(rosine_correct_query($_GET['paperwork'], 
			$rosine_db_query['get_articles_from_paperwork_with_all']." %singular%_ID=".
			$_GET['paperwork_id'].' ORDER BY POSI_ID ASC'),102);
	if ($result!=false) {
		$sum_all_netto=0;
		$sum_all_brutto=0;
		$sum_tax=0;
		$rows="";
		while($f = $result->fetch_array()) {
			$row = new Rosine_Template();
			$row->set_templateDir(substr($GLOBALS['egw_info']['server']['backup_dir'],0,strrpos($GLOBALS['egw_info']['server']['backup_dir'], '/')).'/rosine/templates/');
			$row->load(str_replace('.html', '_row.html', $config['print_template_'.$_GET['paperwork']]));
			$lang[] = $config['language'];
			$lang = $row->loadLanguage($lang);
			$row->assign('item_id', $f['POSI_ID']);
			$row->assign('item_number', $f['ART_NUMBER']);
			$row->assign('item_ammount', number_format($f['POSI_AMMOUNT'],2,",","."));
			$row->assign('item_unit', $f['POSI_UNIT']);
			$item_netto = $f['POSI_PRICE'];
			$item_tax = $item_netto * ($f['TAX_PERCENTAGE']/100);
			$item_brutto = $item_netto + $item_tax;
			$items_netto = $item_netto*$f['POSI_AMMOUNT'];
			$items_brutto = $item_brutto*$f['POSI_AMMOUNT'];
			$items_tax = $item_tax*$f['POSI_AMMOUNT'];
			$row->assign('item_price_netto', number_format($item_netto,2,",","."));
			$row->assign('item_tax', $f['TAX_PERCENTAGE']."%");
			$row->assign('item_tax_one',number_format($item_tax,2,",","."));
			$row->assign('item_price_brutto', number_format($item_brutto,2,",","."));
			$row->assign('item_price_netto_all', number_format($items_netto,2,",","."));
			$row->assign('item_price_brutto_all', number_format($items_brutto,2,",","."));
			$row->assign('item_tax_all', number_format($items_tax,2));
			$row->assign('item_location', $f['LOCNAME']);
			$row->assign('item_serial', 'POSI_SERIAL');
			$row->assign('item_text', $f['POSI_TEXT']);
			$sum_all_brutto+=$items_brutto;
			$sum_all_netto+=$items_netto;
			$sum_tax+=$items_tax;
			$rows.=$row->return_html();
			$tax_percentage=$f['TAX_PERCENTAGE'];
		}// get every item line by line from this paperwork id
		$result->close();
		//$row.=$tpl->return_html();
	}// there was no error in SQL 2
}// there was no error  in SQL 1

rosine_set_paperwork_printed($_GET['paperwork'], $_GET['paperwork_id']);
// put page together and show it

$tpl->assign('sum_all_netto', number_format($sum_all_netto,2,",","."));
$tpl->assign('sum_all_brutto', number_format($sum_all_brutto,2,",","."));
$tpl->assign('sum_tax', number_format($sum_tax,2,",","."));
$tpl->assign("OK", $OK);
$tpl->assign("error", $error);
$tpl->assign("rows", $rows);
$tpl->assign('paperwork_id', $_GET['paperwork_id']);
$tpl->assign("paperwork_prefix", $config[$_GET['paperwork'].'_prefix']);
$tpl->assign('tax_percentage', $tax_percentage);
$tpl->assign_array('config', $config);

$tpl->display();

?>