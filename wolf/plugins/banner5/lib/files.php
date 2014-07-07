<?php

function banner5files($bannerpath, $bannerimages, $format='table'){
	$files = '';
	$filespath = $bannerimages;
	$thumbs = 0;

	// Define the full path to your <span class="posthilit">folder</span> from root
	$path = $bannerpath; $count = 0;

	// Open the <span class="posthilit">folder</span>
	$dir_handle = @opendir($path) or die("Unable to open $path");

	$removepulbic = str_replace('/public','',$bannerimages); $bannerimages = "/".ADMIN_DIR."/plugin/file_manager/view".$removepulbic;
	// Loop through the <span class="posthilit">files</span>
	while ($file = readdir($dir_handle)) {
		if($file == "." || $file == ".." || $file == '_thumbs' || $file == '.svn' || $file == 'Thumbs.db'){
  			continue;
		}
  		$count++;
		if($format == 'xml'){
			$files .= "<img src=\"".$file."\" title=\"\" description=\"\" />";
		} else if ($format == 'images') {
			$thisfile = $_SERVER['DOCUMENT_ROOT'].Plugin::getSetting('bannerimages', 'banner5').'_thumbs/_'.$file;
			if(file_exists($thisfile)){
				// Thumb exists, all good
			} else {
				// Thumb doesn't exist, count how many
				$thumbs++;
			}
			$files .= "<a href=\"$bannerimages"."$file\"><img src=\"".Plugin::getSetting('bannerimages', 'banner5').'_thumbs/_'.$file."\" alt=\"$file\" /></a>";
		} else if ($format == 'comma') {
			$files .= $file.",";
		} else {
			$files .= "<tr><td>$count.</td><td><a href=\"$bannerimages"."$file\">$file</a></td></tr>\n";
		}
	}

	if ($format == 'images' && $thumbs > 0) {
		Plugin::getSetting('bannerimages', 'banner5');
		$path = str_replace('/public','',Plugin::getSetting('bannerimages', 'banner5'));
		//$path = Plugin::getSetting('bannerimages', 'banner5');
		$files .= "<p>Auto-enable previews here, by simply browsing <b>".$path."</b> in the image browser (you can access this by inserting/selecting an image <span style=\"position:absolute;margin-top:-2px;overflow:hidden;width:20px;height:20px;background:url('/wolf/plugins/tinymce/tinymce/jscripts/tiny_mce/themes/advanced/img/icons.gif') no-repeat -380px 0\"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; from the editor of any page, then selecting the browse icon <span style=\"position:absolute;margin-top:-2px;overflow:hidden;width:20px;height:20px;background:url('/wolf/plugins/tinymce/tinymce/jscripts/tiny_mce/themes/advanced/img/icons.gif') no-repeat -860px 0\"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;).</p>";
	}

	if($count > 0){
		if($format == 'xml'){
			$data = "<album thumbnail=\"\" title=\"\" description=\"\" imagePath=\"".$filespath."\" thumbnailPath=\"\">".$files."</album>";
		} else if ($format == 'comma'){
			$data = $files;
		} else {
			$data = '<table class="fieldset" cellpadding="0" cellspacing="0" border="0">'.$files."</table>\n";
		}
	} else {
		$data = '<p>Find images.</p>';
	}
	
   	closedir($dir_handle);
   	return $data;

}
 
?>