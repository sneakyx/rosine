<?
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-08-26  										    *
 \**************************************************************************/
$GLOBALS['egw_info'] = array(
		'flags' => array(
				'currentapp' => 'rosine',
				'noheader'   => False,
				'nonavbar'   => True
		));
include('../header.inc.php');

$rosine_db_prefix="rosine_";
$egw_db_prefix="egw_";
//for error-and OK-Bar (if nothing to show, they don't show up!
$error="";
$OK="";

function trimhtml (&$value, $key) {
	$value = trim(htmlspecialchars($value, ENT_QUOTES));
}
array_walk_recursive($_GET, 'trimhtml');
array_walk_recursive ($_POST, 'trimhtml');

include ('inc/db.inc.php');
include ('inc/template.class.php');
include_once ('inc/functions.inc.php'); // seems this is inserted by egroupware api
$result=rosine_database_query($rosine_db_query['get_config'],1);
while ($f= $result->fetch_array()) {
	$config[$f['config']]=$f['value'];
//	echo $f['config'].": ".$f['value']."<br>"; // this is just to get an output for the configuration in the database
}// put config into array
$result->close;
//things for every template
$tpl = new Rosine_Template();
$tpl->set_templateDir(substr($GLOBALS['egw_info']['server']['backup_dir'],0,strrpos($GLOBALS['egw_info']['server']['backup_dir'], '/')).'/rosine/templates/');
$lang[] = $config['language'];

?>