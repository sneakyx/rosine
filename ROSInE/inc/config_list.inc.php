<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2017-07-05  										    *
 \**************************************************************************/

$liste.='<table id="rosine_tabelle">';
$liste.='<tr>
		<th>'.lang('config').'</th>
		<th>'.lang('user').'</th>
		<th>'.lang('value').'</th>
		<th>'.lang('delete').'</th>
		<th>'.lang('change').'</th>
	</tr>';

while($f = $result->fetch_array()) {
	$liste.="<tr>";
	if ($_POST['next_function']=="delete" & $_POST['config']==$f['config'] & $_POST['user_id']==$f['user_id']){
		//Sicherheitsabfrage!
		$next_function="really_delete";
		$delete=lang('really_delete');
	}//endif
	else {
		//Normale Funktion
		$delete=lang('delete');
		$next_function="delete";
	}// endelse
	$liste.='<td>'.$f['config'].'</td>';
	if ($f['user_id'] != "0") {
		if ($f['account_name']="" || $f['account_name']="NULL"){
			$f['account_name']=lang('no_user');
		}// no valid user name available
		$liste.='<td style="text-align:center;">'.$f['account_name'].' ('.$f['user_id'].')</td>';
	}// config line not for all users
	else {
		$liste.='<td style="text-align:center;">'.lang('standard_value').' (0)</td>';
	}// user id= 0 -> standard for all users
	$liste.='<td>'.$f['value'].'</td>';
	
	$liste.='<td>';
	if ($f['user_id'] != "0") {
			$liste.='<form action="#" method="post">
				<input type="hidden" name="type" value="type">
				<input type="hidden" name="next_function" value="'.$next_function.'">
				<input type="submit" title="'.$delete.'" value="'.$delete.'">
						<input type="hidden" name="config" value="'.$f['config'].'">
						<input type="hidden" name="user_id" value="'.$f['user_id'].'">
			</form>';
	}// standard values should not be deleted
	$liste.='
			</td>
			<td>
			<form action="config_change.php" method="post">
				<input type="hidden" name="type" value="type">
				<input type="hidden" name="next_function" value="change">
				<input type="submit" title="'.lang('change').'" value="'.lang('change').'">
				<input type="hidden" name="config" value="'.$f['config'].'">
				<input type="hidden" name="user_id" value="'.$f['user_id'].'">
			</form>
			</td>';
	$liste.="</tr>";
}//while fetcharray
?>