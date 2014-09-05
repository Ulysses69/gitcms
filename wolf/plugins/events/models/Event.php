<?php

require_once('Record.php');

class EventsEvent extends EventsRecord
{
	const TABLE_NAME = 'events_events';

	public $id;
	public $name;
	public $start_date;
	public $link;
	public $cost;
	public $description;
	public $category_id;
	public $attraction_id;
	public $venue_id;

	// ACCESSORS

	public function category_name()
	{
		$category = EventsCategory::findByIdFrom('EventsCategory', $this->category_id);
		if (!$category) {
			return null;
		}
		return $category->name;
	}

	public function attraction_name()
	{
		$attraction = EventsAttraction::findByIdFrom('EventsAttraction', $this->attraction_id);
		if (!$attraction) {
			return null;
		}
		return $attraction->name;
	}

	public function venue_name()
	{
		$venue = EventsVenue::findByIdFrom('EventsVenue', $this->venue_id);
		if (!$venue) {
			return null;
		}
		return $venue->name;
	}

	public function year()
	{
		return date('Y', strtotime($this->start_date));
	}

	public function month()
	{
		return date('m', strtotime($this->start_date));
	}

	public function day()
	{
		return date('d', strtotime($this->start_date));
	}

	// HOOKS

	public function beforeSave()
	{
		if (is_null($this->name) || is_null($this->start_date)) {
			return false;
		}
		// Create the other linked records if they are new.
		$related_models = array('category', 'attraction', 'venue');
		foreach ($related_models as $type) {
			$model_id = $type . '_id';
			$data = array(
				'name' => $this->_misc[$type . '_name'],
				);
			if (!$this->$model_id && $data['name']) {
				$record = EventsFactory::get($type, $data);
				if (!$record->save()) {
					return false;
				}
				$this->$model_id = $record->id;
			}
		}
		return true;
	}

	// QUERIES

	public static function getEventsByMonth($year, $month)
	{
		$year = intval($year);
		$month = intval($month);
		$start_date = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
		$end_date = date('Y-m-d', mktime(0, 0, 0, $month + 1, 1, $year));
		$records = self::findAllFrom('EventsEvent', 'start_date >= ? AND start_date < ?', array($start_date, $end_date));
		$events = array(
			$year => array($month => array()),
			);
		// var_dump($records); die();
		foreach ($records as $key => $event) {
			$dom = date('j', strtotime($event->start_date));
			if (!isset($events[$year][$month][$dom])) {
				$events[$year][$month][$dom] = array();
			}
			$events[$year][$month][$dom][] = $event;
		}
		return $events;
	}

	// UTILITY

	/**
	 * Sorts Event Data into an array of the form $event[$year][$month][$day].
	 */
	public static function sortEventData($event_data)
	{
		$new_events = array();
		usort($event_data, create_function('$a, $b', 'if ($a->start_date == $b->start_date) return 0; return ($a->start_date > $b->start_date) ? 1 : -1;'));
		foreach ($event_data as $event) {
			if (!isset($new_events[$event->year()])) {
				$new_events[$event->year()] = array();
			}
			if (!isset($new_events[$event->year()][$event->month()])) {
				$new_events[$event->year()][$event->month()] = array();
			}
			if (!isset($new_events[$event->year()][$event->month()][$event->day()])) {
				$new_events[$event->year()][$event->month()][$event->day()] = array();
			}
			$new_events[$event->year()][$event->month()][$event->day()][] = $event;
		}
		return $new_events;
	}

}
