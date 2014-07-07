<?php

Plugin::setInfos(array(
	'id'			=> 'twitter',
	'title'			=> 'Twitter',
	'description'	=> 'Adds your Twitter status to your site', 
	'version'		=> '0.2.0',
	'update_url'	=> 'http://www.band-x.org/update.xml',
	'author'		=> 'Andrew Waters',
	'website'		=> 'http://www.band-x.org'
));

Plugin::addController('twitter', 'Twitter', 'administrator,developer,editor', FALSE);

// Include Functions
include('functions/twitter_js.php');
include('functions/twitter.php');