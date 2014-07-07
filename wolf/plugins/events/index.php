<?php

require_once('common/Util.php');
require_once('classes/Calendar.php');
require_once('classes/Factory.php');

Plugin::setInfos(array(
	'id'			=> 'events',
	'title'			=> 'Events',
	'description'		=> 'Provides an event management interface.',
	'version'		=> '0.1',
   	'license'		=> 'MIT',
	'require_wolf_version' => '0.6.0',
	'type'			=> 'both',
));


$plugin_id = 'events';
$tab_label = 'Calendar';
$permissions = 'administrator';
$show_tab = true;

Plugin::addController($plugin_id, $tab_label, $permissions, $show_tab);
Plugin::addJavascript($plugin_id, 'js/jquery-1.3.2.min.js');
Plugin::addJavascript($plugin_id, 'js/jquery.autocomplete.min.js');
Plugin::addJavascript($plugin_id, 'js/date.js');
Plugin::addJavascript($plugin_id, 'js/jquery.datePicker.js');

Dispatcher::addRoute(array(
	'/events/event/:num'					=> '/plugin/events/event_show/$1',
	'/events/events'						=> '/plugin/events/events_list',
	'/events/events/:num'					=> '/plugin/events/events_list/$1',
	'/events/events/:num/:num'			=> '/plugin/events/events_list/$1/$2',
	'/events/events/:num/:num/:num'		=> '/plugin/events/events_list/$1/$2/$3',
	'/events/attraction/:num'				=> '/plugin/events/attraction_show/$1',
	'/events/category/:num'				=> '/plugin/events/category_show/$1',
	'/events/venue/:num'					=> '/plugin/events/venue_show/$1',
	));

// Frontend API

// GENERIC

function events_showEvents($mini = false)
{
	$events = events_getEventsForMonth();
	$options = array('mini' => $mini);
	$cal = new EventsCalendar($events, $options);
	return $cal->getMonthCalendar();
}

// CATEGORIES

function events_getCategories()
{
	$c = new EventsController();
	return $c->record_list('category', false);
}

function events_getCategoryByName($name)
{
	$category = EventsCategory::findByNameFrom('EventsCategory', $name);
	return $category;
}

function events_getCategoryById($id)
{
	$category = EventsCategory::findByIdFrom('EventsCategory', $id);
	return $category;
}


// EVENTS

function events_getEvents($start_date = null, $end_date = null)
{

}

function events_getEventsForMonth($year = null, $month = null)
{
	if (is_null($year)) {
		$year = date('Y');
	}
	if (is_null($month)) {
		$month = date('m');
	}
	return EventsEvent::getEventsByMonth($year, $month);
}


// VENUES

function events_getVenues()
{
	$c = new EventsController();
	return $c->record_list('venue', false);
}


// ATTRACTIONS

function events_getAttractions()
{
	$c = new EventsController();
	return $c->record_list('attraction', false);
}
