<?php 
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-04-23  										    *
 \**************************************************************************/
$tpl = new Rosine_Template();
$tpl->load("paperworklist.html");
$lang[] = $config['language'];
$lang = $tpl->loadLanguage($lang);
// should there be one invoice really deleted?
if ($_POST['next_function']=="really_delete"){
	$query=rosine_correct_query($_POST['paperwork'], $rosine_db_query['delete_paperwork'],$_POST['paperwork']);
	$result=mysql_query(str_replace("%ID%", $_POST['number'],$query));
	if (mysql_errno($rosine_db)!=0) {
		// Error in mysql detected
		$error.="10: ".mysql_error($rosine_db);
	}// error while delete
	else {
		$OK.=str_replace("%paperwork%", $lang[$_POST['paperwork']], $lang['paperwork_deleted'])." ".$lang['']." ".$_POST['number']."<br>";
	}// no error while delete

	$query=rosine_correct_query($_POST['paperwork'], $rosine_db_query['delete_paperwork_positions'],$_POST['paperwork']);
	$result=mysql_query(str_replace("%ID%", $_POST['number'],$query));
	if (mysql_errno($rosine_db)!=0) {
		// Error in mysql detected
		$error.="11: ".mysql_error($rosine_db);
	}// error while delete
	else {
		$OK.=str_replace("%paperwork%", $lang[$_POST['paperwork']], $lang['paperwork_positions_deleted'])." ".$lang['']." ".$_POST['number']."<br>";
	}// no error while delete
	
}// realley delete

// get ammount of invoices in database
$result=mysql_query(str_replace("%paperwork%", rosine_get_plural($_POST['paperwork']), $rosine_db_query['get_ammount_of_paperworks'])." 1");
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
	if ($max_rows<$from+$config['items_per_page'])
		$config['items_per_page']=$max_rows-$from;
		$result=mysql_query(rosine_correct_query($_POST['paperwork'], $rosine_db_query['get_paperworks'],$_POST['paperwork'])."1 ORDER BY ".strtoupper($_POST['paperwork'])."_ID LIMIT $from,".$config['items_per_page']);

		if ($from >0) //zurueckblaettern anzeigen wenn moeglich
			$tpl->assign("backward", '<a href="?from='.($from-$config['items_per_page']).'&paperwork='.$_POST['paperwork'].'">&lt;&lt;</a>');
			else
				$tpl->assign("backward", "");

				if ($from < $max_rows-$config['items_per_page']) //vorblaettern anzeigen wenn notwendig
					$tpl->assign("foreward", '<a href="?from='.($from+$config['items_per_page']).'&paperwork='.$_POST['paperwork'].'">&gt;&gt;</a>');
					else
						$tpl->assign("foreward", "");

						$tpl->assign('from', $from);
						$tpl->assign("to", ($from+$config['items_per_page']));
						$tpl->assign("max", $max_rows);

						if (mysql_errno($rosine_db)!=0) {
							// Error in mysql detected
							$error.="2: ".mysql_error($rosine_db);
						}
						else {
							$liste.='<table id="rosine_tabelle">';
							$liste.='<tr>
				<th>'.$lang[$_POST['paperwork'].'_number'].'</th>
				<th>'.$lang['date'].'</th>		
				<th>'.$lang['customer'].'</th>
				<th>'.$lang['status'].'</th>		
				<th>'.$lang['delete'].'</th>
				<th>'.$lang['change'].'</th>
				<th>'.$lang['print'].'</th>		
			</tr>';

							while($f = @mysql_fetch_array($result)) {
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
						<input type="hidden" name="next_function" value="change">
						<input type="submit" title="'.$lang['change'].'" value="'.$lang['change'].'">
						<input type="hidden" name="paperwork_id" value="'.$f[strtoupper($_POST['paperwork']).'_ID'].'">
						<input type="hidden" name="contact_id" value="::'.$f[strtoupper($_POST['paperwork']).'_CUSTOMER'].'">		
					</form>
			</td>'; //ob das mit den zwei Doppelpunkten stimmt?
			$liste.='<td><a href="paperwork_print.php?paperwork='.$_POST['paperwork'].'&paperwork_id='.
					$f[strtoupper($_POST['paperwork']).'_ID'].'" target="_blank">'.$lang['print'].'</a></td>';
			$liste.="</tr>";
		}
		$liste.="</table>";

}
$tpl->assign('paperworklist', $liste);
$tpl->assign("paperwork", $lang[$_POST['paperwork']]);
$tpl->assign("paperwork_type", $_POST['paperwork']);
$tpl->assign("OK", $OK);
$tpl->assign("error", $error);
$tpl->display();
?>