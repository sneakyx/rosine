<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2017-02-01  										    *
 \**************************************************************************/

include ('inc/head.inc.php');
/*
 * This file corrects all numbers of invoice_id when importet von phprechnung
 * because the numbers for every item in my invoices starts with 1
 * be careful! the status will be set to "changed", not be leaved - this file is alpha!
 *  
 */

$tpl->load("paperworks.html");
$lang[] = $config['language'];
$lang = $tpl->loadLanguage($lang);
for ($i=0;$i<rosine_highest_number("invoice")+1;$i++){
	rosine_correct_numbers("invoice", $i);
	$OK.=$i." aktualisiert<br>";
}
//show page
$tpl->assign("OK", $OK);
$tpl->assign("error", $error);
$tpl->assign("input_fields", $input_fields);
$tpl->assign("paperwork", $lang[$_POST['paperwork']]);
$tpl->assign("additional", '<h3>'.$lang['favorite_articles'].'</h3>
	{$input_favorites}{$other_tables}');
if ($_POST['paperwork']!="offer") {
	$tpl->assign('other_tables','<h3>'.$lang["add_articles_from_other_tables"].'</h3>
		{$offer_list} {$order_list} {$delivery_list}');
	$tpl->assign("offer_list", rosine_add_paperworklist("offer",$customer_details['contact_id']));
	if ($_POST['paperwork']!="order") {
		$tpl->assign("order_list", rosine_add_paperworklist("order",$customer_details['contact_id']));
		if ($_POST['paperwork']!="delivery"){
			$tpl->assign("delivery_list", rosine_add_paperworklist("delivery",$customer_details['contact_id']));
		}// paperwork must be invoice
		else {
			$tpl->assign("delivery_list", "");
		}//paperwork must be delivery
	}// paperwork is not order
	else {
		$tpl->assign("order_list", "");
		$tpl->assign("delivery_list", "");
	}//paperwork is order
}// paperwork is not offer
else{
	$tpl->assign("other_tables", "");
}// paperwork is offer
$tpl->assign("input_favorites", rosine_most_used_articles($_POST['paperwork']));
$tpl->assign("this_number",rosine_get_real_number($_POST['paperwork'],$_POST['paperwork_id']));
$tpl->assign("paperwork_file", rosine_get_plural($_POST['paperwork']));
$tpl->assign("paperwork_type", $_POST['paperwork']);

$tpl->display();
?>