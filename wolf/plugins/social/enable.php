<?php

/* Get defined constants such as version */
include PLUGINS_ROOT . '/'.basename(dirname(__FILE__)).'/index.php';

/* Get plugin settings (if they exist) */
$version = Plugin::getSetting('version', 'social');

/* Set version setting */
$settings = array('version' => SOCIAL_VERSION);

/* Set new settings */
if(!Plugin::getSetting('display', 'social')) $settings['display'] = 'show';
if(!Plugin::getSetting('icon_set', 'social')) $settings['icon_set'] = 'circles';
if(!Plugin::getSetting('appearance', 'social')) $settings['appearance'] = 'image';
if(!Plugin::getSetting('facebook_URL', 'social')) $settings['facebook_URL'] = '';
if(!Plugin::getSetting('twitter_URL', 'social')) $settings['twitter_URL'] = '';
if(!Plugin::getSetting('linkedin_URL', 'social')) $settings['linkedin_URL'] = '';
if(!Plugin::getSetting('pinterest_URL', 'social')) $settings['pinterest_URL'] = '';
if(!Plugin::getSetting('youtube_URL', 'social')) $settings['youtube_URL'] = '';
if(!Plugin::getSetting('googleplus_URL', 'social')) $settings['googleplus_URL'] = '';
if(!Plugin::getSetting('vimeo_URL', 'social')) $settings['vimeo_URL'] = '';
if(!Plugin::getSetting('instagram_URL', 'social')) $settings['instagram_URL'] = '';

// Check existing plugin settings
if (!$version || $version == null) {

	// This is a clean install.

	// Store settings.
	if (Plugin::setAllSettings($settings, 'social')) {
		Flash::set('success', __('Social - plugin settings setup.'));
	}
	else
		Flash::set('error', __('Social - unable to save plugin settings!'));


} else {


	// Upgrading from previous installation
	if (SOCIAL_VERSION > $version) {

		// Retrieve the old settings.
		$PDO = Record::getConnection();
		$tablename = TABLE_PREFIX.'plugin_settings';

		$sql_check = "SELECT COUNT(*) FROM $tablename WHERE plugin_id='social'";
		$sql = "SELECT * FROM $tablename WHERE plugin_id='social'";

		$result = $PDO->query($sql_check);

		if (!$result) {
			Flash::set('error', __('Social - unable to access plugin settings.'));
			return;
		}

		// Fetch the old installation's records.
		$result = $PDO->query($sql);

		if ($result && $row = $result->fetchObject()) {

			$result->closeCursor();
			if(defined('SOCIAL_INCLUDE')){ header('Location: '.URL_PUBLIC.ADMIN_DIR.'/plugin/social'); }
		}
	}

	// Store settings.
	if (isset($settings) && Plugin::setAllSettings($settings, 'social')) {
		if (SOCIAL_VERSION > $version){
			Flash::set('success', __('Social - plugin settings updated.'));
		}
	}


}

?>