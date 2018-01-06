<?

/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
* http://www.rothaarsystems.de                                             *
* Author: info@rothaarsystems.de                                           *
* --------------------------------------------                             *
*  This program is free software; you can redistribute it and/or modify it *
*  under the terms of the GNU General Public License as published by the   *
*  Free Software Foundation; version 2 of the License.                     *
*  date of this file: 2018-01-06    		 								*
\**************************************************************************/



function rosine_create_tax_list($taxID){
	$liste='<select name="posi_tax">';
	$result=rosine_database_query(
			$GLOBALS['rosine_db_query']['get_taxs']." 1",206);
	if ($result!=false) {
		while($f = $result->fetch_array()) {
			if ($taxID==$f['TAX_ID']){
				$liste.='<option selected value="'.$f['TAX_ID'].'">'.substr($f['TAX_NAME'],0,10).' '.$f['TAX_PERCENTAGE']."%";
			}// if tax id matches
			else {
				$liste.='<option value="'.$f['TAX_ID'].'">'.substr($f['TAX_NAME'],0,10).' '.$f['TAX_PERCENTAGE']."%";
			}// tax id doesn't match
			$liste.="</option>";
		}// end while
		$result->close;
	}// no error in mysql
	$liste.='</select>';

	return $liste;
}//endfunc taxlist

function rosine_create_location_list($locationID){
	$liste='<select name="posi_location">';
	$result=rosine_database_query(
			$GLOBALS['rosine_db_query']['get_locations']." 1",207);
	if ($result!=false) {
		while($f = $result->fetch_array()) {
			if ($locationID==$f['LOC_ID']){
				$liste.='<option selected value="'.$f['LOC_ID'].'">'.substr($f['LOC_NAME'],0,30)." ";
			}// if loc id matches
			else {
				$liste.='<option value="'.$f['LOC_ID'].'">'.substr($f['LOC_NAME'],0,10)." ";
			}// loc id doesn't match
			$liste.="</option>";
		}// end while
		$result->close;
	}// no error in mysql
	$liste.='</select>';
	return $liste;
}//endfunc taxlist

function rosine_create_items_list($singular,$ID){
	/*
	 * This function creates the list of the items that are already in an offer/order etc
	 * and shows it for changing or deleting items
	 * $singular = offer/order...
	 * $ID - the ID of the order/offer etc
	 */
	$plural=rosine_get_plural($singular);
	$result=rosine_database_query(rosine_correct_query($singular, 
			"{$GLOBALS['rosine_db_query']['get_articles_from_paperwork']}%plural%_positions WHERE %SINGULAR%_ID=$ID 
                AND COMPANY_ID=%company%"),205);
			if ($result!=false) {
				$liste="<table id='rosine_tabelle'>";
				$liste.="<tr><th></th>
						<th>".lang('posi_id')."<br> ".lang('delete')."</th>
						<th width='55%'>".lang('article')."</th>
						<th>".lang('ammount')."</th>
						<th>".lang('price')."</th></tr>";
				while($f = $result->fetch_array()) {
					$liste.='<td><p class="rosine_back" style="margin:0px;"><a href="paperwork_item_change.php?paperwork='.$singular.'&paperwork_id='.$ID.'&posi_id='.$f['POSI_ID'].'" >'.lang('change').'</a></p></td>';
					$liste.='<td><input type="checkbox" name="delete['.$f['POSI_ID'].']" value="'.$f['POSI_ID'].'"> '.$f['POSI_ID']."</td>".
							"<td><center>".$f['ART_NUMBER'].': '.$f['POSI_TEXT'].'</center></td>
									<td>'.str_replace(".000", "", $f['POSI_AMMOUNT']).' '.$f['POSI_UNIT'].'</td>
									<td>à '.$f['POSI_PRICE']." ".$GLOBALS['currency'].'</td>';
					$liste.="<tr>
							";
				}//get rows with articles in database
				$liste.="</table>";
				$result->close();
			}//no error 5 in mysql
				
			return $liste;
}//endfunc rosine_create_items_list

function rosine_add_complete_paperwork($singular1,$ID1,$singular2,$ID2,$complete=true){
	// this adds a complete paperwork into another paperwork eg an offer into an order
	/*
	* $singular1 = from which paperwork comes the data
	* $ID1 = which ID has the source paperwork
	* $singular2 = to which paperwork goes the data
	* $ID2 = which ID has the destination paperwork
	*
	*/
	$plural1=rosine_get_plural($singular1);
	$plural2=rosine_get_plural($singular2);
	$query=str_replace("%singular1%", $singular1, $GLOBALS['rosine_db_query']['insert_paperwork_into_paperwork']);
	$query=str_replace("%singular2%",$singular2,$query);
	$query=str_replace("%plural1%", $plural1, $query);
	$query=str_replace("%plural2%", $plural2, $query);
	$query=rosine_correct_query($singular1, $query);
	
	if ($singular1==$singular2){
		$query=str_replace("%infotext%", "", $query);
	}// if a paperwork is just copied - not yet implemented
	else {
		$infotext=rosine_get_field_database($GLOBALS['rosine_db_query']['get_all_notes'].
				' NOTE_ID='.$GLOBALS['config']['insert_'.$singular1.'_into_paperwork'], 'NOTE_TEXT' ,800);
		$query=str_replace("%infotext%", $infotext, $query);
	}// paperwork is inserted into another - normal use of this function
	$query=str_replace("%paperwork%", $GLOBALS['lang'][$singular1], $query);
	$query=str_replace("%ID1%", $ID1, $query);
	$query=str_replace("%ID2%", $ID2, $query);
	$query=str_replace("%date%",rosine_get_field_database(rosine_correct_query($singular1,
			$GLOBALS['rosine_db_query']['get_paperworks'].' '.strtoupper($singular1).
			'_ID='.$ID1), strtoupper($singular1).'_DATE',801),$query);
	$query=str_replace("%SINGULAR1%",$GLOBALS['lang'][$singular1],$query);
	$query0=str_replace("%singular%", $singular2, $GLOBALS['rosine_db_query']['get_highest_number']);
	$query0=str_replace("%plural%",$plural2,$query0);
	$query0=str_replace("%1%", $singular2."_id=".$ID2, $query0);
	$query0=rosine_correct_query($singular1, $query0);
	$result0=rosine_database_query( $query0,401);
    if ($result0) {
    	$max=$result0->fetch_row();
    	$max[0]+=1;
    	$result0->close;
    	$query=str_replace("%max%", $max[0], $query);
    	$query=explode(";", $query);
    
    	array_walk($query, 'rosine_database_query');
    	if ($complete){
    		rosine_set_status_paperwork($singular1,$ID1,substr($singular2,0,2)." ".$ID2);
    	}// if the complete paperwork is added, we have to set the new status
    }//there's a result

}//endfunc add complete paperwork

function rosine_add_paperworklist($singular,$customer){
	//add a paperwork list for this customer
	$query=rosine_correct_query($singular, $GLOBALS['rosine_db_query']['paperwork_not_used']);
	if ($singular!="draft") {
		$query=str_replace("%customer%", $customer, $query);
		$query=str_replace("%where%", $singular.'_status="changed"', $query);
	} // search for explicit customer number if not a draft
	else {
		$query=str_replace("%customer%", $customer." OR ". $singular."_customer=0", $query);
		$query=str_replace("%where%", '1', $query);
	}// if it is draft, use also drafts for every customer
	//echo "<br>".$query."<br>";
	$result=rosine_database_query( $query, 406);
	$zeile='<select name="'.$singular.'">';
	$zeile.='<option selected value="" >'.lang($singular).'</option>';
	if ($result!=false){
		while ($f=$result->fetch_array()){
			$zeile.='<option value="'.$f[$singular.'_id'].'" title="'.str_replace(",000","",str_replace(".",",",str_replace(',', '; ', $f['contents']))).
			'">'.lang($singular).':'.$f[$singular.'_id'].' - '.lang('articles').
			':'.$f['ammount'].' ('.$f['money'].'€)</option>';

		}//end while
		$result->close();
	}//endif

	$zeile.='</select>';
	return $zeile;
}//endfunc rosine_add_paperworklist

function rosine_paperwork_add_article($singular, $ammount,$ID, $where,$unity=""){
	// singular = %paperwork%
	// number =  article number
	// ammount = ammount to add
	// $ID = $_POST[%paperwork%_id]
	// $where = where clause in MySQL
	// unity = unit to add
	$result=rosine_database_query(
			$GLOBALS['rosine_db_query']['get_articles'].$where,500);
	$lines=$result->num_rows;
	if ($lines==1){
		$f = $result->fetch_array();
		if (! $f['ART_STOCKNR']) {
			$f['ART_STOCKNR']="0";
		}
		$query=$GLOBALS['rosine_db_query']['insert_article_into_paperwork'].
		    "(%company%,
            '$ID', '".
            (rosine_highest_number($singular." positions",$ID)+1)."', 
            '{$f['ART_NUMBER']}',
        	$ammount, '";
		if ($unity!=""){
		    $query.="$unity.',";
		}
		else {
		    $query.="{$f['ART_UNIT']}', ";
		}
		$query.="{$f['ART_PRICE']},
		{$f['ART_STOCKNR']},
			'',
			'{$f['ART_NAME']}',
			{$f['ART_TAX']})";
			
		$query=rosine_correct_query($singular,$query); 
				$result2=rosine_database_query($query,501);
	}// endif affected rows is exactly 1

	return array("lines"=>$lines,'ART_NAME'=> $f['ART_NAME'],'ART_UNIT'=>$f['ART_UNIT'],"result"=>$result);
}//endfunction rosine_paperwork_add_article


function rosine_set_status_paperwork($singular,$ID,$status){
	$query=rosine_correct_query($singular, $GLOBALS['rosine_db_query']['set_paperwork_status']);
	$query=str_replace("%ID%", $ID, $query);
	$query=str_replace("%status%",$status,$query);
	$result=rosine_database_query($query,"257");
}// end function set status paperwork

function rosine_set_paperwork_printed($singular,$ID){
	$query=rosine_correct_query($singular, $GLOBALS['rosine_db_query']['set_paperwork_printed']);
	$query=str_replace("%ID%", $ID, $query);
	$result=rosine_database_query($query,"258");
}// end function set paperwork_printed

function rosine_most_used_articles($singular, $location="",$unity=""){
	$query=rosine_correct_query($singular, $GLOBALS['rosine_db_query']['most_used_articles']. $GLOBALS['config']['favorite_articles']);
	if ($location!=0) // when there is a limitation by stocknr
		$query=str_replace("WHERE 1", "WHERE a.ART_STOCKNR=".$location, $query);
		$result=rosine_database_query($query,700);
		$i=$GLOBALS['config']['items_per_page'];
		if ($result!=false) {
			while ($f= $result->fetch_array(MYSQLI_ASSOC)){
				$liste.='<div class="rosine_paperwork_input_line"><input type="text" style="width:40px;" max-width="10" name="ammount['.$i.']">'
						.'<input type="hidden" name="articles['.$i.']" value="#'.$f['art_number'].'">';
						if ($unity!="")
							$liste.='<input class="rosine_input_ammount" style="width:40px;" name="unity['.$i.']" type="text" width="5" maxwidth="10"
						value="'.$f['art_unit'].'">';
							$liste.=substr($f['art_name'],0,10).'('.$f['art_number'].')&nbsp;&nbsp;&nbsp;&nbsp;</div> ';
							$i+=1;
			}//add rows to the return
			$result->close();
		}//if $result
		$liste.="<br><br>";
		//return $query;

		return $liste;
}//returns a list of the most used articles

function rosine_get_real_number($singular, $ID){
	$query=rosine_correct_query($singular, $GLOBALS['rosine_db_query']['count_real_number'].$ID);
	$result=rosine_database_query($query,"200");
	if ($result!=false){
		$result=rosine_database_query($result,300);
		$returned=$result['0'];
	}// there was no error getting the hightest number
	else {
		$returned= "-1";
	}// there was an error
	if ($returned <$GLOBALS['items_per_page'])
		return 0; // if the actual item is less then items per page, the page displayes from 0
		else
			return ($returned-1); // the actual item is on top

}//endfunction get real number for back button in order_change, offers_change etc

function rosine_get_plural($singular){
	if ($singular=="delivery")
		$plural="deliveries";
		else
			$plural=$singular."s";
			return $plural;
}// get plural of table name for the right sql queries

function rosine_correct_query($singular,$query,$paperwork=""){
	//correction of query with singular and plural
	$plural=rosine_get_plural($singular);
	$query=str_replace("%company%", $GLOBALS['config']['company'], $query);
	$query=str_replace("%singular%", $singular, $query);
	$query=str_replace("%plural%", $plural, $query);
	$query=str_replace("%SINGULAR%", strtoupper($singular), $query);
	$query=str_replace("%PLURAL%", strtoupper($plural), $query);
	$query=str_replace("%paperwork%", $paperwork, $query);
	
	return $query;

}//endfunction correct query

function rosine_update_ammount_paperwork($singular,$ID){
	$query=$GLOBALS['rosine_db_query']['update_paperwork_ammount'];
	$query=rosine_correct_query($singular, $query);
	$query=str_replace("%id%", $ID, $query);
	rosine_database_query($query, 520);
	rosine_database_query(rosine_correct_query($singular, $GLOBALS['rosine_db_query']['update_brutto_ammount_paperwork'],$ID), 521);
}// endfunction update the ammount (of money) in paperwork

function rosine_delete_positions ($value, $key, $query){
	//query to delete a position from paperwork positions
	$result=rosine_database_query(str_replace("%value%",$value,$query),750);
}//endfunction delete_positions

function rosine_correct_numbers ($singular, $ID){
	// this function corrects IDs of items after deleting etc
	$query=$GLOBALS['rosine_db_query']['correct_numbers_from_paperwork'];

	$plural=rosine_get_plural($singular);

    $query=rosine_correct_query($singular, $query);
	$query=str_replace("%id%", $ID, $query);
	$result=rosine_database_query($query,927);

	$max=rosine_highest_number($singular." positions", $ID);
	if ($max>0){
		rosine_set_status_paperwork($singular, $ID, "changed");
	}//minimum of 1 article in paperwork with this id
	else{
		rosine_set_status_paperwork($singular, $ID, "empty");
	}// paperwork is empty
}//endfunction correct_numbers

function rosine_highest_number ($singular, $ID=0){
	/* this function gives the highest number from the database - either offer, order, delivery, invoice or payment
	 * or returns -1 as error
	 * $singular can also be "offer_postions" for search in table offer positions
	 * then a second parameter (ID of the offer) must be commited
	 */
	if (substr_count($singular, "positions")==1){
		// if we search highest number in positions in paperwork
		$plural2='_positions';
		$singular=substr($singular, 0, -10);
		$singular2="posi";
	} // table is _positions
	else {
		$plural2='';
		$singular2=$singular;
	}// table is not _positions


	$plural=rosine_get_plural($singular);

	$query=$GLOBALS['rosine_db_query']['get_highest_number'];
	$query=str_replace("%singular%", $singular2, $query);
	$query=str_replace("%plural%", $plural.$plural2, $query);
	if ($ID==0){
	    $query=str_replace("%1%", "1", $query);
	}
	else {
		$query=str_replace("%1%", $singular."_id =".$ID, $query);
	}
	$query=rosine_correct_query($singular, $query);
	$result=rosine_database_query($query,"100");
	if ($result!=false){
		$result=$result->fetch_row();
		$returned=$result['0'];
	}// there was no error getting the hightest number
	else {
		$returned= "-1";
	}// there was an error
    
	return $returned;

}//endfunctiuon rosine_highest_number

function rosine_database_query ($query, $error_number='00'){
	/*
	 * this function gives executes the selected mysql-query and returns also an error
	 */
	global $rosine_db;
	$result=$rosine_db->query($query);
		//echo "<br>".$query."<br>"; // this ist just for  debug
	if ($rosine_db->errno!=0){
		// Error in mysql detected
		$result=false;
		$GLOBALS['error'].=$error_number.'('.$rosine_db->errno.'): '.$rosine_db->error."<br>Query: ".$query;
		if ($error_number < 100) {
			echo $GLOBALS['error'];
		}// there is no template yet, error has to be printed out directly
	}
	return $result;
}//endfunction rosine_database_query

function rosine_get_field_database( $query,$field, $error_number=0){
	$result=rosine_database_query($query, $error_number);
	if ($result!=false){
		$row=$result->fetch_array();
		$result->close();
		return $row[$field];
	}//there was no error
	else {
		return false;
	}//there was an error
}//endfunction rosine_get_field_database

function rosine_next_article_number(){
	$result=rosine_database_query($GLOBALS['rosine_db_query']['get_next_article_number'],600);
	$f=$result->fetch_array();
	$result->close();
	return $f['maximum']+1;

}//endfunc next article number

?>