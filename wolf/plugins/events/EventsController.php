<?php

class EventsController extends PluginController
{

	private $title;

	public function __construct()
	{
		$this->title = __('Event');
		if (defined('CMS_BACKEND')) {
			define('LEAPFROG_VIEWS_BASE', 'events/views');
			$this->setLayout('backend');
		} else {
			define('LEAPFROG_VIEWS_BASE', '../../plugins/events/views');
			$page = $this->findByUri(Plugin::getSetting('frontpage', 'events'));
			$layout_id = $this->getLayoutId($page);
			$layout = Layout::findById($layout_id);
			$this->setLayout($layout->name);
		}
		$this->assignToLayout('sidebar', new View('../../plugins/events/views/sidebar'));
	}
	
	private function findByUri($uri)
	{
		if (function_exists('find_page_by_uri')) {
			// Frog
			return find_page_by_uri($uri);
		}
		// Wolf
		return Page::findByUri($uri);
	}

	private function getLayoutId($page)
	{
		$page->includeSnippet('registerfunctions'); // Include custom functions snippet
		if ($page->layout_id) {
			return $page->layout_id;
		} else if ($page->parent) {
			return $this->getLayoutId($page->parent);
		} else {
			exit ('You need to set a layout!');
		}
	}

	public function title()
	{
		return $this->title;
	}

	public function content($part = false, $inherit = false)
	{
		if (!$part) {
			return $this->content;
		} else {
			return false;
		}
	}

	public function find($args = null)
	{
		return $this->findByUri(Plugin::getSetting('frontpage', 'events'));
	}

	public function index()
	{
		$this->events();
	}

	// CRUD

	public function ajax_list($type)
	{
		$search = '';
		if (isset($_GET['q'])) {
			$search = Record::getConnection()->quote($_GET['q']);
			$search = substr($search, 1, -1); // Strip quotes.
		}
		$class = 'Events' . ucfirst($type);
		$where = "name LIKE '%{$search}%'";
		$records = call_user_func("{$class}::findAllFrom", $class, $where);
		$ajax_records = array();
		foreach ($records as $r) {
			$ajax_records[] = array('id' => $r->id, 'name' => $r->name);
		}
		header('Content-type: application/json');
		echo json_encode($ajax_records);
		die();
	}

	public function record_list($type, $display = true)
	{
		$p_type = pluralise($type);
		$class = 'Events' . ucfirst($type);
		$records = call_user_func("{$class}::findAllFrom", $class);
		if (!$display) {
			return $records;
		}
		$this->display(LEAPFROG_VIEWS_BASE . "/{$p_type}_list", array($p_type => $records));
	}

	public function record_new($type)
	{
		$data = Flash::get('post_data');
		$record = EventsFactory::get($type, $data);
		$p_type = pluralise($type);
		$this->display(LEAPFROG_VIEWS_BASE . "/{$p_type}_edit", array($type => $record));
	}

	public function record_edit($type, $id)
	{
		$data = Flash::get('post_data');
		$record = EventsFactory::get($type, $data);
		$class = 'Events' . ucfirst($type);
		if (empty($data)) {
			$record = call_user_func("{$class}::findByIdFrom", $class, $id);
		}
		$p_type = pluralise($type);
		$this->display(LEAPFROG_VIEWS_BASE . "/{$p_type}_edit", array($type => $record));
	}

	public function record_save($type)
	{
		$data = EventsRecord::nuller($_POST[$type]);
		$record = EventsFactory::get($type, $data);
		$p_type = pluralise($type);
		if (!$record->save()) {
			if (defined('DEBUG') && DEBUG) {
				echo "Could not save:\n";
				var_dump($record->getQueryLog());
				var_dump($data);
				echo mysql_error();
				die();
			}
			Flash::set('error', ucfirst($type) . " '{$record->name}' could not be saved.");
			Flash::set('post_data', $data);
			if ($record->id) {
				redirect_to(get_url("plugin/events/{$p_type}_edit/" . $record->id));
			}
			redirect_to(get_url("plugin/events/{$p_type}_new"));
		}
		Flash::set('success', ucfirst($type) . " '{$record->name}' saved successfully.");
		redirect_to(get_url("plugin/events/{$p_type}"));
	}

	public function record_delete($type, $id)
	{
		$class = 'Events' . ucfirst($type);
		$record = call_user_func("{$class}::findByIdFrom", $class, $id);
		$record->delete();
		Flash::set('success', ucfirst($type) . " '{$record->name}' deleted successfully.");
		$p_type = pluralise($type);
		redirect_to(get_url("plugin/events/{$p_type}"));
	}

	// ATTRACTIONS

	public function attractions()
	{
		$this->record_list('attraction');
	}

	public function attractions_delete($id)
	{
		$this->record_delete('attraction', $id);
	}

	public function attractions_edit($id)
	{
		$this->record_edit('attraction', $id);
	}

	public function attractions_new()
	{
		$this->record_new('attraction');
	}

	public function attractions_save()
	{
		$this->record_save('attraction');
	}

	// CATEGORIES

	public function categories()
	{
		$this->record_list('category');
	}

	public function categories_delete($id)
	{
		$this->record_delete('category', $id);
	}

	public function categories_edit($id)
	{
		$this->record_edit('category', $id);
	}

	public function categories_new()
	{
		$this->record_new('category');
	}

	public function categories_save()
	{
		$this->record_save('category');
	}

	// VENUES

	public function venues()
	{
		$this->record_list('venue');
	}

	public function venues_delete($id)
	{
		$this->record_delete('venue', $id);
	}

	public function venues_edit($id)
	{
		$this->record_edit('venue', $id);
	}

	public function venues_new()
	{
		$this->record_new('venue');
	}

	public function venues_save()
	{
		$this->record_save('venue');
	}

	// EVENTS

	public function events()
	{
		$this->record_list('event');
	}

	public function events_delete($id)
	{
		$this->record_delete('event', $id);
	}

	public function events_edit($id)
	{
		$this->record_edit('event', $id);
	}

	public function events_new()
	{
		$this->record_new('event');
	}

	public function events_save()
	{
		$this->record_save('event');
	}

	// FRONT-END

	public function event_show($event_id)
	{
		$event = EventsEvent::findByIdFrom('EventsEvent', $event_id);
		$this->display(LEAPFROG_VIEWS_BASE . "/f_event_show", array('event' => $event));
	}

	public function events_list($year = null, $month = null, $day = null)
	{
		$this->title = __('Events');
		$where = array();
		foreach (array('year', 'month', 'day') as $timeframe) {
			if (!is_null($$timeframe)) {
				$func = strtoupper($timeframe);
				$where[] = "{$func}(start_date) = '{$$timeframe}'";
			}
		}
		$where = implode(' AND ', $where);
		$events = EventsEvent::findAllFrom('EventsEvent', $where);
		$events = EventsEvent::sortEventData($events);
		$this->display(LEAPFROG_VIEWS_BASE . "/f_events_list", array('events' => $events));
	}

	public function attraction_show($attraction_id)
	{
		$this->title = __('Attraction');
		$attraction = EventsEvent::findByIdFrom('EventsAttraction', $attraction_id);
		$this->display(LEAPFROG_VIEWS_BASE . "/f_attraction_show", array('attraction' => $attraction));
	}

	public function category_show($category_id)
	{
		$this->title = __('Category');
		$category = EventsCategory::findByIdFrom('EventsCategory', $category_id);
		$this->display(LEAPFROG_VIEWS_BASE . "/f_category_show", array('category' => $category));
	}

	public function venue_show($venue_id)
	{
		$this->title = __('Venue');
		$venue = EventsVenue::findByIdFrom('EventsVenue', $venue_id);
		$this->display(LEAPFROG_VIEWS_BASE . "/f_venue_show", array('venue' => $venue));
	}

}
