<?php

/*
 * Redirector - Wolf CMS URL redirection plugin
 *
 * Copyright (c) 2010 Design Spike
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://themes.designspike.ca/redirector/help/
 *
 */

Plugin::setInfos(array(
	'id'		  => 'redirector',
	'title'	   => 'Redirector',
	'description' => 'Provides an interface to manage redirects.',
	'version'	 => '0.1', 
   	'license'	 => 'MIT',
	'author'	  => 'Design Spike'
));

//Behavior::add('page_not_found', '');
//Observer::observe('page_requested', 'redirector_catch_redirect');
//Observer::observe('page_not_found', 'redirector_log_404');

AutoLoader::addFolder(dirname(__FILE__) . '/models');
if(Plugin::isEnabled('dashboard') == true){
	Plugin::addController('redirector', 'Redirect', 'administrator', false);
} else {
	Plugin::addController('redirector', 'Redirect');
}
//Plugin::addJavascript('redirector', 'js/jquery.scrollTo-min.js');

// redirect urls already set up
function redirector_catch_redirect(){
	$redirect = Record::findAllFrom('RedirectorRedirects', 'url = \''.$_SERVER['REQUEST_URI'].'\'');
	if(sizeof($redirect) > 0) {
		Record::update('RedirectorRedirects', array('hits' => ($redirect[0]->hits + 1)), 'id = '.$redirect[0]->id);

		header ('HTTP/1.1 301 Moved Permanently', true);
		header ('Location: '.$redirect[0]->destination);
		exit();
	}

}

// watch and log 404 errors
function redirector_log_404(){
	$redirect = Record::findAllFrom('Redirector404s', 'url = \''.$_SERVER['REQUEST_URI'].'\'');
	if(sizeof($redirect) > 0) {
		Record::update('Redirector404s', array('hits' => ($redirect[0]->hits + 1)), 'id = '.$redirect[0]->id);
	} else {
		Record::insert('Redirector404s', array('url' => $_SERVER['REQUEST_URI']));
	}
}
