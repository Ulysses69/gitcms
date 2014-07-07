<h2><?php echo __('Bookings'); ?></h2>
<p class="record_add"><a href="<?php echo get_url('plugin/events/events_new'); ?>"><?php echo __('New Booking'); ?></a></p>

<?php if (count($events) == 0 ): ?>

	<p><?php echo __('There are currently no Bookings.'); ?></p>
	
<?php else: ?>
		
	<table id="users" class="index" cellpadding="0" cellspacing="0" border="0">
		<thead>
		<tr>
			<th><?php echo __('Name'); ?></th>
			<th><?php echo __('Date'); ?></th>
			<!--
			<th><?php echo __('Link'); ?></th>
			<th><?php echo __('Cost'); ?></th>
			<th><?php echo __('Description'); ?></th>
			<th><?php echo __('Category'); ?></th>
			<th><?php echo __('Attraction'); ?></th>
			<th><?php echo __('Venue'); ?></th>
			-->
			<th><?php echo __('Modify'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($events as $row): ?>
			<tr>
				<td><a class="name" href="<?php echo get_url('plugin/events/events_edit') . '/' . $row->id; ?>"><?php echo h($row->name); ?></a></td>
				<td><?php echo h(EventsUtil::format_date($row->start_date)); ?></td>
				<!--
				<td><a href="<?php echo h($row->link); ?>" target="_blank"><?php echo h($row->link); ?></a></td>
				<td><?php echo h(EventsUtil::format_currency($row->cost)); ?></td>
				<td><?php echo h(trunc($row->description)); ?></td>
				<td><a href="<?php echo get_url('plugin/events/categories_edit') . '/' . $row->category_id; ?>"><?php echo h($row->category_name()); ?></a></td>
				<td><a href="<?php echo get_url('plugin/events/attractions_edit') . '/' . $row->attraction_id; ?>"><?php echo h($row->attraction_name()); ?></a></td>
				<td><a href="<?php echo get_url('plugin/events/venues_edit') . '/' . $row->venue_id; ?>"><?php echo h($row->venue_name()); ?></a></td>
				-->
				<td>
					<a class="delete" href="<?php echo get_url('plugin/events/events_delete') . '/' . $row->id; ?>">
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
