<?
function rosine_highest_number ($singular){
	/* this function gives the highest number from the database - either offer, order, delivery, invoice or payment
	 * or returns -1 as error
	 */
	if ($singular=="delivery")
		$plural="deliveries";
	else 
		$plural=$singular."s";
	
	$query=$GLOBALS['rosine_db_query']['get_highest_number'];
	$query=str_replace("%singular%", $singular, $query);
	$query=str_replace("%plural%", $plural, $query);
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