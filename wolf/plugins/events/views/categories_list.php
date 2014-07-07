<h2><?php echo __('Categories'); ?></h2>
<p class="record_add"><a href="<?php echo get_url('plugin/events/categories_new'); ?>"><?php echo __('New Category'); ?></a></p>

<?php if (count($categories) == 0 ): ?>

	<p><?php echo __('There are currently no Categories.'); ?></p>
	
<?php else: ?>
		
	<table id="users" class="index" cellpadding="0" cellspacing="0" border="0">
		<thead>
		<tr>
			<th><?php echo __('Name'); ?></th>
			<th><?php echo __('Modify'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($categories as $row): ?>
			<tr>
				<td><a class="name" href="<?php echo get_url('plugin/events/categories_edit') . '/' . $row->id; ?>"><?php echo h($row->name); ?></a></td>
				<td>
					<a class="delete" href="<?php echo get_url('plugin/events/categories_delete') . '/' . $row->id; ?>">
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
