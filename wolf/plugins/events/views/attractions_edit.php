<h2><?php echo __('Add/Edit Attraction'); ?></h2>

<h3><?php echo __('Attraction'); ?></h3>

<?php if (!$attraction): ?>

	<p>Invalid Attraction. Return to <a href="<?php echo get_url('plugin/events/attractions'); ?>">a listing of Attractions</a>.</p>
	
<?php else: ?>


	<form name="attraction_edit" action="<?php echo get_url('plugin/events/attractions_save'); ?>" method="post">
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="attraction_name">Name</label></td>
				<td class="field"><input class="textbox" id="attraction_name" maxlength="255" name="attraction[name]" size="100" type="text" value="<?php echo h($attraction->name); ?>" /></td>
				<td class="help">Required.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="user_email">E-mail</label></td>
				<td class="field"><input class="textbox" id="attraction_email" maxlength="255" name="attraction[email]" size="255" type="text" value="<?php echo h($attraction->email); ?>" /></td>
				<td class="help">Optional.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="user_phone">Phone</label></td>
				<td class="field"><input class="textbox" id="attraction_phone" maxlength="255" name="attraction[phone]" size="40" type="text" value="<?php echo h($attraction->phone); ?>" /></td>
				<td class="help">Optional.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="user_link">Link</label></td>
				<td class="field"><input class="textbox" id="attraction_link" maxlength="255" name="attraction[link]" size="40" type="text" value="<?php echo h($attraction->link); ?>" /></td>
				<td class="help">Optional.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="user_bio">Bio</label></td>
				<td class="field"><textarea class="textbox" id="attraction_bio" name="attraction[bio]"><?php echo h($attraction->bio); ?></textarea></td>
				<td class="help">Optional.</td>
			</tr>
		</table>

		<p class="buttons">
			<input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="Save then close" value="Save" />
			<a href="<?php echo get_url('plugin/events/attractions'); ?>" id="site-view-page" class="button" title="Close without saving">Cancel</a>
		</p>

		<input type="hidden" name="attraction[id]" value="<?php echo h($attraction->id); ?>" />
	</form>

<?php endif; ?>
