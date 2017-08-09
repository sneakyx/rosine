<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
* http://www.rothaarsystems.de                                             *
* Author: info@rothaarsystems.de                                           *
* --------------------------------------------                             *
*  This program is free software; you can redistribute it and/or modify it *
*  under the terms of the GNU General Public License as published by the   *
*  Free Software Foundation; version 2 of the License.                     *
*  date of this file: 2017-08-08  										    *
\**************************************************************************/

// mysql to get config
$rosine_db_query['get_config']='SELECT * FROM '.$rosine_db_prefix.
'config WHERE user_id =0 OR user_id ='.$GLOBALS['egw_info']['user']['account_id'].
' GROUP BY config desc';
//mysql for articles
$rosine_db_query['insert_article']="INSERT INTO ".$rosine_db_prefix."articles (ART_NUMBER, ART_UNIT, ART_NAME, ART_PRICE, ART_TAX, ART_STOCKNR, ART_INSTOCK, ART_NOTE, `GENERATED`, CHANGED) VALUES ";
$rosine_db_query['get_articles']="SELECT * FROM ".$rosine_db_prefix."articles WHERE ";
$rosine_db_query['get_article_ammount']="SELECT COUNT(*) FROM ".$rosine_db_prefix."articles WHERE ";
$rosine_db_query['update_article']="UPDATE ".$rosine_db_prefix."articles SET ";
$rosine_db_query['delete_article']="DELETE FROM ".$rosine_db_prefix."articles WHERE ";
$rosine_db_query['get_next_article_number']='SELECT MAX(ART_NUMBER) AS maximum FROM '.$rosine_db_prefix.'articles WHERE 1';
// mysql for taxes
$rosine_db_query['get_tax_ammount']="SELECT COUNT(*) FROM ".$rosine_db_prefix."taxes WHERE ";
$rosine_db_query['get_taxs']="SELECT * FROM ".$rosine_db_prefix."taxes WHERE ";
$rosine_db_query['update_tax']="UPDATE ".$rosine_db_prefix."taxes SET ";
$rosine_db_query['delete_tax']="DELETE FROM ".$rosine_db_prefix."taxes WHERE ";
$rosine_db_query['insert_tax']="INSERT INTO ".$rosine_db_prefix."taxes (TAX_ID, TAX_NAME, TAX_PERCENTAGE, `GENERATED`, CHANGED) VALUES ";

// mysql for locations
$rosine_db_query['get_location_ammount']="SELECT COUNT(*) FROM ".$rosine_db_prefix."locations WHERE ";
$rosine_db_query['get_locations']="SELECT * FROM ".$rosine_db_prefix."locations WHERE ";
$rosine_db_query['update_location']="UPDATE ".$rosine_db_prefix."locations SET ";
$rosine_db_query['delete_location']="DELETE FROM ".$rosine_db_prefix."locations WHERE ";
$rosine_db_query['insert_location']="INSERT INTO ".$rosine_db_prefix."locations (LOC_ID, LOC_NAME, LOC_NOTE, `GENERATED`, CHANGED) VALUES ";

// mysql for search customers
$rosine_db_query['search_customers_ammount']="SELECT COUNT(*) FROM ".$egw_db_prefix."addressbook WHERE ";
$rosine_db_query['get_customers']="SELECT * FROM ".$egw_db_prefix."addressbook WHERE ";

// mysql for special lists
$rosine_db_query['most_used_articles']="SELECT art_name, count(p.art_number) as counter,p.art_number as art_number, a.art_unit as art_unit from ".$rosine_db_prefix."%plural%_positions as p JOIN ".$rosine_db_prefix."articles AS a ON a.art_number=p.art_number WHERE 1 GROUP BY art_number ORDER BY counter DESC LIMIT ".$config['favorite_articles'];
$rosine_db_query['paperwork_not_used']='SELECT r.%singular%_id AS %singular%_id, GROUP_CONCAT(concat (p.posi_ammount, " ", a.art_name)) AS contents, r.changed AS changed, COUNT(p.posi_id) AS ammount, r.%singular%_ammount AS money FROM '.$rosine_db_prefix.'%plural% AS r JOIN '.$rosine_db_prefix.'%plural%_positions as p on r.%singular%_id = p.%singular%_id JOIN '.$rosine_db_prefix.'articles AS a ON a.art_number=p.art_number WHERE %where% AND (%singular%_customer=%customer% ) GROUP BY %singular%_id ORDER BY changed DESC';

// mysql for paperwork
$rosine_db_query['insert_paperwork']="INSERT INTO ".$rosine_db_prefix."%plural% (%SINGULAR%_ID,%SINGULAR%_DATE,%SINGULAR%_CUSTOMER,%SINGULAR%_CUSTOMER_PRIVATE,%SINGULAR%_AMMOUNT,%SINGULAR%_STATUS,`GENERATED`,%SINGULAR%_NOTE, %SINGULAR%_TEMPLATE) VALUES ";
$rosine_db_query['get_highest_number']="SELECT MAX(%singular%_id) AS maximum FROM ".$rosine_db_prefix."%plural% WHERE %1%";
$rosine_db_query['insert_article_into_paperwork']='INSERT INTO '.$rosine_db_prefix.'%plural%_positions (%SINGULAR%_ID, POSI_ID, ART_NUMBER, POSI_AMMOUNT, POSI_UNIT, POSI_PRICE, POSI_LOCATION, POSI_SERIAL, POSI_TEXT, POSI_TAX) VALUES ';
$rosine_db_query['get_articles_from_paperwork']="SELECT * FROM ".$rosine_db_prefix;
$rosine_db_query['delete_article_from_paperwork']="DELETE FROM ".$rosine_db_prefix."%paperwork%_positions WHERE ";
$rosine_db_query['correct_numbers_from_paperwork']="UPDATE ".$rosine_db_prefix."%plural%_positions r,(SELECT @n := 0) m SET r.posi_id = @n := @n + 1 WHERE r.%singular%_id=%id%;";
$rosine_db_query['update_paperwork_ammount']="UPDATE ".$rosine_db_prefix."%plural% SET %singular%_AMMOUNT = ( SELECT sum( posi_price * posi_ammount ) AS %singular%_ammount FROM ".$rosine_db_prefix."%plural%_positions WHERE %singular%_id =%id% ) , CHANGED = now( ) WHERE %singular%_id =%id%";
$rosine_db_query['get_ammount_of_paperworks']="SELECT count(*) FROM ".$rosine_db_prefix."%paperwork% WHERE ";
$rosine_db_query['get_paperworks']="SELECT * FROM ".$rosine_db_prefix."%plural%  JOIN ".$egw_db_prefix."addressbook ON %SINGULAR%_CUSTOMER = contact_id WHERE ";
$rosine_db_query['delete_paperwork']="DELETE FROM ".$rosine_db_prefix."%plural% WHERE %singular%_ID=%ID% LIMIT 1";
$rosine_db_query['delete_paperwork_positions']="DELETE FROM ".$rosine_db_prefix."%plural%_positions WHERE %singular%_ID=%ID%";
$rosine_db_query['count_real_number']="SELECT count( * ) FROM ".$rosine_db_prefix."%plural% WHERE %singular%_ID <=";
$rosine_db_query['set_paperwork_status']="UPDATE ".$rosine_db_prefix.'%plural% SET %singular%_status="%status%" WHERE %singular%_ID=%ID% LIMIT 1';
$rosine_db_query['insert_paperwork_into_paperwork']='set @n= %max%; INSERT INTO '.$rosine_db_prefix.'%plural2%_positions SELECT %ID2%,(@n:=@n+1) as POSI_ID , ART_NUMBER, POSI_AMMOUNT, POSI_UNIT, POSI_PRICE, POSI_LOCATION, POSI_SERIAL, CONCAT("%infotext% ",POSI_TEXT), POSI_TAX, false FROM '.$rosine_db_prefix.'%plural1%_positions WHERE %singular1%_id=%ID1%;UPDATE '.$rosine_db_prefix.'%plural1%_positions SET DONE=true WHERE %singular1%_id=%ID1%';
$rosine_db_query['get_customer_name_by_paperwork_id']='SELECT e.n_fn as customer_name, %singular%_customer as customer_id  FROM '.$egw_db_prefix.'addressbook AS e JOIN '.$rosine_db_prefix.'%plural% as r ON e.contact_id=%singular%_CUSTOMER WHERE r.%singular%_id=%ID%';
$rosine_db_query['update_paperwork_item']='UPDATE '.$rosine_db_prefix.'%plural%_positions SET %set% WHERE %SINGULAR%_ID=%paperwork_id% AND POSI_ID=%posi_id% LIMIT 1';
$rosine_db_query['get_articles_from_paperwork_with_all']='SELECT * FROM '.$rosine_db_prefix.'%plural%_positions AS r JOIN '.$rosine_db_prefix.'locations AS l ON r.POSI_LOCATION=l.LOC_ID JOIN '.$rosine_db_prefix.'taxes AS t ON r.POSI_TAX=TAX_ID WHERE ';
$rosine_db_query['get_unfinished_paperwork']='SELECT r.%SINGULAR%_ID as paperwork_id, r.%SINGULAR%_CUSTOMER_PRIVATE as customer_private, e.n_fn, sum(p.POSI_AMMOUNT) AS ammount , p.POSI_LOCATION as location FROM '.$rosine_db_prefix.'%plural% as r JOIN '.$egw_db_prefix.'addressbook AS e ON r.%SINGULAR%_CUSTOMER=e.contact_id JOIN '.$rosine_db_prefix.'%plural%_positions AS p ON r.%SINGULAR%_ID=p.%SINGULAR%_ID  WHERE (r.%SINGULAR%_STATUS ="changed" OR r.%SINGULAR%_STATUS LIKE "%partly%") AND p.POSI_LOCATION=%location% AND p.DONE=false group by paperwork_id';
$rosine_db_query['get_ammount_unfinished_items']='SELECT count(*) as number FROM '.$rosine_db_prefix.'%plural%_positions WHERE %SINGULAR%_ID=%paperwork% and done=false';
$rosine_db_query['get_standard_note']='SELECT n.NOTE_TEXT as text, n.NOTE_ID as id FROM '.$rosine_db_prefix.'notes AS n JOIN '.$rosine_db_prefix.'config AS c ON n.NOTE_ID=c.value WHERE c.config="note_%singular%" AND n.LANGUAGE="%language%"';
$rosine_db_query['get_all_notes']='SELECT * FROM '.$rosine_db_prefix.'notes WHERE';
$rosine_db_query['update_paperwork_note']='UPDATE '.$rosine_db_prefix.'%plural% SET %SINGULAR%_NOTE="%paperwork%" WHERE %SINGULAR%_ID=';
$rosine_db_query['update_brutto_ammount_paperwork']='UPDATE '.$rosine_db_prefix.'%plural% SET %SINGULAR%_AMMOUNT_BRUTTO = (SELECT SUM(POSI_PRICE*(100+TAX_PERCENTAGE)/100*POSI_AMMOUNT) FROM '.$rosine_db_prefix.'%plural%_positions AS p JOIN '.$rosine_db_prefix.'taxes AS t ON p.POSI_TAX=t.TAX_ID WHERE %SINGULAR%_ID=%paperwork% GROUP BY %SINGULAR%_ID ) WHERE %SINGULAR%_ID=%paperwork%';
$rosine_db_query['set_paperwork_printed']="UPDATE ".$rosine_db_prefix.'%plural% SET %SINGULAR%_PRINTED=1 WHERE %singular%_ID=%ID% LIMIT 1';
$rosine_db_query['customer_with_most_paperwork']="SELECT e.* , count( r.%SINGULAR%_ID ) as anzahl FROM ".$egw_db_prefix."addressbook AS e JOIN ".$rosine_db_prefix."%plural% AS r ON e.contact_id = r.%SINGULAR%_CUSTOMER WHERE %where% GROUP BY contact_id ORDER BY count( r.%SINGULAR%_ID ) DESC ";
$rosine_db_query['last_customers']="SELECT max( r.%SINGULAR%_ID ) AS number, e . *
									FROM ".$egw_db_prefix."addressbook AS e
									JOIN ".$rosine_db_prefix."%plural% AS r ON e.contact_id = r.%SINGULAR%_CUSTOMER
									WHERE %where%
									GROUP BY e.contact_id
									ORDER BY number DESC ";


$rosine_db_query['customer_with_most_sales']="SELECT SUM( r.INVOICE_AMMOUNT_BRUTTO ) AS money, e.contact_id, e.n_family, e.n_given, e.org_name, e.adr_one_locality, e.adr_two_locality
												FROM ".$egw_db_prefix."addressbook AS e
												JOIN ".$rosine_db_prefix."invoices AS r ON e.contact_id = r.INVOICE_CUSTOMER
												WHERE %where%
												GROUP BY contact_id
												ORDER BY money DESC ";
$rosine_db_query['customers_with_open_paperwork']='SELECT e.*, r.%SINGULAR%_CUSTOMER_PRIVATE as private, r.%SINGULAR%_AMMOUNT as ammount FROM '.$egw_db_prefix.'addressbook AS e JOIN '.$rosine_db_prefix.'%plural% AS r ON e.contact_id = r.%SINGULAR%_CUSTOMER WHERE r.%SINGULAR%_STATUS = "changed" AND %where% ';
$rosine_db_query['get_paperwork_template']='SELECT %SINGULAR%_TEMPLATE FROM '.$rosine_db_prefix.'%plural% WHERE %SINGULAR%_ID=';

//mysql for payments
$rosine_db_query['get_unpaid_invoices']='SELECT e.n_fn AS name, i.INVOICE_CUSTOMER AS invoice_customer, i.INVOICE_ID AS invoice_id, i.INVOICE_AMMOUNT_BRUTTO AS invoice_ammount, sum( p.PAYMENT_AMMOUNT ) AS already_paid FROM '.$rosine_db_prefix.'invoices AS i NATURAL LEFT JOIN '.$rosine_db_prefix.'payments AS p JOIN '.$egw_db_prefix.'addressbook as e ON i.INVOICE_CUSTOMER=e.contact_id WHERE i.invoice_status = "changed" GROUP BY i.INVOICE_ID ORDER BY i.INVOICE_ID';
$rosine_db_query['get_payment_methods']='SELECT * FROM '.$rosine_db_prefix.'payments_methods WHERE 1';
$rosine_db_query['insert_payment']='INSERT INTO '.$rosine_db_prefix.'payments (PAYMENT_ID , INVOICE_ID , PAYMENT_DATE , METH_ID , PAYMENT_AMMOUNT , PAYMENT_NOTE ) VALUES ';
$rosine_db_query['get_open_money']='SELECT sum(p.PAYMENT_AMMOUNT) as already_payed, i.INVOICE_AMMOUNT_BRUTTO as invoice_ammount from '.$rosine_db_prefix.'payments as p JOIN '.$rosine_db_prefix.'invoices as i on i.INVOICE_ID=p.INVOICE_ID WHERE p.INVOICE_ID=';

//mysql for configuration
$rosine_db_query['get_configurations']='SELECT c.config as config, c.user_id as user_id, c.value as value, a.account_lid as account_name FROM '.$rosine_db_prefix.'config as c left join '.$egw_db_prefix.'accounts as a on c.user_id=a.account_id WHERE ';
$rosine_db_query['get_configuration_ammount']='SELECT COUNT(*) FROM '.$rosine_db_prefix.'config WHERE ';
$rosine_db_query['delete_configuration']="DELETE FROM ".$rosine_db_prefix."config WHERE ";
$rosine_db_query['update_configuration']="UPDATE ".$rosine_db_prefix."config SET ";

//mysql for statistics
$rosine_db_query['statistics']['get_customer_with_most_sales']="SELECT SUM( r.INVOICE_AMMOUNT_BRUTTO ) AS money, e.contact_id as customer_id, e.n_family as name, e.n_given, e.org_name, e.adr_one_locality, e.adr_two_locality
												FROM ".$egw_db_prefix."addressbook AS e
												JOIN ".$rosine_db_prefix."invoices AS r ON e.contact_id = r.INVOICE_CUSTOMER
												WHERE %where%
												GROUP BY contact_id
												ORDER BY money DESC ";
$rosine_db_query['statistics']['get_articles_by_sales']="
		SELECT SUM( i.POSI_PRICE * i.POSI_AMMOUNT) AS money, i.ART_NUMBER as article_number, COALESCE(NULLIF(a.ART_NAME, ''),'no_article') as description
															FROM ".$rosine_db_prefix."invoices_positions AS i LEFT JOIN ".$rosine_db_prefix."articles AS a ON i.ART_NUMBER=a.ART_NUMBER
															WHERE INVOICE_ID 
																	IN ( SELECT INVOICE_ID FROM ".$rosine_db_prefix."invoices AS r WHERE %where%)
															GROUP BY i.ART_NUMBER
															ORDER BY money DESC ";

$rosine_db = new mysqli(
		$GLOBALS['egw_info']['server']['db_host'],
		$GLOBALS['egw_info']['server']['db_user'],
		$GLOBALS['egw_info']['server']['db_pass'],
		$GLOBALS['egw_info']['server']['db_name'],
		$GLOBALS['egw_info']['server']['db_port']) ;
if ($rosine_db->connect_error) {
	die('Connect Error (' . $rosine_db->connect_errno . ') '
			. $rosine_db->connect_error.'
					db_host:'.$GLOBALS['egw_info']['server']['db_host'].
			'db_name:'.$GLOBALS['egw_info']['server']['db_name']);
} // die if database error

$rosine_db->query('SET NAMES "utf8"');
$rosine_db->query('SET sql_mode=""');

?>