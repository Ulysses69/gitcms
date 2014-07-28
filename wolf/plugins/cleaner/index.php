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




if(!function_exists('prefix_safelist')){
		// Function which will prefix file_path to all safelist values (saves specifying them into array)
		function prefix_safelist($safelist){
		    if (!is_array($safelist)){
		        return false;
		    }
		    foreach($safelist as $key => $value){
		        if (!is_string($value)){
		            continue;
		        }
		        $safelist[$key] = file_path($value);
		    }
		    return $safelist;
		}
}
	
if(!function_exists('file_path')){
		function file_path($value){
			$pathvalue = $_SERVER{'DOCUMENT_ROOT'}.$value;
			//$pathvalue = getcwd().'/'.$value;
			$pathvalue = str_replace("\\", "/", $pathvalue);
			$pathvalue = str_replace("//", "/", $pathvalue);
			return $pathvalue;
		}
}
	
if(!function_exists('get_dir_size')){
		function get_dir_size($directory) {
			$size = 0;
			if (is_dir($directory)) {
				foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file) {
					$size+=$file->getSize();
				}
			}
			return $size;
		}
}
	
if(!function_exists('format_size')){
	    function format_size($size) {
	        $mod = 1024;
	        $units = explode(' ','B KB MB GB TB PB');
	        for ($i = 0; $size > $mod; $i++) {
	            $size /= $mod;
	        }
	        return round($size, 2) . ' ' . $units[$i];
	    }
}
	
if(!function_exists('delete_directory')){
		function delete_directory($dirname, $data = '', &$filesizes, $safelist, $protected = ''){

			// Clean up trailing slashes
			$dirname = rtrim($dirname,"/");
			settype($dirname, "string");
			

			//$dirname = str_replace("E:/", "/", $dirname);


		    $info = new SplFileInfo($dirname);
			if (($info->getExtension() == '' || is_dir($dirname)) && !stristr($dirname,'error_log') && !stristr($dirname,'error.log')){
			//if (is_dir($dirname)){
				$data .= '<li>IS DIR: '.$dirname."</li><br/>";
		        $dir_handle = @opendir($dirname);
		    }
		    if (!isset($dir_handle)){

		        if (file_exists($dirname)){
					
					$data .= '<li>FILE EXISTS: '.$dirname."</li><br/>";

					$size = filesize($dirname);
					if (basename($dirname) == 'error_log' || basename($dirname) == 'error.log'){

						// Empty files
						if($size > 0){
							$filesizes[] = $size;
							$f = @fopen($dirname, "r+");
							if ($f !== false){
							    $data .= '<li>Emptied '.$dirname." (FILE ".format_size($size).")</li>";
							    //ftruncate($f, 0);
							    //fclose($f);
							}
						}
	
					} else {
	
						// Remove files
						$filesizes[] = $size;
	
						// Check if file is protected
						if(strpos(implode(' ', prefix_safelist($safelist)), $dirname) !== false){
							$protected = ' Protected';
						} else {
							
							if($size > 0){

								// Unlink both unlinks AND removes files, where as unlink does not itself remove folders
								$data .= '<li>Removed '.$dirname." (FILE ".format_size($size).$protected.")</li>";
								//unlink($dirname);
							
							}
	
						}

					}
					
					return $data;

				} else {

					$data .= '<li>FILE DOES NOT EXIST: '.$dirname."</li><br/>";

				}

		    }

			// Collect found files
			$collected = glob($dirname.'/*');
	
			// Get size of folder
		    $size = get_dir_size($dirname);

		    // Folder contains some unprotected files
			if(count(array_diff($collected, prefix_safelist($safelist))) > 0){
				while ($file = readdir($dir_handle)){
					
					$data .= '<li>DIR IS READIBLE: '.$dirname."</li><br/>";

			        if ($file != "." && $file != ".."){
		
						// Check if folder contains files or folders to protect
						if(strpos(implode(' ', prefix_safelist($safelist)), $dirname) !== false){
							$protected = ' Protected';
						}
		
						if (!is_dir($dirname."/".$file)){
			                if(strpos(implode(' ', prefix_safelist($safelist)), $dirname."/".$file) !== false){
								$protected = ' Protected';
							} else {
								// Remove unprotected files only
								//unlink($dirname."/".$file);
							}
			            } else {
			                delete_directory($dirname.'/'.$file, $data, $filesizes, $safelist, $protected);
			            }
		
			        }
			    }
			}

			// Check if folder contains files or folders to protect
			if(strpos(implode(' ', prefix_safelist($safelist)), $dirname) !== false){
				$protected = ' Protected Contents';
	
				// Folder contains some unprotected files
				if(count(array_diff($collected, prefix_safelist($safelist))) > 0){
				    $data .= '<li>Cleaned '.$dirname." (FOLDER ".format_size($size).$protected.")</li>";
				}
				
			} else {
				$filesizes[] = $size;
			    //closedir($dir_handle);
			    if($size > 0){
					$data .= '<li>Removed '.$dirname." (FOLDER ".format_size($size).$protected.")</li>";
				}
			    //rmdir($dirname);
			}
	
		    return $data;

		}
}




if(!function_exists('cleanCMS')){
function cleanCMS(){
	$cleanlist = Plugin::getSetting('cleanlist', 'cleaner');
	$protectlist = Plugin::getSetting('protectlist', 'cleaner');

	if($cleanlist != ''){

		global $filesizes;
		global $deletelist;
		global $safelist;
		global $datalist;
		global $value;
		global $data;
		global $lis;
		global $size;
		global $spacesaved;

		$filesizes = array();
		$spacesaved = 0;

		$deletelist = explode("\n", $cleanlist);
		$safelist = explode("\n", $protectlist);
		$data = ''; $lis = ''; $thedata = ''; $thedata = ''; $datalist = '';
		sort($deletelist);
		sort($safelist);

		foreach ($filesizes as $value) {
			$spacesaved = $spacesaved + $value;
		}

		foreach ($deletelist as $value) {
			//$datalist .= file_path($value).'<br/>';
			$datalist .= delete_directory(file_path($value), '', $filesizes, $safelist, '');
		}

		if($datalist != ''){
			$thedata .= "<ul>\n";
			$thedata .= $datalist;
			$thedata .= "</ul>\n";
			echo $thedata;

			if($spacesaved > 0){
				echo '<p>Space Saved: '.format_size($spacesaved).'</p>';
			}

		}

	}

}
}