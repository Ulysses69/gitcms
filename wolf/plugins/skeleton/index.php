<?php

if (!defined('SKELETON_VERSION')) {		define('SKELETON_VERSION', '0.0.1'); }
if (!defined('SKELETON_ID')) {			define('SKELETON_ID', 'skeleton'); }
if (!defined('SKELETON_TITLE')) {		define('SKELETON_TITLE', 'Skeleton'); }
if (!defined('SKELETON_DESC')) {		define('SKELETON_DESC', 'Plugin skeleton'); }
if (!defined('SKELETON_ROOT')) {		define('SKELETON_ROOT', URI_PUBLIC.'wolf/plugins/'.SKELETON_ID); }

Plugin::setInfos(array(
	'id'					=> SKELETON_ID,
	'title'					=> SKELETON_TITLE,
	'description'			=> SKELETON_DESC,
	'version'				=> SKELETON_VERSION,
	'license'				=> 'GPLv3',
	'require_wolf_version'	=> '0.5.5'
));

/* Check if this plugin is enabled */
if(Plugin::isEnabled(SKELETON_ID)){

	if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
		Plugin::addController(SKELETON_ID, SKELETON_TITLE, 'administrator', true);
	}

}