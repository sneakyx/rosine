<?php
	/**************************************************************************\
	* Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
	* http://www.rothaarsystems.de                                             *
	* Author: info@rothaarsystems.de                                           *
	* --------------------------------------------                             *
	*  This program is free software; you can redistribute it and/or modify it *
	*  under the terms of the GNU General Public License as published by the   *
	*  Free Software Foundation; version 2 of the License.                     *
	*  date of this file: 2015-11-19  										   *
	\**************************************************************************/


$GLOBALS['phpgw_info']['flags']['currentapp'] = 'rosine';
include('../header.inc.php');
// importierung von Stylesheets


// Variablenumwandlung und Deklaration
// Eigene Verbindung zur Datenbank
@$db = mysql_connect($egw_info["server"]["db_host"], $egw_info["server"]["db_user"], $egw_info["server"]["db_pass"]) OR die("Fehler mit Datenbank");
@mysql_select_db($egw_info["server"]["db_name"],$db) OR die ("Falsche Datenbank!");


?>


