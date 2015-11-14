<?php
	/**************************************************************************\
	* Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
	* http://www.rothaarsystems.de                                             *
	* Author: info@rothaarsystems.de                                           *
	* --------------------------------------------                             *
	*  This program is free software; you can redistribute it and/or modify it *
	*  under the terms of the GNU General Public License as published by the   *
	*  Free Software Foundation; version 2 of the License.                     *
	\**************************************************************************/


	$setup_info['invoice']['name']	= 'invoice';
	$setup_info['invoice']['title']	= 'ROSInE';
	$setup_info['invoice']['version']	= '0.0.1';
	$setup_info['invoice']['app_order']	= 33;

	$setup_info['invoice']['author']	= array(
		'name'	=> 'André Scholz',
		'email'	=> 'info@rothaarsystems.de',
	);

	$setup_info['invoice']['license']	= 'GPL';
	$setup_info['invoice']['description']= 'Help for telephone calls';

	$setup_info['invoice']['maintainer'] = array(
		'name'	=> 'André Scholz',
		'email'	=> 'info@rothaarsystems.de',
	);


	$setup_info['invoice']['tables']    = array();
	$setup_info['invoice']['enable']    = 1;


?>
