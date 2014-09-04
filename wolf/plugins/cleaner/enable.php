<?php

/* Get defined constants such as version */
include PLUGINS_ROOT . '/'.basename(dirname(__FILE__)).'/index.php';

/* Get plugin settings (if they exist) */
$version = Plugin::getSetting('version', 'cleaner');

/* Set version setting */
$settings = array('version' => CLEANER_VERSION);

// Check for existing settings
if(!Plugin::getSetting('cleanlist', 'cleaner')){
	// Read clean list from txt file
	$clist = strip_tags(file_get_contents($_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/cleaner/lib/cleanlist.txt', true));
	// If clean list fails or is empty, set to empty
	if($clist === false) $clist = '';
	$settings['cleanlist'] = $clist;
}
if(!Plugin::getSetting('protectlist', 'cleaner')){
	// Read protect list from txt file
	$plist = strip_tags(file_get_contents($_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/cleaner/lib/protectlist.txt', true));
	// If protect list fails or is empty, set to empty
	if($plist === false) $plist = '';
	$settings['protectlist'] = $plist;
}
if(!Plugin::getSetting('customconditions', 'cleaner')) $settings['customconditions'] = '';
if(!Plugin::getSetting('debugmode', 'cleaner')) $settings['debugmode'] = true;

// Check existing plugin settings
if (!$version || $version == null) {

    // This is a clean install.

    // Store settings.
    if (Plugin::setAllSettings($settings, 'cleaner')) {
        Flash::set('success', __('Cleaner - plugin settings setup.'));
        cleanCMS();
    }
    else
        Flash::set('error', __('Cleaner - unable to save plugin settings.'));


} else {


    // Upgrade from previous installation
    if (CLEANER_VERSION > $version) {

        // Retrieve the old settings.
        $PDO = Record::getConnection();
        $tablename = TABLE_PREFIX.'plugin_settings';

        $sql_check = "SELECT COUNT(*) FROM $tablename WHERE plugin_id='cleaner'";
        $sql = "SELECT * FROM $tablename WHERE plugin_id='cleaner'";

        $result = $PDO->query($sql_check);

        if (!$result) {
            Flash::set('error', __('Cleaner - unable to access plugin settings.'));
            return;
        }

        // Fetch the old installation's records.
        $result = $PDO->query($sql);

        if ($result && $row = $result->fetchObject()) {

			$result->closeCursor();
            if(defined('CLEANER_INCLUDE')){ header('Location: '.URL_PUBLIC.ADMIN_DIR.'plugin/cleaner'); }
        }
    }


    // Store settings.
    if (isset($settings) && Plugin::setAllSettings($settings, 'cleaner')) {
        if (CLEANER_VERSION > $version){
			Flash::set('success', __('Cleaner - plugin settings updated.'));
		}
    }

}


?>