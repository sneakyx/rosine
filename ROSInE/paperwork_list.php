<?php
	/**************************************************************************\
	* Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
	* http://www.rothaarsystems.de                                             *
	* Author: info@rothaarsystems.de                                           *
	* --------------------------------------------                             *
	*  This program is free software; you can redistribute it and/or modify it *
	*  under the terms of the GNU General Public License as published by the   *
	*  Free Software Foundation; version 2 of the License.                     *
	*  date of this file: 2016-08-24  										   *
	\**************************************************************************/

$GLOBALS['egw_info'] = array(
		'flags' => array(
				'currentapp' => 'rosine',
				'noheader'   => True,
				'nonavbar'   => True
		));
include('../header.inc.php');
include ('inc/settings.php');
include ('inc/template.class.php');
if ($_GET['paperwork']!="")
	/* this must be the first call of this file, so it is called by another
	 * file, like main menue
* But this $_POST variable is used everywhere in this file
*/
	$_POST['paperwork']=$_GET['paperwork'];
	
include ('inc/paperwork_list_inc_'.$config[$_POST['paperwork'].'_list_form'].'.php');
?>