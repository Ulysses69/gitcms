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
		function delete_directory($dirname, $data = '', &$filesizes, $safelist, $protected = '', $start = 0, $end = 3, $cssdata = ''){

			if((time() - $start) < $end){
                
                $removeplugin = false;
                
                // Clean up trailing slashes
                $dirname = rtrim($dirname,"/");

                // Clean up whitespace
                $dirname = trim($dirname);

                // Relative URL
                $relname = str_replace($_SERVER{'DOCUMENT_ROOT'}, '', $dirname);
                
                // Plugin check
                if(stristr($dirname, 'wolf/plugins/')){
                    $plugindir = str_replace($_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/", '', $dirname);
                    $pluginname = explode("/", $plugindir); $plugin = $pluginname[0];
                    if(Plugin::isEnabled($plugin) != true){
                        //$data .= '<li>Plugin: '.$plugin."</li>";
                        $removeplugin = true;
                    }
                }

                if($relname != '' || $removeplugin == true){
                    $info = new SplFileInfo($dirname);
                    if (($info->getExtension() == '' || is_dir($dirname)) && !stristr($dirname,'error_log') && !stristr($dirname,'error.log') && !stristr($dirname,'README')){
                        //$data .= '<li>FOLDER: '.$dirname."</li>";
                        $dir_handle = @opendir($dirname);
                    }
                    if (!isset($dir_handle)){
                        if (file_exists($dirname)){				    
                            //$data .= '<li>FILE: '.$dirname."</li>";
                            $size = filesize($dirname);
                            if (basename($dirname) == 'error_log' || basename($dirname) == 'error.log'){

                                // Empty files
                                if($size > 0){
                                    $filesizes[] = $size;
                                    $f = @fopen($dirname, "r+");
                                    if ($f !== false){
                                        $data .= '<li>Emptied '.$relname." (FILE ".format_size($size).")</li>";
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
                                        $data .= '<li>Removed '.$relname." (FILE ".format_size($size).$protected.")</li>";
                                        //unlink($dirname);

                                    }

                                }

                            }

                            return $data;

                        } else {

                            $data .= '<li>FILE DOES NOT EXIST: '.$relname."</li>";

                        }

                    }

                    // Collect found files
                    $collected = glob($dirname.'/*');

                    // Get size of folder
                    $size = get_dir_size($dirname);

                    // Folder contains some unprotected files
                    if(count(array_diff($collected, prefix_safelist($safelist))) > 0){
                        while ($file = readdir($dir_handle)){
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
                                        $fsize = filesize($dirname);
                                        $filesizes[] = $fsize;                                        
                                        $ex = new SplFileInfo($file);
                                        
                                        // Check fonts
                                        if(stristr($dirname, 'inc/font') || $ex->getExtension() == 'eot' || $ex->getExtension() == 'woff' || $ex->getExtension() == 'ttf'){
                                            // Remove fonts if not found in collected CSS data
                                            if(!stristr($cssdata, $file)){
                                                $data .= '<li>Remove Font: '.$file.'</li>';
                                            }
                                        }                                        
                                        //unlink($dirname."/".$file);
                                    }
                                } else {
                                    delete_directory($dirname.'/'.$file, $data, $filesizes, $safelist, $protected, $start, $end, $cssdata);
                                }

                            }
                        }
                    }

                    // Check if folder contains files or folders to protect
                    if(strpos(implode(' ', prefix_safelist($safelist)), $dirname) !== false){
                        $protected = ' Protected Contents';

                        // Folder contains some unprotected files
                        if(count(array_diff($collected, prefix_safelist($safelist))) > 0){
                            $data .= '<li>Cleaned '.$relname." (FOLDER ".format_size($size).$protected.")</li>";
                        }

                    } else {
                        $filesizes[] = $size;
                        closedir($dir_handle);
                        if($size > 0){
                            $data .= '<li>Removed '.$relname." (FOLDER ".format_size($size).$protected.")</li>";
                        }
                        //rmdir($dirname);
                    }

                    
                }
                
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
                // Collect CSS data from home page stylesheets (not including @media)
                $cssdata .= file_get_contents($_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.ltrim($href,'/'));
                $datalist .= '<li>CSS: '.$href.'</li>';
            }
        }


        // Start timer
        $start = time();
		// Server time out
        $maxtime = ini_get('max_execution_time');
        // Seconds for timeout (set a second or two lower than server)
        $end = 5;
        foreach ($deletelist as $value) {
            // Ensure script finishes executing before server time out
            if((time() - $start) < $end){
                //$datalist .= file_path($value).'<br/>';            
                $datalist .= delete_directory(file_path($value), '', $filesizes, $safelist, '', $start, $end, $cssdata);
            }
		}

		foreach ($filesizes as $value) {
			$spacesaved = $spacesaved + $value;
		}        

		if($datalist != ''){
            echo '<h2>Cleaned</h2>';
			$thedata .= "<ul>\n";
			$thedata .= $datalist;
			$thedata .= "</ul>\n";
			echo $thedata;

			if($spacesaved > 0){
				echo '<h2>Space Saved</h2><p>'.format_size($spacesaved).'</p>';
			}

		}

	}

}
}