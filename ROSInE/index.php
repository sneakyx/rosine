<?php
	/**************************************************************************\
	* Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
	* http://www.rothaarsystems.de                                             *
	* Author: info@rothaarsystems.de                                           *
	* --------------------------------------------                             *
	*  This program is free software; you can redistribute it and/or modify it *
	*  under the terms of the GNU General Public License as published by the   *
	*  Free Software Foundation; version 2 of the License.                     *
	*  date of this file: 2016-08-27 										   *
	\**************************************************************************/
include ('inc/head.inc.php');

$tpl->load("mainmenu.html");
$lang = $tpl->loadLanguage($lang);
if (!$lang){
	echo "<br>False!<br>";
}

$tpl->assign("OK", "");
$tpl->assign("error", "");
$tpl->display();

?>
