<?php

Plugin::setInfos(array(
	'id'		  			=> 'wordpress',
	'title'	   			=> __('Wordpress Page Type'),
	'description' 			=> __('Wordpress Page Type.'),
	'version'	 			=> '1.0.0',
	'license'	 			=> 'GPL',
	'require_wolf_version' 		=> '0.5.5'
));

Behavior::add('Wordpress', '');


?>