<?php

Plugin::setInfos(array(
	'id'					=> 'password_protection',
	'title'					=> 'Password Protection',
	'description'			=> 'Password Protect access to website.',
	'version'				=> '1.0.0',
	'license'				=> 'GPLv3',
	'require_wolf_version'	=> '0.5.5'
));

if(!AuthUser::hasPermission('client')){
	if(Plugin::isEnabled('dashboard') == true){
		Plugin::addController('password_protection', 'Password Protection', 'administrator', false);
	} else {
		Plugin::addController('password_protection', 'Password Protection', 'administrator', true);
	}
}