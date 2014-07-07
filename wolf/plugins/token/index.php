<?php

/*
 * Token - Wolf CMS URL token plugin
 *
 * Copyright (c) 2012 Steven Henderson
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 *
 */

if (!defined('TOKEN_VERSION')) { define('TOKEN_VERSION', '0.2'); }
Plugin::setInfos(array(
    'id'          => 'token',
    'title'       => 'Token',
    'description' => 'Use placeholders to insert text such as [email].',
    'version'     => TOKEN_VERSION,
   	'license'     => 'MIT',
	'author'      => 'Steven Henderson'
));

//Behavior::add('page_not_found', '');
// Observer::observe('page_requested', 'token_catch_token');


AutoLoader::addFolder(dirname(__FILE__) . '/models');
if(Plugin::isEnabled('dashboard') == true){
	Plugin::addController('token', 'Tokens', 'administrator', false);
} else {
	Plugin::addController('token', 'Tokens', 'administrator', true);
}
//Plugin::addJavascript('token', 'js/jquery.scrollTo-min.js');

