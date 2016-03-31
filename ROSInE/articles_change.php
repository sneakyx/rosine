<?php
	/**************************************************************************\
	* Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
	* http://www.rothaarsystems.de                                             *
	* Author: info@rothaarsystems.de                                           *
	* --------------------------------------------                             *
	*  This program is free software; you can redistribute it and/or modify it *
	*  under the terms of the GNU General Public License as published by the   *
	*  Free Software Foundation; version 2 of the License.                     *
	*  date of this file: 2016-03-31 										   *
	\**************************************************************************/
$GLOBALS['phpgw_info']['flags']['currentapp'] = 'rosine';
include('../header.inc.php');
include ('inc/settings.php');
include ('inc/template.class.php');
$tpl = new Rosine_Template();
$lang[] = $language;

$tpl->load("insert_article.html");
$lang = $tpl->loadLanguage($lang);


switch ($_POST['next_function']){
	
	case "new": 
		if (!$_POST['stock'])
			$_POST['stock']="0";
		$tpl->assign("next_function", "new");
		$tpl->assign("what_to_do", $lang['insert_again_new_article']);
		if ($_POST['number']=="")
			$error.=$lang['number_missing']."<br>";
		if ($_POST['article_name']=="")
			$error.=$lang['name_missing']."<br>";
		if ($error==""){
			// in Tabelle einfügen!
		$result=mysql_query($rosine_db_query['insert_article'].
							'("'.$_POST[number].'","'.
							$_POST[unity].'","'.
							$_POST[article_name].'", '.
							$_POST[price].','. 
							$_POST['posi_tax'].','.
							$_POST['posi_location'].','.
							$_POST[stock].', "'.
							$_POST[notes].'", "'.
							date("Y-m-d-H-i-s").'","")');
		if (mysql_errno($rosine_db)!=0) {
			// Error in mysql detected
			$error.="0: ".mysql_error($rosine_db);
			$error.="<br>".$rosine_db_query['insert_article'].
							'("'.$_POST[number].'","'.
							$_POST[unity].'","'.
							$_POST[article_name].'", '.
							$_POST[price].','. 
							$_POST['posi_tax'].','.
							$_POST['posi_location'].','.
							$_POST[stock].', "'.
							$_POST[notes].'", "'.
							date("Y-m-d-H-i-s").'","")';
			$OK="";
			$tpl->assign("number", $_POST['number']);
			$tpl->assign("unity", $_POST['unity']);
			$tpl->assign("article_name",$_POST['article_name']);
			$tpl->assign("price", $_POST['price']);
			$tpl->assign("stock", $_POST['stock']);
		}
		else 
			//no error in mysql
			$OK=$lang['article_inserted']." ".$lang['article_number'].":".$_POST['number'];
			// this is to empty the values
			$tpl->assign("number", "");
			$tpl->assign("unity", "");
			$tpl->assign("article_name","");
			$tpl->assign("price", "");
			$tpl->assign("stock", "");
		}

	break; // article is inserted

	case "change":
		//this is diretly sent from articles.php to change a specific article
		$tpl->assign("what_to_do", $lang['change_article']);
		$tpl->assign("next_function", "changed");
		$result=mysql_query($rosine_db_query['get_articles']. ' ART_NUMBER="'.$_POST['number'].'" LIMIT 1');
		if (mysql_errno($rosine_db)!=0) {
			// Error in mysql detected
			$error.="1: ".mysql_error($rosine_db);
		}
		else {
			$row = @mysql_fetch_array($result);
			$tpl->assign("number", $row['ART_NUMBER'].
					'" > <input type="hidden" name="oldnumber" value="'.$row['ART_NUMBER'].'"');
					//this is to have the possibiliity to change even the article number!
			$tpl->assign("unity", $row['ART_UNIT']);
			$tpl->assign("article_name",$row['ART_NAME']);
			$tpl->assign("price", $row['ART_PRICE']);
			$tpl->assign("stock", $row['ART_INSTOCK']);
			$_POST['posi_location']=$row['ART_STOCKNR'];
			$_POST['posi_tax']=$row['ART_TAX'];
		}
	break;
	
	case "changed":
		/*
		 * user has changed the details
		 * now the changes have to be stored in the database
		 * what to do then?
		 * return to articles.php?
		 * should be the best!
		 */
		$result=mysql_query($rosine_db_query['update_article'].
							' ART_NUMBER="'.$_POST['number'].'", 
							 ART_NAME="'.$_POST['article_name'].'",
							 ART_UNIT="'.$_POST['unity'].'",
							 ART_PRICE='.$_POST['price'].',
							 ART_INSTOCK='.$_POST['stock'].',
							 ART_STOCKNR='.$_POST['posi_location'].',
							 ART_TAX='.$_POST['posi_tax'].',
							 CHANGED="'.date("Y-m-d-H-i-s").'"		
							 WHERE ART_NUMBER="'.$_POST['oldnumber'].'"');
		if (mysql_errno($rosine_db)!=0) {
			// Error in mysql detected
			$error.="4: ".mysql_error($rosine_db);
		}
		else {
			$OK.=$lang['article_changed'];	
		}
		
	
	default:
		// this file is 1. loaded, no inserted articles before
		$tpl->assign("what_to_do", $lang['insert_new_article']);
		$tpl->assign( "next_function", "new" );
		// this is to empty the values
		$tpl->assign("number", "");
		$tpl->assign("unity", "");
		$tpl->assign("article_name","");
		$tpl->assign("price", "");
		$tpl->assign("stock", "");
		
}//end case select what happens with the data
$tpl->assign("error", $error);
$tpl->assign("OK", $OK);
$tpl->assign("selector_tax", rosine_create_tax_list($_POST['posi_tax']));
$tpl->assign("selector_stock",rosine_create_location_list($_POST['posi_location']));
$tpl->display();
?>