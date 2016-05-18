<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-04-23  										    *
 \**************************************************************************/
$GLOBALS['phpgw_info']['flags']['currentapp'] = 'rosine';
include('../header.inc.php');
include ('inc/settings.php');
include ('inc/template.class.php');

//2. Dimension von $GEt und $post durchsuchen!!!!
if ($_GET['paperwork']!="") 
	/* this must be the first call of this file, so it is called by another
	 * file, like main menue
	 * But this $_POST variable is used everywhere in this file 
	 */
	$_POST['paperwork']=$_GET['paperwork'];
	include ('inc/paperwork_change_inc_'.$config[$_POST['paperwork'].'_change_form'].'.php');
/*
 * This is to include the right php-File for special customers...
 */

?>