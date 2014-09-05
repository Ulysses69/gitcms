<?php

/* Get defined constants such as version */
include PLUGINS_ROOT . '/'.basename(dirname(__FILE__)).'/index.php';

/* Get plugin settings (if they exist) */
$version = Plugin::getSetting('version', CLIENTDETAILS_ID);

/* Set version setting */
$settings = array('version' => CLIENTDETAILS_VERSION);

// Check for existing settings
$clientname = Setting::get('admin_title');
if(!Plugin::getSetting('clientslogan', CLIENTDETAILS_ID)) $settings['clientslogan'] = 'Thank you for visiting [client]';
if(!Plugin::getSetting('clientname', CLIENTDETAILS_ID)) $settings['clientname'] = $clientname;
if(!Plugin::getSetting('clientaddress', CLIENTDETAILS_ID)) $settings['clientaddress'] = "122 Bath Road \nCheltenham \nGloucestershire \nGL53 7JX (Blue Horizons)";
if(!Plugin::getSetting('clientaddress_building', CLIENTDETAILS_ID)) $settings['clientaddress_building'] = '';
if(!Plugin::getSetting('clientaddress_thoroughfare', CLIENTDETAILS_ID)) $settings['clientaddress_thoroughfare'] = '';
if(!Plugin::getSetting('clientaddress_street', CLIENTDETAILS_ID)) $settings['clientaddress_street'] = '122 Bath Road';
if(!Plugin::getSetting('clientaddress_locality', CLIENTDETAILS_ID)) $settings['clientaddress_locality'] = '';
if(!Plugin::getSetting('clientaddress_town', CLIENTDETAILS_ID)) $settings['clientaddress_town'] = 'Cheltenham';
if(!Plugin::getSetting('clientaddress_county', CLIENTDETAILS_ID)) $settings['clientaddress_county'] = 'Gloucestershire';
if(!Plugin::getSetting('clientaddress_postcode', CLIENTDETAILS_ID)) $settings['clientaddress_postcode'] = 'GL53 7JX (Blue Horizons)';
if(!Plugin::getSetting('clientphone', CLIENTDETAILS_ID)) $settings['clientphone'] = '01242 236600 (Blue Horizons)';
if(!Plugin::getSetting('clientemail', CLIENTDETAILS_ID)) $settings['clientemail'] = 'info@bluehorizonsclient.com';
if(!Plugin::getSetting('schema', CLIENTDETAILS_ID)) $settings['schema'] = 'LocalBusiness';
if(!Plugin::getSetting('mondayopen', CLIENTDETAILS_ID)) $settings['mondayopen'] = '';
if(!Plugin::getSetting('mondayclose', CLIENTDETAILS_ID)) $settings['mondayclose'] = '';
if(!Plugin::getSetting('tuesdayopen', CLIENTDETAILS_ID)) $settings['tuesdayopen'] = '';
if(!Plugin::getSetting('tuesdayclose', CLIENTDETAILS_ID)) $settings['tuesdayclose'] = '';
if(!Plugin::getSetting('wednesdayopen', CLIENTDETAILS_ID)) $settings['wednesdayopen'] = '';
if(!Plugin::getSetting('wednesdayclose', CLIENTDETAILS_ID)) $settings['wednesdayclose'] = '';
if(!Plugin::getSetting('thursdayopen', CLIENTDETAILS_ID)) $settings['thursdayopen'] = '';
if(!Plugin::getSetting('thursdayclose', CLIENTDETAILS_ID)) $settings['thursdayclose'] = '';
if(!Plugin::getSetting('fridayopen', CLIENTDETAILS_ID)) $settings['fridayopen'] = '';
if(!Plugin::getSetting('fridayclose', CLIENTDETAILS_ID)) $settings['fridayclose'] = '';
if(!Plugin::getSetting('saturdayopen', CLIENTDETAILS_ID)) $settings['saturdayopen'] = 'Closed';
if(!Plugin::getSetting('saturdayclose', CLIENTDETAILS_ID)) $settings['saturdayclose'] = 'Closed';
if(!Plugin::getSetting('sundayopen', CLIENTDETAILS_ID)) $settings['sundayopen'] = 'Closed';
if(!Plugin::getSetting('sundayclose', CLIENTDETAILS_ID)) $settings['sundayclose'] = 'Closed';
if(!Plugin::getSetting('mondaylunchstart', CLIENTDETAILS_ID)) $settings['mondaylunchstart'] = '';
if(!Plugin::getSetting('mondaylunchend', CLIENTDETAILS_ID)) $settings['mondaylunchend'] = '';
if(!Plugin::getSetting('tuesdaylunchstart', CLIENTDETAILS_ID)) $settings['tuesdaylunchstart'] = '';
if(!Plugin::getSetting('tuesdaylunchend', CLIENTDETAILS_ID)) $settings['tuesdaylunchend'] = '';
if(!Plugin::getSetting('wednesdaylunchstart', CLIENTDETAILS_ID)) $settings['wednesdaylunchstart'] = '';
if(!Plugin::getSetting('wednesdaylunchend', CLIENTDETAILS_ID)) $settings['wednesdaylunchend'] = '';
if(!Plugin::getSetting('thursdaylunchstart', CLIENTDETAILS_ID)) $settings['thursdaylunchstart'] = '';
if(!Plugin::getSetting('thursdaylunchend', CLIENTDETAILS_ID)) $settings['thursdaylunchend'] = '';
if(!Plugin::getSetting('fridaylunchstart', CLIENTDETAILS_ID)) $settings['fridaylunchstart'] = '';
if(!Plugin::getSetting('fridaylunchend', CLIENTDETAILS_ID)) $settings['fridaylunchend'] = '';
if(!Plugin::getSetting('saturdaylunchstart', CLIENTDETAILS_ID)) $settings['saturdaylunchstart'] = '';
if(!Plugin::getSetting('saturdaylunchend', CLIENTDETAILS_ID)) $settings['saturdaylunchend'] = '';
if(!Plugin::getSetting('sundaylunchstart', CLIENTDETAILS_ID)) $settings['sundaylunchstart'] = '';
if(!Plugin::getSetting('sundaylunchend', CLIENTDETAILS_ID)) $settings['sundaylunchend'] = '';
if(!Plugin::getSetting('mondayappt', CLIENTDETAILS_ID)) $settings['mondayappt'] = '';
if(!Plugin::getSetting('tuesdayappt', CLIENTDETAILS_ID)) $settings['tuesdayappt'] = '';
if(!Plugin::getSetting('wednesdayappt', CLIENTDETAILS_ID)) $settings['wednesdayappt'] = '';
if(!Plugin::getSetting('thursdayappt', CLIENTDETAILS_ID)) $settings['thursdayappt'] = '';
if(!Plugin::getSetting('fridayappt', CLIENTDETAILS_ID)) $settings['fridayappt'] = '';
if(!Plugin::getSetting('saturdayappt', CLIENTDETAILS_ID)) $settings['saturdayappt'] = '';
if(!Plugin::getSetting('sundayappt', CLIENTDETAILS_ID)) $settings['sundayappt'] = '';
if(!Plugin::getSetting('showcurrentday', CLIENTDETAILS_ID)) $settings['showcurrentday'] = false;
if(!Plugin::getSetting('hournotation', CLIENTDETAILS_ID)) $settings['hournotation'] = '12';
if(!Plugin::getSetting('mergelunch', CLIENTDETAILS_ID)) $settings['mergelunch'] = 'separate';
if(!Plugin::getSetting('daytag', CLIENTDETAILS_ID)) $settings['daytag'] = 'h3';

// Check existing plugin settings
if (!$version || $version == null) {

	// Store settings.
	if (Plugin::setAllSettings($settings, CLIENTDETAILS_ID)) {
		Flash::set('success', __(CLIENTDETAILS_TITLE.' - plugin settings setup.'));
	}
	else
		Flash::set('error', __(CLIENTDETAILS_TITLE.' - unable to save plugin settings.'));



} else {

	// Upgrade from previous installation
	if (CLIENTDETAILS_VERSION > $version) {

		// Retrieve the old settings.
		$PDO = Record::getConnection();
		$tablename = TABLE_PREFIX.'plugin_settings';

		$sql_check = "SELECT COUNT(*) FROM $tablename WHERE plugin_id='".CLIENTDETAILS_ID."'";
		$sql = "SELECT * FROM $tablename WHERE plugin_id='".CLIENTDETAILS_ID."'";

		$result = $PDO->query($sql_check);

		if (!$result) {
			Flash::set('error', __(CLIENTDETAILS_TITLE.' - unable to access plugin settings.'));
			return;
		}

		// Fetch the old installation's records.
		$result = $PDO->query($sql);

		if ($result && $row = $result->fetchObject()) {

			$result->closeCursor();
			if(defined('CLIENTDETAILS_INCLUDE')){ header('Location: '.URL_PUBLIC.ADMIN_DIR.'/plugin/'.CLIENTDETAILS_ID); }
		}
	}


	// Store settings.
	if (isset($settings) && Plugin::setAllSettings($settings, CLIENTDETAILS_ID)) {
		if (CLIENTDETAILS_VERSION > $version){
			Flash::set('success', __(CLIENTDETAILS_TITLE.' - plugin settings updated.'));
		}
	}

}


?>