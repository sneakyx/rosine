<?php
/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2016-04-09  										    *
 \**************************************************************************/
$GLOBALS['phpgw_info']['flags']['currentapp'] = 'rosine';
include('../header.inc.php');
include ('inc/settings.php');
include ('inc/template.class.php');

//2. Dimension von $GEt und $post durchsuchen!!!!
$OK="";
$error="";
$tpl = new Rosine_Template();
$tpl->load("select_invoice_payment.html");
$lang[] = $language;
$lang = $tpl->loadLanguage($lang);



switch ($_POST['next_function']) {
	case "insert_payment":
			//insert an empty payment
			
			// choose either address one or two if to use customers address one or two
			/* here we get the highest number of payments from the database
			 * this ist just for the use in the next functions
			 */
			//hier einfuegen 
			$_POST['payment_id']=rosine_highest_number("payment")+1;
			$result=mysql_query($rosine_db_query['insert_payment'].
						'('.
					$_POST['payment_id'].','. 
					$_POST['invoice_id'].',"'.
					$_POST['payment_date'].'",'.
					$_POST['meth_id'].','.
					$_POST['payment_ammount'].',"'.
					$_POST['note'].'")');
			if ($result!=false)
				// das geht noch nicht- warum?
				$OK.=$lang['payment_inserted'].' '.$lang['invoice'].' '.$_POST['invoice_id'];
			else 
				$error.="6: ".mysql_error();
				
			$result=mysql_query($rosine_db_query['get_open_money'].$_POST['invoice_id']);

			if ($result!=false){
				// 
				$row=mysql_fetch_row($result);
				if ($row[0] >= $row[1]){
					$OK.="<br>".$lang['invoice_payed'];
					rosine_set_status_paperwork("invoice", $_POST['invoice_id'], "paid");
				}// invoice is payed
				
			}// no error
			else
				$error.="7: ".mysql_error();
				
					/*
					 * although case insert_payment ends here, after inserting empty payment,
					 * this has to be filled with articles, so this break isn't used!
					 *
					 */
							
//	break; //insert_payment 
	
	default:
		// Step 0 - show address to choose	

		$result=mysql_query($rosine_db_query['get_unpaid_invoices']);

		if (mysql_errno($rosine_db)!=0) {
			// Error in mysql detected
			$error.="3: ".mysql_error($rosine_db);

		} // Error in mysql detected
		else {
					//no error in mysql get customers
			$input_fields.='<select name="invoice_id" size="10">';
						
			while($f = @mysql_fetch_array($result)) {
				$input_fields.='<option value="'.$f['invoice_id'].'">'.$lang['invoice'].' '.$f['invoice_id'].' - '.
					$f['name'].' ('.$f['invoice_customer'].') '.$lang['unpayed_ammount'].number_format(($f['invoice_ammount']-$f['already_paid']),2,".","").' '.$lang['from'].' '.$f['invoice_ammount'].$currency.'</option>
							';
			}//endwhile
			$input_fields.='</select>';
			$result=mysql_query($rosine_db_query['get_payment_methods']);
			if (mysql_errno($rosine_db)!=0) {
				// Error in mysql detected
				$error.="4: ".mysql_error($rosine_db);
			
			} // Error in mysql detected
			else {
				$input_fields.='<select name="meth_id" size="10">';
				while($f = @mysql_fetch_array($result)) {
					if ($f['METH_ID']==$favorite_payment_selected)
							$input_fields.='<option selected value="'.$f['METH_ID'].'">'.$f['METH_NAME'].'('.
								$f['METH_ID'].') </option>
								';
					else 
						$input_fields.='<option value="'.$f['METH_ID'].'">'.$f['METH_NAME'].'('.
								$f['METH_ID'].') </option>
								';
						
				}//endwhile
				$input_fields.='<select>';
			}// endelse - no error in mysql query 4
	
		} //endelse no error in mysql search for customers				
}//end switch next_function

//show page
$tpl->assign("OK", $OK);
$tpl->assign("error", $error);
$tpl->assign("input_fields", $input_fields);
$tpl->assign("paperwork", $lang['payment']);
$tpl->assign("currency", $currency);
$tpl->assign("date",date("Y-m-d"));

// $tpl->assign("this_number",rosine_get_real_number("payment",$_POST['payment_id']));
$tpl->assign("paperwork_file", "payments");
$tpl->display();

?>