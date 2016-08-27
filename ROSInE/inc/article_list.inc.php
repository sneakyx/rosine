<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-08-26  										   *
 \**************************************************************************/

$liste.='<table id="rosine_tabelle">';
$liste.='<tr>
				<th>'.$lang['article_number'].'</th>
				<th>'.$lang['article_name'].'</th>
				<th>'.$lang['price'].'</th>
				<th>'.$lang['stock'].'</th>
				<th>'.$lang['delete'].'</th>
				<th>'.$lang['change'].'</th>
			</tr>';

while($f = $result->fetch_array()) {
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
			<td>".$f['ART_PRICE']." ".$config['currency']."</td>
			<td>".$f['INSTOCK'].'</td>
			<td>
					<form action="#" method="post">
						<input type="hidden" name="type" value="article">
						<input type="hidden" name="next_function" value="'.$next_function.'">
						<input type="submit" title="'.$delete.'" value="'.$delete.'">
						<input type="hidden" name="number" value="'.$f['ART_NUMBER'].'">
					</form>
			</td>
			<td>
					<form action="articles_change.php" method="post">
						<input type="hidden" name="type" value="article">
						<input type="hidden" name="next_function" value="change">
						<input type="submit" title="'.$lang['change'].'" value="'.$lang['change'].'">
						<input type="hidden" name="number" value="'.$f['ART_NUMBER'].'">
					</form>
			</td>';
	$liste.="</tr>";
}
?>