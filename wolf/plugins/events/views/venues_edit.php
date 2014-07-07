<h2><?php echo __('Add/Edit Venue'); ?></h2>

<h3><?php echo __('Venue'); ?></h3>

<?php if (!$venue): ?>

	<p>Invalid Venue. Return to <a href="<?php echo get_url('plugin/events/venues'); ?>">a listing of Venues</a>.</p>
	
<?php else: ?>

	<form name="venue_edit" action="<?php echo get_url('plugin/events/venues_save'); ?>" method="post">
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="venue_name">Name</label></td>
				<td class="field"><input class="textbox" id="venue_name" maxlength="255" name="venue[name]" size="255" type="text" value="<?php echo h($venue->name); ?>" /></td>
				<td class="help">Required.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="venue_street">Street</label></td>
				<td class="field"><input class="textbox" id="venue_street" maxlength="255" name="venue[street]" size="255" type="text" value="<?php echo h($venue->street); ?>" /></td>
				<td class="help">Optional.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="venue_suburb">Suburb</label></td>
				<td class="field"><input class="textbox" id="venue_suburb" maxlength="255" name="venue[suburb]" size="255" type="text" value="<?php echo h($venue->suburb); ?>" /></td>
				<td class="help">Optional.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="venue_state">State</label></td>
				<td class="field"><input class="textbox" id="venue_state" maxlength="255" name="venue[state]" size="255" type="text" value="<?php echo h($venue->state); ?>" /></td>
				<td class="help">Optional.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="venue_postcode">Postcode</label></td>
				<td class="field"><input class="textbox" id="venue_postcode" maxlength="255" name="venue[postcode]" size="255" type="text" value="<?php echo h($venue->postcode); ?>" /></td>
				<td class="help">Optional.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="venue_country">Country</label></td>
				<td class="field"><input class="textbox" id="venue_country" maxlength="255" name="venue[country]" size="255" type="text" value="<?php echo h($venue->country); ?>" /></td>
				<td class="help">Optional.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="venue_link">Link</label></td>
				<td class="field"><input class="textbox" id="venue_link" maxlength="255" name="venue[link]" size="255" type="text" value="<?php echo h($venue->link); ?>" /></td>
				<td class="help">Optional.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="venue_phone">Phone</label></td>
				<td class="field"><input class="textbox" id="venue_phone" maxlength="255" name="venue[phone]" size="255" type="text" value="<?php echo h($venue->phone); ?>" /></td>
				<td class="help">Optional.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="venue_contact_name">Contact Name</label></td>
				<td class="field"><input class="textbox" id="venue_contact_name" maxlength="255" name="venue[contact_name]" size="255" type="text" value="<?php echo h($venue->contact_name); ?>" /></td>
				<td class="help">Optional.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="venue_contact_email">Contact Email</label></td>
				<td class="field"><input class="textbox" id="venue_contact_email" maxlength="255" name="venue[contact_email]" size="255" type="text" value="<?php echo h($venue->contact_email); ?>" /></td>
				<td class="help">Optional.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="venue_description">Description</label></td>
				<td class="field"><textarea id="venue_description" name="venue[description]"><?php echo h($venue->description); ?></textarea></td>
				<td class="help">Optional.</td>
			</tr>
		</table>

		<p class="buttons">
			<input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="Save then close" value="Save" />
			<a href="<?php echo get_url('plugin/events/venues'); ?>" id="site-view-page" class="button" title="Close without saving">Cancel</a>
		</p>

		<input type="hidden" name="venue[id]" value="<?php echo h($venue->id); ?>" />
	</form>

<?php endif ?>
