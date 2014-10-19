<br />

<?php
$display = Plugin::getSetting('display', 'social');
$icon_set = Plugin::getSetting('icon_set', 'social');
$appearance = Plugin::getSetting('appearance', 'social');
$facebook_URL = Plugin::getSetting('facebook_URL', 'social');
$twitter_URL = Plugin::getSetting('twitter_URL', 'social');
$linkedin_URL = Plugin::getSetting('linkedin_URL', 'social');
$pinterest_URL = Plugin::getSetting('pinterest_URL', 'social');
$youtube_URL = Plugin::getSetting('youtube_URL', 'social');
$googleplus_URL = Plugin::getSetting('googleplus_URL', 'social');
$vimeo_URL = Plugin::getSetting('vimeo_URL', 'social');
$instagram_URL = Plugin::getSetting('instagram_URL', 'social');
?>

<script type="text/javascript" charset="utf-8" src="/wolf/plugins/mobile_check/js/jquery.miniColors.js"></script>
<script type="text/javascript" charset="utf-8" src="/wolf/plugins/mobile_check/js/jquery.cookie.js"></script>
<link type="text/css" rel="stylesheet" href="/wolf/plugins/mobile_check/js/jquery.miniColors.css" />
<script type="text/javascript" charset="utf-8" src="/wolf/plugins/mobile_check/js/scripts.js"></script>

<form action="<?php echo get_url('plugin/social/save_settings'); ?>" method="post">

	<fieldset style="padding: 0.5em 1.5em !important;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Social'); ?></legend>		
 
		<?php
        $icon_set_array = array();
        if ($handle = opendir($_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/social/icons/')) {
            $blacklist = array('.', '..','.DS_Store','Thumbs.db');
            while (false !== ($file = readdir($handle))) {
                if (!in_array($file, $blacklist)) {
                    $icon_set_array[] = array(ucfirst($file), $file);
                }
            }
            closedir($handle);
        }?>        
    
        <fieldset style="padding: 0.5em;">
			<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Social Icons'); ?></legend>
			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">

			<tr>
				<td class="label"><label for="display"><?php echo __('Display'); ?></label></td>
				<td class="field display"><input type="checkbox" name="display" id="display" value="show" class="checkbox"<?php if($display == "show"){echo " checked";}?>/></td>
				<td class="help">Appearance of social links</td>
			</tr>
                
		<?php if(!empty($icon_set_array)){ ?>                
            <tr>
				<td class="label"><label for="aicon_set">Icon Set</label></td>
				<td class="field">
				<select name="icon_set" id="aicon_set">
				<?php                                                                                                               
				//$icon_set_array = array(
				//array ('A4', 'A4'),
				//array ('A5', 'A5'));
				foreach($icon_set_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $icon_set){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</td>
                <td class="help"></td>
			</tr>
        <?php }	?>

			<tr>
				<td class="label"><label for="appearance">Appearance</label></td>
				<td class="field">
				<select name="appearance" id="appearance">
				<?php                                                                                                               
				$appearance_array = array(
				array ('Images', 'image'),
				array ('Text', 'text'));
				foreach($appearance_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $appearance){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</td>
                <td class="help"></td>
			</tr>
			</table>
		</fieldset>
        
		<fieldset style="padding: 0.5em;">
			<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Social Links'); ?></legend>
			<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="label"><label for="facebook_URL"><?php echo __('Facebook URL'); ?></label></td>
					<td class="field"><input name="facebook_URL" id="facebook_URL" value="<?php echo htmlentities($facebook_URL); ?>" /></td>
					<td class="help"></td>
			   </tr>
				<tr>
					<td class="label"><label for="twitter_URL"><?php echo __('Twitter URL'); ?></label></td>
					<td class="field"><input name="twitter_URL" id="twitter_URL" value="<?php echo htmlentities($twitter_URL); ?>" /></td>
					<td class="help"></td>
			   </tr>
				<tr>
					<td class="label"><label for="linkedin_URL"><?php echo __('Linkedin URL'); ?></label></td>
					<td class="field"><input name="linkedin_URL" id="linkedin_URL" value="<?php echo htmlentities($linkedin_URL); ?>" /></td>
					<td class="help"></td>
			   </tr>
				<tr>
					<td class="label"><label for="pinterest_URL"><?php echo __('Pinterest URL'); ?></label></td>
					<td class="field"><input name="pinterest_URL" id="pinterest_URL" value="<?php echo htmlentities($pinterest_URL); ?>" /></td>
					<td class="help"></td>
			   </tr>
				<tr>
					<td class="label"><label for="youtube_URL"><?php echo __('Youtube URL'); ?></label></td>
					<td class="field"><input name="youtube_URL" id="youtube_URL" value="<?php echo htmlentities($youtube_URL); ?>" /></td>
					<td class="help"></td>
			   </tr>
				<tr>
					<td class="label"><label for="googleplus_URL"><?php echo __('Google+ URL'); ?></label></td>
					<td class="field"><input name="googleplus_URL" id="googleplus_URL" value="<?php echo htmlentities($googleplus_URL); ?>" /></td>
					<td class="help"></td>
			   </tr>
				<tr>
					<td class="label"><label for="vimeo_URL"><?php echo __('Vimeo URL'); ?></label></td>
					<td class="field"><input name="vimeo_URL" id="vimeo_URL" value="<?php echo htmlentities($vimeo_URL); ?>" /></td>
					<td class="help"></td>
			   </tr>
				<tr>
					<td class="label"><label for="instagram_URL"><?php echo __('Instagram URL'); ?></label></td>
					<td class="field"><input name="instagram_URL" id="instagram_URL" value="<?php echo htmlentities($instagram_URL); ?>" /></td>
					<td class="help"></td>
			   </tr>
			</table>

		</fieldset>

	</fieldset>

	<p class="buttons">
		<input class="button" id="site-save-page" name="commit" title="Save then close" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
		<a href="<?php echo get_url('plugin/product'); ?>"  id="site-cancel-page" class="button" title="Close without saving"><?php echo __('Cancel'); ?></a>
	</p>

</form>