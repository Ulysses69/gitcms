<?php

Plugin::setInfos(array(
	'id'		  			=> 'video',
	'title'	   			=> __('Video Page Type'),
	'description' 			=> __('Video Page Type.'),
	'version'	 			=> '1.0.0',
	'license'	 			=> 'GPL',
	'require_wolf_version' 		=> '0.5.5'
));

Behavior::add('Video', '');

?>