<?php

$version = Plugin::getSetting('version', 'tweaker');

// Check if settings were found for tweaker
if (!$version || $version == null) {
	// Check if we're upgrading from a previous version.
	$upgrade = checkForOldInstall();

	// Upgrading from previous installation
	if ($upgrade) {
		// Retrieve the old settings.
		$PDO = Record::getConnection();
		$tablename = TABLE_PREFIX.'tweaker';

		$sql_check = "SELECT COUNT(*) FROM $tablename";
		$sql = "SELECT * FROM $tablename";

		$result = $PDO->query($sql_check);

		// Checking if old tweaker table is OK
		if ($result && $result->fetchColumn() != 1) {
			$result->closeCursor();
			Flash::set('error', __('Tweaker - upgrade needed, but invalid upgrade scenario detected!'));
			return;
		}
		
		if (!$result) {
			Flash::set('error', __('Tweaker - upgrade need detected earlier, but unable to retrieve table information!'));
			return;
		}

		// Fetch the old installation's records.
		$result = $PDO->query($sql);

		if ($result && $row = $result->fetchObject()) {
			$settings = array('version' => $version,
							  'urlpublic' => $row->urlpublic,
							  'autometa' => $row->autometa,
							  'plugindescriptions' => $row->plugindescriptions
							 );
			$result->closeCursor();
		}
		else {
			Flash::set('error', __('Tweaker - upgrade needed, but unable to retrieve old settings!'));
			return;
		}
	}
	// This is a clean install.
	else {
		$settings = array(	'version' => $version,
					'urlpublic' => '/',
					'autometa' => 'true',
					'plugindescriptions' => 'true'
						 );
	}

	// Store settings.
	if (Plugin::setAllSettings($settings, 'tweaker')) {
		if ($upgrade)
			Flash::set('success', __('Tweaker - plugin settings copied from old installation.'));
		else
			Flash::set('success', __('Tweaker - plugin settings initialized.'));
	}
	else
		Flash::set('error', __('Tweaker - unable to store plugin settings!'));

}
		
/**
 * This function checks to see if there is a valid old installation with regards to the DB.
 * 
 * @return boolean
 */
function checkForOldInstall() {
	$tablename = TABLE_PREFIX.'tweaker';
	$PDO = Record::getConnection();

	$sql = "SELECT COUNT(*) FROM $tablename";

	$result = $PDO->query($sql);

	if ($result != null) {
		$result->closeCursor();
		return true;
	}
	else
		return false;
}

?>