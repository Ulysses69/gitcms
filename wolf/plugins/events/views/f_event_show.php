<?php if (!$event): ?>

	<p>Invalid Event. Return to <a href="<?php echo get_url('plugin/events/events'); ?>">a listing of Events</a>.</p>

<?php else: ?>

	<h1><?php echo h($event->name); ?></h1>

	<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="label"><label for="event_name">Name</label></td>
			<td class="field"><?php echo h($event->name); ?></td>
		</tr>
		<tr>
			<td class="label"><label for="event_start_date">Date</label></td>
			<td class="field"><?php echo h($event->start_date); ?></td>
		</tr>
		<tr>
			<td class="label"><label class="optional" for="event_link">Link</label></td>
			<td class="field"><?php echo h($event->link); ?></td>
		</tr>
		<tr>
			<td class="label"><label class="optional" for="event_cost">Cost</label></td>
			<td class="field"><?php echo h($event->cost); ?></td>
		</tr>
		<tr>
			<td class="label"><label class="optional" for="event_description">Description</label></td>
			<td class="field"><?php echo h($event->description); ?></td>
		</tr>
		<tr>
			<td class="label"><label class="optional" for="event_category_name">Category</label></td>
			<td class="field">
				<a href="<?php echo get_url("events/category/{$event->category_id}"); ?>"><?php echo h($event->category_name()); ?></a>
			</td>
		</tr>
		<tr>
			<td class="label"><label class="optional" for="event_attraction_name">Attraction</label></td>
			<td class="field">
				<a href="<?php echo get_url("events/attraction/{$event->attraction_id}"); ?>"><?php echo h($event->attraction_name()); ?></a>
			</td>
		</tr>
		<tr>
			<td class="label"><label class="optional" for="event_venue_name">Venue</label></td>
			<td class="field">
				<a href="<?php echo get_url("events/venue/{$event->venue_id}"); ?>"><?php echo h($event->venue_name()); ?></a>
			</td>
		</tr>
	</table>

<?php endif; ?>
