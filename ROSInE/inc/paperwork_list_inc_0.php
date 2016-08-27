<?php 
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-08-26  										    *
 \**************************************************************************/
$tpl = new Rosine_Template();
$tpl->load("paperworklist.html");
$lang[] = $config['language'];
$lang = $tpl->loadLanguage($lang);
// should there be one invoice really deleted?
if ($_POST['next_function']=="really_delete"){
	$query=rosine_correct_query($_POST['paperwork'], $rosine_db_query['delete_paperwork'],$_POST['paperwork']);
	$result=rosine_database_query(str_replace("%ID%", $_POST['number'],$query),110);
	if ($result!=false) {
		$OK.=str_replace("%paperwork%", $lang[$_POST['paperwork']], $lang['paperwork_deleted'])." ".$lang['']." ".$_POST['number']."<br>";
	}// no error while delete

	$query=rosine_correct_query($_POST['paperwork'], $rosine_db_query['delete_paperwork_positions'],$_POST['paperwork']);
	$result=rosine_database_query(str_replace("%ID%", $_POST['number'],$query),111);
	if ($result!=false) {
		$OK.=str_replace("%paperwork%", $lang[$_POST['paperwork']], $lang['paperwork_positions_deleted'])." ".$lang['']." ".$_POST['number']."<br>";
	}// no error while delete
	
}// really delete

// get ammount of paperworks in database
$result=rosine_database_query(str_replace("%paperwork%", rosine_get_plural($_POST['paperwork']), $rosine_db_query['get_ammount_of_paperworks'])." 1",112);
$liste="";
if ($result!=false) {
	$g = $result->fetch_array();
	$max_rows=$g[0];
}
/*
 * correct the from-variable and the items per page-variable
 * if from is to slow and items-per-page is to high
 */
$from=(intval($_GET['from']));
if ($from < 0){
	$from=0;
}//endif
if ($max_rows<$from+$config['items_per_page']) {
	$config['items_per_page']=$max_rows-$from;
}
$result=rosine_database_query(rosine_correct_query($_POST['paperwork'], 
				$rosine_db_query['get_paperworks'],$_POST['paperwork']).
				"1 ORDER BY ".strtoupper($_POST['paperwork'])."_ID DESC LIMIT $from,".
				$config['items_per_page'],120);
if ($from >0) {//zurueckblaettern anzeigen wenn moeglich
	$tpl->assign("backward", '<a href="?from='.($from-$config['items_per_page']).
			'&paperwork='.$_POST['paperwork'].'">&lt;&lt;</a>');
}//endif
else {
	$tpl->assign("backward", "");
}//endelse
if ($from < $max_rows-$config['items_per_page']){ //vorblaettern anzeigen wenn notwendig
	$tpl->assign("foreward", '<a href="?from='.($from+$config['items_per_page']).'&paperwork='.$_POST['paperwork'].'">&gt;&gt;</a>');
}//endif
else {
	$tpl->assign("foreward", "");
}//endelse

$tpl->assign('from', $from);
$tpl->assign("to", ($from+$config['items_per_page']));
$tpl->assign("max", $max_rows);

if ($result!=false) {
	$liste.='<table id="rosine_tabelle">';
	$liste.='<tr>
			<th>'.$lang[$_POST['paperwork'].'_number'].'</th>
			<th>'.$lang['date'].'</th>		
			<th>'.$lang['customer'].'</th>
			<th>'.$lang['money'].'</th>
			<th>'.$lang['status'].'</th>		
			<th>'.$lang['delete'].'</th>
			<th>'.$lang['change'].'</th>
			<th>'.$lang['print'].'</th>		
		</tr>';

	while($f = $result->fetch_array()) {
		$liste.="<tr>";
		if ($_POST['next_function']=="delete" & $_POST['number']==$f[strtoupper($_POST['paperwork']).'_ID']){
			//Sicherheitsabfrage!
			$next_function="really_delete";
			$delete=$lang['really_delete'];
		}// endif safety question
		else {
			//Normale Funktion
			$delete=$lang['delete'];
			$next_function="delete";
		}// no safety question
		if ($f[$_POST['paperwork'].'_customer_private']=="1")
			$f['n_fn'].=" ".$lang['private'];
		else 
			$f['n_fn'].=" ".$lang['company'];
		$liste.="<td>".$f[strtoupper($_POST['paperwork']).'_ID']."</td>".
				"<td>".$f[strtoupper($_POST['paperwork']).'_DATE']."</td>".
				"<td>".$f['n_fn']."</td>".
				"<td>".$f[strtoupper($_POST['paperwork']).'_AMMOUNT'].$config['currency']."</td>".
				"<td>".$f[strtoupper($_POST['paperwork']).'_STATUS']."</td>".
				'<td>
				<form action="#" method="post">
					<input type="hidden" name="next_function" value="'.$next_function.'">
					<input type="submit" title="'.$delete.'" value="'.$delete.'">
					<input type="hidden" name="number" value="'.$f[strtoupper($_POST['paperwork']).'_ID'].'">
				</form>
				</td>
				<td>
				<form action="paperwork_change.php" method="post">
					<input type="hidden" name="paperwork" value="'.$_POST['paperwork'].'">
					<input type="hidden" name="next_function" value="overview">
					<input type="submit" title="'.$lang['change'].'" value="'.$lang['change'].'">
					<input type="hidden" name="paperwork_id" value="'.$f[strtoupper($_POST['paperwork']).'_ID'].'">
					<input type="hidden" name="contact_id" value="::'.$f[strtoupper($_POST['paperwork']).'_CUSTOMER'].'">		
				</form>
		</td>'; 
		$liste.='<td><a href="paperwork_print.php?paperwork='.$_POST['paperwork'].'&paperwork_id='.
				$f[strtoupper($_POST['paperwork']).'_ID'].'" target="_blank">'.$lang['print'].'</a></td>';
		$liste.="</tr>";
	}//endwhile
	$liste.="</table>";
	$result->close();
}//endwhile
$tpl->assign('paperworklist', $liste);
$tpl->assign("paperwork", $lang[$_POST['paperwork']]);
$tpl->assign("paperwork_type", $_POST['paperwork']);
$tpl->assign("OK", $OK);
$tpl->assign("error", $error);
$tpl->display();

?>