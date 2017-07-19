<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2017-07-19  										    *
 \**************************************************************************/

$liste.='<table id="rosine_tabelle">';
$liste.='<tr class="article">
				<th>'.$lang['tax_id'].'</th>
				<th>'.$lang['tax_name'].'</th>
				<th>'.$lang['tax_percentage'].'</th>
				<th>'.$lang['delete'].'</th>
				<th>'.$lang['change'].'</th>
			</tr>';

while($f = $result->fetch_array()) {
	$liste.="<tr class='article'>";
	if ($_POST['next_function']=="delete" & $_POST['tax_id']==$f['TAX_ID']){
		//Sicherheitsabfrage!
		$next_function="really_delete";
		$delete=$lang['really_delete'];
	}
	else {
		//Normale Funktion
		$delete=$lang['delete'];
		$next_function="delete";
	}
	$liste.="<td>".$f['TAX_ID']."</td>".
			'<td style="text-align:center;">'.$f['TAX_NAME']."</td>
			<td>".$f['TAX_PERCENTAGE']." %</td>".'
			<td>
					<form action="#" method="post">
						<input type="hidden" name="type" value="tax">
						<input type="hidden" name="next_function" value="'.$next_function.'">
						<input type="submit" title="'.$delete.'" value="'.$delete.'">
						<input type="hidden" name="tax_id" value="'.$f['TAX_ID'].'">
					</form>
			</td>
			<td>
					<form action="taxes_change.php" method="post">
						<input type="hidden" name="type" value="tax">
						<input type="hidden" name="next_function" value="change">
						<input type="submit" title="'.$lang['change'].'" value="'.$lang['change'].'">
						<input type="hidden" name="tax_id" value="'.$f['TAX_ID'].'">
					</form>
			</td>';
	$liste.="</tr>";
}
?>