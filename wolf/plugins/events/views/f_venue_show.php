<?php if (!$venue): ?>

	<p>Invalid Venue.</p>

<?php else: ?>

	<h1><?php echo h($venue->name); ?></h1>

	<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="label">Name</td>
			<td class="field"><?php echo h($venue->name); ?></td>
		</tr>
		<tr>
			<td class="label">Street</td>
			<td class="field"><?php echo h($venue->street); ?></td>
		</tr>
		<tr>
			<td class="label">Suburb</td>
			<td class="field"><?php echo h($venue->suburb); ?></td>
		</tr>
		<tr>
			<td class="label">State</td>
			<td class="field"><?php echo h($venue->state); ?></td>
		</tr>
		<tr>
			<td class="label">Postcode</td>
			<td class="field"><?php echo h($venue->postcode); ?></td>
		</tr>
		<tr>
			<td class="label">Country</td>
			<td class="field"><?php echo h($venue->country); ?></td>
		</tr>
		<tr>
			<td class="label">Link</td>
			<td class="field"><a href="<?php echo h($venue->link); ?>"><?php echo h($venue->link); ?></a></td>
		</tr>
		<tr>
			<td class="label">Phone</td>
			<td class="field"><?php echo h($venue->phone); ?></td>
		</tr>
		<tr>
			<td class="label">Contact Name</td>
			<td class="field"><?php echo h($venue->contact_name); ?></td>
		</tr>
		<tr>
			<td class="label">Contact Email</td>
			<td class="field"><a href="mailto:<?php echo h($venue->contact_email); ?>"><?php echo h($venue->contact_email); ?></a></td>
		</tr>
		<tr>
			<td class="label">Description</td>
			<td class="field"><?php echo h($venue->description); ?></td>
		</tr>
	</table>

<?php endif; ?>
