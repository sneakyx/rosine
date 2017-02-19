<?php
	/**************************************************************************\
	* Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
	* http://www.rothaarsystems.de                                             *
	* Author: info@rothaarsystems.de                                           *
	* --------------------------------------------                             *
	*  This program is free software; you can redistribute it and/or modify it *
	*  under the terms of the GNU General Public License as published by the   *
	*  Free Software Foundation; version 2 of the License.                     *
	*  date of this file: 2017-02-15 										   *
	\**************************************************************************/
use EGroupware\Api;
include ('inc/head.inc.php');
$tpl->load("mainmenu.html");
$lang = $tpl->loadLanguage($lang);
if (!$lang){
	echo "<br>False!<br>";
}
/* Just a test for the egroupware- E-Mail-Function
$emailsend = new Api\Mailer();
$emailsend->setFrom("info@rothaarsystems.de");
$emailsend->addAddress("info@rothaarsystems.de");
$emailsend->setBody("Testtext");
$emailsend->addHeader("subject","Test-Email");
$emailsend->send();
echo "E-Mail gesendet";*/
$tpl->assign("OK", "");
$tpl->assign("error", "");
$tpl->display();

?>
