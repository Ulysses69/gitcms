
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>

		<!-- required plugins -->
		<script type="text/javascript" src="scripts/date.js"></script>
		<!--[if lt IE 7]><script type="text/javascript" src="/wolf/plugins/events/js/jquery.bgiframe.min.js"></script><![endif]-->
		
		<!-- jquery.datePicker.js -->
		<script type="text/javascript" src="/wolf/plugins/events/js/jquery.datePicker.js"></script>
		
		<!-- datePicker required styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="/wolf/plugins/events/css/datePicker.css">


<script type="text/javascript" charset="utf-8">
$(function(){
$('#event_start_date').datePicker({autoFocusNextInput: true});
});
</script>



<h2><?php echo __('Add/Edit Booking'); ?></h2>

<h3><?php echo __('Bookings'); ?></h3>

<?php if (!$event): ?>

	<p>Invalid Booking. Return to <a href="<?php echo get_url('plugin/events/events'); ?>">a listing of Bookings</a>.</p>

<?php else: ?>

	<form name="event_edit" action="<?php echo get_url('plugin/events/events_save'); ?>" method="post">
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="label"><label for="event_name">Name</label></td>
				<td class="field"><input class="textbox" id="event_name" maxlength="255" name="event[name]" size="255" type="text" value="<?php echo h($event->name); ?>" /></td>
				<td class="help">Required.</td>
			</tr>
			<tr>
				<td class="label"><label for="event_start_date">Date</label></td>
				<td class="field"><input class="textbox" id="event_start_date" maxlength="255" name="event[start_date]" size="255" type="text" value="<?php echo h($event->start_date); ?>" /></td>
				<td class="help">Required. <span>Format YYYY-MM-DD (with optional 24H time).</span></td>
			</tr>
			<!--
			<tr>
				<td class="label"><label class="optional" for="event_link">Link</label></td>
				<td class="field"><input class="textbox" id="event_link" maxlength="255" name="event[link]" size="255" type="text" value="<?php echo h($event->link); ?>" /></td>
				<td class="help">Optional.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="event_cost">Cost</label></td>
				<td class="field"><input class="textbox" id="event_cost" maxlength="255" name="event[cost]" size="255" type="text" value="<?php echo h($event->cost); ?>" /></td>
				<td class="help">Optional. Do not include the currency symbol.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="event_description">Description</label></td>
				<td class="field"><textarea id="event_description" name="event[description]"><?php echo h($event->description); ?></textarea></td>
				<td class="help long">Optional.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="event_category_name">Category</label></td>
				<td class="field">
					<input class="textbox" id="event_category_name" maxlength="255" name="event[category_name]" size="255" type="text" value="<?php echo h($event->category_name()); ?>" />
					<input id="event_category_id" name="event[category_id]" type="hidden" value="<?php echo h($event->category_id); ?>" />
				</td>
				<td class="help">Optional. If you enter a Category that doesn't exist, it will be created for you.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="event_attraction_name">Attraction Name</label></td>
				<td class="field">
					<input class="textbox" id="event_attraction_name" maxlength="255" name="event[attraction_name]" size="255" type="text" value="<?php echo h($event->attraction_name()); ?>" />
					<input id="event_attraction_id" name="event[attraction_id]" type="hidden" value="<?php echo h($event->attraction_id); ?>" />
				</td>
				<td class="help">Optional. If you enter an Attraction that doesn't exist, it will be created for you.</td>
			</tr>
			<tr>
				<td class="label"><label class="optional" for="event_venue_name">Venue Name</label></td>
				<td class="field">
					<input class="textbox" id="event_venue_name" maxlength="255" name="event[venue_name]" size="255" type="text" value="<?php echo h($event->venue_name()); ?>" />
					<input id="event_venue_id" name="event[venue_id]" type="hidden" value="<?php echo h($event->venue_id); ?>" />
				</td>
				<td class="help">Optional. If you enter a Venue that doesn't exist, it will be created for you.</td>
			</tr>
			-->
		</table>

		<p class="buttons">
			<input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="Save then close" value="Save" />
			<a href="<?php echo get_url('plugin/events/events'); ?>" id="site-view-page" class="button" title="Close without saving">Cancel</a>
		</p>

		<input type="hidden" name="event[id]" value="<?php echo h($event->id); ?>" />
	</form>

	<script>

	// TODO: Clear the ID when a non-selection has been made.
	function setupAC(type) {
		var data = [{id: 1, name: 'Test 1'}, {id: 2, name: 'Test 2'}];
		data = [{"id":"1","name":"Test Venue"}];
		jQuery('#event_' + type + '_name').autocomplete('<?php echo get_url('plugin/events/ajax_list/'); ?>' + type, {
			matchContains: true,
			dataType: 'json',
			cacheLength: 0,
			parse: function(data) {
				return jQuery.map(data, function(row) {
					return {
						data: row,
						value: row.name,
						result: row.name
					}
				});
			},
			formatItem: function(item) {
				return item.name;
			}
		});
		jQuery('#event_' + type + '_name').result(function(event, data, formatted) {
			// console.log('Setting #event_%s_id to %o', type, data);
			jQuery('#event_' + type + '_id').val(data.id);
			// console.log('Set #event_%s_id to %o', type, jQuery('#event_' + type + '_id').val());
		});
		jQuery('#event_' + type + '_name').change(function() {
			jQuery('#event_' + type + '_id').val('');
			// console.log('Cleared #event_%s_id');
		});
	}

	jQuery(document).ready(function() {
		setupAC('category');
		setupAC('attraction');
		setupAC('venue');
	});

	</script>

<?php endif; ?>