<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2017-07-07  										    *
 \**************************************************************************/
use EGroupware\Api\Framework;

include ('inc/head.inc.php');
include ('inc/paperwork_change_inc_'.$config[$_POST['paperwork'].'_change_form'].'.php');
/*
 * This is to include the right php-File for special customers...
 */

?>