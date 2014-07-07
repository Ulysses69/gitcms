<?php

class EventsCalendar
{
	/**
	 * Constructs a calendar with a set of Event data.
	 */
	public function __construct($event_data = null, $options = array())
	{
		$this->options = $options;
		$this->event_data = $event_data;
		$this->date = new DateTime();
	}

	public function getMonthCalendar()
	{
		$current_year = $this->date->format('Y');
		$current_month = $this->date->format('n');
		$current_day = $this->date->format('j');
		$days_in_month = $this->date->format('t');

		$weeks = array();
		$week = 1;
		for ($i = 1; $i <= $days_in_month; $i++) {
			$day = new DateTime("{$current_year}-{$current_month}-{$i}");
			$day_of_week = $day->format('w');
			if (!isset($weeks[$day_of_week])) {
				$weeks[$day_of_week] = array();
			}
			$weeks[$day_of_week][$week-1] = new EventsDay($day, $this->getEventData($current_year, $current_month, $i));
			if ($day_of_week == 6) {
				$week++;
			}
		}
		return $this->formatMonthCalendar($weeks);
	}

	public function formatMonthCalendar($week_data)
	{
		$rows = 5; // Four weeks in the month plus a spillover week.
		$weekdays = array();
		$s = '';
		for ($week = 1; $week <= $rows; $week++) {
			$s .= "<tr>\n";
			for ($dow = 1; $dow <= 7; $dow++) {
				$hasevents = '';
				$content = '';
				$addclass = '';
				if (isset($week_data[$dow-1][$week-1])) {
					$content = $week_data[$dow-1][$week-1]->formatEvents($this->option('mini'));
					// Check that there are events for this day.
					if(strlen($content) > 2){ $hasevents .= ' event'; }
					$addclass = ' class="date'.$hasevents.'"';
					// Store the day of the month in the correct week day.
					$weekdays[$dow] = $week_data[$dow-1][$week-1]->name($this->option('mini'));
				}
				$s .= '<td' . $addclass . '>' . $content . "</td>\n";
			}
			$s .= "</tr>\n";
		}
		$add_class = $this->option('mini') ? 'events-mini' : 'events-large';
		//$heading = "\n".'<h3 class="events-calendar-heading">' . date('F') . "</h3>\n";
		$wrapper = "<table class=\"events-calendar {$add_class}\">\n";
		$wrapper .= "<tr>\n";
		$wrapper .= "<th id='month' scope='col' colspan='7'>" . date('F') . "</th>\n";
		$wrapper .= "</tr>\n";
		$wrapper .= "<tr>\n";
		for ($dow = 1; $dow <= 7; $dow++) {
			$formatted_dow = $weekdays[$dow];
			$wrapper .= "<th id='" . strtolower($weekdays[$dow]) . "' scope='col'>{$weekdays[$dow]}</th>\n";
		}
		$wrapper .= "</tr>\n";
		$wrapper = $wrapper . $s . "</table>\n";
		/* $css = EventsUtil::css('frontend'); */ $css = '';
		return $css . $heading . $wrapper;
	}

	public function getEventData($year = null, $month = null, $day = null)
	{
		if (is_null($year)) {
			return $this->event_data;
		}
		if (is_null($month)) {
			if (isset($this->event_data[$year])) {
				return $this->event_data[$year];
			}
			return false;
		}
		if (is_null($day)) {
			if (isset($this->event_data[$year]) && isset($this->event_data[$year][$month])) {
				return $this->event_data[$year][$month];
			}
			return false;
		}
		if (isset($this->event_data[$year]) && isset($this->event_data[$year][$month]) && isset($this->event_data[$year][$month][$day])) {
			return $this->event_data[$year][$month][$day];
		}
		return false;
	}

	private function option($name)
	{
		if (isset($this->options[$name])) {
			return$this->options[$name];
		}
		return null;
	}
}


class EventsDay
{
	public function __construct($date, $event_data = null)
	{
		$this->date = $date;
		$this->event_data = array();
		if ($event_data) {
			$this->event_data = $event_data;
		}
	}

	public function formatEvents($mini = false)
	{
		// Day of month.
		$s = $this->date->format('j');
		if ($mini) {
			if ($this->event_data) {
				//$year = $this->date->format('Y');
				//$month = $this->date->format('m');
				//$day = $this->date->format('d');
				//$url = get_url("events/events/{$year}/{$month}/{$day}");
				//$s = "<a href=\"{$url}\">{$s}</a>";
				$s = "<a href=\"\" title=\"Booked\">{$s}</a>";
			}
			return $s;
		}
		// Each event in a list.
		//$s .= "<ul>\n";
		$url = get_url("events/event/");
		foreach ($this->event_data as $i => $event) {
			if($start != true){ $start = true; $s .= "\n<ul>\n"; }
			$addclass = '';
			if (($i + 1) == count($this->event_data)) {
				$addclass = ' class="last"';
			}
			//$s .= "<li{$addclass}><a href=\"{$url}{$event->id}\">{$event->name}</a></li>\n";
			$s .= "<li><a href=\"{$url}{$event->id}\">{$event->name}</a></li>\n";
			if($addclass != ''){ $s .= "</ul>\n"; }
		}
		//$s .= "</ul>\n";
		return $s;
	}

	public function name($short = false) {
		if ($short) {
			return $this->date->format('D');
		}
		return $this->date->format('l');
	}
}
