<?php
	/**************************************************************************\
	* Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
	* http://www.rothaarsystems.de                                             *
	* Author: info@rothaarsystems.de                                           *
	* --------------------------------------------                             *
	*  This program is free software; you can redistribute it and/or modify it *
	*  under the terms of the GNU General Public License as published by the   *
	*  Free Software Foundation; version 2 of the License.                     *
	*  date of this file: 2016-01-02 										   *
	\**************************************************************************/
$GLOBALS['phpgw_info']['flags']['currentapp'] = 'rosine';
include('../header.inc.php');
include ('inc/settings.php');
include ('inc/template.class.php');
$tpl = new Rosine_Template();
$lang[] = "de.php";
$error="";
$OK="";
if ($_POST['next_function']=="new") {
	$tpl->load("insert_article.html");
	$lang = $tpl->loadLanguage($lang);
	$tpl->assign("next_function", "new");
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
							$_POST[price].', 
							1 , 
							1, '.
							$_POST[stock].', "'.
							$_POST[notes].'", "'.
							date("Y-m-d-H-i").'","")');
		$OK=$result;
	}
	$tpl->assign("error", $error);
	$tpl->assign("OK", $OK);	
}
else {
	$tpl->load("new_article.html");
	$tpl->assign( "next_function", "new" );
	$lang = $tpl->loadLanguage($lang);
}
$tpl->display();
?>


