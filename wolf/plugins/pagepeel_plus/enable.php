<?php

$version = Plugin::getSetting('version', 'pagepeel_plus');

// Check if settings were found for pagepeel_plus
if (!$version || $version == null) {
	// Check if we're upgrading from a previous version.
	$upgrade = checkForOldInstall();

	// Upgrading from previous installation
	if ($upgrade) {
		// Retrieve the old settings.
		$PDO = Record::getConnection();
		$tablename = TABLE_PREFIX.'pagepeel_plus';

		$sql_check = "SELECT COUNT(*) FROM $tablename";
		$sql = "SELECT * FROM $tablename";

		$result = $PDO->query($sql_check);

		// Checking if old pagepeel_plus table is OK
		if ($result && $result->fetchColumn() != 1) {
			$result->closeCursor();
			Flash::set('error', __('Pagepeel Plus - upgrade needed, but invalid upgrade scenario detected!'));
			return;
		}
		
		if (!$result) {
			Flash::set('error', __('Pagepeel Plus - upgrade need detected earlier, but unable to retrieve table information!'));
			return;
		}

		// Fetch the old installation's records.
		$result = $PDO->query($sql);

		if ($result && $row = $result->fetchObject()) {
			$settings = array('version' => $version,
							  'pagelink' => $row->pagelink,
							  'pagelist' => $row->pagelist
							 );
			$result->closeCursor();
		}
		else {
			Flash::set('error', __('Pagepeel Plus - upgrade needed, but unable to retrieve old settings!'));
			return;
		}
	}
	// This is a clean install.
	else {
		$settings = array(	'version' => '1.0.0',
							'pagelink' => 'http://www.bluehorizonsmarketing.co.uk',
							'pagelist' => 'all'
						 );
	}

	// Store settings.
	if (Plugin::setAllSettings($settings, 'pagepeel_plus')) {
		if ($upgrade)
			Flash::set('success', __('Pagepeel Plus - plugin settings copied from old installation.'));
		else
			Flash::set('success', __('Pagepeel Plus - plugin settings initialized.'));
	}
	else
		Flash::set('error', __('Pagepeel Plus - unable to store plugin settings!'));

}
		
/**
 * This function checks to see if there is a valid old installation with regards to the DB.
 * 
 * @return boolean
 */
function checkForOldInstall() {
	$tablename = TABLE_PREFIX.'pagepeel_plus';
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