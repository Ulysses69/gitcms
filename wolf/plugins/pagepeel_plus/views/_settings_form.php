<?php
	$pagelink		= Plugin::getSetting('pagelink', 'pagepeel_plus');
	$pagelist		= Plugin::getSetting('pagelist', 'pagepeel_plus');
?>

<form action="<?php echo get_url('plugin/pagepeel_plus/save_settings'); ?>" method="post">

	<fieldset style="padding: 0.5em;">
		<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Settings'); ?></legend>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="pagelink" id="apagelink"><?php echo __('Link URL'); ?></label></td>
				<td class="field"><input class="textbox" name="pagelink" value="<?php echo $pagelink; ?>" /></td>
				<td class="help"><?php echo __('URL for the page peel to link to.');?></td>
			</tr>
			<tr>
				<td class="label"><label for="pagelist" id="apagelist"><?php echo __('Include Pages'); ?></label></td>
				<td class="field">
				<textarea name="pagelist" id="pagelist"><?php echo $pagelist; ?></textarea>
		</td>
				<td class="help"><?php echo __('List pages by slug, seperated by line return. Use \'all\' for all pages and \'home\' for the home page.');?></td>
			</tr>
		</table>
	</fieldset>

	<p class="buttons">
		<input class="button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save');?>" />
		<?php echo __('or'); ?> <a href="<?php echo get_url('plugin/product'); ?>"><?php echo __('Cancel'); ?></a>
	</p>

</form>