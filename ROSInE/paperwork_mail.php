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

switch ($_POST['next_function']) {
	
	case "sent":
		$tpl->load("paperwork-email-sent.html");
		$lang[] = $config['language'];
		$lang = $tpl->loadLanguage($lang);
		
			/* Just a test for the egroupware- E-Mail-Function
 $emailsend = new Api\Mailer();
 $emailsend->setFrom("info@rothaarsystems.de");
 $emailsend->addAddress("info@rothaarsystems.de");
 $emailsend->setBody("Testtext");
 $emailsend->addHeader("subject","Test-Email");
 $emailsend->send();
 echo "E-Mail gesendet";*/
	break;
	
	default:
		/*
		 * show E-Mail before send
		 */
		$tpl->load("paperwork-email.html");
		$lang[] = $config['language'];
		$lang = $tpl->loadLanguage($lang);
		$tpl->assign("what_to_do", $lang['send_email_for']."  ".
				$lang[$_POST["paperwork"]]." ".$_POST["paperwork_id"]);
		$tpl->assign("paperwork", $_POST["paperwork"]);
		$tpl->assign("cc",$config[$_POST["paperwork"].'_cc']);
		$tpl->assign("bcc",$config[$_POST["paperwork"].'_bcc']);
		$result=rosine_database_query(rosine_correct_query($_GET['paperwork'],
				$rosine_db_query['get_paperworks']."%singular%_ID=".
				$_GET['paperwork_id']),101);
		if ($result!=false) {
			// now the fields can be generated
			$row=$result->fetch_array();
			// goes this paperwork to organisation or to private?		
			if ($row[strtoupper($_GET['paperwork']."_customer_private")]=="1") {
				$tpl->assign('to',$row['contact_email_home']);
			}// customer is private
			else {
				$tpl->assign('to',$row['contact_email']);
			}// customer is organisation
		}// there is an customer in database
}//next_function
/*
 * Standard-Aktion: Mailtext generieren und anzeigen
 * Folgende Felder sollen enthalten sein:
 * To: /An: (Feld aus Adressdatenbank von Egroupware, abhängig von privat/Firma)
 * CC: (dies soll voreinstellbar aus Konfiguration)
 * Text vor dem Lieferschein aus Template
 * Lieferscheinpositionen
 * Endtext aus Template
 * 
 * Alles zum Bearbeiten 
 * Buttons: Senden und Abbrechen
 * 
 * Abbrechen kehrt zur Liste zurück
 * Senden sendet E-Mail
 */


$tpl->assign("OK", "");
$tpl->assign("error", "");
$tpl->display();

?>