<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-01-23										   *
 \**************************************************************************/
$GLOBALS['phpgw_info']['flags']['currentapp'] = 'rosine';
include('../header.inc.php');
include ('inc/settings.php');
include ('inc/template.class.php');


$tpl = new Rosine_Template();
$tpl->load("paperworks.html");
$lang[] = $language;
$lang = $tpl->loadLanguage($lang);

for ($i=0;$i<$articles_per_page;$i++){
	$input_fields.='<input name="articles['.$i.']" type="text" width="30" maxwidth="50" placeholder="'.
	$lang['article'].' '.($i+1).'">';
}
$tpl->assign("next_function", '<input type="hidden" name="next_function" value="change">');

//show page
$tpl->assign("OK", $OK);
$tpl->assign("error", $error);
$tpl->assign("input_fields", $input_fields);
$tpl->assign("paperwork", $lang['offer']);
$tpl->display();

?>