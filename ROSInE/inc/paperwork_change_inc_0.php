<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2017-01-20  									    *
 \**************************************************************************/
// paperwork list, add items etc
switch ($_POST['next_function']) {
	case "insert":
			//insert an empty paperwork- just to fill in next step
			
			// choose either address one or two if to use customers address one or two
			if (ucfirst(substr($_POST['contact_id'],0,1))=="P"){
				$customer_private=1;
			}//endif
			else {
				$customer_private=0;
			}//endelse
			/* here we get the highest number of paperworks from the database
			 * this ist just for the use in the next functions
			 */

			$_POST['paperwork_id']=rosine_highest_number($_POST['paperwork'])+1;
			$query=rosine_correct_query($_POST['paperwork'], $rosine_db_query['insert_paperwork']);
			$result=rosine_database_query($query.'('.
					$_POST['paperwork_id'].', now(), '.
				substr($_POST['contact_id'],2).
				','.$customer_private.',0,"empty","'.date("Y-m-d-H-i-s").'","'.$_POST["note_text"].'")',0);
			if ($result!=false)
				$OK.=$lang['paperwork_inserted'];
			
				/* 
				 * although case insert ends here, after inserting empty paperwork, 
				 * this has to be filled with articles, so this break isn't used!
				 * 
				 */
//	break; //insert 

	case "overview":
	case "change":
		$tpl->load("paperworks.html");
		$lang[] = $config['language'];
		$lang = $tpl->loadLanguage($lang);

		$input_fields.='<input type="hidden" name="contact_id" value="'.$_POST['contact_id'].'"> ';
		$input_fields.='<input type="hidden" name="paperwork_id" value="'.$_POST['paperwork_id'].'"> ';
		$input_fields.='<input type="hidden" name="paperwork" value="'.$_POST['paperwork'].'"> ';
		$input_fields.='<div id="rosine_paperwork_input_wrap">';
		// first edit the changes - if there are any
		for ($i=0;$i<$config['items_per_page'];$i++){
			$ammount="";
			$select_article=false;
						
			if ($_POST['articles'][$i]!="") {
				// if field is not empty
				if (substr($_POST['articles'][$i], 0,1)=="#"){
					$result=rosine_paperwork_add_article($_POST['paperwork'],$_POST['ammount'][$i],$_POST['paperwork_id'],' ART_NUMBER = "'.substr($_POST['articles'][$i],1).'"');
				}// # is used to search directly for an article number
				else {
					$result=rosine_paperwork_add_article($_POST['paperwork'],$_POST['ammount'][$i],$_POST['paperwork_id'],' ART_NAME  LIKE "%'.$_POST['articles'][$i].'%" OR ART_NUMBER LIKE "%'.$_POST['articles'][$i].'%"');
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
				// select fields must be displayed in paperwork to select the right
				$input_fields.='<select name="articles['.$i.']" style="width:16.5em;">';
				$input_fields.='<option selected>---------</option>';
				while ($f = $result['result']->fetch_array()){
					$input_fields.='<option value="#'.$f['ART_NUMBER'].'">'.$f['ART_NAME'].' ('.$f['ART_NUMBER'].')</option>';
				}// get every article that correspondeces to this search
				$input_fields.='</select>';
				$result['result']->close();
			}// endif $select_article=true
			else {
				$input_fields.='<input  name="articles['.$i.']" type="text" width="30" maxwidth="50" placeholder="'.
						$_POST['articles'][$i].'"> ';
			}
			$input_fields.='| </div>';
		}// test all fields for articles
		$input_fields.='</div>';
		//add extra fields (most used articles)
		for ($i=$config['items_per_page'];$i<($config['items_per_page']+$config['favorite_articles']);$i++){
			//add favorite articles
			if ($_POST['ammount'][$i]>0){
				rosine_paperwork_add_article($_POST['paperwork'], $_POST['ammount'][$i], $_POST['paperwork_id'],' ART_NUMBER = "'.substr($_POST['articles'][$i].'"',1));
			}//endif ammount field is not empty
		}// endfor add favorite articles
		/*
		 * now insert new %paperwork%_note_text
		 * but only if there is something in it
		 */
		if ($_POST['note_text']!=""){
			rosine_database_query(rosine_correct_query($_POST['paperwork'], 
					$rosine_db_query['update_paperwork_note'],
					$_POST['note_text']).$_POST['paperwork_id'], 804);
		}// insert new text if it's not empty!
		
		
		// get customer from database
		$result=rosine_database_query($rosine_db_query['get_customers']." contact_id=".
				substr($_POST['contact_id'],2),140);
		/* hier könnte ich das noch so ändern, dass die Abfrage von 
		 * $rosine_db_query['get_paperworks'] kommt und damit die extra Abfrage unten für
		 * %paperwork%_NOTE gespart wird....
		 */ 
		if ($result!=false) {
			$customer_details = $result->fetch_array();
			$result->close();
			//are there items to delete?
			array_walk ($_POST[delete], 'rosine_delete_positions',str_replace("%paperwork%",
					rosine_get_plural($_POST['paperwork']),$rosine_db_query['delete_article_from_paperwork']).
					' '.strtoupper($_POST['paperwork']).'_ID= '.$_POST['paperwork_id'].' AND POSI_ID=%value%');
			// is there anything to add from other tables?
			if ($_POST['offer']!=""){
				rosine_add_complete_paperwork("offer", $_POST['offer'], $_POST['paperwork'], $_POST['paperwork_id']);
			}// if there is an offer to add
			if ($_POST['order']!=""){
				rosine_add_complete_paperwork("order", $_POST['order'], $_POST['paperwork'], $_POST['paperwork_id']);
			}// if there is an order to add
			if ($_POST['delivery']!=""){
				rosine_add_complete_paperwork("delivery", $_POST['delivery'], $_POST['paperwork'], $_POST['paperwork_id']);
			}// if there is an delivery to add
			
			// correct numbers
			rosine_correct_numbers($_POST['paperwork'], $_POST['paperwork_id']);
			$liste=rosine_create_items_list($_POST['paperwork'], $_POST['paperwork_id']);
			$tpl->assign("paperwork_list", $liste);
			$tpl->assign("next_function", '<input type="hidden" name="next_function" value="change">');
			$tpl->assign("customer", $customer_details['n_fn']);
			$tpl->assign("ID", $customer_details['contact_id']);
			$tpl->assign("note_text", rosine_get_field_database(rosine_correct_query($_POST['paperwork'], 
					$rosine_db_query['get_paperworks'].'%SINGULAR%_ID='.
					$_POST['paperwork_id']), strtoupper($_POST['paperwork'])."_NOTE"));
			// update paperwork_ammount in table rosine paperwork
			rosine_update_ammount_paperwork($_POST['paperwork'], $_POST['paperwork_id']);
			
		}// no error in mysql for getting customer details
	break;
		
	case "find_customer":
		/*
		 * just a dummy thing
		 */ 
	
	default:
		// Step 0 - show address to choose
		$tpl->load("paperworks_select_customer.html");
		$lang[] = $config['language'];
		$lang = $tpl->loadLanguage($lang);
		
		// search settings
		if ($_POST['searchstring']!=''){
			if (intval($_POST['searchstring']==0)){
				// Name is passed
				$where=" n_fn LIKE '%".$_POST['searchstring'].
				"%' OR n_given LIKE '%".$_POST['searchstring'].
				"%' OR org_name LIKE '%".$_POST['searchstring'].
				"%' ";
			}// Name is passed
			else {
				$where=" contact_id=".intval($_POST['searchstring'])." ";
			}//number is passed
			$tpl->assign('searchstring', $_POST['searchstring']);
		}// customers should be searched
		else {
			$tpl->assign('searchstring', '');
			$where="1"; //standard-search
		}// search setting
		
		//sort setting
		$sort_select['customer_with_most_sales']="";
		$sort_select['customer_with_most_paperwork']="";
		$sort_select['last_customers']="";
		$sort_select['sorted_in_alphabetic_order']="";
		$sort_select['customers_with_open_offer']="";
		$sort_select['customers_with_open_order']="";
		$sort_select['customers_with_open_delivery']="";
		$sort_select['customers_with_open_invoice']="";
		$sort_select[$_POST['sort_list']]="selected";
		if ($_POST['sort_list']=="" || $_POST['sort_list']=="sorted_in_alphabetic_order"){
			$sort=" ORDER BY concat( COALESCE( n_fn , '' ) , COALESCE( org_name , '' ) , COALESCE( n_family , '' ) , COALESCE( n_given , '' ) ) ";
			$sql_query=$rosine_db_query['get_customers']." ".$where.$sort;
			$sort_select['sorted_in_alphabetic_order']="selected";
			$sql_query=rosine_correct_query($_POST['paperwork'], $sql_query);
			$ammount_query=str_replace('SELECT * ', 'SELECT COUNT(*) ', $sql_query);
		}// default sort
		else {
			if (substr($_POST['sort_list'], 15,4)=="open") {
				$sql_query=str_replace("%where%", $where, 
						rosine_correct_query(
								substr($_POST['sort_list'],20), 
								$rosine_db_query[substr($_POST['sort_list'],0,20).'paperwork']." ")); // this is to correct the database query
			}// only open paperwork
			else{
				$sql_query=str_replace("%where%", $where, $rosine_db_query[$_POST['sort_list']]." ");
			}// just other sort
			$sql_query=rosine_correct_query($_POST['paperwork'], $sql_query);
			$ammount_query=str_replace('SELECT ', 'SELECT COUNT(*), ', $sql_query);
		}// other sort or open paperwork
		
		$tpl->assign_array('sort', $sort_select);
		
		// get ammount of customers
		$result=rosine_database_query($ammount_query,160);
		// 
		if ($result!=false) {
			// this is for changing pages
		
			$g = $result->fetch_array();
			$max_rows=$g[0];
			$from=(intval($_GET['from']));
			if ($from < 0){
				$from=0;
			}//endif	
			if ($max_rows<$from+$config['customers_per_page']){
				$config['customers_per_page']=$max_rows-$from;
			}//endif
			if ($from >0) {//zurueckblaettern anzeigen wenn moeglich
				$tpl->assign("backward", '<a href="?from='.($from-$config['customers_per_page']).'&paperwork='.
						$_POST['paperwork'].'&searchstring='.$_POST['searchstring'].
						'&sort_list='.$_POST['sort_list'].'">&lt;&lt;</a>');
			}//endif
			else{
				$tpl->assign("backward", "");
			}//endelse
			if ($from < $max_rows-$config['customers_per_page']) { //vorblaettern anzeigen wenn notwendig
				$tpl->assign("foreward", '<a href="?from='.($from+$config['customers_per_page']).'&paperwork='.
						$_POST['paperwork'].'&searchstring='.$_POST['searchstring'].
						'&sort_list='.$_POST['sort_list'].'">&gt;&gt;</a>');
			}//endif
			else {
				$tpl->assign("foreward", "");
			}//endelse
			$tpl->assign('from', $from);
			$tpl->assign("to", ($from+$config['customers_per_page']));
			$tpl->assign("max", $max_rows);
			//here the things for changing the pages end
			
			$result=rosine_database_query($sql_query." LIMIT ".$from. ", ".$config['customers_per_page'],165);
			if ($result!=false) {
				//no error in mysql get customers
				$input_fields.='<input type="hidden" name="paperwork" value="'.$_POST['paperwork'].'">';
				while($f = $result->fetch_array()) {
					if ($f['n_family']!="")
							$input_fields.='<button name="contact_id" value="P-'.$f["contact_id"].
							'" type="submit" >'.$f['n_fn'].' - '.$f['adr_two_locality'].' ['.$f['contact_id'].']'.$lang['private'].'</button>';
					if ($f['org_name']!="")
						$input_fields.='<button name="contact_id" value="F-'.$f["contact_id"].
						'" type="submit" >'.$f['org_name'].' - '.$f['adr_one_locality'].' ['.$f['contact_id'].']'.$lang['company'].'</button>';
					$input_fields.="&nbsp;|&nbsp; ";
				}//endwhile
				$result->close();
			} //endelse no error in mysql search for customers
			
		}// endelse no error in customer ammount search
		// show drop down list for paperwork notes
		$standard_note=rosine_get_field_database(rosine_correct_query($_POST['paperwork'], 
				str_replace("%language%", $config['language'], 
				$rosine_db_query['get_standard_note'])), "id",700);
		$note_field='<select name="note_text">';
		$result=rosine_database_query($rosine_db_query['get_all_notes']." 1", 701);
		while ($f=$result->fetch_array()){
			$note_field.='<option value="'.$f['NOTE_TEXT'].'"';
				if ($f['NOTE_ID']==$standard_note && $f['LANGUAGE']==$config['language'])
					$note_field.=" selected "; // for getting the standard note
			$note_field.='>'.$f['NOTE_TEXT'].'</option>';
		}//no error getting all notes
		$result->close();
		$note_field.='</select>';
		$tpl->assign("note_field", $note_field);
		$tpl->assign("next_function", '<input type="hidden" name="next_function" value="change">');
				
}//end switch next_function

//show page
$tpl->assign("OK", $OK);
$tpl->assign("error", $error);
$tpl->assign("input_fields", $input_fields);
$tpl->assign("paperwork", $lang[$_POST['paperwork']]);
$tpl->assign("additional", '<h3>'.$lang['favorite_articles'].'</h3>
	{$input_favorites}{$other_tables}');
if ($_POST['paperwork']!="offer") {
	$tpl->assign('other_tables','<h3>'.$lang["add_articles_from_other_tables"].'</h3>
		{$offer_list} {$order_list} {$delivery_list}');
	$tpl->assign("offer_list", rosine_add_paperworklist("offer",$customer_details['contact_id']));
	if ($_POST['paperwork']!="order") {
		$tpl->assign("order_list", rosine_add_paperworklist("order",$customer_details['contact_id']));
		if ($_POST['paperwork']!="delivery"){
			$tpl->assign("delivery_list", rosine_add_paperworklist("delivery",$customer_details['contact_id']));
		}// paperwork must be invoice
		else {
			$tpl->assign("delivery_list", "");
		}//paperwork must be delivery
	}// paperwork is not order
	else {
		$tpl->assign("order_list", "");
		$tpl->assign("delivery_list", "");
	}//paperwork is order
}// paperwork is not offer
else{
	$tpl->assign("other_tables", "");
}// paperwork is offer
$tpl->assign("input_favorites", rosine_most_used_articles($_POST['paperwork']));
$tpl->assign("this_number",rosine_get_real_number($_POST['paperwork'],$_POST['paperwork_id']));
$tpl->assign("paperwork_file", rosine_get_plural($_POST['paperwork']));
$tpl->assign("paperwork_type", $_POST['paperwork']);

$tpl->display();
?>