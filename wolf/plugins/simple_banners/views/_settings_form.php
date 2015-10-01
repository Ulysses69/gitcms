<br />

<?php
$display = Plugin::getSetting('display', 'simple_banners');
$bannercontainer = Plugin::getSetting('bannercontainer', 'simple_banners');
$bannerduration = Plugin::getSetting('bannerduration', 'simple_banners');
$images_home_FOLDER = Plugin::getSetting('images_home_FOLDER', 'simple_banners');
$images_main_FOLDER = Plugin::getSetting('images_main_FOLDER', 'simple_banners');
?>

<form action="<?php echo get_url('plugin/simple_banners/save_settings'); ?>" method="post">

	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Banners'); ?></legend>
 
		<?php
        $image_folders_array = array(array('Not set',''));
        $blacklist = array('.', '..', '.DS_Store', 'Thumbs.db', '_thumbs', 'users', 'mockup', 'favicon');
        $start_folder = '/public/images/';
        $start_path = $_SERVER{'DOCUMENT_ROOT'}.$start_folder;
        foreach(glob($start_path.'*', GLOB_ONLYDIR) as $dir) {
		    $dir = str_replace($start_path, '', $dir);
		    if (!in_array($dir, $blacklist)) {
				$image_folders_array[] = array($dir, $dir);
			}
		}
		?>

			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">

				<tr>
					<td class="label"><label for="bannercontainer"><?php echo __('Container'); ?></label></td>
					<td class="field bannercontainer"><input type="checkbox" name="bannercontainer" id="bannercontainer" value="show" class="checkbox"<?php if($bannercontainer == "show"){echo " checked";}?>/></td>
					<td class="help"><?php echo __('Add container with <strong>banner</strong> as id'); ?></td>
				</tr>

			   	<tr>
					<td class="label"><label for="display"><?php echo __('Display'); ?></label></td>
					<td class="field display"><input type="checkbox" name="display" id="display" value="show" class="checkbox"<?php if($display == "show"){echo " checked";}?>/></td>
					<td class="help"><?php echo __('Appearance of banners'); ?></td>
				</tr>

			   	<tr>
					<td class="label"><label for="bannerduration"><?php echo __('Duration'); ?></label></td>
					<td class="field">
						<select name="bannerduration" id="bannerduration">
						<?php
						$bannerduration_array = array(
						array ('3 Seconds', '3'),
						array ('4 Seconds', '4'),
						array ('5 Seconds', '5'),
						array ('6 Seconds', '6'));
						foreach($bannerduration_array as $subarray) {
							list($text, $val) = $subarray;
							if($val == $bannerduration){
								echo "<option value=\"$val\" selected>$text</option>\n";
							} else {
								echo "<option value=\"$val\">$text</option>\n";
							}
						}
						?>
						</select>
					</td>
					<td class="help">Time to display each image</td>
				</tr>

			<?php if(!empty($image_folders_array)){ ?>
	
				<tr>
					<td class="label"><label for="images_home_FOLDER"><?php echo __('Home Images Folder'); ?></label></td>
					<td class="field">
						<select name="images_home_FOLDER" id="images_home_FOLDER">
						<?php                                                                                                               
						foreach($image_folders_array as $subarray) {
							list($text, $val) = $subarray;
							if($val == htmlentities($images_home_FOLDER)){
								echo "<option value=\"$val\" selected>$text</option>\n";
							} else {
								echo "<option value=\"$val\">$text</option>\n";
							}
						}
						?>
						</select>
					</td>
					<td class="help"><?php if(htmlentities($images_home_FOLDER) != ''){ echo '<a href="'.URL_PUBLIC.ADMIN_DIR.'/plugin/file_manager/browse'.str_replace('public/', '',$start_folder).htmlentities($images_home_FOLDER).'">'.htmlentities($images_home_FOLDER).'</a>'; } ?></td>
				</tr>
				<tr>
					<td class="label"><label for="images_main_FOLDER"><?php echo __('Main Images Folder'); ?></label></td>
					<td class="field">
						<select name="images_main_FOLDER" id="images_main_FOLDER">
						<?php
						foreach($image_folders_array as $subarray) {
							list($text, $val) = $subarray;
							if($val ==htmlentities($images_main_FOLDER)){
								echo "<option value=\"$val\" selected>$text</option>\n";
							} else {
								echo "<option value=\"$val\">$text</option>\n";
							}
						}
						?>
						</select>
					</td>
					<td class="help"><?php if(htmlentities($images_main_FOLDER) != ''){ echo '<a href="'.URL_PUBLIC.ADMIN_DIR.'/plugin/file_manager/browse'.str_replace('public/', '',$start_folder).htmlentities($images_main_FOLDER).'">'.htmlentities($images_main_FOLDER).'</a>'; } ?></td>
				</tr>

        <?php }	?>

		</table>

	</fieldset>

	<p class="buttons">
		<input class="button" id="site-save-page" name="commit" title="<?php echo __('Save then close');?>" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
		<a href="<?php echo get_url('plugin/product'); ?>"  id="site-cancel-page" class="button" title="<?php echo __('Close without saving');?>"><?php echo __('Cancel'); ?></a>
	</p>

</form>