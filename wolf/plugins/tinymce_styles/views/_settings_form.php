<?php

$tinymce_styles_list = Plugin::getSetting('tinymce_styles_list', 'tinymce_styles');

?>

<!-- <h2>SEO</h2> -->

<form action="<?php echo get_url('plugin/tinymce_styles/save_settings'); ?>" method="post">

<br />

	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Styles'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="tinymce_styles_list"><?php echo __('Labels'); ?></label></td>
				<td class="field">
				<textarea name="tinymce_styles_list" id="tinymce_styles_list"><?php echo $tinymce_styles_list; ?></textarea>
				</td>
				<td class="help"><?php echo __('List styles, one per line.');?></td>
			</tr>
		</table>
	</fieldset>

	<p class="buttons">
	   <input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="Save and continue" value="Save" />
		<a href="<?php echo get_url('plugin/product'); ?>" id="site-cancel-page" class="button" title="Close without saving">Cancel</a>
	</p>

</form>
