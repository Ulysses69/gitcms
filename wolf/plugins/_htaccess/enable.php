<?php

if (!defined('IN_CMS')) { exit(); }

$htaccessfile = $_SERVER{'DOCUMENT_ROOT'}.'/.htaccess';
$htaccesstitle = 'Server configuration file';
$htaccessbackup = $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/_htaccess/backups/.htaccess.bak';
$htaccessdefault = $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/_htaccess/backups/.htaccess.default';
$plugintitle = '.htaccess';

// Server configuration file exists.
if(file_exists($htaccessfile)){

	chmod($htaccessfile, 0777);
	chmod($htaccessbackup, 0777);
	chmod($htaccessdefault, 0777);

	// Create original backup.
	if(file_exists($htaccessdefault) == FALSE || (file_exists($htaccessdefault) && file_get_contents($htaccessfile) != file_get_contents($htaccessdefault))){

		/* Read htaccess */
		$defaultdata = file_get_contents($htaccessfile);

		/* Backup htaccess */
		$htaccesssave = fopen($_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/_htaccess/backups/.htaccess','w+');
		if($defaultdata != ''){
			fwrite($htaccesssave, $defaultdata);
		}
		chmod($htaccessdefault, 0644);

		$default = fopen($htaccessdefault, 'w');
		if($default){
	
			// Read default data to backup.
			$defaultdata = file_get_contents($htaccessfile);
			
		    // Write default content to backup file.
		    if (fwrite($default, $defaultdata) === FALSE) {
		        Flash::set('error', __('Cannot backup '.$htaccesstitle));
		        fclose($default);
				exit;
		    }
	
			// New default backup created.
			Flash::set('success', __($htaccesstitle.' has been created.'));
			fclose($default);
	
		} else {
	
			// New default backup could not be created.
			Flash::set('error', __('For security, '.$plugintitle.' will not be enabled as backup cannot be created.'));
			fclose($backup);
			
			// For security, do not proceed with modifying server configuration.
			exit;
	
		}
	}
	
	
	


	// Create new backup.
	$backup = fopen($htaccessbackup, 'w');
	if($backup){

		// Read data to backup.
		$data = file_get_contents($htaccessfile);

	    // Write content to backup file.
	    if (fwrite($backup, $data) === FALSE) {
	        Flash::set('error', __('Cannot backup '.$htaccesstitle));
	        fclose($backup);
			exit;
	    }

		// New backup created.
		Flash::set('success', __($htaccesstitle.' has been created.'));
		fclose($backup);

	} else {

		// New backup could not be created.
		Flash::set('error', __('For security, '.$plugintitle.' will not be enabled as backup cannot be created.'));
		fclose($backup);
		
		// For security, do not proceed with modifying server configuration.
		exit;

	}


	// Server configuration file is editable.
	if(is_writable($htaccessfile)){

		// Cache server configuration file data.
		$cacheddata = file_get_contents($htaccessfile);
		
		// Open server configuration file for writing (w) and check permissions.
		$htaccessopen = fopen($htaccessfile,'w');
		if($htaccessopen && fileperms($htaccessfile) >= 0644){

			// Update server configuration file if not empty.
			if($cacheddata != ''){
				$currentdata = "# htaccess update\n\n".$cacheddata;
				fwrite($htaccessopen, $currentdata);
			}

			// Rewrite of server configuration file is possible.
			Flash::set('success', __($plugintitle.' is enabled.'));
			
			fclose($htaccessopen);

		} else {
			
			// Server configuration file cannot be read.
			Flash::set('error', __($htaccesstitle.' cannot be read. Status: '.stat($htaccessfile)));

		}

		fclose($htaccessopen);

	} else {

		// Rewrite is not possible.
		Flash::set('error', __($htaccesstitle.' is not writable.'));

	}

	chmod($htaccessfile, 0644);
	chmod($htaccessbackup, 0644);
	chmod($htaccessdefault, 0644);

	// Check if plugin settings already exist and create them if not.
	if (Plugin::getSetting('htaccessbackup', 'htaccess') === false) {

	    // Store settings
	    $settings = array('htaccess' => $currentdata, 'htaccessbackup' => $data, 'htaccessdefault' => $defaultdata);
	    Plugin::setAllSettings($settings, 'htaccess');

	} else {

	    // Store settings
	    $settings = array('htaccess' => $currentdata);
	    Plugin::setAllSettings($settings, 'htaccess');

	}

} else {
	
	// Server configuration file doesn't exist.
	Flash::set('error', __($htaccesstitle.' cannot be found.'));
	Flash::set('error', __($plugintitle.' cannot be enabled.'));

}


//exit();