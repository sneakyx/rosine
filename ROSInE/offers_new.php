<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-03-26  										    *
 \**************************************************************************/
$GLOBALS['phpgw_info']['flags']['currentapp'] = 'rosine';
include('../header.inc.php');
include ('inc/settings.php');
include ('inc/template.class.php');

//2. Dimension von $GEt und $post durchsuchen!!!!

$tpl = new Rosine_Template();

switch ($_POST['next_function']) {
	case "insert_offer":
			//insert an empty offer- just to fill in next step
			
			// choose either address one or two if to use customers address one or two
			if (ucfirst(substr($_POST['contact_id'],0,1))=="P")
				$customer_private=1;
			else 
				$customer_private=0;
			/* here we get the highest number of offers from the database
			 * this ist just for the use in the next functions
			 */
			//hier einfuegen 
			$_POST['offer_id']=rosine_highest_number("offer")+1;
			$result=rosine_database_query($rosine_db_query['insert_offer'].'('.
					$_POST['offer_id'].', now(), '.
				substr($_POST['contact_id'],2).
				','.$customer_private.',0,"empty","'.date("Y-m-d-H-i-s").'")',0);
			if ($result!=false)
				// aus irgendeinem Grund geht das noch nicht!
				$OK.=$lang['paperwork_inserted'];
			
				/* 
				 * although case insert_offer ends here, after inserting empty offer, 
				 * this has to be filled with articles, so this break isn't used!
				 * 
				 */
//	break; //insert_offer 

	case "overview":
	case "change":
		// first edit the changes - if there are any
		for ($i=0;$i<$articles_per_page;$i++){
			if ($_POST['articles'][$i]!="") {
				$result=mysql_query($rosine_db_query['get_articles'].' ART_NAME  LIKE "%'.$_POST['articles'][$i].'%" OR ART_NUMBER LIKE "%'.$_POST['articles'][$i].'%"');
				if (mysql_errno($rosine_db)!=0) {
					// Error in mysql detected
					$error.="6: ".mysql_error($rosine_db);
		
				} // Error in mysql detected
				else {
					switch (mysql_num_rows($result)){
						case 0: 
							$_POST['articles'][$i]=$lang['not_found']." ".$_POST['articles'][$i];
							break;
						case 1:
							$f = mysql_fetch_array($result);
							if (! $f['ART_INSTOCKNR'])
								$f['ART_INSTOCKNR']="0";
							$result2=mysql_query($rosine_db_query['insert_article_into_offer'].
									'("'.$_POST[offer_id].'", "'.
									(rosine_highest_number("offer positions",$_POST['offer_id'])+1).'", "'.
									$f['ART_NUMBER'].'", '.
									$_POST['ammount'][$i].', "'.
									$f['ART_UNIT'].'", '.
									$f['ART_PRICE'].', '.
								$f['ART_INSTOCKNR'].',
									"","'. //theres no possibility to add Seriennummer (yet)
									$f['ART_NAME'].'",'.
									$f['ART_TAX'].')');
							if (mysql_errno($rosine_db)!=0) {
								// Error in mysql detected
								$error.="7: ".mysql_error($rosine_db)."<br>";
							} // Error in mysql detected
							$_POST['articles'][$i]="added!"; //must be changed
							break;
						default:
							$_POST['articles'][$i]="too much possibilities"; //must be changed	
					}
				}// no error, show rows
			}// if field is not empty
			else 
				$_POST['articles'][$i]=$lang['article']. "Artikel ".($i+1);
		}// test all fields for articles
		
		
		// offer list, add items etc
		$tpl->load("paperworks.html");
		$lang[] = $language;
		$lang = $tpl->loadLanguage($lang);
		// get customer from database
		$input_fields.='<input type="hidden" name="contact_id" value="'.$_POST['contact_id'].'"> ';
		$input_fields.='<input type="hidden" name="offer_id" value="'.$_POST['offer_id'].'"> ';
		$result=mysql_query($rosine_db_query['get_customers']." contact_id=".substr($_POST['contact_id'],2));
		if (mysql_errno($rosine_db)!=0) {
			// Error in mysql detected
			$error.="4: ".mysql_error($rosine_db);
				
		} // Error in mysql detected
		else {
			$customer_details = @mysql_fetch_array($result);
			$input_fields.='<div id="rosine_paperwork_input_wrap">';
			for ($i=0;$i<$articles_per_page;$i++){
				$input_fields.='<div class="rosine_paperwork_input_line"><input class="rosine_input_ammount" name="ammount['.$i.']" type="text" width="5" maxwidth="10" placeholder="'.
						$lang['ammount'].'"><input name="articles['.$i.']" type="text" width="30" maxwidth="50" placeholder="'.					
						$_POST['articles'][$i].'"> | </div>
								';
			}//endelse
			$input_fields.='</div>';
			$result=mysql_query($rosine_db_query['get_articles_from_paperwork']."offers_positions WHERE OFFER_ID=".$_POST['offer_id']);
			if (mysql_errno($rosine_db)!=0){
				//Error 5 in mysql
				$error.="5: ".mysql_error($rosine_db);
				$error.=$rosine_db_query['get_articles_from_paperwork']."offers_positions WHERE OFFER_ID=".$_POST['offer_id'];
			}// Error in mysql detected
			else {
				$liste="<table id='rosine_tabelle'><tr>";
				while($f = @mysql_fetch_array($result)) {
					$liste.="<td>".$f['POSI_ID']."</td>".
							"<td>".$f['ART_NUMBER']."</td>".
							'<td style="text-align:center;">'.$f['POSI_TEXT'].'</td>
									<td>'.$f['POSI_AMMOUNT'].' '.$f['POSI_UNIT'].'</td>
									<td>à '.$f['POSI_PRICE']." ".$currency.'</td>';
					$liste.="<tr>
							";
				}//get rows with articles in database
				$liste.="</table>";
				$tpl->assign("paperwork_list", $liste);
			}//no error 5 in mysql
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