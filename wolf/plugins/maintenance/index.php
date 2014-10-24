<?php

/**
 * Maintenance Plugin <http://www.band-x.org/projects/maintenance>
 * Copyright (C) 2010, band-x Media Limited <info@band-x.org>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 * 
 * All copyright notices and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * 
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 */

/**
 * @package Maintenance
 *
 * @author Andrew Waters <andrew@band-x.org>
 * @version 1.1.0
 * @license http://creativecommons.org/licenses/MIT MIT License
 * @copyright band-x Media Limited, 2009 - 2010
 */


if(!defined('IN_CMS')) { exit(); }

Plugin::setInfos(array(
	'id'			=>	'maintenance',
	'title'			=>	'Maintenance',
	'description'   =>	'Prevent unauthorised access to a site during development and maintenance sessions.',
	'license'		=>	'MIT',
	'author'		=>	'Andrew Waters',
	'website'		=>	'http://www.band-x.org/',
	'update_url'	=>	'http://www.band-x.org/update.xml',
	'version'		=>	'1.2.1',
	'type'			=>	'both'
));

if(!AuthUser::hasPermission('client')) {
	if(Plugin::isEnabled('dashboard') == false) {
		Plugin::addController('maintenance', 'Access', 'administrator,developer,editor', TRUE);
	} else {
		Plugin::addController('maintenance', 'Access', 'administrator,developer,editor', FALSE);
	}
} else {
	Plugin::addController('maintenance', 'Access', 'client', FALSE);
}

include('models/AccessControl.php');
include('models/MaintenancePage.php');

$settings = Plugin::getAllSettings('maintenance');
//if(Plugin::isEnabled('maintenance') == true){
if(isset($settings['maintenanceMode']) && $settings['maintenanceMode'] == 'on'){
	Observer::observe('dispatch_route_found', 'maintenance_check');
	Observer::observe('page_requested', 'maintenance_check');
}
Behavior::add('Maintenance', '');



if(defined('CMS_BACKEND')) {
	Dispatcher::addRoute(array(

		'/maintenance'							=>	'/plugin/maintenance/index',
		'/maintenance/'							=>	'/plugin/maintenance/index',
		'/maintenance/add'						=>	'/plugin/maintenance/add',
		'/maintenance/edit'						=>	'/plugin/maintenance/edit',
		'/maintenance/view/:num'				=>	'/plugin/maintenance/view/$1',
		'/maintenance/delete/:num'				=>	'/plugin/maintenance/delete/$1',
		'/maintenance/access'					=>	'/plugin/maintenance/access',
		'/maintenance/access/'					=>	'/plugin/maintenance/access',
		'/maintenance/access/update/:num/:any'	=>	'/plugin/maintenance/access/update?id=$1&target=$2',
		'/maintenance/settings'					=>	'/plugin/maintenance/settings',
		'/maintenance/settings/'				=>	'/plugin/maintenance/settings',
		'/maintenance/settings/update'			=>	'/plugin/maintenance/settings/update',
		'/maintenance/settings/update/'			=>	'/plugin/maintenance/settings/update',
		'/maintenance/switchStatus/:any'		=>	'/plugin/maintenance/switchStatus/$1'

	));
}

function maintenance_check($uri=NULL) {
	
	//echo $page->id;
	//exit;

	AuthUser::load();
	$settings = Plugin::getAllSettings('maintenance');

	if($settings['maintenanceMode'] == 'on') {

		$ip = $_SERVER['REMOTE_ADDR'];
		Observer::notify('maintenance_page_requested', $uri);
		if($settings['maintenanceBackdoorStatus'] == 'on' && isset($_GET['backdoorkey']) && ($_GET['backdoorkey'] == $settings['maintenanceBackdoorKey'])) {
			//echo 'Logged In 1'; exit;
			Observer::notify('maintenance_page_bypassed', $ip, $uri);
		//} elseif(MaintenanceAccessControl::isAllowed($ip) == FALSE) {
		} elseif(MaintenanceAccessControl::isAllowed($ip) == FALSE && ($settings['maintenanceAuthorizedAccess'] == 'on' && !AuthUser::isLoggedIn())) {
			//echo 'Not Allowed'; exit;
			$uriSlug = trim($uri, '/');
			$maintenancePage = MaintenancePage::getMaintenanceURI();
			if($uriSlug != $maintenancePage || !isset($maintenancePage)) {
				//echo 'Maintenance'; exit;
				Observer::notify('maintenance_page_displayed', $uri);
				MaintenanceController::displayMaintenancePage($uri, $settings);
			}

		} else {
			//echo 'Logged In 2'; exit;
			//Observer::notify('maintenance_page_bypassed', $ip, $uri);
			Observer::notify('maintenance_page_bypassed', $ip, $uri);

			// Pass page to layout switch, otherwise layout switch is bypassed
			if(function_exists('layout_switch_check')){
				$page = Page::findByUri(str_replace(URL_SUFFIX,'',$_SERVER['REQUEST_URI']));
				layout_switch_check($page);
			}

		}

	}

	// Pass page to layout switch, otherwise layout switch is bypassed
	if(function_exists('layout_switch_check')){
		//echo 'Logged In 2'; exit;
		$page = Page::findByUri(str_replace(URL_SUFFIX,'',$_SERVER['REQUEST_URI']));
		layout_switch_check($page);
	}

}