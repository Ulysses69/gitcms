<h2><?php echo __('Venues'); ?></h2>
<p class="record_add"><a href="<?php echo get_url('plugin/events/venues_new'); ?>"><?php echo __('New Venue'); ?></a></p>

<?php if (count($venues) == 0 ): ?>

	<p><?php echo __('There are currently no Venues.'); ?></p>
	
<?php else: ?>
		
	<table id="users" class="index" cellpadding="0" cellspacing="0" border="0">
	<thead>
		<tr>
			<th><?php echo __('Name'); ?></th>
			<th><?php echo __('Suburb'); ?></th>
			<th><?php echo __('State'); ?></th>
			<th><?php echo __('Link'); ?></th>
			<th><?php echo __('Contact Name'); ?></th>
			<th><?php echo __('Phone'); ?></th>
			<th><?php echo __('Contact Email'); ?></th>
			<th><?php echo __('Modify'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($venues as $row): ?>
			<tr>
				<td><a class="name" href="<?php echo get_url('plugin/events/venues_edit') . '/' . $row->id; ?>"><?php echo h($row->name); ?></a></td>
				<td><?php echo h($row->suburb); ?></td>
				<td><?php echo h($row->state); ?></td>
				<td><a href="<?php echo h($row->link); ?>" target="_blank"><?php echo h($row->link); ?></a></td>
				<td><?php echo h($row->contact_name); ?></td>
				<td><?php echo h($row->phone); ?></td>
				<td><a href="mailto:<?php echo h($row->contact_email); ?>"><?php echo h($row->contact_email); ?></a></td>
				<td>
					<a class="delete" href="<?php echo get_url('plugin/events/venues_delete') . '/' . $row->id; ?>">
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
