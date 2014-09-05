<?php

/* Get defined constants such as version */
include PLUGINS_ROOT . '/'.basename(dirname(__FILE__)).'/index.php';

$version = Plugin::getSetting('version', 'jscripts');

/* Set version setting */
$settings = array('version' => JSCRIPTS_VERSION);

// Check for existing settings
if(!Plugin::getSetting('embedding', 'jscripts')) $settings['embedding'] = 'auto';
if(!Plugin::getSetting('rows', 'jscripts')) $settings['rows'] = '1';
if(!Plugin::getSetting('script0', 'jscripts')) $settings['script0'] = '';
if(!Plugin::getSetting('include0', 'jscripts')) $settings['include0'] = '';
if(!Plugin::getSetting('exclude0', 'jscripts')) $settings['exclude0'] = '';
if(!Plugin::getSetting('insert0', 'jscripts')) $settings['insert0'] = '';
if(!Plugin::getSetting('marqueeparent', 'jscripts')) $settings['marqueeparent'] = 'news';
if(!Plugin::getSetting('marqueecontent', 'jscripts')) $settings['marqueecontent'] = 'title';
if(!Plugin::getSetting('marqueedisplaynum', 'jscripts')) $settings['marqueedisplaynum'] = '1';
if(!Plugin::getSetting('marqueeorder', 'jscripts')) $settings['marqueeorder'] = 'created_on';
if(!Plugin::getSetting('marqueesort', 'jscripts')) $settings['marqueesort'] = 'descend';
if(!Plugin::getSetting('marqueeduration', 'jscripts')) $settings['marqueeduration'] = '3000';
if(!Plugin::getSetting('marqueetransition', 'jscripts')) $settings['marqueetransition'] = '1000';

// Check existing plugin settings
if (!$version || $version == null) {

	// This is a clean install.

	// Store settings.
	if (Plugin::setAllSettings($settings, 'jscripts')) {
		Flash::set('success', __('JScripts - plugin settings setup.'));
	}
	else
		Flash::set('error', __('JScripts - unable to save plugin settings.'));


} else {


	// Upgrade from previous installation
	if (JSCRIPTS_VERSION > $version) {

		// Retrieve the old settings.
		$PDO = Record::getConnection();
		$tablename = TABLE_PREFIX.'plugin_settings';

		$sql_check = "SELECT COUNT(*) FROM $tablename WHERE plugin_id='jscripts'";
		$sql = "SELECT * FROM $tablename WHERE plugin_id='jscripts'";

		$result = $PDO->query($sql_check);

		if (!$result) {
			Flash::set('error', __('JScripts - unable to access plugin settings.'));
			return;
		}

		// Fetch the old installation's records.
		$result = $PDO->query($sql);

		if ($result && $row = $result->fetchObject()) {

			$result->closeCursor();
			if(defined('JSCRIPTS_INCLUDE')){ header('Location: '.URL_PUBLIC.ADMIN_DIR.'plugin/jscripts'); }
		}
	}


	// Store settings.
	if (isset($settings) && Plugin::setAllSettings($settings, 'jscripts')) {
		if (JSCRIPTS_VERSION > $version){
			Flash::set('success', __('JScripts - plugin settings updated.'));
		}
	}

}

?>