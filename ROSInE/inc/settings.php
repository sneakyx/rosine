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


@$rosine_db = mysql_connect($egw_info["server"]["db_host"], $egw_info["server"]["db_user"], $egw_info["server"]["db_pass"]) OR die("Fehler mit Datenbank");
@mysql_select_db($egw_info["server"]["db_name"],$rosine_db) OR die ("Falsche Datenbank!");
$rosine_db_prefix="rosine_";

function trimhtml (&$value, $key) {
	$value = trim(htmlspecialchars($value, ENT_QUOTES));
}
array_walk ($_GET, 'trimhtml');
array_walk ($_POST, 'trimhtml');

$rosine_db_query['insert_article']="INSERT INTO ".$rosine_db_prefix."articles (ART_NUMBER, ART_UNIT, ART_NAME, ART_PRICE, ART_TAX, ART_STOCKNR, ART_INSTOCK, ART_NOTE, GENERATED, CHANGED) VALUES ";
?>