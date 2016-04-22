<?php 
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-04-20  										    *
 \**************************************************************************/


@$rosine_db = mysql_connect($egw_info["server"]["db_host"], $egw_info["server"]["db_user"], $egw_info["server"]["db_pass"]) OR die("Fehler mit Datenbank");
@mysql_select_db($egw_info["server"]["db_name"],$rosine_db) OR die ("Wrong database!");
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
$paperwork_terms="Zahlbar innerhalb von 14 Tagen. Falls nicht anders angegeben, ist Rechnungsdatum auch Lieferdatum!";

// mysql to get config
$rosine_db_query['get_config']='SELECT * FROM '.$rosine_db_prefix.'config WHERE user_id =0 OR user_id ='.$egw_info['user']['account_id'].' GROUP BY config desc';
$result=mysql_query($rosine_db_query['get_config']);
if (mysql_errno($rosine_db)!=0) {
	// Error in mysql detected
	echo "1000: ".mysql_error($rosine_db);
	echo $rosine_db_query['get_config'];
}
while ($f= mysql_fetch_array($result)) {
	$config[$f['config']]=$f['value'];
//	echo $f['config'].": ".$f['value']."<br>"; // this is just to get an output for the configuration in the database
}// put config into array
//mysql for articles
$rosine_db_query['insert_article']="INSERT INTO ".$rosine_db_prefix."articles (ART_NUMBER, ART_UNIT, ART_NAME, ART_PRICE, ART_TAX, ART_STOCKNR, ART_INSTOCK, ART_NOTE, GENERATED, CHANGED) VALUES ";
$rosine_db_query['get_articles']="SELECT * FROM ".$rosine_db_prefix."articles WHERE ";
$rosine_db_query['get_article_ammount']="SELECT COUNT(*) FROM ".$rosine_db_prefix."articles WHERE ";
$rosine_db_query['update_article']="UPDATE ".$rosine_db_prefix."articles SET ";
$rosine_db_query['delete_article']="DELETE FROM ".$rosine_db_prefix."articles WHERE ";
$rosine_db_query['get_next_article_number']='SELECT MAX(ART_NUMBER) AS maximum FROM '.$rosine_db_prefix.'articles WHERE 1';
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

// mysql for special lists
$rosine_db_query['most_used_articles']="SELECT art_name, count(p.art_number) as counter,p.art_number as art_number from ".$rosine_db_prefix."%plural%_positions as p JOIN ".$rosine_db_prefix."articles AS a ON a.art_number=p.art_number where 1 group by art_number ORDER BY counter DESC LIMIT ".$config['favorite_articles'];
$rosine_db_query['paperwork_not_used']='SELECT r.%singular%_id AS %singular%_id, GROUP_CONCAT(concat (p.posi_ammount, " ", a.art_name)) AS contents, r.changed AS changed, COUNT(p.posi_id) AS ammount, r.%singular%_ammount AS money FROM '.$rosine_db_prefix.'%plural% AS r JOIN '.$rosine_db_prefix.'%plural%_positions as p on r.%singular%_id = p.%singular%_id JOIN '.$rosine_db_prefix.'articles AS a ON a.art_number=p.art_number WHERE %singular%_status="changed" AND %singular%_customer=%customer% GROUP BY %singular%_id ORDER BY changed DESC'; 

// mysql for paperwork
$rosine_db_query['insert_paperwork']="INSERT INTO ".$rosine_db_prefix."%plural% (%singular%_ID,%singular%_DATE,%singular%_CUSTOMER,%singular%_CUSTOMER_PRIVATE,%singular%_AMMOUNT,%singular%_STATUS,GENERATED) VALUES ";
$rosine_db_query['get_highest_number']="SELECT MAX(%singular%_id) AS maximum FROM ".$rosine_db_prefix."%plural% WHERE %1%";
$rosine_db_query['insert_article_into_paperwork']='INSERT INTO '.$rosine_db_prefix.'%plural%_positions (%singular%_ID, POSI_ID, ART_NUMBER, POSI_AMMOUNT, POSI_UNIT, POSI_PRICE, POSI_LOCATION, POSI_SERIAL, POSI_TEXT, POSI_TAX) VALUES ';
$rosine_db_query['get_articles_from_paperwork']="SELECT * FROM ".$rosine_db_prefix;
$rosine_db_query['delete_article_from_paperwork']="DELETE FROM ".$rosine_db_prefix."%paperwork%_positions WHERE ";
$rosine_db_query['correct_numbers_from_paperwork']="UPDATE ".$rosine_db_prefix."%plural%_positions r,(SELECT @n := 0) m SET r.posi_id = @n := @n + 1 WHERE r.%singular%_id=%id%;";
$rosine_db_query['update_paperwork_ammount']="UPDATE ".$rosine_db_prefix."%plural% SET %singular%_AMMOUNT = ( SELECT sum( posi_price * posi_ammount ) AS %singular%_ammount FROM ".$rosine_db_prefix."%plural%_positions WHERE %singular%_id =%id% ) , CHANGED = now( ) WHERE %singular%_id =%id%";
$rosine_db_query['get_ammount_of_paperworks']="SELECT count(*) FROM ".$rosine_db_prefix."%paperwork% WHERE ";
$rosine_db_query['get_paperworks']="SELECT * FROM ".$rosine_db_prefix."%plural%  JOIN ".$egw_db_prefix."addressbook ON %singular%_customer = contact_id WHERE ";
$rosine_db_query['delete_paperwork']="DELETE FROM ".$rosine_db_prefix."%plural% WHERE %singular%_ID=%ID% LIMIT 1";
$rosine_db_query['delete_paperwork_positions']="DELETE FROM ".$rosine_db_prefix."%plural%_positions WHERE %singular%_ID=%ID%";
$rosine_db_query['count_real_number']="SELECT count( * ) FROM ".$rosine_db_prefix."%plural% WHERE %singular%_ID <=";
$rosine_db_query['set_paperwork_status']="UPDATE ".$rosine_db_prefix.'%plural% SET %singular%_status="%status%" WHERE %singular%_ID=%ID% LIMIT 1';
$rosine_db_query['insert_paperwork_into_paperwork']='set @n= %max%; INSERT INTO '.$rosine_db_prefix.'%plural2%_positions SELECT %ID2%,(@n:=@n+1) as POSI_ID , ART_NUMBER, POSI_AMMOUNT, POSI_UNIT, POSI_PRICE, POSI_LOCATION, POSI_SERIAL, CONCAT("%infotext% ",POSI_TEXT), POSI_TAX FROM '.$rosine_db_prefix.'%plural1%_positions WHERE %singular1%_id=%ID1%';
$rosine_db_query['get_customer_name_by_paperwork_id']='SELECT e.n_fn as customer_name, %singular%_customer as customer_id  FROM '.$egw_db_prefix.'addressbook AS e JOIN '.$rosine_db_prefix.'%plural% as r ON e.contact_id=%singular%_CUSTOMER WHERE r.%singular%_id=%ID%';
$rosine_db_query['update_paperwork_item']='UPDATE '.$rosine_db_prefix.'%plural%_positions SET %set% WHERE %singular%_id=%paperwork_id% AND posi_id=%posi_id% LIMIT 1';
$rosine_db_query['get_articles_from_paperwork_with_all']='SELECT * FROM '.$rosine_db_prefix.'%plural%_positions AS r JOIN '.$rosine_db_prefix.'locations AS l ON r.POSI_LOCATION=l.LOC_ID JOIN '.$rosine_db_prefix.'taxes AS t ON r.POSI_TAX=TAX_ID WHERE ';
//mysql for payments
$rosine_db_query['get_unpaid_invoices']='SELECT e.n_fn AS name, i.INVOICE_CUSTOMER AS invoice_customer, i.INVOICE_ID AS invoice_id, i.INVOICE_AMMOUNT AS invoice_ammount, sum( p.PAYMENT_AMMOUNT ) AS already_paid FROM '.$rosine_db_prefix.'invoices AS i NATURAL LEFT JOIN '.$rosine_db_prefix.'payments AS p JOIN '.$egw_db_prefix.'addressbook as e ON i.INVOICE_CUSTOMER=e.contact_id WHERE i.invoice_status = "changed" GROUP BY i.INVOICE_ID ORDER BY i.INVOICE_ID';
$rosine_db_query['get_payment_methods']='SELECT * FROM '.$rosine_db_prefix.'payments_methods WHERE 1';
$rosine_db_query['insert_payment']='INSERT INTO '.$rosine_db_prefix.'payments (PAYMENT_ID , INVOICE_ID , PAYMENT_DATE , METH_ID , PAYMENT_AMMOUNT , PAYMENT_NOTE ) VALUES ';
$rosine_db_query['get_open_money']='SELECT sum(p.PAYMENT_AMMOUNT) as already_payed, i.INVOICE_AMMOUNT as invoice_ammount from '.$rosine_db_prefix.'payments as p JOIN '.$rosine_db_prefix.'invoices as i on i.INVOICE_ID=p.INVOICE_ID WHERE p.INVOICE_ID=';

?>