<?php

Plugin::setInfos(array(
	'id'					=> 'tinymce_styles',
	'title'					=> 'TinyMCE Styles',
	'description'			=> 'TinyMCE Plugin for Custom Styles.',
	'version'				=> '1.0.0',
	'license'				=> 'GPLv3',
	'require_wolf_version'	=> '0.5.5'
));

if(!AuthUser::hasPermission('client') && Plugin::isEnabled('tinymce') == true){
	if(Plugin::isEnabled('clientdetails') == true){
		Plugin::addController('tinymce_styles', 'TinyMCE Styles', 'administrator', false);
	} else {
		Plugin::addController('tinymce_styles', 'TinyMCE Styles', 'administrator', true);
	}
}