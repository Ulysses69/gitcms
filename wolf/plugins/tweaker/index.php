<?php

Plugin::setInfos(array(
	'id'				=> 'tweaker',
	'title'				=> 'Tweaker',
	'description'			=> 'Allows you to tweak settings.',
	'version'			=> '0.2.0',
	'license'			=> 'GPLv3',
	'require_wolf_version'		=> '0.5.5'
));

if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
	Plugin::addController('tweaker', 'Tweaker', 'administrator', true);
}

Observer::observe('page_found', 'tweakaway');

/*
function displayTweaker(){
	$urlpublic = Plugin::getSetting('urlpublic', 'tweaker');
	$autometa = Plugin::getSetting('autometa', 'tweaker');
}
*/

function tweakaway($page) {
	$urlpublic = Plugin::getSetting('urlpublic', 'tweaker');
	if($urlpublic == '/' && URL_PUBLIC != '/'){
		ob_start();
		$page->_executeLayout();
		$page = ob_get_contents();
		ob_end_clean();
		$page = str_replace(URL_PUBLIC, $urlpublic, $page);
		echo $page;
		exit();
	}
}