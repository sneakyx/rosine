<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2018-01-06  										    *
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
$template=rosine_get_field_database(
		rosine_correct_query($_POST['paperwork'], 
			$rosine_db_query['get_paperwork_template'].$_POST['paperwork_id']),
		0,357);
if (!$template){
	//if template is template is empty -> use standard template
	// this is just for old entries in database!
	$template=$config['print_template_'.$_POST['paperwork']];
}

$tpl->load($template);
$lang = $tpl->loadLanguage($lang);

// get fields from database (just the fields for the full page)
//$tpl->set_config($config);
$tpl->set_post($_POST);
$tpl->set_row_template(str_replace('.html', '_row.html', $config['print_template_'.$_GET['paperwork']]));
$tpl->set_sql_paperwork(rosine_correct_query($_POST['paperwork'],
		$rosine_db_query['get_paperworks']."%singular%_ID=".
		$_POST['paperwork_id']));
$tpl->set_sql_row(rosine_correct_query($_POST['paperwork'],
			$rosine_db_query['get_articles_from_paperwork_with_all']." %singular%_ID=".
			$_POST['paperwork_id'].' ORDER BY POSI_ID ASC'));
$tpl->assign_full_file();

$tpl->display();

?>