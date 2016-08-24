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
	$rosine_db_prefix="rosine_";

	$setup_info['rosine']['name']	= 'rosine';
	$setup_info['rosine']['title']	= 'ROSInE';
	$setup_info['rosine']['version']	= '2016-08-23';
	$setup_info['rosine']['app_order']	= 33;
	$setup_info['rosine']['enable']    = 1;
	
	$setup_info['rosine']['author']	= array(
		'name'	=> 'André Scholz',
		'email'	=> 'info@rothaarsystems.de',
	);

	$setup_info['rosine']['license']	= 'GPL';
	$setup_info['rosine']['description']= 'Easy to handle App for writing invoices, delivery notes, etc';

	$setup_info['rosine']['maintainer'] = array(
		'name'	=> 'André Scholz',
		'email'	=> 'info@rothaarsystems.de',
	);
	$setup_info['rosine']['tables']= array(
			$rosine_db_prefix.'articles',
			$rosine_db_prefix.'config',
			$rosine_db_prefix.'deliveries',
 		$rosine_db_prefix.'deliveries_positions',
			$rosine_db_prefix.'invoices',
			$rosine_db_prefix.'invoices_positions',
			$rosine_db_prefix.'locations',
			$rosine_db_prefix.'notes',
			$rosine_db_prefix.'offers',
			$rosine_db_prefix.'offers_positions',
			$rosine_db_prefix.'orders',
			$rosine_db_prefix.'orders_positions',
			$rosine_db_prefix.'payments',
			$rosine_db_prefix.'payments_methods',
			$rosine_db_prefix.'taxes'
	);
#	$setup_info['rosine']['tables'][] = $rosine_db_prefix.'articles';
#	$setup_info['rosine']['tables'][] = $rosine_db_prefix.'config';
#	$setup_info['rosine']['tables'][] = 'egw_cal_user';
#	$setup_info['rosine']['tables'][] = 'egw_cal_extra';
#	$setup_info['rosine']['tables'][] = 'egw_cal_dates';
#	$setup_info['rosine']['tables'][] = 'egw_cal_timezones';
	
	$setup_info['rosine']['depends'][] = array(
			'appname' => 'api',
			'versions' => Array(
					'14.1',
					'16.1'
					)
	);

?>
