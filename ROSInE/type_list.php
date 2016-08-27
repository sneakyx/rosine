<?php
	/**************************************************************************\
	* Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
	* http://www.rothaarsystems.de                                             *
	* Author: info@rothaarsystems.de                                           *
	* --------------------------------------------                             *
	*  This program is free software; you can redistribute it and/or modify it *
	*  under the terms of the GNU General Public License as published by the   *
	*  Free Software Foundation; version 2 of the License.                     *
	*  date of this file: 2016-08-27  										   *
	\**************************************************************************/
include ('inc/head.inc.php');
if ($_GET['type']!="") {
	/* this must be the first call of this file, so it is called by another
	 * file, like main menue
	 * But this $_POST variable is used everywhere in this file
	 */
	$_POST['type']=$_GET['type'];
}//endif
$tpl->load($_POST['type'].'list.html');
$lang = $tpl->loadLanguage($lang);

// should there be one article really deleted?
if ($_POST['next_function']=="really_delete"){
	$type_short=strtoupper(substr($_POST['type'], 0,3));
	if ($type_short=='ART'){
		$type_short.='_NUMBER';
		$id_name='number';
	}
	else{
		$type_short.='_ID';
		$id_name=strtolower($type_short);
	}
	$result=rosine_database_query($rosine_db_query['delete_'.$_POST['type']].' '.$type_short.'="'.$_POST[$id_name].'" LIMIT 1',101);
	if ($result!=false){
		//no error deleting line
		$OK.=$lang[$_POST['type'].'_deleted']." ".$lang[$_POST['type'].'_number']." ".$_POST['number'];
	}// endif $result !=false
	
}//endif really delete

// get ammount of articles in database
$max_rows=rosine_get_field_database($rosine_db_query['get_'.$_POST['type'].'_ammount'].' 1','0', 102);
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
$result=rosine_database_query($rosine_db_query['get_'.$_POST['type'].'s']."1 LIMIT $from,".$config['items_per_page'] , 103);
if ($from >0) {//if there's apossibility to go back
	$tpl->assign("backward", '<a href="?from='.($from-$config['items_per_page']).'">&lt;&lt;</a>');
}//endif
else {
	$tpl->assign("backward", "");
}//endelse

if ($from < $max_rows-$config['items_per_page']){ //if you can click next
	$tpl->assign("foreward", '<a href="?from='.($from+$config['items_per_page']).'">&gt;&gt;</a>');
}//endif
else {
	$tpl->assign("foreward", "");
}//endelse

$tpl->assign('from', $from);
$tpl->assign("to", ($from+$config['items_per_page']));
$tpl->assign("max", $max_rows);

if ($result!=false){
	include ('inc/'.$_POST['type'].'_list.inc.php');
	$liste.="</table>";
	$result->close();
}
$tpl->assign($_POST['type'].'list', $liste);
$tpl->assign("OK", $OK);
$tpl->assign("error", $error);
$tpl->display();

?>