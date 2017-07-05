<?
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2017-06-29  										    *
 \**************************************************************************/


if (basename ($_SERVER['SCRIPT_NAME'])!= "paperwork_print.php") {
	$GLOBALS['egw_info'] = array(
			'flags' => array(
					'currentapp' => 'rosine',
					'noheader'   => False,
					'nonavbar'   => True
			));
}// header for all files but not printing
else {
	$GLOBALS['egw_info'] = array(
			'flags' => array(
					'currentapp' => 'rosine',
					'noheader'   => True,
					'nonavbar'   => True
			));
}// header for paperwork_print.php
include('../header.inc.php');

$rosine_db_prefix="rosine_";
$egw_db_prefix="egw_";
//for error-and OK-Bar (if nothing to show, they don't show up!
$error="";
$OK="";

function trimhtml (&$value, $key) {
	$value = trim(htmlspecialchars($value, ENT_QUOTES)); // just to delete strange, dangerous stuff from GET and POST
	//echo $key.":".$value."<br>"; // this line is just for debugging
	$newvalue=str_replace(' ','',str_replace(",",".",$value));
	if (is_numeric($newvalue)){
		$value=floatval($newvalue);
	}// change kommas in numbers to dot
	//echo "$key=$value <br>"; //just a test function!
}// function trimhtml
array_walk_recursive($_GET, 'trimhtml');
array_walk_recursive ($_POST, 'trimhtml');
$_POST=(array_merge($_POST, $_GET));
include ('inc/db.inc.php');
include ('inc/template.class.php');
include_once ('inc/functions.inc.php'); // seems this is inserted by egroupware api
include ('inc/template.paperwork.class.php');

$result=rosine_database_query($rosine_db_query['get_config'],1);
while ($f= $result->fetch_array()) {
	$config[$f['config']]=$f['value'];
	//echo $f['config'].": ".$f['value']."<br>"; // this is just to get an output for the configuration in the database
}// put config into array
$result->close;
//things for every template
if ($rosine_load_template_paperwork){
	$tpl = new Rosine_Paperwork_Template();
}// load special class
else {
	$tpl = new Rosine_Template();
}// normal class

$tpl->set_templateDir(substr($GLOBALS['egw_info']['server']['backup_dir'],0,strrpos($GLOBALS['egw_info']['server']['backup_dir'], '/')).'/rosine/templates/');
$lang[] = $config['language'];

// if configuration says, the templates have to be overwritten, just do it!
if ($config['overwrite_templates']=="yes"){
	$tpl->rosine_setup_templates($renew="yes");
	$result=rosine_database_query(
			$rosine_db_query['update_configuration'].
			' user_id=0, value="no"
			 WHERE config="overwrite_templates" ',104);
			if ($result!=false) {
				$OK.=$lang['config_changed'];
			}//endif
				
}// templates are renewed

?>