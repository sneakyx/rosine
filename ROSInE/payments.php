<?php
	/**************************************************************************\
	* Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
	* http://www.rothaarsystems.de                                             *
	* Author: info@rothaarsystems.de                                           *
	* --------------------------------------------                             *
	*  This program is free software; you can redistribute it and/or modify it *
	*  under the terms of the GNU General Public License as published by the   *
	*  Free Software Foundation; version 2 of the License.                     *
	*  date of this file: 2016-08-24 										   *
	\**************************************************************************/


$GLOBALS['egw_info'] = array(
		'flags' => array(
				'currentapp' => 'rosine',
				'noheader'   => True,
				'nonavbar'   => True
		));

include('../header.inc.php');
@$db = mysql_connect($egw_info["server"]["db_host"], $egw_info["server"]["db_user"], $egw_info["server"]["db_pass"]) OR die("Fehler mit Datenbank");
@mysql_select_db($egw_info["server"]["db_name"],$db) OR die ("Falsche Datenbank!");

echo file_get_contents("templates/rosine/head.html");
//echo file_get_contents('inc/mainmenu.html');

echo"not yet implemented!";
echo file_get_contents("template/rosine/footer.html");
// Variablenumwandlung und Deklaration
// Eigene Verbindung zur Datenbank

?>