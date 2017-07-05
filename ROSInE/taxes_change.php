<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
* http://www.rothaarsystems.de                                             *
* Author: info@rothaarsystems.de                                           *
* --------------------------------------------                             *
*  This program is free software; you can redistribute it and/or modify it *
*  under the terms of the GNU General Public License as published by the   *
*  Free Software Foundation; version 2 of the License.                     *
*  date of this file: 2017-07-05 										   *
\**************************************************************************/
include ('inc/head.inc.php');

$tpl->load("insert_tax.html");


switch ($_POST['next_function']){

	case "new":

		$tpl->assign("next_function", "new");
		$tpl->assign("what_to_do", lang('insert_again_new_tax'));
		if ($_POST['tax_id']==""){
			$error.=lang('number_missing')."<br>";
		}//endif
		if ($_POST['tax_name']==""){
			$error.=lang('name_missing')."<br>";
		}//endif
	if ($error==""){
		// in Tabelle einfügen!
		$result=rosine_database_query($rosine_db_query['insert_tax'].
				'("'.$_POST['tax_id'].'","'.
				$_POST['tax_name'].'", '.
				$_POST['tax_percentage'].',
				"","'.
				date("Y-m-d-H-i-s").'")',101);
		
		if ($result==false) {
			// Error in mysql detected
			$tpl->assign("tax_id", $_POST['tax_id']);
			$tpl->assign("tax_name",$_POST['tax_name']);
			$tpl->assign("tax_percentage", $_POST['tax_percentage']);
		}//endif
		else{
			//no error in mysql
			$OK=lang('tax_inserted')." ".$lang['tax_id'].":".$_POST['tax_id'];
			// this is to empty the values
			$tpl->assign("tax_id", "");
			$tpl->assign("tax_name","");
			$tpl->assign("tax_percentage", "");
			$result->close;
		}//endelse
	}

	break; // tax is inserted

	case "change":
		//this is diretly sent from taxes.php to change a specific tax
		$tpl->assign("what_to_do", lang('change_tax'));
		$tpl->assign("next_function", "changed");
		$result=rosine_database_query(
			$rosine_db_query['get_taxs']. ' TAX_ID="'.$_POST['tax_id'].'" LIMIT 1',102);
		if ($result!=false) {
			$row = $result->fetch_array();
			$tpl->assign("tax_id", $row['TAX_ID'].
					'" > <input type="hidden" name="oldnumber" value="'.$row['TAX_ID'].'"');
			//this is to have the possibiliity to change even the tax number!
			$tpl->assign("tax_name",$row['TAX_NAME']);
			$tpl->assign("tax_percentage", $row['TAX_PERCENTAGE']);
			$result->close();
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
		$result=rosine_database_query( 
			$rosine_db_query['update_tax'].
		' TAX_ID="'.$_POST['tax_id'].'",
							 TAX_NAME="'.$_POST['tax_name'].'",
							 TAX_PERCENTAGE='.$_POST['tax_percentage'].',
							 CHANGED="'.date("Y-m-d-H-i-s").'"
							 WHERE TAX_ID="'.$_POST['oldnumber'].'"',104);
		if ($result!=false) {
			$OK.=lang('tax_changed');
		}


	default:
		// this file is 1. loaded, no inserted articles before
		$tpl->assign("what_to_do", lang('insert_new_tax'));
		$tpl->assign( "next_function", "new" );
		// this is to empty the values
		$tpl->assign("tax_id", "");
		$tpl->assign("tax_name","");
		$tpl->assign("tax_percentage", "");
}//end case select what happens with the data
$tpl->assign("error", $error);
$tpl->assign("OK", $OK);
$tpl->display();
?>
