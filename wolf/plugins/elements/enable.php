<?php
/*
$version = Plugin::getSetting('version', 'elements');

// Check if settings were found for elements
if (!$version || $version == null) {
	// Check if we're upgrading from a previous version.
	$upgrade = checkForOldInstall();

	// Upgrading from previous installation
	if ($upgrade) {
		// Retrieve the old settings.
		$PDO = Record::getConnection();
		$tablename = TABLE_PREFIX.'elements';

		$sql_check = "SELECT COUNT(*) FROM $tablename";
		$sql = "SELECT * FROM $tablename";

		$result = $PDO->query($sql_check);

		// Checking if old elements table is OK
		if ($result && $result->fetchColumn() != 1) {
			$result->closeCursor();
			Flash::set('error', __('Elements - upgrade needed, but invalid upgrade scenario detected!'));
			return;
		}
		
		if (!$result) {
			Flash::set('error', __('Elements - upgrade need detected earlier, but unable to retrieve table information!'));
			return;
		}

		// Fetch the old installation's records.
		$result = $PDO->query($sql);

		if ($result && $row = $result->fetchObject()) {
			$settings = array('version' => $version,
							  'pagelist' => $row->pagelist
							 );
			$result->closeCursor();
		}
		else {
			Flash::set('error', __('Elements - upgrade needed, but unable to retrieve old settings!'));
			return;
		}
	}
	// This is a clean install.
	else {
		$settings = array(	'version' => '1.0.0',
					'pagelist' => 'all'
						 );
	}

	// Store settings.
	if (Plugin::setAllSettings($settings, 'elements')) {
		if ($upgrade)
			Flash::set('success', __('Elements - plugin settings copied from old installation.'));
		else
			Flash::set('success', __('Elements - plugin settings initialized.'));
	}
	else
		Flash::set('error', __('Elements - unable to store plugin settings!'));

}
		

function checkForOldInstall() {
	$tablename = TABLE_PREFIX.'elements';
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
*/
?>