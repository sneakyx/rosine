<?php 
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-03-25  										    *
 \**************************************************************************/


@$rosine_db = mysql_connect($egw_info["server"]["db_host"], $egw_info["server"]["db_user"], $egw_info["server"]["db_pass"]) OR die("Fehler mit Datenbank");
@mysql_select_db($egw_info["server"]["db_name"],$rosine_db) OR die ("Falsche Datenbank!");
$rosine_db_prefix="rosine_";
$egw_db_prefix="egw_";
mysql_query("SET NAMES 'utf8'");
function trimhtml (&$value, $key) {
	//if ($key !="articles" || $key != "ammount")
	//	$value = trim(htmlspecialchars($value, ENT_QUOTES));
	// das funktioniert im Moment noch nicht mit den 2 dimensionalen Aarrays!
	// Da muss ich mir noch was ausdenken!
}
array_walk ($_GET, 'trimhtml');
array_walk ($_POST, 'trimhtml');

//for error-and OK-Bar (if nothing to show, they don't show up!
$error="";
$OK="";
$language="de.php";

// some important things
$currency="€";
$items_per_page="10"; // list of articles per page, etc
$articles_per_page=10; // ammount of input fields in new offer, order, invoice
$customers_per_page=10; // ammount of shown customers in new offer, order, invoice

//mysql for articles
$rosine_db_query['insert_article']="INSERT INTO ".$rosine_db_prefix."articles (ART_NUMBER, ART_UNIT, ART_NAME, ART_PRICE, ART_TAX, ART_STOCKNR, ART_INSTOCK, ART_NOTE, GENERATED, CHANGED) VALUES ";
$rosine_db_query['get_articles']="SELECT * FROM ".$rosine_db_prefix."articles WHERE ";
$rosine_db_query['get_article_ammount']="SELECT COUNT(*) FROM ".$rosine_db_prefix."articles WHERE ";
$rosine_db_query['update_article']="UPDATE ".$rosine_db_prefix."articles SET ";
$rosine_db_query['delete_article']="DELETE FROM ".$rosine_db_prefix."articles WHERE ";

// mysql for taxes
$rosine_db_query['get_tax_ammount']="SELECT COUNT(*) FROM ".$rosine_db_prefix."taxes WHERE ";
$rosine_db_query['get_taxes']="SELECT * FROM ".$rosine_db_prefix."taxes WHERE ";
$rosine_db_query['update_tax']="UPDATE ".$rosine_db_prefix."taxes SET ";
$rosine_db_query['delete_tax']="DELETE FROM ".$rosine_db_prefix."taxes WHERE ";
$rosine_db_query['insert_tax']="INSERT INTO ".$rosine_db_prefix."taxes (TAX_ID, TAX_NAME, TAX_PERCENTAGE, GENERATED, CHANGED) VALUES ";

// mysql for locations
$rosine_db_query['get_locations_ammount']="SELECT COUNT(*) FROM ".$rosine_db_prefix."locations WHERE ";
$rosine_db_query['get_locations']="SELECT * FROM ".$rosine_db_prefix."locations WHERE ";
$rosine_db_query['update_location']="UPDATE ".$rosine_db_prefix."locations SET ";
$rosine_db_query['delete_location']="DELETE FROM ".$rosine_db_prefix."locations WHERE ";
$rosine_db_query['insert_location']="INSERT INTO ".$rosine_db_prefix."locations (LOC_ID, LOC_NAME, LOC_NOTE, GENERATED, CHANGED) VALUES ";

// mysql for search customers
$rosine_db_query['search_customers_ammount']="SELECT COUNT(*) FROM ".$egw_db_prefix."addressbook WHERE ";
$rosine_db_query['get_customers']="SELECT * FROM ".$egw_db_prefix."addressbook WHERE ";

// mysql for offers
$rosine_db_query['insert_offer']="INSERT INTO ".$rosine_db_prefix."offers (OFFER_ID,OFFER_DATE,OFFER_CUSTOMER,OFFER_CUSTOMER_PRIVATE,OFFER_AMMOUNT,OFFER_STATUS,GENERATED) VALUES ";
$rosine_db_query['get_highest_number']="SELECT MAX(%singular%_id) AS maximum FROM ".$rosine_db_prefix."%plural% WHERE %1%";

$rosine_db_query['insert_article_into_offer']='INSERT INTO '.$rosine_db_prefix.'offers_positions (OFFER_ID, POSI_ID, ART_NUMBER, POSI_AMMOUNT, POSI_UNIT, POSI_PRICE, POSI_LOCATION, POSI_SERIAL, POSI_TEXT, POSI_TAX) VALUES ';
// mysql for paperwork

$rosine_db_query['get_articles_from_paperwork']="SELECT * FROM ".$rosine_db_prefix;
?>