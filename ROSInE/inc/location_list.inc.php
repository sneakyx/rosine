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

$liste.='<table id="rosine_tabelle">';
$liste.='<tr>
		<th>'.$lang['location_id'].'</th>
		<th>'.$lang['location_name'].'</th>
		<th>'.$lang['delete'].'</th>
		<th>'.$lang['change'].'</th>
	</tr>';

while($f = $result->fetch_array()) {
	$liste.="<tr>";
	if ($_POST['next_function']=="delete" & $_POST['loc_id']==$f['LOC_ID']){
		//Sicherheitsabfrage!
		$next_function="really_delete";
		$delete=$lang['really_delete'];
	}//endif
	else {
		//Normale Funktion
		$delete=$lang['delete'];
		$next_function="delete";
	}// endelse
	$liste.='<td>'.$f['LOC_ID'].'</td>'.
			'<td style="text-align:center;">'.$f['LOC_NAME'].'</td>
			<td>
			<form action="#" method="post">
				<input type="hidden" name="type" value="type">
				<input type="hidden" name="next_function" value="'.$next_function.'">
				<input type="submit" title="'.$delete.'" value="'.$delete.'">
				<input type="hidden" name="loc_id" value="'.$f['LOC_ID'].'">
			</form>
			</td>
			<td>
			<form action="locations_change.php" method="post">
				<input type="hidden" name="type" value="type">
				<input type="hidden" name="next_function" value="change">
				<input type="submit" title="'.$lang['change'].'" value="'.$lang['change'].'">
				<input type="hidden" name="loc_id" value="'.$f['LOC_ID'].'">
			</form>
			</td>';
	$liste.="</tr>";
}//while fetcharray
?>