<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
* http://www.rothaarsystems.de                                             *
* Author: info@rothaarsystems.de                                           *
* --------------------------------------------                             *
*  This program is free software; you can redistribute it and/or modify it *
*  under the terms of the GNU General Public License as published by the   *
*  Free Software Foundation; version 2 of the License.                     *
*  date of this file: 2017-08-08 										   *
\**************************************************************************/
include ('inc/head.inc.php');

$tpl->load("show_statistics.html");
$lang = $tpl->loadLanguage($lang);
//standard values
$results="";
$params="";
$queries="";
$first_button="rosine_hidden";
$value="";
// standard-values for search-queries- TODO:this should be changed, so that every field used in template should be set to "" if variable is empty
if (!$_POST["date_from"])
	$_POST["date_from"]="";
if (!$_POST["date_to"])
	$_POST["date_to"]="";
if (!$_POST["numbers"])
	$_POST['numbers']="";

foreach ($rosine_db_query['statistics'] as $key=>$value){
	//puts the queries in template
	$queries.="<option value='$key'";
	if ($key==$_POST['query']){
		//if query was selected
		$queries.="selected";
		$sql_query=$value;
	}//endif query was selected
	$queries.=" >{L_".strtoupper($key)."}</option>";
}//endforeach

if($_POST['params_click']!=null){
	// second button was clicked
	$_POST['next_function']='show';
}


switch ($_POST['next_function']){

	case "params":
		// this is step 2 - giving fields for query to get some params from user
		$tpl->assign("class_params", "rosine_visible");
		$tpl->assign("class_results", "rosine_hidden");
		$tpl->assign("class_page_buttons", "rosine_hidden");

	break; 

	case "show":
		// step 3 - show the results 
		$tpl->assign("class_params", "rosine_visible");
		$tpl->assign("class_results", "rosine_visible");
		$tpl->assign("class_page_buttons", "rosine_visible");
	
		
		if (!$sql_query){
			//this is if there is a query quested, that is not existing
			// if there is no valid query, do an output
			$error.="This is no valid query!<br>".$_POST['query']."<br>";
			$sql_query=$rosine_db_query['statistics']['get_customer_with_most_sales'];
		}
		//construct the %where in mysql statement
		$where ="1 ";
		if ($_POST['date_from']){
			$date_from = new DateTime($_POST['date_from']);
			if ($_POST['date_to']){
				//end-date is entered
				$date_to = new DateTime($_POST['date_to']);
				$where.=" AND r.INVOICE_DATE > '{$date_from->format('Y-m-d H:i:s')}'";
				$where.=" AND r.INVOICE_DATE < '{$date_to->format('Y-m-d H:i:s')}'";
			}// there is an enddate
			else {
				// no end-date is entered
				$where.=" AND r.INVOICE_DATE = '{$date_from->format('Y-m-d H:i:s')}'";
			}// there is no enddate
		}// there is a date added
		if ($_POST['numbers']){
			$numbers_komma=explode(",",$_POST['numbers']);
			$where.=" AND (";
			foreach ($numbers_komma as $key=>$value){
				//builds the query for the numbers
				if ($key==0) {
					//first key we have to add and, otherwise or
					$where.=" r.INVOICE_ID ";
				}
				else{
					//this is not first key
					$where.=" OR r.INVOICE_ID ";
				}
				if (strpos($value,"-")){
					// there is a range
					$where.=" BETWEEN ".strstr($value,"-",true)." AND ".substr(strstr($value,"-"),1);
				}
				else{
					//there is no range
					$where.="=".$value;
				}
				
			}//endforeach
			$where.=")";
		}//there were numbers added
		
		$sql_query=str_replace("%where%", $where, $sql_query);

		// get ammount of articles in database
		
		$max_rows=rosine_get_field_database("SELECT COUNT(*) FROM ( $sql_query )  AS SUB0", '0',102);
		$liste='';
		/*
		 * correct the from-variable and the items per page-variable
		 * if from is to slow and items-per-page is to high
		 */
		$from=(intval($_GET['from']));
		if ($from < 0){
			//if the number is to low
			$from=0;
		}// endif
		if ($max_rows<$from+$config['items_per_page']) {
			//if the number is to high
			$config['items_per_page']=$max_rows-$from;
		}//endif
		$result=rosine_database_query($sql_query." LIMIT $from,".$config['items_per_page'] , 103);
		if ($from >0) {//if there's apossibility to go back
			$tpl->assign("backward", "<a href='?next_function=show&query={$_POST["query"]}&numbers={$_POST['numbers']}&date_from={$_POST['date_from']}&date_to={$_POST['date_to']}&from=".($from-$config['items_per_page'])."'>&lt;&lt;</a>");
		}//endif
		else {
			$tpl->assign("backward", "");
		}//endelse
		
		if ($from < $max_rows-$config['items_per_page']){ //if you can click next
			$tpl->assign("foreward", "<a href='?next_function=show&query={$_POST["query"]}&numbers={$_POST['numbers']}&date_from={$_POST['date_from']}&date_to={$_POST['date_to']}&from=".($from+$config['items_per_page'])."'>&gt;&gt;</a>");
		}//endif
		else {
			$tpl->assign("foreward", "");
		}//endelse
		$results.="<table id='rosine_tabelle'><tr>";
		foreach($result->fetch_fields() as $f) {
			$results.=vsprintf ("<th>{L_%s}</th>\n", strtoupper($f->name));
		}
		$results.="</tr>";
		while($f = $result->fetch_row()) {
			$formating=str_repeat("<td>%s</td>", count($f))."\n";
			$results.="<tr>".vsprintf ($formating, $f)."</tr>";
		}
		$results.="</table>";
	break;
		
	default:
		// the default case is selecting the sql-query
		$tpl->assign("class_params", "rosine_hidden");
		$tpl->assign("class_results", "rosine_hidden");
		$tpl->assign("class_page_buttons", "rosine_hidden");
		$first_button="";
		
}//end case select what happens with the data
$tpl->assign("results", $results);
$tpl->assign("queries", $queries);
$tpl->assign_array("post", $_POST);
$lang = $tpl->loadLanguage($lang);
$tpl->assign('from', $from);
$tpl->assign("to", ($from+$config['items_per_page']));
$tpl->assign("max", $max_rows);
$tpl->assign("first_button", $first_button);
$tpl->assign("params", $params);


$tpl->assign("error", $error);
$tpl->assign("OK", $OK);
$tpl->display();
?>
