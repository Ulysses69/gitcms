<?php

if (!defined('PRICELIST_VERSION')) { define('PRICELIST_VERSION', '0.1.4'); }
Plugin::setInfos(array(
	'id'		  => 'pricelist',
	'title'	   => 'Pricelist',
	'description' => 'Pricelist and Page Type',
	'version'	 => PRICELIST_VERSION
));

Behavior::add('Pricelist', '');

/* Check if this plugin is enabled */
if(Plugin::isEnabled('pricelist')){
	if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
		AutoLoader::addFolder(dirname(__FILE__) . '/models');
		AuthUser::load();
		/* UNDER DEVELOPMENT - HIDE FROM USERS */
		if(Plugin::isEnabled('pricelist') == true && AuthUser::getId() == 2){
			Plugin::addController('pricelist', 'Prices', 'administrator', true);
		} else {
			Plugin::addController('pricelist', 'Prices', 'administrator', false);
		}
	}
}

//Plugin::addJavascript('pricelist', 'js/jquery.scrollTo-min.js');

