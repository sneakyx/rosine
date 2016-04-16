<?php
	/**************************************************************************\
	* Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
	* http://www.rothaarsystems.de                                             *
	* Author: info@rothaarsystems.de                                           *
	* --------------------------------------------                             *
	*  This program is free software; you can redistribute it and/or modify it *
	*  under the terms of the GNU General Public License as published by the   *
	*  Free Software Foundation; version 2 of the License.                     *
	*  date of this file: 2016-04-16  										   *
	\**************************************************************************/

$GLOBALS['phpgw_info']['flags']['currentapp'] = 'rosine';
include('../header.inc.php');
include ('inc/settings.php');
include ('inc/template.class.php');

$tpl = new Rosine_Template();
$tpl->load("orderlist.html");
$lang[] = $language;
$lang = $tpl->loadLanguage($lang);
// should there be one order really deleted?
if ($_POST['next_function']=="really_delete"){
	$query=rosine_correct_query("order", $rosine_db_query['delete_paperwork'],"order");
	$result=mysql_query(str_replace("%ID%", $_POST['number'],$query));
	if (mysql_errno($rosine_db)!=0) {
		// Error in mysql detected
		$error.="10: ".mysql_error($rosine_db);
	}// error while delete
	else {
		$OK.=str_replace("%paperwork%", $lang['order'], $lang['paperwork_deleted'])." ".$lang['']." ".$_POST['number']."<br>";
	}// no error while delete

	$query=rosine_correct_query("order", $rosine_db_query['delete_paperwork_positions'],"order");
	$result=mysql_query(str_replace("%ID%", $_POST['number'],$query));
	if (mysql_errno($rosine_db)!=0) {
		// Error in mysql detected
		$error.="11: ".mysql_error($rosine_db);
	}// error while delete
	else {
		$OK.=str_replace("%paperwork%", $lang['order'], $lang['paperwork_positions_deleted'])." ".$lang['']." ".$_POST['number']."<br>";
	}// no error while delete
	
}// realley delete

// get ammount of orders in database
$result=mysql_query(str_replace("%paperwork%", "orders", $rosine_db_query['get_ammount_of_paperworks'])." 1");
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
		$result=mysql_query(rosine_correct_query("order", $rosine_db_query['get_paperworks'],"orders")."1 ORDER BY ORDER_ID LIMIT $from,$items_per_page");

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
				<th>'.$lang['order_number'].'</th>
				<th>'.$lang['date'].'</th>		
				<th>'.$lang['customer'].'</th>
				<th>'.$lang['ammount'].'</th>
				<th>'.$lang['status'].'</th>		
				<th>'.$lang['delete'].'</th>
				<th>'.$lang['change'].'</th>
				<th>'.$lang['print'].'</th>		
			</tr>';

							while($f = @mysql_fetch_array($result)) {
								$liste.="<tr>";

								if ($_POST['next_function']=="delete" & $_POST['number']==$f['ORDER_ID']){
									//Sicherheitsabfrage!
									$next_function="really_delete";
									$delete=$lang['really_delete'];
								}// endif safety question
								else {
									//Normale Funktion
									$delete=$lang['delete'];
									$next_function="delete";
								}// no safety question
								if ($f['order_customer_private']=="1")
									$f['n_fn'].=" ".$lang['private'];
								else 
									$f['n_fn'].=" ".$lang['company'];
								$liste.="<td>".$f['ORDER_ID']."</td>".
										"<td>".$f['ORDER_DATE']."</td>".
										"<td>".$f['n_fn']."</td>".
										"<td>".$f['ORDER_AMMOUNT']."</td>".
										"<td>".$f['ORDER_STATUS']."</td>".
										'<td>
					<form action="#" method="post">
						<input type="hidden" name="next_function" value="'.$next_function.'">
						<input type="submit" title="'.$delete.'" value="'.$delete.'">
						<input type="hidden" name="number" value="'.$f['ORDER_ID'].'">
					</form>
			</td>
			<td>
					<form action="orders_change.php" method="post">
						<input type="hidden" name="next_function" value="change">
						<input type="submit" title="'.$lang['change'].'" value="'.$lang['change'].'">
						<input type="hidden" name="order_id" value="'.$f['ORDER_ID'].'">
						<input type="hidden" name="contact_id" value="::'.$f['ORDER_CUSTOMER'].'">		
					</form>
			</td>'; //ob das mit den zwei Doppelpunkten stimmt?
								$liste.='<td><a href="print_paperwork.php?paperwork=order&paperwork_id='.
										$f['ORDER_ID'].'" target="_blank">'.$lang['print'].'</a></td>';
								$liste.="</tr>";
							}
							$liste.="</table>";

						}
						$tpl->assign('orderlist', $liste);
						$tpl->assign("OK", $OK);
						$tpl->assign("error", $error);
						$tpl->display();

?>