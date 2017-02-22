<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2017-02-20  										    *
 \**************************************************************************/

/*

 */
$rosine_load_template_paperwork=true; //contruct class at once
include ('inc/head.inc.php');

/*function rosine_assign_invoice_fields ($item, $key, $tpl){
	// assign all template-fields in invoice with data
	$tpl->assign($key, $item);
}//endfunction rosine_assign_invoice_fields

* not used, maybe later on
*/

$tpl->load($config['print_template_'.$_GET['paperwork']]);
$lang = $tpl->loadLanguage($lang);
$tpl->assign('paperwork', $lang[$_GET['paperwork']]);

// get fields from database (just the fields for the full page)
$tpl->set_config($config);
$tpl->set_post($_POST);
$tpl->set_row_template(str_replace('.html', '_row.html', $config['print_template_'.$_GET['paperwork']]));
$tpl->set_sql_paperwork(rosine_correct_query($_GET['paperwork'],
		$rosine_db_query['get_paperworks']."%singular%_ID=".
		$_GET['paperwork_id']));
$tpl->set_sql_row(rosine_correct_query($_GET['paperwork'],
			$rosine_db_query['get_articles_from_paperwork_with_all']." %singular%_ID=".
			$_GET['paperwork_id'].' ORDER BY POSI_ID ASC'));
$tpl->assign_full_file();

$tpl->display();

?>