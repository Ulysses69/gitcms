<?php

foreach ($events as $year => $months) {
	echo "<h3>{$year}</h3>\n";
	foreach ($months as $month => $days) {
		echo "<h4>{$month}</h4>\n";
		foreach ($days as $day => $event_list) {
			echo "<h5>{$day}</h5>\n";
			echo "<ul>\n";
			foreach ($event_list as $event) {
				$url = get_url('events/event/' . $event->id);
				echo "<li><a href=\"{$url}\">{$event->name}</a></li>\n";
			}
			echo "</ul>";
		}
	}
}
