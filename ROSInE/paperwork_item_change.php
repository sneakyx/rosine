<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-04-22  										    *
 \**************************************************************************/
$GLOBALS['phpgw_info']['flags']['currentapp'] = 'rosine';
include('../header.inc.php');
include ('inc/settings.php');
include ('inc/template.class.php');
$tpl = new Rosine_Template();
// order list, add items etc
switch ($_POST['next_function']){
	case "changed":
		// form was filled, now it has to be changed
		$tpl->load("paperwork_item_changed.html");
		$lang[] = $config['language'];
		$lang = $tpl->loadLanguage($lang);
		$OK="";
		$error="";
		
		$set='POSI_AMMOUNT='.$_POST['posi_ammount'].', POSI_UNIT="'.$_POST['posi_unit'].'", POSI_PRICE='.$_POST['posi_price'].
			', POSI_LOCATION='.$_POST['posi_location'].',POSI_SERIAL="'.$_POST['posi_serial'].'", POSI_TEXT="'.$_POST['posi_text'].
			'", POSI_TAX='.$_POST['posi_tax'].' ';
		$query=rosine_correct_query($_POST['paperwork'], $rosine_db_query['update_paperwork_item']);
		$query=str_replace("%paperwork_id%", $_POST['paperwork_id'], $query);
		$query=str_replace("%posi_id%", $_POST['posi_id'],$query);
		$query=str_replace("%set%", $set, $query);
		$result=mysql_query($query);
		if (mysql_errno($rosine_db)!=0) {
			// Error in mysql detected
			$error.="9: ".mysql_error($rosine_db);
				
		} // Error in mysql detected
		else {
			$OK.=$lang['item_changed'].' ' .$lang[$_POST['paperwork']].': '.$_POST['paperwork_id'].' - '.$lang['position'].': '.$_POST['posi_id'];
		}//no error in mysql
		$tpl->assign("what_to_do", $lang['item_changed']);
		$tpl->assign("paperwork_id", $_POST['paperwork_id']);
		$tpl->assign("customer_id", $_POST['customer_id']);
		$tpl->assign("paperworks", rosine_get_plural($_POST['paperwork']));
	break;


	default:
	//if next function is empty then the item most be loaded from database
	$tpl->load("paperwork_item_change.html");
	$lang[] = $config['language'];
	$lang = $tpl->loadLanguage($lang);
	$OK="";
	$error="";
	
	$query=$rosine_db_query['get_articles_from_paperwork'].rosine_get_plural($_GET['paperwork']).'_positions WHERE '.$_GET['paperwork'].'_id='.$_GET['paperwork_id'].' AND posi_id='.$_GET['posi_id'];
	$result=mysql_query($query);
	if (mysql_errno($rosine_db)!=0){
		//Error 1 in mysql
		$error.="1: ".mysql_error($rosine_db);
		$error.=$query;
	}// Error in mysql detected
	else {
		$f=mysql_fetch_array($result);
		$query2=rosine_correct_query($_GET['paperwork'], $rosine_db_query['get_customer_name_by_paperwork_id']);
		$query2=str_replace("%ID%", $_GET['paperwork_id'], $query2);
		$result2=mysql_query($query2);
		$g=mysql_fetch_array($result2);
		$hidden='<input type="hidden" name="posi_id" value="'.$f['POSI_ID'].'">';
		$hidden.='<input type="hidden" name="paperwork_id" value="'.$_GET['paperwork_id'].'">';
		$hidden.='<input type="hidden" name="paperwork" value="'.$_GET['paperwork'].'">';
		$hidden.='<input type="hidden" name="posi_serial" value="'.$f['POSI_SERIAL'].'">';
		$hidden.='<input type="hidden" name="customer_id" value="'.$g['customer_id'].'">';
		$tpl->assign('posi_price', $f['POSI_PRICE']);
		$tpl->assign('posi_unit',$f['POSI_UNIT']);
		$tpl->assign('posi_ammount', $f['POSI_AMMOUNT']);
		$tpl->assign('posi_text', $f['POSI_TEXT']);
		$tpl->assign('customer', $g['customer_name']);
		$tpl->assign('selector_tax', rosine_create_tax_list($f['POSI_TAX']));
		$tpl->assign('selector_stock', rosine_create_location_list($f['POSI_LOCATION']));
		$tpl->assign('hidden_fields',$hidden);
		$_POST['next_function']="changed";
		$tpl->assign("what_to_do", $lang['change_item_in_paperwork']);
		$tpl->assign('paperwork', $lang[$_GET['paperwork']]);
		$tpl->assign("paperwork_id", $_GET['paperwork_id']);
		$tpl->assign ("posi_id",$_GET['posi_id']);
		
	}// there was no error
}//end switch "next_function"

$tpl->assign("next_function", $_POST['next_function']);
$tpl->assign('currency', $config['currency']);
$tpl->assign("OK", $OK);
$tpl->assign("error", $error);
$tpl->assign('paperwork_type', $_POST['paperwork']);
$tpl->display();


?>