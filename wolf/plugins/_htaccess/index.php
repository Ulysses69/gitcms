<?php

if (!defined('IN_CMS')) { exit(); }

define('HTACCESS_TITLE', 'Server Configuration');
define('HTACCESS_ID', '_htaccess');
define('HTACCESS_VERSION', '1.0.1');
define('HTACCESS_ROOT', URI_PUBLIC.'wolf/plugins/'.HTACCESS_ID);

Plugin::setInfos(array(
	'id'							=> HTACCESS_ID,
	'title'							=> __(HTACCESS_TITLE),
	'description'					=> __('Manage server configuration.'),
	'version'						=> HTACCESS_VERSION,
	'author'						=> 'Steven Henderson',
	'require_wolf_version'			=> '0.5.5'
));

# Example:
# $myarticles = truncate($article->content,300);
# echo $myarticles;

Plugin::addController(HTACCESS_ID, '.htaccess', 'administrator', false);

function saveServerConfig($htaccess='',$htaccessbackup='',$htaccessfile='',$htaccessbackupfile=''){

	//echo $htaccess;
	//exit;

	/* htaccess and backup data required. Don't proceed without data. */
	 if($htaccess != '' && $htaccessbackup != ''){

		if($htaccessfile == '') $htaccessfile = $_SERVER{'DOCUMENT_ROOT'}.'/.htaccess';
		if($htaccessbackupfile == '') $htaccessbackupfile = $_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/_htaccess/backups/.htaccess.bak';

		/* Update backup htaccess */
		chmod($htaccessbackupfile, 0777);
	
		/* Read htaccess */
		$defaultdata = file_get_contents($htaccessfile);
	
		/* Backup htaccess */
		$htaccesssave = fopen($_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/_htaccess/backups/.htaccess.bak','w+');
		if($defaultdata != ''){
			fwrite($htaccesssave, $defaultdata);
		}
	
		/* Protect backup htaccess */
		chmod($htaccessbackupfile, 0644);
	
		/* Update htaccess */
		chmod($htaccessfile, 0777);
	
		// Server configuration file is editable.
		if(is_writable($htaccessfile)){
	
			// Open server configuration file for writing (w) and check permissions.
			$htaccessopen = fopen($htaccessfile,'w');
			if($htaccessopen && fileperms($htaccessfile) >= 0644){
	
				if(stristr($htaccess,'### CMS-Generated Update')){
					$htaccess = preg_replace("/### CMS-Generated Update.*?###/ms",'',$htaccess);
				}
				$htaccess = "### CMS-Generated Update ".date("F j, Y, g:i a")." ###\n\n".$htaccess;
				//}
				
				/* Remove empty lines */
				$htaccess = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\r\n", $htaccess);
				
				// Update server configuration file if not empty and contains no php error notices.
				if($htaccess != '' && !stristr($htaccess, '<b>Notice</b>:') && !stristr($htaccess, ' on line <b>')){
					fwrite($htaccessopen, $htaccess);
				}
	
			}
	
			fclose($htaccessopen);
	
			/* Protect htaccess */
			chmod($htaccessfile, 0644);
	
		}
	
	}

}