<?php if (!$attraction): ?>

	<p>Invalid Attraction.</p>

<?php else: ?>

	<h1><?php echo h($attraction->name); ?></h1>

	<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="label">Name</td>
			<td class="field"><?php echo h($attraction->name); ?></td>
		</tr>
		<tr>
			<td class="label">Email</td>
			<td class="field"><?php echo h($attraction->email); ?></td>
		</tr>
		<tr>
			<td class="label">Phone</td>
			<td class="field"><?php echo h($attraction->phone); ?></td>
		</tr>
		<tr>
			<td class="label">Link</td>
			<td class="field"><a href="<?php echo h($attraction->link); ?>"><?php echo h($attraction->link); ?></a></td>
		</tr>
		<tr>
			<td class="label">Bio</td>
			<td class="field"><?php echo h($attraction->bio); ?></td>
		</tr>
	</table>

<?php endif; ?>
