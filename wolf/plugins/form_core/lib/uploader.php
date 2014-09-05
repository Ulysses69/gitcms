
			<fieldset id="uploader">
			<<?php echo $grouptag; ?>>Upload Photos</<?php echo $grouptag; ?>>

				<?php

				/* Include Upload and Attachment Libraries - NEW */
				//require_once('./wolf/plugins/form_core/lib/upload/upload_class.php');
				//require_once('./wolf/plugins/form_core/lib/attach/attach_mailer_class.php');

				// Check upload folder
				if(!is_dir($upload_dir)){
					$upload_error .= 'Upload folder not found: <b>'.$upload_dir.'</b> ';
				} else {
					if (!is_writable(dirname($upload_dir))) {
						$upload_error .= 'Upload folder needs writable permissions. ';
					}
				}

				// Clear folder
				$upload_files = glob($upload_dir.'*');
				foreach($upload_files as $upload_file){
					if(is_file($upload_file)){

						// Get timeout setting
						include('formSettings.php');
						if(!isset($timeout)) $timeout = 60;

						// Delete file if older than timeout
						if (filemtime($upload_file) < time() - $timeout) {
							unlink($upload_file);
						}
					}
				}
				// Filesize formatter
				if(!function_exists('filesize_formatted')){
					function filesize_formatted($upload_size){
						//$upload_size = filesize($upload_path);
						$upload_units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
						$upload_power = $upload_size > 0 ? floor(log($upload_size, 1024)) : 0;
						return number_format($upload_size / pow(1024, $upload_power), 2, '.', ',') . ' ' . $upload_units[$upload_power];
					}
				}
				if(!function_exists('format_bytes')){
					function format_bytes($a_bytes) {
					  if ($a_bytes < 1024) {
						return $a_bytes .' B';
					  } elseif ($a_bytes < 1048576) {
						return round($a_bytes / 1024, 2) .' KB';
					  } elseif ($a_bytes < 1073741824) {
						return round($a_bytes / 1048576, 2) . ' MB';
					  } elseif ($a_bytes < 1099511627776) {
						return round($a_bytes / 1073741824, 2) . ' GB';
					  } elseif ($a_bytes < 1125899906842624) {
						return round($a_bytes / 1099511627776, 2) .' TB';
					  }
					}
				}

				/*
				if(!function_exists('getNixDirSize')){
					function getNixDirSize($path) {
					  $io = popen('/usr/bin/du -ks '.$path, 'r');
					  $output = fgets($io, 4096);
					  $result = preg_split('/\s/', $output);
					  $size = $result[0]*1024;
					  pclose($io);
					  return $size;
					}
				}
				if(!function_exists('getWinDirSize')){
					function getWinDirSize($path) {
					  $f = dirname(__FILE__);
					  $obj = new COM('scripting.filesystemobject');
					  if(is_object($obj)){
						$ref = $obj->getfolder($path);
						$dir_size = $ref->size;
						$obj = null;
						return $dir_size;
					  }
					}
				}
				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
				  //This is a server using Windows
				  $upload_get_folder_size = format_bytes(getWinDirSize(dirname(__FILE__)));
				} else {
				  //This is a server not using Windows
				  $upload_get_folder_size = format_bytes(getNixDirSize(dirname(__FILE__)));
				}
				*/

				if(!function_exists('GetDirectorySize')){
					function GetDirectorySize($path){
						$bytestotal = 0;
						$path = realpath($path);
						if($path!==false){
							foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
								$bytestotal += $object->getSize();
							}
						}
						return $bytestotal;
					}
				}
				$upload_get_folder_size = format_bytes(GetDirectorySize(dirname(__FILE__)));



				// Check upload folder size
				/*
				if(stristr($upload_dir,':')){
					// Windows environment
					$upload_obj = new COM('scripting.filesystemobject');
					if(is_object($upload_obj)){
						$upload_ref = $upload_obj->getfolder($upload_dir);
						$upload_get_folder_size = $upload_ref->size;
						//echo 'Directory: '.$upload_dir.' => Size: '.filesize_formatted($upload_get_folder_size).'. ';
						$upload_obj = null;
					} else {
						$upload_error .= 'Cannot create filesystem object. ';
					}
				} else {
					// Linux environment
					$upload_io = popen('/usr/bin/du -sk ' . $upload_f, 'r');
					$upload_size = fgets($upload_io, 4096);
					$upload_size = substr($upload_size, 0, strpos ($upload_size, ' ' ));
					$upload_get_folder_size = $upload_ref->size;
					pclose($upload_io);
					//echo 'Directory: '.$upload_f. ' => Size: '.filesize_formatted($upload_get_folder_size).'. ';
				}
				*/





					
				if($upload_error != ''){
					$upload_error = '<p>'.$upload_error.'</p>';
				}

				?>

				<?php echo $upload_error; ?>
				<div>
					<label for="upload[]">Upload a photo or x-ray (if available)</label>
					<input type="file" name="upload[]" size="30">
				</div>

				<!--
				<div>
					<label for="upload[]">File 2</label>
					<input type="file" name="upload[]" size="30">
				</div>
				<div>
					<label for="upload[]">File 3</label>
					<input type="file" name="upload[]" size="30">
				</div>
				-->


				<!-- <input type="submit" name="Submit" value="Submit"> -->
				<p>To upload more than one file supply as .rar .zip or .sit</p>
				<p><small>Supported file types: <?php echo implode(' ', $upload_allowed_extensions); ?><br />Maximum file size: <?php echo filesize_formatted($upload_allowed_file_size); ?></small></p>

				<?php if(DEBUG == true){ ?>
				<!--
				<p>Attachment sender email: <?php echo $formsEmail; ?></p>
				<p>Attachment client name: <?php echo $clientname; ?></p>
				-->

				<?php } ?>


			</fieldset>
