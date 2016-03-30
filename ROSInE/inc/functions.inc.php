<?

/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-03-30   		 								*
 \**************************************************************************/
function rosine_add_complete_paperwork($singular1,$ID1,$singular2,$ID2,$complete=true){
	// this adds a complete paperwork into another paperwork eg an offer into an order
	/*
	 * $singular1 = from which paperwork comes the data
	 * $paperwork_ID1 = which ID has the source paperwork 
	 * $singular2 = to which paperwork goes the data
	 * $paperwork_ID2 = which ID has the destination paperwork
	 * 
	 */
	$plural1=rosine_get_plural($singular1);
	$plural2=rosine_get_plural($singular2);
	$query=str_replace("%singular1%", $singular1, $GLOBALS['rosine_db_query']['insert_paperwork_into_paperwork']);
	$query=str_replace("%singular2%",$singular2,$query);
	$query=str_replace("%plural1%", $plural1, $query);
	$query=str_replace("%plural2%", $plural2, $query);
	if ($singular1==$singular2){
		$query=str_replace("%infotext%", "", $query);
	}// if a paperwork is just copied - not yet implemented
	else {
		$query=str_replace("%infotext%", $GLOBALS['lang']['from_paperwork'], $query);
	}// paperwork is inserted into another - normal use of this function
	$query=str_replace("%paperwork%", $GLOBALS['lang'][$singular1], $query);
	$query=str_replace("%ID1%", $ID1, $query);
	$query=str_replace("%ID2%", $ID2, $query);
	$query=explode(";", $query);
	$result1=mysql_query($query[0]); // query to set MySQL-Variable @n
	$result2=mysql_query($query[1]); // query to add the paperwork items to the new paperwork
	if ($complete){
		rosine_set_status_paperwork($singular1,$ID1,$singular2." ".$ID2);
	}// if the complete paperwork is added, we have to set the new status
}//endfunc add complete paperwork 

function rosine_add_paperworklist($singular,$customer){
	//add a paperwork list for this customer
	$query=rosine_correct_query($singular, $GLOBALS['rosine_db_query']['paperwork_not_used']);
	$query=str_replace("%customer%", $customer, $query);
	$result=mysql_query($query);
	$zeile='<select name="'.$singular.'">';
	$zeile.='<option selected value="" >'.$GLOBALS['lang'][$singular].'</option>';
	while ($f=mysql_fetch_array($result)){
		$zeile.='<option value="'.$f['offer_id'].'" title="'.str_replace(",000","",str_replace(".",",",str_replace(',', '; ', $f['contents']))).
			'">'.$GLOBALS['lang'][$singular].':'.$f['offer_id'].' - '.$GLOBALS['lang']['articles'].
		':'.$f['ammount'].' ('.$f['money'].'€)</option>';
	
	}//end while
	$zeile.='</select>';
	return $zeile;
}//endfunc rosine_add_paperworklist

function rosine_paperwork_add_article($singular, $ammount,$ID, $where){
	// singular = %paperwork%
	// number =  article number
	// ammount = ammount to add
	// $ID = $_POST[%paperwork%_id]
	// $where = where clause in MySQL

	$result=mysql_query($GLOBALS['rosine_db_query']['get_articles'].$where);
	$lines=mysql_num_rows($result);
	if ($lines==1){
		$f = mysql_fetch_array($result);
		if (! $f['ART_INSTOCKNR'])
			$f['ART_INSTOCKNR']="0";
		$query=rosine_correct_query($singular, $GLOBALS['rosine_db_query']['insert_article_into_paperwork']);		
		$result2=mysql_query($query.
				'("'.$ID.'", "'.
				(rosine_highest_number($singular." positions",$ID)+1).'", "'.
				$f['ART_NUMBER'].'", '.
				$ammount.', "'.
				$f['ART_UNIT'].'", '.
				$f['ART_PRICE'].', '.
				$f['ART_INSTOCKNR'].',
										"","'. //theres no possibility to add Seriennummer (yet)
				$f['ART_NAME'].'",'.
				$f['ART_TAX'].')');
	}// endif affected rows is exactly 1
	// echo $GLOBALS['rosine_db_query']['get_articles'].$where; //only for testing
	return array("lines"=>$lines,'ART_NAME'=> $f['ART_NAME'],'ART_UNIT'=>$f['ART_UNIT'],"result"=>$result);
}//endfunction rosine_paperwork_add_article


function rosine_set_status_paperwork($singular,$ID,$status){
	$query=rosine_correct_query($singular, $GLOBALS['rosine_db_query']['set_paperwork_status']);
	$query=str_replace("%ID%", $ID, $query);
	$query=str_replace("%status%",$status,$query);
	$result=rosine_database_query($query,"210");
}// end function set status paperwork

function rosine_most_used_articles($singular){
	$query=rosine_correct_query($singular, $GLOBALS['rosine_db_query']['most_used_articles']);
	$result=mysql_query($query);
	if (mysql_errno()!=0){
		// Error in mysql detected
		$result=false;
		echo $error_number.": ".mysql_error()."<br>".$query;
	}// there is no error
	$i=$GLOBALS['items_per_page'];
	while ($f= mysql_fetch_array($result,MYSQL_ASSOC)){
		$liste.='<div class="rosine_paperwork_input_line"><input type="text" style="width:40px;" max-width="10" name="ammount['.$i.']">'
			.'<input type="hidden" name="articles['.$i.']" value="#'.$f['art_number'].'">'	
			.$f['art_name'].'('.$f['art_number'].')&nbsp;&nbsp;&nbsp;&nbsp;</div> ';
		$i+=1;
	}//add rows to the return
	$liste.="<br><br>";
	//return $query;
	
	return $liste;
}//returns a list of the most used articles

function rosine_get_real_number($singular, $ID){
	$query=rosine_correct_query($singular, $GLOBALS['rosine_db_query']['count_real_number'].$ID);
	$result=rosine_database_query($query,"200");
	if ($result!=false){
		$result=mysql_fetch_row($result);
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
	$query=str_replace("%singular%", $singular, $query);
	$query=str_replace("%plural%", $plural, $query);
	$query=str_replace("%paperwork%", $paperwork, $query);
	return $query;
	
}//endfunction correct query

function rosine_update_ammount_paperwork($singular,$ID){
	$query=$GLOBALS['rosine_db_query']['update_paperwork_ammount'];
	$query=rosine_correct_query($singular, $query);
	$query=str_replace("%id%", $ID, $query);
	$result=mysql_query($query);
	if (mysql_errno($GLOBALS['rosine_db'])!=0){
		// Error in mysql detected
		$result=false;
		$GLOBALS['error'].="210: ".mysql_error($GLOBALS['rosine_db'])."<br>".$query;
	}//endif there's an error
	
}// endfunction update the ammount (of money) in paperwork

function rosine_delete_positions ($value, $key, $query){
	//query to delete a position from paperwork positions
	$result=mysql_query(str_replace("%value%",$value,$query));
}//endfunction delete_positions

function rosine_correct_numbers ($singular, $ID){
	$query=$GLOBALS['rosine_db_query']['correct_numbers_from_paperwork'];
	
	$plural=rosine_get_plural($singular);
	
	$query=str_replace("%singular%", $singular, $query);
	$query=str_replace("%plural%", $plural, $query);
	$query=str_replace("%id%", $ID, $query);
	$result=mysql_query($query);
	if (mysql_errno($GLOBALS['rosine_db'])!=0){
		// Error in mysql detected
		$result=false;
		$GLOBALS['error'].="200: ".mysql_error($GLOBALS['rosine_db'])."<br>".$query;
	}//if there is an error
	
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
	if ($ID==0)
		$query=str_replace("%1%", "1", $query);
	else 
		$query=str_replace("%1%", $singular."_id =".$ID, $query);
	$result=rosine_database_query($query,"100");
	if ($result!=false){
		$result=mysql_fetch_row($result);
		$returned=$result['0'];
	}// there was no error getting the hightest number
	else {
		$returned= "-1";
	}// there was an error
	
	return $returned;
	
}//endfunctiuon rosine_highest_number

function rosine_database_query ($query, $error_number){
	/*
	 * this function gives executes the selected mysql-query and returns also an error
	 */
	$result=mysql_query($query);
	if (mysql_errno($GLOBALS['rosine_db'])!=0){ 
		// Error in mysql detected
		$result=false;
		$GLOBALS['error'].=$error_number.": ".mysql_error($GLOBALS['rosine_db'])."<br>".$query;
	}
	return $result;
}//endfunction rosine_database_query


?>