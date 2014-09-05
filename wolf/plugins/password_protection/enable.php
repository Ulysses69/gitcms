<?php

//if(Plugin::isEnabled('tinymce') == true){

	$version = Plugin::getSetting('version', 'password_protection');

	// Check if settings were found for password_protection
	if (!$version || $version == null) {
		// Check if we're upgrading from a previous version.
		$upgrade = checkForOldInstall();

		// Upgrading from previous installation
		if ($upgrade) {
			// Retrieve the old settings.
			$PDO = Record::getConnection();
			$tablename = TABLE_PREFIX.'password_protection';
	
			$sql_check = "SELECT COUNT(*) FROM $tablename";
			$sql = "SELECT * FROM $tablename";
	
			$result = $PDO->query($sql_check);
	
			// Checking if old password_protection table is OK
			if ($result && $result->fetchColumn() != 1) {
				$result->closeCursor();
				Flash::set('error', __('Password Protection - upgrade needed, but invalid upgrade scenario detected!'));
				return;
			}
			
			if (!$result) {
				Flash::set('error', __('Password Protection - upgrade need detected earlier, but unable to retrieve table information!'));
				return;
			}
	
			// Fetch the old installation's records.
			$result = $PDO->query($sql);
	
			if ($result && $row = $result->fetchObject()) {
				$settings = array('version' => $version,
								  'password_protection_list' => $row->password_protection_list
								 );
				$result->closeCursor();
			}
			else {
				Flash::set('error', __('Password Protection - upgrade needed, but unable to retrieve old settings!'));
				return;
			}
		}
		// This is a clean install.
		else {
			$settings = array( 'version' => $version,
					  		   'password_protection_list' => ''
	);
		}
	
		// Store settings.
		if (Plugin::setAllSettings($settings, 'password_protection')) {
			if ($upgrade)
				Flash::set('success', __('Password Protection - plugin settings copied from old installation.'));
			else
				Flash::set('success', __('Password Protection - plugin settings initialized.'));
		}
		else
			Flash::set('error', __('Password Protection - unable to store plugin settings!'));
	
	}
			
	/**
	 * This function checks to see if there is a valid old installation with regards to the DB.
	 * 
	 * @return boolean
	 */
	function checkForOldInstall() {
		$tablename = TABLE_PREFIX.'password_protection';
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

//} else {
//	Flash::set('error', __('TinyMCE Styles requires TinyMCE Editor plugin.'));
//}

?>