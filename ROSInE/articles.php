<?php
	/**************************************************************************\
	* Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
	* http://www.rothaarsystems.de                                             *
	* Author: info@rothaarsystems.de                                           *
	* --------------------------------------------                             *
	*  This program is free software; you can redistribute it and/or modify it *
	*  under the terms of the GNU General Public License as published by the   *
	*  Free Software Foundation; version 2 of the License.                     *
	*  date of this file: 2016-01-12  										   *
	\**************************************************************************/


$GLOBALS['phpgw_info']['flags']['currentapp'] = 'rosine';
include('../header.inc.php');
include ('inc/settings.php');
include ('inc/template.class.php');

$tpl = new Rosine_Template();
$tpl->load("articlelist.html");
$lang[] = $language;
$lang = $tpl->loadLanguage($lang);
// should there be one articles really deleted?
if ($_POST['next_function']=="really_delete"){
	$result=mysql_query($rosine_db_query['delete_article'].' ART_NUMBER="'.$_POST['number'].'" LIMIT 1');
	if (mysql_errno($rosine_db)!=0) {
		// Error in mysql detected
		$error.="1: ".mysql_error($rosine_db);
	}
	else {
		$OK.=$lang['article_deleted']." ".$lang['article_number']." ".$_POST['number'];
	}
	
}

// get ammount of articles in database
$result=mysql_query($rosine_db_query['get_article_ammount']." 1");
$liste="";
if (mysql_errno($rosine_db)!=0) {
	// Error in mysql detected
	$error.="1: ".mysql_error($rosine_db);
}
else {
	$g = @mysql_fetch_array($result);
	$max_rows=$g[0];
}
/* 
 * correct the from-variable and the items per page-variable
 * if from is to slow and items-per-page is to high
 */
$from=(intval($_GET['from']));
if ($from < 0)
	$from=0;
if ($max_rows<$from+$items_per_page)
	$items_per_page=$max_rows-$from;
$result=mysql_query($rosine_db_query['get_articles']."1 LIMIT $from,$items_per_page");

if ($from >0) //zurueckblaettern anzeigen wenn moeglich
	$tpl->assign("backward", '<a href="?from='.($from-$items_per_page).'">&lt;&lt;</a>');
else 
	$tpl->assign("backward", "");

if ($from < $max_rows-$items_per_page) //vorblaettern anzeigen wenn notwendig
	$tpl->assign("foreward", '<a href="?from='.($from+$items_per_page).'">&gt;&gt;</a>');
else 
	$tpl->assign("foreward", "");

$tpl->assign('from', $from);
$tpl->assign("to", ($from+$items_per_page));
$tpl->assign("max", $max_rows);

if (mysql_errno($rosine_db)!=0) {
	// Error in mysql detected
	$error.="2: ".mysql_error($rosine_db);
}
else {
	$liste.='<table id="rosine_tabelle">';
	$liste.='<tr>
				<th>'.$lang['article_number'].'</th>
				<th>'.$lang['article_name'].'</th>
				<th>'.$lang['price'].'</th>
				<th>'.$lang['stock'].'</th>
				<th>'.$lang['delete'].'</th>
				<th>'.$lang['change'].'</th>
			</tr>';
		
	while($f = @mysql_fetch_array($result)) {
		$liste.="<tr>";
		if ($_POST['next_function']=="delete" & $_POST['number']==$f['ART_NUMBER']){
			//Sicherheitsabfrage!
			$next_function="really_delete";
			$delete=$lang['really_delete'];
		}
		else {
			//Normale Funktion
			$delete=$lang['delete'];
			$next_function="delete";
		}
		$liste.="<td>".$f['ART_NUMBER']."</td>".
			'<td style="text-align:center;">'.$f['ART_NAME']."</td>
			<td>".$f['ART_PRICE']." ".$currency."</td>
			<td>".$f['INSTOCK'].'</td>
			<td>
					<form action="#" method="post">
						<input type="hidden" name="next_function" value="'.$next_function.'">
						<input type="submit" title="'.$delete.'" value="'.$delete.'">
						<input type="hidden" name="number" value="'.$f['ART_NUMBER'].'">
					</form>
			</td>
			<td>
					<form action="articles_change.php" method="post">
						<input type="hidden" name="next_function" value="change">
						<input type="submit" title="'.$lang['change'].'" value="'.$lang['change'].'">
						<input type="hidden" name="number" value="'.$f['ART_NUMBER'].'">
					</form>
			</td>';
		$liste.="</tr>";
	}
	$liste.="</table>";
	
}
$tpl->assign('articlelist', $liste);
$tpl->assign("OK", $OK);
$tpl->assign("error", $error);
$tpl->display();

?>