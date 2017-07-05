<?php

/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
* http://www.rothaarsystems.de                                             *
* Author: info@rothaarsystems.de                                           *
* --------------------------------------------                             *
*  This program is free software; you can redistribute it and/or modify it *
*  under the terms of the GNU General Public License as published by the   *
*  Free Software Foundation; version 2 of the License.                     *
*  date of this file: 2017-07-05 										   *
\**************************************************************************/
use EGroupware\Api;
include ('inc/head.inc.php');

switch ($_POST['next_function']) {
	
	case "sent":
		$tpl->load("paperwork_email_sent.html");
 		$emailsend = new Api\Mailer();
 		$emailsend->setFrom("info@rothaarsystems.de");
 		$emailsend->addAddress($_POST['to']);
 		$emailsend->addAddress($_POST['cc'],"","cc");
 		$emailsend->addAddress($_POST['bcc'],"","bcc");
 		$emailsend->setBody($_POST['emailtext']);
 		$emailsend->addHeader("subject",lang($_POST['paperwork']).
 					"  ".$_POST['paperwork_id']);
 		$emailsend->send();
 		$tpl->assign("paperwork_id", $_POST['paperwork_id']);
 		$tpl->assign("paperwork_type", $_POST["paperwork"]);
	break;
	
	default:
		/*
		 * show E-Mail before send
		 */
		$tpl->load("paperwork_email.html");
		
		$tpl->assign("what_to_do", lang('send_email_for')."  ".
				lang($_POST["paperwork"])." ".$_POST["paperwork_id"]);
		$tpl->assign("paperwork", $_POST["paperwork"]);
		$tpl->assign("paperwork_id", $_POST["paperwork_id"]);
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
		$emailtext= new Rosine_Paperwork_Template();
		$emailtext->set_templateDir(substr($GLOBALS['egw_info']['server']['backup_dir'],0,strrpos($GLOBALS['egw_info']['server']['backup_dir'], '/')).'/rosine/templates/');
		$emailtext->load($config['email_template_'.$_GET['paperwork']]);
		$emailtext->replaceLangVars($lang);
		
		$emailtext->set_config($config);
		$emailtext->set_post($_POST);
		$emailtext->set_row_template(str_replace('.txt', '_row.txt', 
				$config['email_template_'.$_POST['paperwork']]));
		$emailtext->set_sql_paperwork(rosine_correct_query($_GET['paperwork'],
			$rosine_db_query['get_paperworks']."%singular%_ID=".
			$_GET['paperwork_id']));
		$emailtext->set_sql_row(rosine_correct_query($_GET['paperwork'],
			$rosine_db_query['get_articles_from_paperwork_with_all'].
				" %singular%_ID=".$_GET['paperwork_id'].
				' ORDER BY POSI_ID ASC'));
		$emailtext->assign('paperwork', lang($_GET['paperwork']));
		$emailtext->assign_full_file();
		$tpl->assign("emailtext", $emailtext->return_html());
		$tpl->assign("next_function", "sent");
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