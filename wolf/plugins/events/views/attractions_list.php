<h2><?php echo __('Attractions'); ?></h2>
<p class="record_add"><a href="<?php echo get_url('plugin/events/attractions_new'); ?>"><?php echo __('New Attraction'); ?></a></p>

<?php if (count($attractions) == 0 ): ?>

	<p><?php echo __('There are currently no Attractions.'); ?></p>

<?php else: ?>

	<table id="users" class="index" cellpadding="0" cellspacing="0" border="0">
		<thead>
		<tr>
			<th><?php echo __('Name'); ?></th>
			<th><?php echo __('Email'); ?></th>
			<th><?php echo __('Phone No.'); ?></th>
			<th><?php echo __('Website'); ?></th>
			<th><?php echo __('Bio'); ?></th>
			<th><?php echo __('Modify'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($attractions as $row): ?>
			<tr>
				<td><a class="name" href="<?php echo get_url('plugin/events/attractions_edit') . '/' . $row->id; ?>"><?php echo h($row->name); ?></a></td>
				<td><a href="mailto:<?php echo h($row->email); ?>"><?php echo h($row->email); ?></a></td>
				<td><?php echo h($row->phone); ?></td>
				<td><a href="<?php echo $row->link; ?>" target="_blank"><?php echo h($row->link); ?></a></td>
				<td><?php echo h($row->bio); ?></td>
				<td>
					<a class="delete" href="<?php echo get_url('plugin/events/attractions_delete') . '/' . $row->id; ?>">
						<img title="<?php echo __('Delete') . " '" . h($row->name) . "'"; ?>" src="/admin/images/icon-remove.gif" alt="Remove" />
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<script>
		// Provide delete links with a prompt.
		jQuery('a.delete').click(function() {
			var name = jQuery('a.name', jQuery(this).parent().parent()).text();
			var prompt = "<?php echo __('Are you sure you want to remove'); ?> \'" + name + '\'?';
			return confirm(prompt);
		});
	</script>

<?php endif; ?>
