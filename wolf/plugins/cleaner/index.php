<?php

if (!defined('CLEANER_VERSION')) { define('CLEANER_VERSION', '0.1.4'); }
if (!defined('CLEANER_ROOT')) { define('CLEANER_ROOT', URI_PUBLIC.'wolf/plugins/cleaner'); }
Plugin::setInfos(array(
	'id'					=> 'cleaner',
	'title'					=> 'Cleaner',
	'description'			=> 'File and Data Maintenance',
	'version'				=> CLEANER_VERSION,
	'license'				=> 'GPLv3',
	'require_wolf_version'	=> '0.5.5'
));


Plugin::addController('cleaner', __('Clean'), 'administrator', true);




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

// Plugin check
if(!function_exists('plugin_check')){
	function plugin_check($dirname,$debug=false) {
		if(stristr($dirname, 'wolf/plugins/')){
			$lowestpath = getcwd();
			$rep = str_replace('\\', '/', $lowestpath);
			$wolfpath = str_replace('/'.ADMIN_DIR, '', $rep);

			$plugindir = str_replace(rtrim($wolfpath)."/wolf/plugins/", '', $dirname);
			$pluginname = explode("/", $plugindir);
			$plugin = $pluginname[0];
			if(Plugin::isEnabled($plugin) == true){
				$removeplugin = true;
				if($debug == true){
					return $plugin;
				} else {
					return 'enabled';
				}
			}
		}
	}
}

if(!function_exists('delete_directory')){
		function delete_directory($debug = true, $dirname, $wolfpath, $data = '', &$filesizes, $safelist, $protected = '', $start = 0, $end = 3, $cssdata = ''){

			if((time() - $start) < $end){				

				$removeplugin = false;
				
				// Clean up trailing slashes
				$dirname = rtrim($dirname,"/");

				// Clean up whitespace
				$dirname = trim($dirname);

				// Relative URL
				$relname = str_replace($_SERVER{'DOCUMENT_ROOT'}, '', $dirname);

				//$data .= 'Relname: ' . $relname;

				// Ensure files/folders exist within root (to protect server critical files/folders)
				//if($relname != '' && stristr($relname, $_SERVER{'DOCUMENT_ROOT'})){
				if($relname != '' && (substr($relname, 0, 1) == '/' && !stristr($relname, './'))){

					//$data .= 'Checking Files. ';

					$info = new SplFileInfo($dirname);
					if (($info->getExtension() == '' || is_dir($dirname)) && !stristr($dirname,'error_log') && !stristr($dirname,'error.log') && !stristr($dirname,'README')){
						//$data .= '<li><b>FOLDER: '.$dirname."</b></li>";
						$dir_handle = @opendir($dirname);
					}

					if (!isset($dir_handle)){
						if (file_exists($dirname)){
							//$data .= '<li><b>FILE: '.$dirname."</b></li>";
							$size = filesize($dirname);
							if (basename($dirname) == 'error_log' || basename($dirname) == 'error.log'){

								// Empty files
								if($size > 0){
									$filesizes[] = $size;
									$f = @fopen($dirname, "r+");
									if ($f !== false){
										
										// Report task outcome
										$data .= '<li>Emptied File: '.$relname." (".format_size($size).")</li>";

										// Test task or carry it out
										if($debug == false){
											ftruncate($f, 0);
											fclose($f);
										}
									}
								}

							} else {

								// Remove files
								//$filesizes[] = $size;

								// Check if file is protected
								if(strpos(implode(' ', prefix_safelist($safelist)), $dirname) !== false){
									$protected = ' Protected';
								} else {

									if($size > 0){

										// Unlink both unlinks AND removes files, where as unlink does not itself remove folders

										// Report task outcome
										$data .= '<li>Removed File: '.$relname." (".format_size($size).")</li>";

										// Test task or carry it out
										if($debug == false){
											unlink($dirname);
										}

									}

								}

							}

							//return $data;

						} else {

							//$data .= '<li>FILE DOES NOT EXIST: '.$relname."</li>";

						}

					}

					// Collect found files
					$collected = glob($dirname.'/*');

					// Get size of folder
					$size = get_dir_size($dirname);

					// Folder contains some unprotected files
					if(count(array_diff($collected, prefix_safelist($safelist))) > 0){
						while ($file = readdir($dir_handle)){

							// Check if we need to exit loop
							if(time() >= $start + $end){
								global $stopdelete;
								$stopdelete = '<p>Stop Deleting</p>';
								break;
							}

							if ($file != "." && $file != ".."){
								
								$removeFile = true;
								$highlightopen = '';
								$highlightclose = '';
	
								// Check if folder contains files or folders to protect
								if(strpos(implode(' ', prefix_safelist($safelist)), $dirname) !== false){
									$removeFile = false;
								}
	
								$ex = new SplFileInfo($file);
	
								// Check fonts
								if(stristr($dirname, 'inc/font') || $ex->getExtension() == 'eot' || $ex->getExtension() == 'woff' || $ex->getExtension() == 'ttf'){
									// Remove fonts if not found in collected CSS data
									if(!stristr($cssdata, $file)){
	
										// Report task outcome
										//$data .= '<li>Removed Font: '.$file.' ('.format_size($fsize).')</li>';
										$removeFile = true;
	
									} else {
	
										$removeFile = false;
	
									}
	
								}

								// Check if this file is associated with an enabled plugin (only seems to work for folder, not plugin files themselves)
								if(stristr($relname, 'wolf/plugins/')){
									if(plugin_check($dirname) == 'enabled'){

									//if(!is_dir($dirname."/".$file)){

										// Don't remove enabled plugin files
										$removeFile = false;

										// This file IS in the safelist
										//if(!stristr(implode(' ', prefix_safelist($safelist)), $dirname."/".$file)){
										if(strpos(implode(' ', prefix_safelist($safelist)), $dirname."/".$file) !== false){
											//$highlightopen = '<b>';
											//$highlightclose = '</b>';
											$removeFile = false;
										} else {
											//$highlightopen = '';
											//$highlightclose = '';
											$removeFile = true;

											// Report task outcome
											//$data .= '<li>Remove Plugin File: '.$highlightopen.$relname.'/'.$file.$highlightclose.' ('.format_size($fsize).')</li>';

										}
										
										//$data .= '<li>Keep Plugin File: '.$highlightopen.$relname.'/'.$file.$highlightclose.' ('.format_size($fsize).')</li>';

	
									//}

									} else {
										// Remove plugin files
										$removeFile = true;
										//$data .= '<li>Remove Plugin File: '.$highlightopen.$relname.'/'.$file.$highlightclose.' ('.format_size($fsize).')</li>';
									}

								}
								
								// Check if this file is associated with an enabled plugin
								if($removeFile == true){

									if(!is_dir($dirname."/".$file)){
										
										//$data .= '<li><b>SUB FILE: '.$dirname."/".$file."</b></li>";

										// Get file size
										$fsize = filesize($dirname.'/'.$file);



										$filesizes[] = $fsize;
										
										// Report task outcome
										$data .= '<li>Removed File: '.$relname.'/'.$file.' ('.format_size($fsize).')</li>';

										// Test task or carry it out
										if($debug == false){
											unlink($dirname."/".$file);
										}

									} else {
										// NOTE : Individual files in child folders are not looped through. They are deleted like a single file.

										// Get size of folder
										//$size = get_dir_size($dirname."/".$file);
										//$filesizes[] = $size;

										// Report task outcome
										//$data .= '<li>Removed Folder: '.$relname.'/'.$file.' ('.format_size($size).')</li>';
										$data .= '<li>Cleaned Folder: '.$relname.'/'.$file.'</li>';

										delete_directory($debug, $dirname.'/'.$file, $wolfpath, $data, $filesizes, $safelist, $protected, $start, $end, $cssdata);
									}

								}

							}

						}

					}

					// Check if folder contains files or folders to protect
					if(strpos(implode(' ', prefix_safelist($safelist)), $dirname) !== false){
						$protected = ' Protected Contents';

						// Folder contains some unprotected files
						if(count(array_diff($collected, prefix_safelist($safelist))) > 0){

							// Report task outcome
							//$data .= '<li>Cleaned Folder: '.$relname." (".format_size($size).")</li>";

						}

					} else {
						//$filesizes[] = $size;
						if($size > 0){

							closedir($dir_handle);

							// Report task outcome (use child folder and file reporting for most accurate sizes)
							//$data .= '<li>Removed Folder: '.$relname." (".format_size($size).")</li>";
							//$data .= '<li>Removed Folder: '.$relname."</li>";
							
							// Test task or carry it out
							if($debug == false){
								rmdir($dirname);
							}

						}


					}

					
				}

				//$data .= 'Test Finished. ';


			} 

			return $data;

		}
}




if(!function_exists('cleanCMS')){
function cleanCMS($mode='test'){
	$cleanlist = Plugin::getSetting('cleanlist', 'cleaner');
	$protectlist = Plugin::getSetting('protectlist', 'cleaner');
	$debug = Plugin::getSetting('debugmode', 'cleaner');

	if($cleanlist != ''){		
		//$debug = true;
		
		// Set size of minimum clean (1000 = 1KB)
		$cleanSize = 50000;

		// Determine wolf path
		// As plugins run from admin folder, excluding this folder reveals wolf root
		$lowestpath = getcwd();
		$rep = str_replace('\\', '/', $lowestpath);
		$wolfpath = rtrim(str_replace('/'.ADMIN_DIR, '', $rep));

		global $filesizes;
		global $deletelist;
		global $safelist;
		global $datalist;
		global $value;
		global $data;
		global $lis;
		global $size;
		global $spacesaved;
		global $stopdelete;

		$filesizes = array();
		$spacesaved = 0;

		$deletelist = explode("\n", $cleanlist);
		$safelist = explode("\n", $protectlist);
		$data = ''; $lis = ''; $thedata = ''; $thedata = ''; $datalist = ''; $stopdelete = '';
		sort($deletelist);
		sort($safelist);

		
		// Get home page
		$fullURL = !empty($_SERVER['HTTPS']) == 'on' ? 'https://' : 'http://';
		$fullURL .= $_SERVER['SERVER_PORT'] != '80' ? $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"] : $_SERVER['SERVER_NAME'];
		$home = $fullURL;
		$dom = new DOMDocument();
		@$dom->loadHTMLFile($home);
		$xpath = new DOMXPath($dom);
		$stylesheets = $xpath->query('/html/head/link[@rel="stylesheet"]');
		$cssfiles = array();
		$cssdata = '';
		foreach($stylesheets as $stylesheet){
			//$css = $dom->saveHtml($stylesheet);
			$href = $stylesheet->getAttribute('href');
			$href = strtok($href, '?');
			// Check local/relative stylesheets
			if(!stristr($href, '//') || stristr($fullURL, $_SERVER["SERVER_NAME"])){
				$cssfiles[] = $href;
				// Collect CSS data from home page stylesheets (not including @media and includes commented fonts)
				$cssdata .= file_get_contents($wolfpath.'/'.ltrim($href,'/'));
				//$datalist .= '<li>CSS: '.$href.'</li>';
			}
		}


		// Start timer
		$start = time();
		// Server time out
		$maxtime = ini_get('max_execution_time');
		// Seconds for timeout (set a second or two lower than server)
		$end = (time() + 10);
		foreach ($deletelist as $value) {

			//echo '<b>Mode:</b> ' . $mode . '<br/>';
			//echo '<b>Time:</b> ' . (time() - $start) . ' <b>Start:</b> ' . $start . ' <b>End:</b> ' . $end . ' <br/>';

			// Ensure script finishes executing before server time out (or check if anything needs cleaning)
			//if((time() - $start) < $end){
			if(($mode != 'check' && (time() - $start) < $end) || ($mode == 'check' && $datalist == '')){

				//echo '<b>Deletelist Value:</b> ' . $value . '<br/>';

				//$datalist .= file_path($value).'<br/>';
				$datalist .= delete_directory($debug, file_path($value), $wolfpath, '', $filesizes, $safelist, '', $start, $end, $cssdata);
			}
		}

		foreach ($filesizes as $value) {
			$spacesaved = $spacesaved + $value;
		}


		//echo '<b>Datalist:</b> ' . $datalist . '<br/>';		
		//exit;	


		if($datalist != ''){

			if($mode == 'check'){

				// Is there over enough to clean?
				if($spacesaved > $cleanSize){
					return true;
				}

			} else {
				$saved = '';

				// Is there over enough to clean?
				if($spacesaved > $cleanSize){
					$saved = format_size($spacesaved);
				}
	

				if($stopdelete != ''){
					// Test task or carry it out
					if($debug == false){
						// Is there over 500KB to clean?
						if($spacesaved > $cleanSize){
							$thedata .= '<h2>Cleaned '.$saved.'</h2>';
							$thedata .= '<p>Want to clean more? <a href="'.URL_PUBLIC.ADMIN_DIR.'/plugin/cleaner/clean">Continue Cleaning</a></p>';
						}
					}
				}

				// Is there enough to clean?
				if($spacesaved > $cleanSize){

					if(!stristr($thedata, '<h2>')){
						$thedata .= '<h2>Cleaned '.$saved.'</h2>';
					}
					$thedata .= "<ul>\n";
					$thedata .= $datalist;
					$thedata .= "</ul>\n";

				} else {

					if(!stristr($thedata, '<h2>')){
						$thedata .= '<h2>Clean</h2>';
						$thedata .= '<p>No cleaning is required.</p>';
					}

				}

				echo $thedata;

			}


		} else {

			if($mode != 'check'){
				echo '<h2>Clean</h2>';
				echo '<p>No cleaning is required.</p>';
			}

		}

	}

}
}