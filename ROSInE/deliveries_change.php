<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-03-31  										    *
 \**************************************************************************/
$GLOBALS['phpgw_info']['flags']['currentapp'] = 'rosine';
include('../header.inc.php');
include ('inc/settings.php');
include ('inc/template.class.php');

//2. Dimension von $GEt und $post durchsuchen!!!!

$tpl = new Rosine_Template();
// delivery list, add items etc

switch ($_POST['next_function']) {
	case "insert_delivery":
			//insert an empty delivery- just to fill in next step
			
			// choose either address one or two if to use customers address one or two
			if (ucfirst(substr($_POST['contact_id'],0,1))=="P")
				$customer_private=1;
			else 
				$customer_private=0;
			/* here we get the highest number of deliveries from the database
			 * this ist just for the use in the next functions
			 */
			//hier einfuegen 
			$_POST['delivery_id']=rosine_highest_number("delivery")+1;
			$query=rosine_correct_query("delivery", $rosine_db_query['insert_paperwork']);
			$result=rosine_database_query($query.'('.
					$_POST['delivery_id'].', now(), '.
				substr($_POST['contact_id'],2).
				','.$customer_private.',0,"empty","'.date("Y-m-d-H-i-s").'")',0);
			if ($result!=false)
				// aus irgendeinem Grund geht das noch nicht!
				$OK.=$lang['paperwork_inserted'];
			
				/* 
				 * although case insert_delivery ends here, after inserting empty delivery, 
				 * this has to be filled with articles, so this break isn't used!
				 * 
				 */
//	break; //insert_delivery 

	case "overview":
	case "change":
		$tpl->load("paperworks.html");
		$lang[] = $language;
		$lang = $tpl->loadLanguage($lang);
		
		$input_fields.='<input type="hidden" name="contact_id" value="'.$_POST['contact_id'].'"> ';
		$input_fields.='<input type="hidden" name="delivery_id" value="'.$_POST['delivery_id'].'"> ';
		$input_fields.='<div id="rosine_paperwork_input_wrap">';
		// first edit the changes - if there are any
		for ($i=0;$i<$items_per_page;$i++){
			$ammount="";
			$select_article=false;
						
			if ($_POST['articles'][$i]!="") {
				// if field is not empty
				if (substr($_POST['articles'][$i], 0,1)=="#"){
					$result=rosine_paperwork_add_article("delivery",$_POST['ammount'][$i],$_POST['delivery_id'],' ART_NUMBER = "'.substr($_POST['articles'][$i],1).'"');
				}// # is used to search directly for an article number
				else {
					$result=rosine_paperwork_add_article("delivery",$_POST['ammount'][$i],$_POST['delivery_id'],' ART_NAME  LIKE "%'.$_POST['articles'][$i].'%" OR ART_NUMBER LIKE "%'.$_POST['articles'][$i].'%"');
				}// if no # in the beginning
				
				switch ($result['lines']){
					//how many lines were returned?
					case 0: 
						$_POST['articles'][$i].=' '.$lang['not_found'];
						break;
					case 1:
						$_POST['articles'][$i]= $result['ART_NAME'].$lang['added']; 
						$_POST['ammount'][$i].= " ".$result['ART_UNIT'];
						break;
					default:				
						$_POST['articles'][$i]="too much possibilities"; //must be changed	
						$ammount=$_POST['ammount'][$i];
						$select_article=true;
				}//end switch $result['lines']
			}// if field is not empty
			else {
				$_POST['articles'][$i]=$lang['article'].($i+1);
				$_POST['ammount'][$i]=$lang['ammount'];
				
			}// if field is empty
			$input_fields.='<div class="rosine_paperwork_input_line">';
			$input_fields.='<input class="rosine_input_ammount" style="width:40px;" name="ammount['.$i.']" type="text" width="5" maxwidth="10" placeholder="'.
					$_POST['ammount'][$i].'" value="'.$ammount.'">';
			if ($select_article){
				// select fields must be displayed in delivery to select the right
				$input_fields.='<select name="articles['.$i.']" style="width:16.5em;">';
				$input_fields.='<option selected>---------</option>';
				while ($f = @mysql_fetch_array($result['result'])){
					$input_fields.='<option value="#'.$f['ART_NUMBER'].'">'.$f['ART_NAME'].' ('.$f['ART_NUMBER'].')</option>';
				}// get every article that correspondeces to this search
				$input_fields.='</select>';
			}// endif $select_article=true
			else {
				$input_fields.='<input  name="articles['.$i.']" type="text" width="30" maxwidth="50" placeholder="'.
						$_POST['articles'][$i].'"> ';
			}
			$input_fields.='| </div>';
		}// test all fields for articles
		$input_fields.='</div>';
		//add extra fields (most used articles)
		for ($i=$items_per_page;$i<($items_per_page+$favorite_articles);$i++){
			//add favorite articles
			if ($_POST['ammount'][$i]>0){
				rosine_paperwork_add_article("delivery", $_POST['ammount'][$i], $_POST['delivery_id'],' ART_NUMBER = '.substr($_POST['articles'][$i],1));
			}//endif ammount field is not empty
		}// endfor add favorite articles
		// get customer from database
		$result=mysql_query($rosine_db_query['get_customers']." contact_id=".substr($_POST['contact_id'],2));
		if (mysql_errno($rosine_db)!=0) {
			// Error in mysql detected
			$error.="4: ".mysql_error($rosine_db);
				
		} // Error in mysql detected
		else {
			$customer_details = @mysql_fetch_array($result);
			//are there items to delete?
			array_walk ($_POST[delete], 'rosine_delete_positions',str_replace("%paperwork%",
					"deliveries",$rosine_db_query['delete_article_from_paperwork']).
					' DELIVERY_ID= '.$_POST['delivery_id'].' AND POSI_ID=%value%');
			// is there anything to add from other tables?
			if ($_POST['offer']!=""){
				rosine_add_complete_paperwork("offer", $_POST['offer'], "delivery", $_POST['delivery_id']);
			}// if there is an offer to add
			if ($_POST['order']!=""){
				rosine_add_complete_paperwork("order", $_POST['order'], "delivery", $_POST['delivery_id']);
			}// if there is an order to add
					
			// correct numbers
			rosine_correct_numbers("delivery", $_POST['delivery_id']);
			$liste=rosine_create_items_list("delivery", $_POST['delivery_id']);
			$tpl->assign("paperwork_list", $liste);
			$tpl->assign("next_function", '<input type="hidden" name="next_function" value="change">');
			$tpl->assign("customer", $customer_details['n_fn']);
			$tpl->assign("ID", $customer_details['contact_id']);
			// update delivery_ammount in table rosine deliveries
			rosine_update_ammount_paperwork("delivery", $_POST['delivery_id']);
				
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
							<input type="hidden" name="next_function" value="insert_delivery">';
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
$tpl->assign("paperwork", $lang['delivery']);
$tpl->assign("additional", '<h3>'.$lang['favorite_articles'].'</h3>
	{$input_favorites}
		<h3>'.$lang["add_articles_from_other_tables"].'</h3>
		{$offer_list} {$order_list}');
$tpl->assign("input_favorites", rosine_most_used_articles("delivery"));
$tpl->assign("offer_list", rosine_add_paperworklist("offer",$customer_details['contact_id']));
$tpl->assign("order_list", rosine_add_paperworklist("order",$customer_details['contact_id']));
$tpl->assign("this_number",rosine_get_real_number("delivery",$_POST['delivery_id']));
$tpl->assign("paperwork_file", "deliveries");
$tpl->display();

?>