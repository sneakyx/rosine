<?

/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-03-25   		 								*
 \**************************************************************************/

function rosine_highest_number ($singular, $ID=0){
	/* this function gives the highest number from the database - either offer, order, delivery, invoice or payment
	 * or returns -1 as error
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
		
	
	if ($singular=="delivery")
		$plural="deliveries";
	else 
		$plural=$singular."s";
	
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
	}
	else {
		$returned= "-1";
	}
	return $returned;
}

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
}

?>