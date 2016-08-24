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


	$setup_info['rosine']['tables']    = array();
	$setup_info['rosine']['depends'][] = array(
			'appname' => 'api',
			'versions' => Array(
					'14.1',
					'16.1'
					)
	);

?>
