<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
* http://www.rothaarsystems.de                                             *
* Author: info@rothaarsystems.de                                           *
* --------------------------------------------                             *
*  This program is free software; you can redistribute it and/or modify it *
*  under the terms of the GNU General Public License as published by the   *
*  Free Software Foundation; version 2 of the License.                     *
*  date of this file: 2016-12-30 										   *
\**************************************************************************/
include ('inc/head.inc.php');

$tpl->load("insert_configuration.html");
$lang = $tpl->loadLanguage($lang);

switch ($_POST['next_function']){

	case "new":
		$tpl->assign("next_function", "new");
		$tpl->assign("what_to_do", $lang['insert_again_new_location']);
		if ($_POST['configuration']==""){
			$error.=str_replace('%value%', $lang['config'], $lang['missing'])."<br>";
		}//endif
		if ($_POST['user_id']==""){
			$error.=str_replace('%value%', $lang['user'], $lang['missing'])."<br>";
		}//endif
		if ($_POST['value']==""){
			$error.=str_replace('%value%', $lang['value'], $lang['missing'])."<br>";
		}//endif
		
		if ($error==""){
			// in Tabelle einfügen!
			$result=rosine_database_query( 
				$rosine_db_query['insert_configuration'].
					'("'.$_POST['config'].'",'.
					$_POST['user_id'].', "'.
					$_POST['value'].'")',101);
			
			if ($result==false) {
				// Error in mysql detected
				$tpl->assign("config", $_POST['config']);
				$tpl->assign("user_id",$_POST['user_id']);
				$tpl->assign("value", $_POST['value']);
			}
			else {
				//no error in mysql
				$OK=$lang['config_inserted']." ".$lang['config'].":".$_POST['config'];
				// this is to empty the values
				$tpl->assign("config", "");
				$tpl->assign("user_id","");
				$tpl->assign("value", "");
				$result->close;
			}// else =no error in mysql
			
		}// error=0;
				
		break; // location is inserted

	case "change":
		//this is if diretly sent to a special config
		$tpl->assign("what_to_do", $lang['change_config']);
		$tpl->assign("next_function", "changed");
		$result=rosine_database_query( 
				$rosine_db_query['get_configurations']. ' config="'.$_POST['config'].'" and user_id='.$_POST['user_id'].' LIMIT 1',102);
		if ($result !=false) {
			$row = $result->fetch_array();
			$tpl->assign("config", $row['config'].
					'" > <input type="hidden" name="oldconfig" value="'.$row['config'].'"');
			//this is to have the possibiliity to change even the tax number!
			$tpl->assign("user_id",$row['user_id'].
					'" > <input type="hidden" name="olduser_id" value="'.$row['user_id'].'"');
			$tpl->assign("value", $row['value']);
			$result->close();
		}// error in mysql 
		
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
			$rosine_db_query['update_configuration'].
				' config="'.$_POST['config'].'",
				 user_id='.$_POST['user_id'].',
				 value="'.$_POST['value'].'"
				 WHERE config="'.$_POST['oldconfig'].'" and user_id='.$_POST['olduser_id'],104);
		if ($result!=false) {
			$OK.=$lang['config_changed'];
		}//endif


	default:
		// this file is 1. loaded, no inserted articles before
		$tpl->assign("what_to_do", $lang['insert_new_configuration']);
		$tpl->assign( "next_function", "new" );
		// this is to empty the values
		$tpl->assign("config", "");
		$tpl->assign("value","");
		$tpl->assign("user_id", "");
		$tpl->assign("what_to_do", $lang['insert_config']);
}//end case select what happens with the data
$tpl->assign("error", $error);
$tpl->assign("OK", $OK);
$tpl->display();
?>
