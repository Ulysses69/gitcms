<?php

/* Get defined constants such as version */
include PLUGINS_ROOT . '/'.basename(dirname(__FILE__)).'/index.php';

/* Get plugin settings (if they exist) */
$version = Plugin::getSetting('version', SKELETON_ID);

/* Set version setting */
$settings = array('version' => SKELETON_VERSION);

/* Set new settings */
//if(!Plugin::getSetting('test1', SKELETON_ID)) $settings['test1'] = '';

// Check existing plugin settings
if (!$version || $version == null) {

    // Store settings.
    if (Plugin::setAllSettings($settings, SKELETON_ID)) {
        Flash::set('success', __(SKELETON_TITLE.' - plugin settings setup.'));
    }
    else
        Flash::set('error', __(SKELETON_TITLE.' - unable to save plugin settings.'));



} else {

    // Upgrade from previous installation
    if (SKELETON_VERSION > $version) {

        // Retrieve the old settings.
        $PDO = Record::getConnection();
        $tablename = TABLE_PREFIX.'plugin_settings';

        $sql_check = "SELECT COUNT(*) FROM $tablename WHERE plugin_id='".SKELETON_ID."'";
        $sql = "SELECT * FROM $tablename WHERE plugin_id='".SKELETON_ID."'";

        $result = $PDO->query($sql_check);

        if (!$result) {
			Flash::set('error', __(SKELETON_TITLE.' - unable to access plugin settings.'));
			return;
        }

        // Fetch the old installation's records.
        $result = $PDO->query($sql);

        if ($result && $row = $result->fetchObject()) {

            $result->closeCursor();
            if(defined('SKELETON_INCLUDE')){ header('Location: '.URL_PUBLIC.ADMIN_DIR.'/plugin/'.SKELETON_ID); }
        }
    }


    // Store settings.
    if (isset($settings) && Plugin::setAllSettings($settings, SKELETON_ID)) {
        if (SKELETON_VERSION > $version){
			Flash::set('success', __(SKELETON_TITLE.' - plugin settings updated.'));
		}
    }

}


?>