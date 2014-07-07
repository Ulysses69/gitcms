<?php

require_once(dirname(__FILE__) . '/../models/Category.php');
require_once(dirname(__FILE__) . '/../models/Attraction.php');
require_once(dirname(__FILE__) . '/../models/Venue.php');
require_once(dirname(__FILE__) . '/../models/Event.php');

class EventsFactory
{
	public static function get($type, $data = array())
	{
		switch ($type) {
			case 'category':
				return new EventsCategory($data);
			case 'event':
				return new EventsEvent($data);
			case 'attraction':
				return new EventsAttraction($data);
			case 'venue':
				return new EventsVenue($data);
			default:
				die("Events: Invalid class: {$type}.");
		}
	}
}
