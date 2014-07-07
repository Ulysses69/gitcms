<?php

Plugin::setInfos(array(
    'id'          			=> 'gallerylist',
    'title'       			=> __('Gallery List'),
    'description' 			=> __('Gallery List.'),
    'version'     			=> '1.1.0',
    'license'     			=> 'GPL',
    'require_wolf_version' 		=> '0.5.5'
));

Behavior::add('Gallery', '');

Observer::observe('view_page_edit_tabs', 'gallerylist_view_edit');
//Observer::observe('page_edit_after_save', 'gallerylist_page_edit'); /* Conflicts with jscripts - as of adding marquee support */
Observer::observe('page_add_after_save', 'gallerylist_page_add');
Observer::observe('page_delete', 'gallerylist_page_delete');


function gallerylist_page_edit($page) {
	$page = Page::findById($page->id);

	// If setThumbs is activiated for page, then update scripts.js
    //echo 'Saved: page_edit for '.$page->slug.'<br/>';
	if(!defined('REGISTER_FUNCTIONS')){
		include('../../.RegisterFunctions');
	}
    //echo REGISTER_FUNCTIONS;
	if(stristr($page->content(),'setThumbs') || stristr($page->content('scripts'),'setThumbs')){
		echo 'setThumbs is set.';
	}
    //echo print_r($page);


	$jscriptstemplate = $_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/jscripts/lib/scripts.php';
	$jscriptsfile = $_SERVER{'DOCUMENT_ROOT'}.'/inc/js/scripts.js';

	// Read jscripts Template
	$defaultdata = file_get_contents($jscriptstemplate);

	// Remove comments array
	$regex = array(
	"`^([\t\s]+)`ism"=>'',
	"`^\/\*(.+?)\*\/`ism"=>"",
	"`([\n\A;]+)\/\*(.+?)\*\/`ism"=>"$1",
	"`([\n\A;\s]+)//(.+?)[\n\r]`ism"=>"$1\n",
	"`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism"=>"\n"
	);

	// Remove comments from jscripts Template
	$defaultdata = preg_replace(array_keys($regex),$regex,$defaultdata);
	
	// Remove whitespace
	if(!function_exists('compress')){
		function compress($css){
			return preg_replace("/\s+/", " ", $css);
		}
	}
	
	$defaultdata = compress($defaultdata);

	// Update jscripts
	chmod($jscriptsfile, 0777);

	// Server configuration file is editable.
	if(is_writable($jscriptsfile) && $defaultdata != ''){

		// Open server configuration file for writing (w) and check permissions.
		$jscriptsopen = fopen($jscriptsfile,'w');
		if($jscriptsopen && fileperms($jscriptsfile) >= 0644){

			// Update server configuration file if not empty.
			if(stristr($jscripts,'/* CMS-Generated Update')){
				$jscripts = preg_replace("//* CMS-Generated Update.*?*//ms",'',$defaultdata);
			}
			$jscripts = "/* CMS-Generated Update ".date("F j, Y, g:i a")." */\n\n".$defaultdata;
			if($jscripts != ''){
				fwrite($jscriptsopen, $jscripts);
			}

		}

		fclose($jscriptsopen);

		// Protect jscripts
		chmod($jscriptsfile, 0644);

	}

    //exit;
}
function gallerylist_page_add($page) {
}
function gallerylist_page_delete($page) {
}

function gallerylist_view_edit($page) {
	global $__CMS_CONN__;
	$sql = 'SELECT gallerylist_folder , gallerylist_name , gallerylist_group, gallerylist_sort, gallerylist_order FROM '.TABLE_PREFIX.'page WHERE id=?';
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	while ($gallerylistindex = $stmt->fetchObject()) {
		$gallerylist_folder = $gallerylistindex->gallerylist_folder;
		$gallerylist_name = $gallerylistindex->gallerylist_name;
		$gallerylist_group = $gallerylistindex->gallerylist_group;
		$gallerylist_sort = $gallerylistindex->gallerylist_sort;
		$gallerylist_order = $gallerylistindex->gallerylist_order;
	}
	
	/* Display Gallery if Page set to Gallery type */
	if($page->behavior_id == "Gallery"){

 	?>

		<div id="gallerylist-container" title="Gallery">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
		<td class="label"><label for="page_gallerylist_folder_index">Image Folder</label></td>
		<td class="field">
		<select name="page[gallerylist_folder]" id="page_gallerylist_folder_index">
		<?php
		if ($gallerylist_folder == NULL){
			$gallerylist_folder = 'follow,index';
		}

		//path to directory to scan
		$directory = $_SERVER{'DOCUMENT_ROOT'}.'/public/';
		 
		//get all files in specified directory
		$folders = glob($directory . "*");

		$url_array = array();
		//print each file name
	    if (is_dir($directory)) {
			$iterator = new RecursiveDirectoryIterator($directory);
			foreach (new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $file) {
				if (!$file->isFile() && $file->getFilename() != '_thumbs') {
					$folder = str_replace("\\", "/", $file->getPath()). '/' . $file->getFilename();
					//echo str_replace($_SERVER{'DOCUMENT_ROOT'},'',$folder).'/';
					$i = str_replace($_SERVER{'DOCUMENT_ROOT'},'',$folder).'/';
					$v = str_replace($_SERVER{'DOCUMENT_ROOT'}.'/','',$folder);
					//$v = str_replace('/',' / ',$v);
					$url_array[] = array($v, $i);
				}
			}
		}
		
		sort($url_array);

		foreach($url_array as $subarray) {
			list($text, $val) = $subarray;
			if($val == $gallerylist_folder){
				echo "<option value=\"$val\" selected>$text</option>";
			} else {
				echo "<option value=\"$val\">$text</option>";
			}
		}
		?>
		</select>
		</td>
		</tr>
		
		
		<tr>
		<td class="label"><label for="page_gallerylist_name_index">Gallery Name</label></td>
		<td class="field">
		<input name="page[gallerylist_name]" id="page_gallerylist_name_index" type="text" value="<?php echo $gallerylist_name;?>" />
		</td>
		</tr>
		
		
		<tr>
		<td class="label"><label for="page_gallerylist_group_index">Group Name</label></td>
		<td class="field">
		<input name="page[gallerylist_group]" title="" id="page_gallerylist_group_index" type="text" value="<?php echo $gallerylist_group;?>" />
		</td>
		</tr>
		
		
		<tr>
		<td class="label"><label for="page_gallerylist_sort_index">Sort by</label></td>
		<td class="field">
		<select name="page[gallerylist_sort]" id="page_gallerylist_sort_index">
		<?php
		if ($gallerylist_sort == NULL){
			$gallerylist_sort = 'ascend';
		}
		$url_array = array(
		array ("File Name", 'name'),
		array ("File Date", 'date'));
		foreach($url_array as $subarray) {
			list($text, $val) = $subarray;
			if($val == $gallerylist_sort){
				echo "<option value=\"$val\" selected>$text</option>";
			} else {
				echo "<option value=\"$val\">$text</option>";
			}
		}
		?>
		</select>
		</td>
		</tr>
		
		
		<tr>
		<td class="label"><label for="page_gallerylist_order_index">Order</label></td>
		<td class="field">
		<select name="page[gallerylist_order]" id="page_gallerylist_order_index">
		<?php
		if ($gallerylist_order == NULL){
			$gallerylist_order = 'ascend';
		}
		$url_array = array(
		array ("Ascending", 'ascend'),
		array ("Descending", 'descend'));
		foreach($url_array as $subarray) {
			list($text, $val) = $subarray;
			if($val == $gallerylist_order){
				echo "<option value=\"$val\" selected>$text</option>";
			} else {
				echo "<option value=\"$val\">$text</option>";
			}
		}
		?>
		</select>
		</td>
		</tr>
		

		</table>
		<div class="notes">
		<h2>Notes</h2>
		<p>Display gallery using following code:<br />
		<&#63;php setGallery(); &#63;></p>
		</div>
		
		
		</div>

<?php }
}


Observer::observe('page_edit_after_save', 'gallerylist_index_save');
function gallerylist_index_save($page){
	global $__CMS_CONN__;
	$gallerylist_folder = $page->gallerylist_folder;
	$gallerylist_name = $page->gallerylist_name;
	$gallerylist_group = $page->gallerylist_group;
	$gallerylist_sort = $page->gallerylist_sort;
	$gallerylist_order = $page->gallerylist_order;
	$sql = "UPDATE ".TABLE_PREFIX."page SET gallerylist_folder = '".$gallerylist_folder."' , gallerylist_name = '".$gallerylist_name."' , gallerylist_group = '".$gallerylist_group."' , gallerylist_sort = '".$gallerylist_sort."' , gallerylist_order = '".$gallerylist_order."' WHERE id=?";
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	//$__CMS_CONN__->exec($sql)
}



?>