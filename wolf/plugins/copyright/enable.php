<?php

/* Get defined constants such as version */
include PLUGINS_ROOT . '/'.basename(dirname(__FILE__)).'/index.php';

/* Get plugin settings (if they exist) */
$version = Plugin::getSetting('version', 'copyright');

/* Set version setting */
$settings = array('version' => COPYRIGHT_VERSION);

// Check for existing settings
if(!Plugin::getSetting('linkback', 'copyright')) $settings['linkback'] = '';
if(!Plugin::getSetting('linkcustom', 'copyright')) $settings['linkcustom'] = '';
if(!Plugin::getSetting('livedate', 'copyright')) $settings['livedate'] = '';
if(!Plugin::getSetting('vatnumber', 'copyright')) $settings['vatnumber'] = '';
if(!Plugin::getSetting('companyregistration', 'copyright')) $settings['companyregistration'] = '';
if(!Plugin::getSetting('countryregistration', 'copyright')) $settings['countryregistration'] = '';
if(!Plugin::getSetting('icoregistrant', 'copyright')) $settings['icoregistrant'] = '';
if(!Plugin::getSetting('icoaddress', 'copyright')) $settings['icoaddress'] = '';
if(!Plugin::getSetting('iconumber', 'copyright')) $settings['iconumber'] = '';
if(!Plugin::getSetting('gdcnumber', 'copyright')) $settings['gdcnumber'] = '';
if(!Plugin::getSetting('gdcurl', 'copyright')) $settings['gdcurl'] = '';
if(!Plugin::getSetting('cqcname', 'copyright')) $settings['cqcname'] = '';
if(!Plugin::getSetting('cqcnumber', 'copyright')) $settings['cqcnumber'] = '';
if(!Plugin::getSetting('cqcurl', 'copyright')) $settings['cqcurl'] = '';

// Check existing plugin settings
if (!$version || $version == null) {

    // This is a clean install.

    // Store settings.
    if (Plugin::setAllSettings($settings, 'copyright')) {
        Flash::set('success', __('Copyright - plugin settings setup.'));
    }
    else
        Flash::set('error', __('Copyright - unable to save plugin settings.'));


} else {


    // Upgrade from previous installation
    if (COPYRIGHT_VERSION > $version) {

        // Retrieve the old settings.
        $PDO = Record::getConnection();
        $tablename = TABLE_PREFIX.'plugin_settings';

        $sql_check = "SELECT COUNT(*) FROM $tablename WHERE plugin_id='copyright'";
        $sql = "SELECT * FROM $tablename WHERE plugin_id='copyright'";

        $result = $PDO->query($sql_check);

        if (!$result) {
            Flash::set('error', __('Copyright - unable to access plugin settings.'));
            return;
        }

        // Fetch the old installation's records.
        $result = $PDO->query($sql);

        if ($result && $row = $result->fetchObject()) {

			$result->closeCursor();
            if(defined('COPYRIGHT_INCLUDE')){ header('Location: '.URL_PUBLIC.ADMIN_DIR.'plugin/copyright'); }
        }
    }


    // Store settings.
    if (isset($settings) && Plugin::setAllSettings($settings, 'copyright')) {
        if (COPYRIGHT_VERSION > $version){
			Flash::set('success', __('Copyright - plugin settings updated.'));
		}
    }

}


?>