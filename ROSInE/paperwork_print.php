<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-04-30  										    *
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
 * $paperwork = kind of paperwork (offer, order, etc)
 * $customer_name = the name that should be on the invoice as recipient
 * $customer_street = the name of customers' street
 * $customer_zip = the customers' zip (postal code)
 * $customer_city = the customers' city
 * $customer_country = the customers' country
 * $paperwork_id = number of paperwork 
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

$GLOBALS['phpgw_info']['flags']['currentapp'] = 'rosine';
include('../header.inc.php');
include ('inc/settings.php');
include ('inc/template.class.php');

/*function rosine_assign_invoice_fields ($item, $key, $tpl){
	// assign all template-fields in invoice with data
	$tpl->assign($key, $item);
}//endfunction rosine_assign_invoice_fields

* not used, maybe later on
*/

//2. Dimension von $GEt und $post durchsuchen!!!!
$OK="";
$error="";
$paperwork = new Rosine_Template();
$paperwork->load("print_paperwork.html");
$lang[] = $config['language'];
$lang = $paperwork->loadLanguage($lang);
$paperwork->assign('paperwork', $lang[$_GET['paperwork']]);

// get fields from database (just the fields for the full page)
$result=mysql_query(rosine_correct_query($_GET['paperwork'], $rosine_db_query['get_paperworks']."%singular%_ID=".
		$_GET['paperwork_id']));
if (mysql_errno($rosine_db)!=0) {
	// Error in mysql detected
	$error.="  1: ".mysql_error($rosine_db)."<br>";
	$error.=rosine_correct_query($_GET['paperwork'], $rosine_db_query['get_paperworks']."%singular%_ID=".
			$_GET['paperwork_id']);
		
} // Error in mysql detected
else {
	// now the fields can be generated
	$result=mysql_fetch_array($result);
	// goes this paperwork to organisation or to private?
	if ($result[strtoupper($_GET['paperwork']."_customer_private")]=="1") {
		$paperwork->assign('customer_name',$result['n_fn']);
		$nr="two";
	}// customer is private
	else {
		$paperwork->assign('customer_name',$result['n_fn']);
		$nr="one";
	}// customer is organisation
	$paperwork->assign('customer_street',$result['adr_'.$nr.'_street']); // depending on private / organisation
	$paperwork->assign('customer_zip',$result['adr_'.$nr.'_postalcode']);// depending on private / organisation
	$paperwork->assign('customer_city',$result['adr_'.$nr.'_locality']);// depending on private / organisation
	$paperwork->assign('customer_country', $result['adr_'.$nr.'_countryname']);// depending on private / organisation
	$paperwork->assign('day', substr($result[strtoupper($_GET['paperwork'].'_DATE')], 8,2));
	$paperwork->assign('month', substr($result[strtoupper($_GET['paperwork'].'_DATE')], 5,2));
	$paperwork->assign('year', substr($result[strtoupper($_GET['paperwork'].'_DATE')], 0,4));
	$paperwork->assign('customer_id', $result['contact_id']);
	$paperwork->assign("paperwork_terms", $result[strtoupper($_GET['paperwork'].'_NOTE')]);
	// now get the items
	$result=mysql_query(rosine_correct_query($_GET['paperwork'], $rosine_db_query['get_articles_from_paperwork_with_all']." %singular%_ID=".$_GET['paperwork_id']));
	if (mysql_errno($rosine_db)!=0) {
		// Error in mysql detected
		$error.="2: ".mysql_error($rosine_db);
	
	} // Error in mysql detected
	else {
		$sum_all_netto=0;
		$sum_all_brutto=0;
		$sum_tax=0;
		$rows="";
		while($f = @mysql_fetch_array($result)) {
			$row = new Rosine_Template();
			$row->load("print_paperwork_row.html");
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
		}// get every item line by line from this paperwork id
		
		//$row.=$paperwork->return_html();
	}// there was no error in SQL 2
}// there was no error  in SQL 1




// put page together and show it

$paperwork->assign('sum_all_netto', number_format($sum_all_netto,2,",","."));
$paperwork->assign('sum_all_brutto', number_format($sum_all_brutto,2,",","."));
$paperwork->assign('sum_tax', number_format($sum_tax,2,",","."));
$paperwork->assign("OK", $OK);
$paperwork->assign("error", $error);
$paperwork->assign("rows", $rows);
$paperwork->assign('paperwork_id', $_GET['paperwork_id']);
$paperwork->assign_array('config', $config);

$paperwork->display();

?>