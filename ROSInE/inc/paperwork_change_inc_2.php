<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-05-23  										    *
 \**************************************************************************/
/*
 * This form works the following way:
 * You have to mark the things you have packed and click on save.
 * But there's another option: You can change the unit and the ammount
 * This way the customer can order for example 4 sausages and you can deliver 500 gramms
 * To change the delivery unit, just change the variable config['delivery_unit_change'] in database
 * table rosine_config!
 * When You finished all things that can be delivered you can print the delivery and
 * return to the list
 */
$tpl = new Rosine_Template();
// paperwork list, add items etc
switch ($_POST['next_function']) {
	case "insert":
			//insert an empty paperwork- just to fill in next step
			
			$result=rosine_database_query(rosine_correct_query($_POST['old_paperwork'],($rosine_db_query['get_paperworks'].'%SINGULAR%_ID='.$_POST['old_paperwork_id'])),100);	
			if ($result!=false)
				$result=mysql_fetch_array($result);
			$_POST['contact_id']=$result[strtoupper($_POST['old_paperwork']).'_CUSTOMER'];
			$customer_private=$result[strtoupper($_POST['old_paperwork']).'_CUSTOMER_PRIVATE'];
			
			/* here we get the highest number of paperworks from the database
			 * this ist just for the use in the next functions
			 */

			$_POST['paperwork_id']=rosine_highest_number($_POST['paperwork'])+1;
			//hier muss noch der Standardtext für note eingetragen werden!
			$_POST['note_text']=rosine_get_field_database(rosine_correct_query($_POST['paperwork'], 
				str_replace("%language%", $config['language'], 
				$rosine_db_query['get_standard_note'])), "text",700);
			$query=rosine_correct_query($_POST['paperwork'], $rosine_db_query['insert_paperwork']);
			$result=rosine_database_query($query.'('.
					$_POST['paperwork_id'].', now(), '.
					$_POST['contact_id'].
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
		$tpl->load("paperworks_1.html");
		$lang[] = $config['language'];
		$lang = $tpl->loadLanguage($lang);

		$input_fields.='<input type="hidden" name="contact_id" value="'.$_POST['contact_id'].'"> ';
		$input_fields.='<input type="hidden" name="paperwork_id" value="'.$_POST['paperwork_id'].'"> ';
		$input_fields.='<input type="hidden" name="paperwork" value="'.$_POST['paperwork'].'"> ';
		$input_fields.='<input type="hidden" name="old_paperwork" value="'.$_POST['old_paperwork'].'"> ';
		$input_fields.='<input type="hidden" name="old_paperwork_id" value="'.$_POST['old_paperwork_id'].'">';
		$input_fields.='<div id="rosine_paperwork_input_wrap">';
		// first edit the changes - if there are any
		for ($i=0;$i<$config['items_per_page'];$i++){
			$ammount="";
			$unity="";
			$select_article=false;
						
			if ($_POST['articles'][$i]!="") {
				// if field is not empty
				if (substr($_POST['articles'][$i], 0,1)=="#"){
					$result=rosine_paperwork_add_article($_POST['paperwork'],$_POST['ammount'][$i],$_POST['paperwork_id'],' ART_NUMBER = "'.substr($_POST['articles'][$i],1).'"',$_POST['unity'][$i]);
				}// # is used to search directly for an article number
				else {
					$result=rosine_paperwork_add_article($_POST['paperwork'],$_POST['ammount'][$i],$_POST['paperwork_id'],' ART_NAME  LIKE "%'.$_POST['articles'][$i].'%" OR ART_NUMBER LIKE "%'.$_POST['articles'][$i].'%"',$_POST['unity'][$i]);
				}// if no # in the beginning
				
				switch ($result['lines']){
					//how many lines were returned?
					case 0: 
						$_POST['articles'][$i].=' '.$lang['not_found'];
						break;
					case 1:
						$_POST['articles'][$i]= $result['ART_NAME'].$lang['added']; 
						
						break;
					default:				
						$_POST['articles'][$i]="too much possibilities"; //must be changed	
						$ammount=$_POST['ammount'][$i];
						$unity=$_POST['unity'][$i];
						$select_article=true;
				}//end switch $result['lines']
			}// if field is not empty
			else {
				$_POST['articles'][$i]=$lang['article'].($i+1);
				$_POST['ammount'][$i]=$lang['ammount'];
				$_POST['unity'][$i]=$lang['unity'];
			}// if field is empty
			$input_fields.='<div class="rosine_paperwork_input_line">';
			$input_fields.='<input class="rosine_input_ammount" style="width:40px;" name="ammount['.$i.']" type="text" width="5" maxwidth="10" placeholder="'.
					$_POST['ammount'][$i].'" value="'.$ammount.'">';
			$input_fields.='<input class="rosine_input_ammount" style="width:40px;" name="unity['.$i.']" type="text" width="5" maxwidth="10" placeholder="'.
					$_POST['unity'][$i].'" value="'.$unity.'">';
								
			if ($select_article){
				// select fields must be displayed in paperwork to select the right one
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
		for ($i=$config['items_per_page'];$i<($config['items_per_page']+$config['favorite_articles']);$i++){
			//add favorite articles
			if ($_POST['ammount'][$i]>0){
				rosine_paperwork_add_article($_POST['paperwork'], $_POST['ammount'][$i], $_POST['paperwork_id'],' ART_NUMBER = '.substr($_POST['articles'][$i],1),$_POST['unity'][$i]);
			}//endif ammount field is not empty
		}// endfor add favorite articles

		// if there are articles from old paperwork insert them into the new paperwork and update old paperwork
		function rosine_add_old_paperwork_posi($value, $key){
			/* this function does everything that is neccessary for partly adding items to another paperwork 
			 */
			// get data from "old" paperwork
			$result= rosine_database_query(rosine_correct_query($GLOBALS['_POST']['old_paperwork'], $GLOBALS['rosine_db_query']['get_articles_from_paperwork'].
				'%plural%_positions WHERE %SINGULAR%_ID='.$GLOBALS['_POST']['old_paperwork_id'].
					' AND POSI_ID='.$value),"6-".$value);
			$GLOBALS['_POST']['old_posi_ammount'][$key]=str_replace(',','.',$GLOBALS['_POST']['old_posi_ammount'][$key]);
			if ($result){
				$f=mysql_fetch_array($result);
				// insert new paperwork
			
				rosine_paperwork_add_article($GLOBALS['_POST']['paperwork'],
						$GLOBALS['_POST']['old_posi_ammount'][$key] , 
						$GLOBALS['_POST']['paperwork_id'],' ART_NUMBER="'.$f['ART_NUMBER'].'"',
						$GLOBALS['_POST']['old_posi_unity'][$key]);
				
				// set the article to delivered 
				$query=rosine_correct_query($GLOBALS['_POST']['old_paperwork'], 
						$GLOBALS['rosine_db_query']['update_paperwork_item']);
				$query=str_replace("%set%", 'DONE=true',$query);
				$query=str_replace("%paperwork_id%", $GLOBALS['_POST']['old_paperwork_id'], $query);
				$query=str_replace('%posi_id%',$value,$query);
				rosine_database_query($query, "8-".$value);
				
				// now the check if the old paperwork is all done
				$query=rosine_correct_query($GLOBALS['_POST']['old_paperwork'], 
						$GLOBALS['rosine_db_query']['get_ammount_unfinished_items'],
						$GLOBALS['_POST']['old_paperwork_id']);
				
				$result=rosine_database_query($query, "9-".$value);
				if ($result){
					$f=mysql_fetch_array($result);

					if ($f['number']==0){
						rosine_set_status_paperwork($GLOBALS['_POST']['old_paperwork'], $GLOBALS['_POST']['old_paperwork_id'], "delivery".$GLOBALS['_POST']['paperwork_id']);
					}// there are no remaining items
					else {
						rosine_set_status_paperwork($GLOBALS['_POST']['old_paperwork'], $GLOBALS['_POST']['old_paperwork_id'], "partly delivery".$GLOBALS['_POST']['paperwork_id']);
					}// there are remaining items
				}//no error while getting the remaining count
			}// no error while getting the data from the the "old" paperwork
			
		}// end function rosine_add_old_paperwork_posi
		
		array_walk($_POST['old_posi_id'], 'rosine_add_old_paperwork_posi');
		
		
		// get Artikels from old paperwork
		$check_fields='';
		$result=rosine_database_query(rosine_correct_query($_POST['old_paperwork'],$rosine_db_query['get_articles_from_paperwork_with_all'].
				strtoupper($_POST['old_paperwork']).'_ID='.$_POST['old_paperwork_id'].' AND POSI_LOCATION='.$config['norm_stock'].' AND DONE=false'), 300);
		$counter=0;
		while ($f = @mysql_fetch_array($result)){
			$counter++;
			$check_fields.='<input type="checkbox" name="old_posi_id['.$counter.']" value="'.$f['POSI_ID'].'"> ';
			$check_fields.=number_format($f['POSI_AMMOUNT'],2,",",".").' '. $f['POSI_UNIT'];
			$check_fields.=' <b>'.$f['POSI_TEXT'].'</b> = ';
			
			if ($f['POSI_UNIT']==$config['delivery_unit_to_change']){
								$check_fields.='<input class ="rosine_input_ammount" style="width:40px;" name="old_posi_ammount['.$counter.']">';
								$check_fields.='<input class ="rosine_input_ammount" style="width:40px;" name="old_posi_unity['.$counter.']" value="kg"><br>';
			}// if unit should be change
			else {
				$check_fields.='<input class ="rosine_input_ammount" style="width:40px;" name="old_posi_ammount['.$counter.']" value="'.number_format($f['POSI_AMMOUNT'],0,",",".").'">';
				$check_fields.='<input class ="rosine_input_ammount" style="width:40px;" name="old_posi_unity['.$counter.']" value="'.$f['POSI_UNIT'].'"><br>';
			}// if unit shouldn't be change
			
		}// get every article that correspondeces to this search
		
		$check_fields.='';
		
		// articles from old paperwork ends here!
		
		// get customer from database
		$result=mysql_query($rosine_db_query['get_customers']." contact_id=".$_POST['contact_id']);
		if (mysql_errno($rosine_db)!=0) {
			// Error in mysql detected
			$error.="4: ".mysql_error($rosine_db);
				
		} // Error in mysql detected
		else {
			$customer_details = @mysql_fetch_array($result);
			//are there items to delete?
			array_walk ($_POST[delete], 'rosine_delete_positions',str_replace("%paperwork%",
					rosine_get_plural($_POST['paperwork']),$rosine_db_query['delete_article_from_paperwork']).
					' '.strtoupper($_POST['paperwork']).'_ID= '.$_POST['paperwork_id'].' AND POSI_ID=%value%');
			// correct numbers
			rosine_correct_numbers($_POST['paperwork'], $_POST['paperwork_id']);
			$liste=rosine_create_items_list($_POST['paperwork'], $_POST['paperwork_id']);
			$tpl->assign("paperwork_list", $liste);
			$tpl->assign("next_function", '<input type="hidden" name="next_function" value="change">');
			$tpl->assign("customer", $customer_details['n_fn']);
			$tpl->assign("ID", $customer_details['contact_id']);
			// update paperwork_ammount in table rosine paperwork
			rosine_update_ammount_paperwork($_POST['paperwork'], $_POST['paperwork_id']);
			
		}// no error in mysql for getting customer details
	break;
		
	
	default:
		// Step 0 - show address to choose	
		$tpl->load("paperwork_select_work.html");
		$lang[] = $config['language'];
		$lang = $tpl->loadLanguage($lang);
		$result=rosine_database_query(str_replace("%location%", $config['norm_stock'], 
				rosine_correct_query("order", $rosine_db_query['get_unfinished_paperwork'])), 4);
		if ($result!=""){
					// this is for changing pages
			$max_rows=mysql_num_rows($result);
			$from=(intval($_GET['from']));
			if ($from < 0)
				$from=0;
			if ($max_rows<$from+$config['customers_per_page'])
				$config['customers_per_page']=$max_rows-$from;
						
			if ($from >0) //zurueckblaettern anzeigen wenn moeglich
				$tpl->assign("backward", '<a href="?from='.($from-$config['customers_per_page']).'">&lt;&lt;</a>');
			else
				$tpl->assign("backward", "");
			if ($from < $max_rows-$config['customers_per_page']) //vorblaettern anzeigen wenn notwendig
				$tpl->assign("foreward", '<a href="?from='.($from+$config['customers_per_page']).'">&gt;&gt;</a>');
			else
				$tpl->assign("foreward", "");
			$tpl->assign('from', $from);
			$tpl->assign("to", ($from+$config['customers_per_page']));
			$tpl->assign("max", $max_rows);
			//here the things for changing the pages end
			
			//no error in mysql get customers
			$input_fields.='<form action="#" method="post">
						<input type="hidden" name="next_function" value="insert">
						<input type="hidden" name="paperwork" value="'.$_POST['paperwork'].'">
						<input type="hidden" name="old_paperwork" value="order">';
			if (mysql_affected_rows()==0)
				$input_fields.=$lang['nothing_to_show']."<br>";
			while($f = @mysql_fetch_array($result)) {
				$input_fields.='<button name="old_paperwork_id" value="'.$f["paperwork_id"].
						'" type="submit" >'.$f['n_fn'].'  ['.$lang['ammount'].': '.$f['ammount'].']</button>';
			}//endwhile
			$input_fields.='</form>';
		
			
		}// endelse no error in customer ammount search
		$tpl->assign("next_function", '<input type="hidden" name="next_function" value="change">');
				
}//end switch next_function

//show page
$tpl->assign("OK", $OK);
$tpl->assign("error", $error);
$tpl->assign("input_fields", $input_fields);
$tpl->assign("check_fields", $check_fields);
$tpl->assign("paperwork", $lang[$_POST['paperwork']]);
$tpl->assign("additional", '
			{$input_favorites}');
$tpl->assign("input_favorites", rosine_most_used_articles($_POST['paperwork'],$config['norm_stock'],true));
$tpl->assign("this_number",rosine_get_real_number($_POST['paperwork'],$_POST['paperwork_id']));
$tpl->assign("paperwork_file", rosine_get_plural($_POST['paperwork']));
$tpl->assign("paperwork_type", $_POST['paperwork']);
$tpl->assign("paperwork_id", $_POST['paperwork_id']);
$tpl->display();
?>