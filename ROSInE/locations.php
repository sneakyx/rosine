<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-01-14  										   *
 \**************************************************************************/



$GLOBALS['phpgw_info']['flags']['currentapp'] = 'rosine';
include('../header.inc.php');
include ('inc/settings.php');
include ('inc/template.class.php');

$tpl = new Rosine_Template();
$tpl->load("locationlist.html");
$lang[] = $language;
$lang = $tpl->loadLanguage($lang);
// should there be one articles really deleted?
if ($_POST['next_function']=="really_delete"){
	$result=mysql_query($rosine_db_query['delete_location'].' LOC_ID='.$_POST['loc_id'].' LIMIT 1');
	if (mysql_errno($rosine_db)!=0) {
		// Error in mysql detected
		$error.="1: ".mysql_error($rosine_db);
	}
	else {
		$OK.=$lang['location_deleted']." ".$lang['number']." ".$_POST['loc_id'];
	}

}

// get ammount of locations in database
$result=mysql_query($rosine_db_query['get_locations_ammount']." 1");
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
		$result=mysql_query($rosine_db_query['get_locations']."1 LIMIT $from,$items_per_page");

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
				<th>'.$lang['location_id'].'</th>
				<th>'.$lang['location_name'].'</th>
				<th>'.$lang['delete'].'</th>
				<th>'.$lang['change'].'</th>
			</tr>';

							while($f = @mysql_fetch_array($result)) {
								$liste.="<tr>";
								if ($_POST['next_function']=="delete" & $_POST['loc_id']==$f['LOC_ID']){
									//Sicherheitsabfrage!
									$next_function="really_delete";
									$delete=$lang['really_delete'];
								}
								else {
									//Normale Funktion
									$delete=$lang['delete'];
									$next_function="delete";
								}
								$liste.='<td>'.$f['LOC_ID'].'</td>'.
										'<td style="text-align:center;">'.$f['LOC_NAME'].'</td>
			<td>
					<form action="#" method="post">
						<input type="hidden" name="next_function" value="'.$next_function.'">
						<input type="submit" title="'.$delete.'" value="'.$delete.'">
						<input type="hidden" name="loc_id" value="'.$f['LOC_ID'].'">
					</form>
			</td>
			<td>
					<form action="locations_change.php" method="post">
						<input type="hidden" name="next_function" value="change">
						<input type="submit" title="'.$lang['change'].'" value="'.$lang['change'].'">
						<input type="hidden" name="loc_id" value="'.$f['LOC_ID'].'">
					</form>
			</td>';
								$liste.="</tr>";
							}
							$liste.="</table>";

						}
						$tpl->assign('locationlist', $liste);
						$tpl->assign("OK", $OK);
						$tpl->assign("error", $error);
						$tpl->display();
?>
