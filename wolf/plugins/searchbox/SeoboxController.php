<?php

class SeoboxController extends PluginController {
	function __construct() {
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn()) {
			searchquery(get_url('login'));
		}
 
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/searchbox/views/sidebar'));
	}
 
	function index() {
		// load searchquerys and logged Match errors
		$data['current_searchquerys'] = Record::findAllFrom('SiteSearchQueries', 'true ORDER BY destination, url');
		$data['current_Matches'] = Record::findAllFrom('SiteSearchMatches', 'true ORDER BY hits DESC');
		
		$this->display('searchbox/views/index', $data);
	}

	function save() {

		$data = $_POST['searchquery'];

		if (empty($data['url']))
		{
			Flash::set('error', __('You have to specify a url!'));
			searchquery(get_url('plugin/searchbox/'));
		}

		if (empty($data['destination']))
		{
			Flash::set('error', __('You have to specify a destination url!'));
			searchquery(get_url('plugin/searchbox/'));
		}
		
		if ($existing_searchquery = Record::findOneFrom('SiteSearchQueries', 'url = \''.($data['url'].'\''))) {
			Record::update('SiteSearchQueries', array('url' => $data['url'], 'destination' => $data['destination']), 'url = \''.($data['url'].'\''));
		} else {
			$entry = new SiteSearchQueries($data);
			
			if ( ! $entry->save())
			{
				Flash::set('error', __('There was a problem adding your searchquery.'));
			}
			else
			{
				if ($error = Record::findOneFrom('SiteSearchMatches', 'url = \''.($data['url'].'\'')))
				{
					$error->delete();
				}

				Flash::set('success', __('Redirect has been added!'));
			}
		}

		
		searchquery(get_url('plugin/searchbox/'));
	}
	
	function remove($id) {
		// find the user to delete
		if ($searchquery = Record::findByIdFrom('SiteSearchQueries', $id))
		{
			if ($searchquery->delete())
			{
				Flash::set('success', __('Redirect has been deleted!'));
			}
			else
				Flash::set('error', __('There was a problem deleting this searchquery!'));
		}
		else Flash::set('error', __('Redirect not found!'));
		
		searchquery(get_url('plugin/searchbox/'));		
	}

	function remove_Match($id) {
		// find the user to delete
		if ($error = Record::findByIdFrom('SiteSearchMatches', $id))
		{
			if ($error->delete())
			{
				Flash::set('success', __('Match Error has been deleted!'));
			}
			else
				Flash::set('error', __('There was a problem deleting this Match error!'));
		}
		else Flash::set('error', __('Match Error not found!'));
		
		searchquery(get_url('plugin/searchbox/'));
	}

}