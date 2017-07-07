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

$tpl->load("paperworklist.html");

$lang = $tpl->loadLanguage($lang);
// should there be one invoice really deleted?
if ($_POST['next_function']=="really_delete"){
	$query=rosine_correct_query($_POST['paperwork'], $rosine_db_query['delete_paperwork'],$_POST['paperwork']);
	$result=rosine_database_query(str_replace("%ID%", $_POST['number'],$query),110);
	if ($result!=false) {
		$OK.=str_replace("%paperwork%", lang($_POST['paperwork']), lang('paperwork_deleted'))." ".$_POST['number']."<br>";
	}// no error while delete

	$query=rosine_correct_query($_POST['paperwork'], $rosine_db_query['delete_paperwork_positions'],$_POST['paperwork']);
	$result=rosine_database_query(str_replace("%ID%", $_POST['number'],$query),111);
	if ($result!=false) {
		$OK.=str_replace("%paperwork%", lang($_POST['paperwork']), lang('paperwork_positions_deleted'))." ".$_POST['number']."<br>";
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
			<th>'.lang($_POST['paperwork'].'_number').'</th>
			<th>'.lang('date').'</th>		
			<th>'.lang('customer').'</th>
			<th>'.lang('money').'</th>
			<th>'.lang('status').'</th>		
			<th colspan="5">'.lang('functions').'</th>		
		</tr>';

	while($f = $result->fetch_array()) {
		$liste.="<tr>";
		if ($max_rows!=$f[strtoupper($_POST['paperwork']).'_ID']&& $_POST['paperwork']=='invoice'){
			$delete="";
			$next_function="";
		}// invoice and not last number, so cannot be deleted
		else {
			if ($_POST['next_function']=="delete" & $_POST['number']==$f[strtoupper($_POST['paperwork']).'_ID']){
				//Sicherheitsabfrage!
				$next_function="really_delete";
				$delete=lang('really_delete');
			}// endif safety question
			else {
				//Normale Funktion
				$delete=lang('delete');
				$next_function="delete";
			}// no safety question
		}// not invoice or invoice and last number, so can be deleted
		if ($f[strtoupper($_POST['paperwork'].'_customer_private')]=="1"){
			$f['n_fn']=substr($f['n_fn'],0,35)." ".lang('private');
		}// paperwork for private address
		else{ 
			$f['n_fn']=substr($f['org_name'],0,35)." ".lang('company');
		}//paperwork for company address
		
		$liste.="<td>".$f[strtoupper($_POST['paperwork']).'_ID']."</td>".
				"<td>".$f[strtoupper($_POST['paperwork']).'_DATE']."</td>".
				"<td>".$f['n_fn']."</td>".
				"<td>".$f[strtoupper($_POST['paperwork']).'_AMMOUNT'].$config['currency']."</td>".
				"<td>";
		switch (substr($f[strtoupper($_POST['paperwork'].'_STATUS')],0,2)){
			case "in":
				$liste.='<img src="../pixelegg/images/billed.png"
						alt="'.lang("billed").'"title="'.lang("billed").'" width="15%"> '.lang('billed');
			break;
			
			case "em":
				$liste.='<img src="../pixelegg/images/leaf.svg"
						alt="'.lang("empty").'"title="'.lang("empty").'" width="15%"> '.lang('empty');
			break;
			
			case "ch":
				$liste.='<img src="../pixelegg/images/infolog.png"
						alt="'.lang("changed").'"title="'.lang("changed").'" width="15%"> '.lang('changed');
			break;
			
			case "de":
				$liste.='<img src="../pixelegg/images/milestone.svg"
						alt="'.lang("delivered").'"title="'.lang("delivered").'" width="15%"> '.lang('delivered');
			break;
				
			default:
				$liste.=lang($f[strtoupper($_POST['paperwork'].'_STATUS')]);
					
		}
		
		$sub_nr = intval(substr($_POST['paperwork'].'_STATUS',2));
		if ($sub_nr > 0){
			$liste.=$sub_nr;
		}
		$liste.="</td>";
		
		if ($f[strtoupper($_POST['paperwork']).'_STATUS']=="changed" | $f[strtoupper($_POST['paperwork']).'_STATUS']=="empty"){
					$liste.='<td>
					<a href="?paperwork='.$_POST['paperwork'].'&number=';
		$liste.=$f[strtoupper($_POST['paperwork']).'_ID'].'&next_function='.$next_function.'"> ';
		
		if ($next_function=='really_delete'){
			$liste.='<img src="../pixelegg/images/error.png"
						alt="'.lang($next_function).'?" title="'.lang($next_function).'?" width="70%">';
		}// safety question
		elseif ($next_function=='delete'){
			$liste.='<img src="../pixelegg/images/trash.png"
						alt="'.lang($next_function).'?" title="'.lang($next_function).'?" width="75%">';
		}//before safety question
		else {
			
		}// cannot be deleted
/*					if ($delete!=""){
						$liste.='<input type="submit" title="'.$delete.'" value="'.$delete.'">';
					}// not invoice or last type, so can be deleted
*/			$liste.='</a></td>
					<td><a href="paperwork_change.php?paperwork='.$_POST['paperwork'].'&paperwork_id=';
		$liste.=$f[strtoupper($_POST['paperwork']).'_ID'].'&next_function=overview&contact_id=::'.$f[strtoupper($_POST['paperwork']).'_CUSTOMER'].'">
						<img src="../pixelegg/images/edit.png" 
						alt="'.lang('change').'" title="'.lang('change').'" width="75%"></a></td>
			';
		}// if paperwork should be able to be deleted or changed
		else {
			$liste.='<td></td><td></td>';
		}// paperwork can be changed or deleted
		$liste.='<td><a href="paperwork_print.php?paperwork='.$_POST['paperwork'].'&print=0&paperwork_id=';
		$liste.=$f[strtoupper($_POST['paperwork']).'_ID'].'" target="_blank">
						<img src="../pixelegg/images/prieview.png" 
						alt="'.lang('preview').'" title="'.lang('preview').'" width="75%"></a></td>';
		$liste.='<td><a href="paperwork_print.php?paperwork='.$_POST['paperwork'].'&paperwork_id=';
		if ($f[strtoupper($_POST['paperwork']).'_PRINTED']=="1") {
				$liste.=$f[strtoupper($_POST['paperwork']).'_ID'].'" target="_blank">
						<img src="../pixelegg/images/print.png" style="opacity: 0.5;filter: alpha(opacity=50);" 
						alt="'.lang('print_again').'" title="'.lang('print_again').'" width="75%"></a></td>';
		} // had been printed
		else {
			$liste.=$f[strtoupper($_POST['paperwork']).'_ID'].'" target="_blank">
					<img src="../pixelegg/images/print.png" alt="'.lang('print').
			'" title="'.lang('print').'" width="75%"></a></td>';
		}// had not been printed
		if ($config['email_'.$_POST['paperwork']]!="none" && $config['email_'.$_POST['paperwork']]!=""){
			$liste.='<td><a href="paperwork_mail.php?paperwork='.$_POST['paperwork'].'&paperwork_id=';
			$liste.=$f[strtoupper($_POST['paperwork']).'_ID'].'&file_type='.$config['email_'.$_POST['paperwork']].'">
							<img src="../pixelegg/images/email.png" 
							alt="'.lang('send_email').'" title="'.lang('send_email').'" width="75%"></a></td>';
		}// the can is an template to use	
		$liste.="</tr>";
	}//endwhile
	$liste.="</table>";
	$result->close();
}//endwhile
$tpl->assign('paperworklist', $liste);
$tpl->assign("paperwork", lang($_POST['paperwork']));
$tpl->assign("paperwork_type", $_POST['paperwork']);
$tpl->assign("OK", $OK);
$tpl->assign("error", $error);
$tpl->display();

?>