<?php

/* Get defined constants such as version */
include PLUGINS_ROOT . '/'.basename(dirname(__FILE__)).'/index.php';

/* Get plugin settings (if they exist) */
$version = Plugin::getSetting('version', 'simple_banners');

/* Set version setting */
$settings = array('version' => SIMPLE_BANNERS_VERSION);

/* Set new settings */
if(!Plugin::getSetting('display', 'simple_banners')) $settings['display'] = 'show';
if(!Plugin::getSetting('bannercontainer', 'simple_banners')) $settings['bannercontainer'] = '';
if(!Plugin::getSetting('bannerduration', 'simple_banners')) $settings['bannerduration'] = '3';
if(!Plugin::getSetting('images_home_FOLDER', 'simple_banners')) $settings['images_home_FOLDER'] = '';
if(!Plugin::getSetting('images_main_FOLDER', 'simple_banners')) $settings['images_main_FOLDER'] = '';

// Check existing plugin settings
if (!$version || $version == null) {

	// This is a clean install.

	// Store settings.
	if (Plugin::setAllSettings($settings, 'simple_banners')) {
		Flash::set('success', __('SimpleBanners - plugin settings setup.'));
	}
	else
		Flash::set('error', __('SimpleBanners - unable to save plugin settings!'));


} else {


	// Upgrading from previous installation
	if (SIMPLE_BANNERS_VERSION > $version) {

		// Retrieve the old settings.
		$PDO = Record::getConnection();
		$tablename = TABLE_PREFIX.'plugin_settings';

		$sql_check = "SELECT COUNT(*) FROM $tablename WHERE plugin_id='simple_banners'";
		$sql = "SELECT * FROM $tablename WHERE plugin_id='simple_banners'";

		$result = $PDO->query($sql_check);

		if (!$result) {
			Flash::set('error', __('SimpleBanners - unable to access plugin settings.'));
			return;
		}

		// Fetch the old installation's records.
		$result = $PDO->query($sql);

		if ($result && $row = $result->fetchObject()) {

			$result->closeCursor();
			if(defined('SIMPLE_BANNERS_INCLUDE')){ header('Location: '.URL_PUBLIC.ADMIN_DIR.'/plugin/simple_banners'); }
		}
	}

	// Store settings.
	if (isset($settings) && Plugin::setAllSettings($settings, 'simple_banners')) {
		if (SIMPLE_BANNERS_VERSION > $version){
			Flash::set('success', __('SimpleBanners - plugin settings updated.'));
		}
	}


}

?>