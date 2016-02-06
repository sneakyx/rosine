<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-02-06 										   *
 \**************************************************************************/
$GLOBALS['phpgw_info']['flags']['currentapp'] = 'rosine';
include('../header.inc.php');
include ('inc/settings.php');
include ('inc/template.class.php');

$tpl = new Rosine_Template();

switch ($_POST['next_function']) {
	case "insert_offer":
			//insert an empty offer- just to fill in next step
			
		/*
		 * Was fehlt- für nächste Funktion noch die Nummer des Angebots!!!!
		 * 
		 */
			if (ucfirst(substr($_POST['contact_id'],0,1))=="P")
				$customer_private=1;
			else 
				$customer_private=0;
			
			$result=mysql_query($rosine_db_query['insert_offer'].
					'(now(), '.
				substr($_POST['contact_id'],2).
				','.$customer_private.',0,"empty","'.date("Y-m-d-H-i-s").'")');
			if (mysql_errno($rosine_db)!=0) {
				// Error in mysql detected
				$error.="0: ".mysql_error($rosine_db);
				$error.=$rosine_db_query['insert_offer'].
					'(now(), '.
				substr($_POST['contact_id'],2).
				','.$customer_private.',0,"empty","'.date("Y-m-d-H-i-s").'")';
			
			} // Error in mysql detected
			else {
				$ok.=$lang['paperwork_inserted'];
			}// no error in inserting an empty offer
			
				/* 
				 * although case insert_offer ends here, after inserting empty offer, 
				 * this has to be filled with articles, so this break isn't used!
				 * 
				 */
//	break; //insert_offer 
			
	case "overview":
		// offer list, add items etc
		$tpl->load("paperworks.html");
		$lang[] = $language;
		$lang = $tpl->loadLanguage($lang);
		// get customer from database
		$result=mysql_query($rosine_db_query['get_customers']." contact_id=".substr($_POST['contact_id'],2));
		if (mysql_errno($rosine_db)!=0) {
			// Error in mysql detected
			$error.="4: ".mysql_error($rosine_db);
				
		} // Error in mysql detected
		else {
			$customer_details = @mysql_fetch_array($result);
		
			for ($i=0;$i<$articles_per_page;$i++){
				$input_fields.='<input name="articles['.$i.']" type="text" width="30" maxwidth="50" placeholder="'.
						$lang['article'].' '.($i+1).'">';
			}
			$tpl->assign("next_function", '<input type="hidden" name="next_function" value="change">');
			$tpl->assign("customer", $customer_details['n_fn']);
			$tpl->assign("ID", $customer_details['contact_id']);
		}// no error in mysql for getting customer details
	break;
		
	
	default:
		// Step 0 - show address to choose	
		$tpl->load("paperworks_select_customer.html");
		$lang[] = $language;
		$lang = $tpl->loadLanguage($lang);
		$result=mysql_query($rosine_db_query['search_customers_ammount']." 1");

		if (mysql_errno($rosine_db)!=0) {
			// Error in mysql detected
			$error.="3: ".mysql_error($rosine_db);

		} // Error in mysql detected
		else {
			// this is for changing pages
		
			$g = @mysql_fetch_array($result);
			$max_rows=$g[0];
			$from=(intval($_GET['from']));
			if ($from < 0)
				$from=0;
			if ($max_rows<$from+$customers_per_page)
				$customers_per_page=$max_rows-$from;
						
			if ($from >0) //zurueckblaettern anzeigen wenn moeglich
				$tpl->assign("backward", '<a href="?from='.($from-$customers_per_page).'">&lt;&lt;</a>');
			else
				$tpl->assign("backward", "");
			if ($from < $max_rows-$customers_per_page) //vorblaettern anzeigen wenn notwendig
				$tpl->assign("foreward", '<a href="?from='.($from+$customers_per_page).'">&gt;&gt;</a>');
			else
				$tpl->assign("foreward", "");
			$tpl->assign('from', $from);
			$tpl->assign("to", ($from+$customers_per_page));
			$tpl->assign("max", $max_rows);
			//here the things for changing the pages end
			
			$result=mysql_query($rosine_db_query['get_customers']." 1");
			if (mysql_errno($rosine_db)!=0) {
				// Error in mysql detected
				$error.="4: ".mysql_error($rosine_db);
			
			} // Error in mysql detected
			else {
				//no error in mysql get customers
				$input_fields.='<form action="#" method="post">
							<input type="hidden" name="next_function" value="insert_offer">';
				while($f = @mysql_fetch_array($result)) {
					if ($f['n_family']!="")
							$input_fields.='<button name="contact_id" value="P-'.$f["contact_id"].
							'" type="submit" >'.$f['n_fn'].' - '.$f['adr_two_locality'].' ['.$f['contact_id'].']</button>';
					if ($f['org_name']!="")
						$input_fields.='<button name="contact_id" value="F-'.$f["contact_id"].
						'" type="submit" >'.$f['org_name'].' - '.$f['adr_one_locality'].' ['.$f['contact_id'].']</button>';
				}//endwhile
				$input_fields.='</form>';
			} //endelse no error in mysql search for customers
			
		}// endelse no error in customer ammount search
		$tpl->assign("next_function", '<input type="hidden" name="next_function" value="change">');
				
}//end switch next_function

//show page
$tpl->assign("OK", $OK);
$tpl->assign("error", $error);
$tpl->assign("input_fields", $input_fields);
$tpl->assign("paperwork", $lang['offer']);
$tpl->display();

?>