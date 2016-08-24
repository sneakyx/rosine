<?php
	/**************************************************************************\
	* Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
	* http://www.rothaarsystems.de                                             *
	* Author: info@rothaarsystems.de                                           *
	* --------------------------------------------                             *
	*  This program is free software; you can redistribute it and/or modify it *
	*  under the terms of the GNU General Public License as published by the   *
	*  Free Software Foundation; version 2 of the License.                     *
	*  Date of this file: 2016-08-24                                           *
	\**************************************************************************/

$phpgw_baseline = array(

		'rosine_articles' => array(
				'fd' => array(
						'ART_NUMBER' => array('type' => 'varchar','precision' => '40','nullable' => False),
						'ART_NAME' => array('type' => 'varchar','precision' => '255','nullable' => False),
						'ART_UNIT' => array('type' => 'varchar','precision' => '20'),
						'ART_PRICE' => array('type' => 'decimal','precision' => '8','scale' => '2'),
						'ART_TAX' => array('type' => 'int','precision' => '1','default' => '1'),
						'ART_STOCKNR' => array('type' => 'int','precision' => '2','default' => '1','nullable' => False),
						'ART_INSTOCK' => array('type' => 'int','precision' => '4'),
						'ART_NOTE' => array('type' => 'text'),
						'GENERATED' => array('type' => 'varchar','precision' => '100'),
						'CHANGED' => array('type' => 'varchar','precision' => '100')
				),
				'pk' => array('ART_NUMBER'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		),
		'rosine_config' => array(
				'fd' => array(
						'config' => array('type' => 'varchar','precision' => '60','nullable' => False),
						'user_id' => array('type' => 'int','precision' => '4','nullable' => False),
						'value' => array('type' => 'varchar','precision' => '255','nullable' => False)
				),
				'pk' => array('config','user_id'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		),
		'rosine_deliveries' => array(
				'fd' => array(
						'DELIVERY_ID' => array('type' => 'auto','nullable' => False),
						'DELIVERY_DATE' => array('type' => 'date'),
						'DELIVERY_CUSTOMER' => array('type' => 'int','precision' => '4'),
						'DELIVERY_CUSTOMER_PRIVATE' => array('type' => 'int','precision' => '1','default' => '1','nullable' => False),
						'DELIVERY_AMMOUNT' => array('type' => 'decimal','precision' => '8','scale' => '2'),
						'DELIVERY_AMMOUNT_BRUTTO' => array('type' => 'decimal','precision' => '8','scale' => '2'),
						'DELIVERY_NOTE' => array('type' => 'text'),
						'DELIVERY_STATUS' => array('type' => 'varchar','precision' => '10','nullable' => False),
						'DELIVERY_PRINTED' => array('type' => 'int','precision' => '1','default' => '0','nullable' => False),
						'GENERATED' => array('type' => 'varchar','precision' => '100'),
						'CHANGED' => array('type' => 'varchar','precision' => '100')
				),
				'pk' => array('DELIVERY_ID'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		),
		'rosine_deliveries_positions' => array(
				'fd' => array(
						'DELIVERY_ID' => array('type' => 'int','precision' => '4','nullable' => False),
						'POSI_ID' => array('type' => 'int','precision' => '4','nullable' => False),
						'ART_NUMBER' => array('type' => 'varchar','precision' => '40','nullable' => False),
						'POSI_AMMOUNT' => array('type' => 'decimal','precision' => '9','scale' => '3'),
						'POSI_UNIT' => array('type' => 'varchar','precision' => '20'),
						'POSI_PRICE' => array('type' => 'decimal','precision' => '8','scale' => '2'),
						'POSI_LOCATION' => array('type' => 'int','precision' => '2'),
						'POSI_SERIAL' => array('type' => 'varchar','precision' => '40'),
						'POSI_TEXT' => array('type' => 'varchar','precision' => '1255'),
						'POSI_TAX' => array('type' => 'int','precision' => '1','nullable' => False),
						'DONE' => array('type' => 'int','precision' => '1','default' => '0')
				),
				'pk' => array('DELIVERY_ID','POSI_ID'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		),
		'rosine_invoices' => array(
				'fd' => array(
						'INVOICE_ID' => array('type' => 'auto','nullable' => False),
						'INVOICE_DATE' => array('type' => 'date'),
						'INVOICE_CUSTOMER' => array('type' => 'int','precision' => '4'),
						'INVOICE_CUSTOMER_PRIVATE' => array('type' => 'int','precision' => '1','default' => '1','nullable' => False),
						'INVOICE_AMMOUNT' => array('type' => 'decimal','precision' => '8','scale' => '2'),
						'INVOICE_AMMOUNT_BRUTTO' => array('type' => 'decimal','precision' => '8','scale' => '2'),
						'INVOICE_NOTE' => array('type' => 'text'),
						'INVOICE_STATUS' => array('type' => 'varchar','precision' => '10','nullable' => False),
						'INVOICE_PRINTED' => array('type' => 'int','precision' => '1','default' => '0'),
						'GENERATED' => array('type' => 'varchar','precision' => '100'),
						'CHANGED' => array('type' => 'varchar','precision' => '100')
				),
				'pk' => array('INVOICE_ID'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		),
		'rosine_invoices_positions' => array(
				'fd' => array(
						'INVOICE_ID' => array('type' => 'int','precision' => '4','nullable' => False),
						'POSI_ID' => array('type' => 'int','precision' => '4','nullable' => False),
						'ART_NUMBER' => array('type' => 'varchar','precision' => '40','nullable' => False),
						'POSI_AMMOUNT' => array('type' => 'decimal','precision' => '9','scale' => '3'),
						'POSI_UNIT' => array('type' => 'varchar','precision' => '20'),
						'POSI_PRICE' => array('type' => 'decimal','precision' => '8','scale' => '2'),
						'POSI_LOCATION' => array('type' => 'int','precision' => '2'),
						'POSI_SERIAL' => array('type' => 'varchar','precision' => '40'),
						'POSI_TEXT' => array('type' => 'varchar','precision' => '1255'),
						'POSI_TAX' => array('type' => 'int','precision' => '1','nullable' => False),
						'DONE' => array('type' => 'int','precision' => '1','default' => '0')
				),
				'pk' => array('INVOICE_ID','POSI_ID'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		),
		'rosine_locations' => array(
				'fd' => array(
						'LOC_ID' => array('type' => 'int','precision' => '2','nullable' => False),
						'LOC_NAME' => array('type' => 'varchar','precision' => '255','nullable' => False),
						'LOC_NOTE' => array('type' => 'text'),
						'GENERATED' => array('type' => 'varchar','precision' => '100'),
						'CHANGED' => array('type' => 'varchar','precision' => '100')
				),
				'pk' => array('LOC_ID'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		),
		'rosine_notes' => array(
				'fd' => array(
						'NOTE_ID' => array('type' => 'auto','nullable' => False),
						'LANGUAGE' => array('type' => 'varchar','precision' => '60','nullable' => False),
						'NOTE_TEXT' => array('type' => 'text')
				),
				'pk' => array('NOTE_ID','LANGUAGE'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		),
		'rosine_offers' => array(
				'fd' => array(
						'OFFER_ID' => array('type' => 'auto','nullable' => False),
						'OFFER_DATE' => array('type' => 'date'),
						'OFFER_CUSTOMER' => array('type' => 'int','precision' => '4'),
						'OFFER_CUSTOMER_PRIVATE' => array('type' => 'int','precision' => '1','default' => '1','nullable' => False),
						'OFFER_AMMOUNT' => array('type' => 'decimal','precision' => '8','scale' => '2'),
						'OFFER_AMMOUNT_BRUTTO' => array('type' => 'decimal','precision' => '8','scale' => '2'),
						'OFFER_NOTE' => array('type' => 'text'),
						'OFFER_STATUS' => array('type' => 'varchar','precision' => '10','nullable' => False),
						'OFFER_PRINTED' => array('type' => 'int','precision' => '1','default' => '0'),
						'GENERATED' => array('type' => 'varchar','precision' => '100'),
						'CHANGED' => array('type' => 'varchar','precision' => '100')
				),
				'pk' => array('OFFER_ID'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		),
		'rosine_offers_positions' => array(
				'fd' => array(
						'OFFER_ID' => array('type' => 'int','precision' => '4','nullable' => False),
						'POSI_ID' => array('type' => 'int','precision' => '4','nullable' => False),
						'ART_NUMBER' => array('type' => 'varchar','precision' => '40','nullable' => False),
						'POSI_AMMOUNT' => array('type' => 'decimal','precision' => '9','scale' => '3'),
						'POSI_UNIT' => array('type' => 'varchar','precision' => '20'),
						'POSI_PRICE' => array('type' => 'decimal','precision' => '8','scale' => '2'),
						'POSI_LOCATION' => array('type' => 'int','precision' => '2'),
						'POSI_SERIAL' => array('type' => 'varchar','precision' => '40'),
						'POSI_TEXT' => array('type' => 'varchar','precision' => '1255'),
						'POSI_TAX' => array('type' => 'int','precision' => '1','nullable' => False),
						'DONE' => array('type' => 'int','precision' => '1','default' => '0')
				),
				'pk' => array('OFFER_ID','POSI_ID'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		),
		'rosine_orders' => array(
				'fd' => array(
						'ORDER_ID' => array('type' => 'auto','nullable' => False),
						'ORDER_DATE' => array('type' => 'date'),
						'ORDER_CUSTOMER' => array('type' => 'int','precision' => '4'),
						'ORDER_CUSTOMER_PRIVATE' => array('type' => 'int','precision' => '1','default' => '1','nullable' => False),
						'ORDER_AMMOUNT' => array('type' => 'decimal','precision' => '8','scale' => '2'),
						'ORDER_AMMOUNT_BRUTTO' => array('type' => 'decimal','precision' => '8','scale' => '2'),
						'ORDER_NOTE' => array('type' => 'text'),
						'ORDER_STATUS' => array('type' => 'varchar','precision' => '10','nullable' => False),
						'ORDER_PRINTED' => array('type' => 'int','precision' => '1','default' => '0'),
						'GENERATED' => array('type' => 'varchar','precision' => '100'),
						'CHANGED' => array('type' => 'varchar','precision' => '100')
				),
				'pk' => array('ORDER_ID'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		),
		'rosine_orders_positions' => array(
				'fd' => array(
						'ORDER_ID' => array('type' => 'int','precision' => '4','nullable' => False),
						'POSI_ID' => array('type' => 'int','precision' => '4','nullable' => False),
						'ART_NUMBER' => array('type' => 'varchar','precision' => '40','nullable' => False),
						'POSI_AMMOUNT' => array('type' => 'decimal','precision' => '9','scale' => '3'),
						'POSI_UNIT' => array('type' => 'varchar','precision' => '20'),
						'POSI_PRICE' => array('type' => 'decimal','precision' => '8','scale' => '2'),
						'POSI_LOCATION' => array('type' => 'int','precision' => '2'),
						'POSI_SERIAL' => array('type' => 'varchar','precision' => '40'),
						'POSI_TEXT' => array('type' => 'varchar','precision' => '1255'),
						'POSI_TAX' => array('type' => 'int','precision' => '1','nullable' => False),
						'DONE' => array('type' => 'int','precision' => '1','default' => '0')
				),
				'pk' => array('ORDER_ID','POSI_ID'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		),
		'rosine_payments' => array(
				'fd' => array(
						'PAYMENT_ID' => array('type' => 'auto','nullable' => False),
						'INVOICE_ID' => array('type' => 'int','precision' => '4'),
						'PAYMENT_DATE' => array('type' => 'date'),
						'METH_ID' => array('type' => 'int','precision' => '4'),
						'PAYMENT_AMMOUNT' => array('type' => 'decimal','precision' => '8','scale' => '2'),
						'PAYMENT_NOTE' => array('type' => 'varchar','precision' => '512')
				),
				'pk' => array('PAYMENT_ID'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		),
		'rosine_payments_methods' => array(
				'fd' => array(
						'METH_ID' => array('type' => 'int','precision' => '2','nullable' => False),
						'METH_NAME' => array('type' => 'varchar','precision' => '255','nullable' => False),
						'METH_NOTE' => array('type' => 'text'),
						'GENERATED' => array('type' => 'varchar','precision' => '100'),
						'CHANGED' => array('type' => 'varchar','precision' => '100')
				),
				'pk' => array('METH_ID'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		),
		'rosine_taxes' => array(
				'fd' => array(
						'TAX_ID' => array('type' => 'int','precision' => '1','nullable' => False),
						'TAX_NAME' => array('type' => 'varchar','precision' => '20'),
						'TAX_PERCENTAGE' => array('type' => 'decimal','precision' => '4','scale' => '2','nullable' => False),
						'GENERATED' => array('type' => 'varchar','precision' => '100','nullable' => False),
						'CHANGED' => array('type' => 'varchar','precision' => '100','nullable' => False)
				),
				'pk' => array('TAX_ID'),
				'fk' => array(),
				'ix' => array(),
				'uc' => array()
		)
		
		);

?>