<?php

if (!defined('CLEANER_VERSION')) { define('CLEANER_VERSION', '0.1.1'); }
if (!defined('CLEANER_ROOT')) { define('CLEANER_ROOT', URI_PUBLIC.'wolf/plugins/cleaner'); }
Plugin::setInfos(array(
	'id'					=> 'cleaner',
	'title'					=> 'Cleaner',
	'description'			=> 'File and Data Maintenance',
	'version'				=> CLEANER_VERSION,
	'license'				=> 'GPLv3',
	'require_wolf_version'	=> '0.5.5'
));


Plugin::addController('cleaner', __('Cleaner'), 'administrator', true);

if(!function_exists('cleanCMS')){
function cleanCMS(){
	$cleanlist = Plugin::getSetting('cleanlist', 'cleaner');
	$protectlist = Plugin::getSetting('protectlist', 'cleaner');
	if($cleanlist != ''){
		$list = explode("\n", $cleanlist); $data = ''; $lis = '';
		if(!empty($list)){
   			foreach ($list as $value) {
				if(!stristr($value, "://")){
					
					// Safelist
					$safelist = array();

					// These are the files and folders we will be removing
					if(!stristr($value, ':/')){ $value = $_SERVER["DOCUMENT_ROOT"].'/'.$value; }
					$value = str_replace("//", "/" , $value);


					$info = new SplFileInfo($value);
					if(($info->getExtension() == '' || is_dir($value)) && !stristr($value, 'admin/error_log')){
						$lis .= '<li>'.$value." (folder)</li>\n";
					} else {
						$lis .= '<li>'.$value." (file)</li>\n";
					}

				}
			}
			$data .= "<ul>\n";
			$data .= $lis;
			$data .= "</ul>\n";
		}
		echo $data;
	}
}
}