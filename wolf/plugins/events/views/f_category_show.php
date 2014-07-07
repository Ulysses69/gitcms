<?php if (!$category): ?>

	<p>Invalid Category.</p>

<?php else: ?>

	<h1><?php echo h($category->name); ?></h1>

	<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="label">Name</td>
			<td class="field"><?php echo h($category->name); ?></td>
		</tr>
	</table>

<?php endif; ?>
