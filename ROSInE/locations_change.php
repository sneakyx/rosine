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

$tpl->load("insert_location.html");


switch ($_POST['next_function']){

	case "new":
		$tpl->assign("next_function", "new");
		$tpl->assign("what_to_do", lang('insert_again_new_location'));
		if ($_POST['loc_id']==""){
			$error.=lang('number_missing')."<br>";
		}//endif
		if ($_POST['loc_name']==""){
			$error.=lang('name_missing')."<br>";
		}//endif
				
		if ($error==""){
			// in Tabelle einfügen!
			$result=rosine_database_query( 
				$rosine_db_query['insert_location'].
					'('.$_POST['loc_id'].',"'.
					$_POST['loc_name'].'", "'.
					$_POST['loc_note'].'",
					"","'.
					date("Y-m-d-H-i-s").'")',101);
			
			if ($result==false) {
				// Error in mysql detected
				$tpl->assign("loc_id", $_POST['loc_id']);
				$tpl->assign("loc_name",$_POST['loc_name']);
				$tpl->assign("loc_note", $_POST['loc_note']);
			}
			else {
				//no error in mysql
				$OK=lang('location_inserted')." ".lang('location_id').":".$_POST['loc_id'];
				// this is to empty the values
				$tpl->assign("loc_id", "");
				$tpl->assign("loc_name","");
				$tpl->assign("loc_note", "");
				$result->close;
			}// else =no error in mysql
			
		}// error=0;
				
		break; // location is inserted

	case "change":
		//this is diretly sent from taxes.php to change a specific tax
		$tpl->assign("what_to_do", lang('change_location'));
		$tpl->assign("next_function", "changed");
		$result=rosine_database_query( 
				$rosine_db_query['get_locations']. ' LOC_ID="'.$_POST['loc_id'].'" LIMIT 1',102);
		if ($result !=false) {
			$row = $result->fetch_array();
			$tpl->assign("loc_id", $row['LOC_ID'].
					'" > <input type="hidden" name="oldnumber" value="'.$row['LOC_ID'].'"');
			//this is to have the possibiliity to change even the tax number!
			$tpl->assign("loc_name",$row['LOC_NAME']);
			$tpl->assign("loc_note", $row['LOC_NOTE']);
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
			$rosine_db_query['update_location'].
				' LOC_ID='.$_POST['loc_id'].',
				 LOC_NAME="'.$_POST['loc_name'].'",
				 LOC_NOTE="'.$_POST['loc_note'].'",
				 CHANGED="'.date("Y-m-d-H-i-s").'"
				 WHERE LOC_ID='.$_POST['oldnumber'],104);
		if ($result!=false) {
			$OK.=lang('location_changed');
		}//endif


	default:
		// this file is 1. loaded, no inserted articles before
		$tpl->assign("what_to_do", lang('insert_new_location'));
		$tpl->assign( "next_function", "new" );
		// this is to empty the values
		$tpl->assign("loc_id", "");
		$tpl->assign("loc_name","");
		$tpl->assign("loc_note", "");
}//end case select what happens with the data
$tpl->assign("error", $error);
$tpl->assign("OK", $OK);
$tpl->display();
?>
