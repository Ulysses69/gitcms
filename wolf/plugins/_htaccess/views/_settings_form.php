<?php

//$htaccess = Plugin::getSetting('htaccess', 'htaccess');
//$htaccessbackup = Plugin::getSetting('htaccessbackup', 'htaccess');
$htaccessdefault = Plugin::getSetting('htaccessdefault', 'htaccess');
$wwwredirect = Plugin::getSetting('wwwredirect', 'htaccess');

$htaccessfile = $_SERVER{'DOCUMENT_ROOT'}.'/.htaccess';
$htaccess = file_get_contents($htaccessfile);
$htaccess = preg_replace("/(\s\s){1,}/","\n",trim($htaccess));

$htaccessbackupfile = $_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/_htaccess/backups/.htaccess.bak';
$htaccessbackup = file_get_contents($htaccessbackupfile);
$htaccessbackup = preg_replace("/(\s\s){1,}/","\n",trim($htaccessbackup));

?>

<br />

<form action="<?php echo get_url('plugin/_htaccess/save_settings'); ?>" method="post">



	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Settings'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">

	  		<tr>
				<td class="label"><label for="awwwredirect">WWW Redirect</label></td>
				<td class="field">
				<select name="wwwredirect" id="awwwredirect">
				<?php
				$wwwredirect_array = array(
				array ('Enabled', 'true'),
				array ('Disabled', 'false'));
				foreach($wwwredirect_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $wwwredirect){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help">Should www be prefixed to pages</td>
			</tr>
			
		</table>
	</fieldset>


	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Configuration'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">

			<tr>
				<td class="label"><label for="htaccess"><?php echo __('Current'); ?></label></td>
				<td class="field">
				<textarea name="htaccess" id="htaccess" style="height:160px"><?php echo $htaccess; ?></textarea>
				</td>
			</tr>

			<tr>
				<td class="label"><label for="htaccessbackup"><?php echo __('Backup'); ?></label></td>
				<td class="field">
				<textarea name="htaccessbackup" id="htaccessbackup" style="color:#666;height:160px" readonly="readonly"><?php echo $htaccessbackup; ?></textarea>
				</td>
			</tr>

			<tr>
				<td class="label"><label for="htaccessdefault"><?php echo __('Default'); ?></label></td>
				<td class="field">
				<textarea name="htaccessdefault" id="htaccessdefault" style="color:#666;height:160px" readonly="readonly"><?php echo $htaccessdefault; ?></textarea>
				</td>
			</tr>

		</table>
	</fieldset>

	<p class="buttons">
		<input class="button" id="site-save-page" name="commit" title="Save then close" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
		<a href="<?php echo get_url('plugin/product'); ?>"  id="site-cancel-page" class="button" title="Close without saving"><?php echo __('Cancel'); ?></a>
	</p>

</form>