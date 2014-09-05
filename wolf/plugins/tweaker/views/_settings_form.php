<form action="<?php echo get_url('plugin/tweaker/save_settings'); ?>" method="post">

	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Public Settings'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="urlpublic"><?php echo __('Public URL'); ?></label></td>
				<td class="field">
				<select name="urlpublic" id="urlpublic">
				<?php
				$url_array = array(
				array ('Relative', '/'),
				array ('Default', URL_PUBLIC));
				foreach($url_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $urlpublic){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Enable relative links/paths to speed up your site.');?></td>
			</tr>
			<!--
		<tr>
				<td class="label"><label for="sitemapbreak"><?php echo __('Sitemap Break'); ?></label></td>
				<td class="field">
				<input name="sitemapbreak" id="sitemapbreak" value="<?php echo $sitemapbreak; ?>" />
				</td>
				<td class="help"><?php echo __('Set point to break generated sitemap.');?></td>
			</tr>
			-->
		</table>
	</fieldset>

	<br />

	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Admin Settings'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<tr>
				<td class="label"><label for="autometa"><?php echo __('Auto-generate meta'); ?></label></td>
				<td class="field">
				<select name="autometa" id="autometa">
				<?php
				$autometa_array = array(
				array ('True', 'true'),
				array ('False', 'false'));
				foreach($autometa_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $autometa){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Set whether slug and breadcrumb should be auto-generated from title.');?></td>
			</tr>

			<tr>
				<td class="label"><label for="plugindescriptions"><?php echo __('Plugin descriptions'); ?></label></td>
				<td class="field">
				<select name="plugindescriptions" id="plugindescriptions">
				<?php
				$plugindescriptions_array = array(
				array ('Visible', 'true'),
				array ('Hidden', 'false'));
				foreach($plugindescriptions_array as $subarray) {
					list($text, $val) = $subarray;
					if($val == $plugindescriptions){
						echo "<option value=\"$val\" selected>$text</option>";
					} else {
						echo "<option value=\"$val\">$text</option>";
					}
				}
				?>
				</select>
				</td>
				<td class="help"><?php echo __('Toggle visibility of plugin descriptions.');?></td>
			</tr>

		</table>
	</fieldset>

	<p class="buttons">
		<input class="button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
		<?php echo __('or'); ?> <a href="<?php echo get_url('plugin/product'); ?>"><?php echo __('Cancel'); ?></a>
	</p>

</form>