<?php

if (!defined('IN_CMS')) { exit(); }

$htaccessfile = $_SERVER{'DOCUMENT_ROOT'}.'/.htaccess';
$htaccesstitle = 'Server configuration file';
$htaccessbackup = $htaccessfile.'.bak';
$plugintitle = '.htaccess';

// Server configuration file exists.
if(file_exists($htaccessfile)){

	chmod($htaccessfile, 0777);
	chmod($htaccessbackup, 0777);

	// Server configuration file is editable.
	if(is_writable($htaccessfile)){

		// Backup server configuration file exists.
	   	if(file_exists($htaccessbackup)){

			// Cache server configuration file data for backup file.
			$newdata = file_get_contents($htaccessfile);

			// Read backup server configuration file data.
			$backup = file_get_contents($htaccessbackup);
			
			// Backup server configuration file data is not empty (or contains any notable layout switch properties).
			if($backup != ''){
	
				// Restore server configuration file from backup data.
				$restore = fopen($htaccessfile, 'w');
				if($restore){
		
					// Write backup server configuration file data to server configuration file.
					if (fwrite($restore, $backup) === FALSE) {
						Flash::set('error', __($plugintitle.' cannot restore '.$htaccesstitle));
						fclose($restore);
						exit;
					}
		
					// New backup created.
					Flash::set('success', __($htaccesstitle.' has been restored from backup.'));
					fclose($restore);
		
				}

			}

		}

	}

	// Backup file is editable.
	if(is_writable($htaccessbackup)){

		// Open backup file for writing (w) and check permissions.
		$htaccessopen = fopen($htaccessbackup,'w');
		if($htaccessopen && fileperms($htaccessbackup) >= 0644){

			// Update backup file if not empty.
			if($newdata != ''){
				fwrite($htaccessopen, $newdata);
			}

			// Rewrite of backup file is possible.
			Flash::set('success', __($plugintitle.' is disabled.'));
			
			fclose($htaccessopen);

		} else {
			
			// Backup file cannot be read.
			Flash::set('error', __($htaccesstitle.' cannot be read. Status: '.stat($htaccessbackup)));

		}

		fclose($htaccessopen);

	} else {

		// Rewrite is not possible.
		Flash::set('error', __($htaccesstitle.' is not writable.'));

	}

	chmod($htaccessfile, 0444);
	chmod($htaccessbackup, 0444);

}

exit();