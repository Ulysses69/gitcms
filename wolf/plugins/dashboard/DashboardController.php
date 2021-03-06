<?php
 
/*
* Dashboard - Frog CMS dashboard plugin
*
* Copyright (c) 2008-2009 Mika Tuupola
*
* Licensed under the MIT license:
* http://www.opensource.org/licenses/mit-license.php
*
* Project home:
* http://www.appelsiini.net/
*
*/
 
class DashboardController extends PluginController
{
	function __construct() {
		AuthUser::load();
		if (!(AuthUser::isLoggedIn())) {
			redirect(get_url('login'));
		}

		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/dashboard/views/sidebar'));
	}
 
	function index() {
		$pdo = Record::getConnection();

		if ('mysql' == $pdo->getAttribute(PDO::ATTR_DRIVER_NAME)) {
			 /* Queries for MySQL */
			$this->display('dashboard/views/index', array(
				'log_entry_today' => Record::findAllFrom('DashboardLogEntry', 'created_on > CURRENT_DATE() ORDER BY created_on DESC'),
				'log_entry_yesterday' => Record::findAllFrom('DashboardLogEntry', 'created_on > DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY) AND created_on < CURRENT_DATE() ORDER BY created_on DESC'),
				'log_entry_older' => Record::findAllFrom('DashboardLogEntry', 'created_on < DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY) AND created_on > DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH) ORDER BY created_on DESC')
			));
		} else {
			 /* Otherwise assume SQLite */
			$this->display('dashboard/views/index', array(
				'log_entry_today' => Record::findAllFrom('DashboardLogEntry', "created_on > DATE('now') ORDER BY created_on DESC"),
				'log_entry_yesterday' => Record::findAllFrom('DashboardLogEntry', "created_on > DATE('now', 'start of day', '-1 day') AND created_on < DATE('now', 'start of day') ORDER BY created_on DESC"),
				'log_entry_older' => Record::findAllFrom('DashboardLogEntry', "created_on < DATE('now', 'start of day', '-1 day') ORDER BY created_on DESC")
			));
		}
	}

	function save() {

		// Check what form is being saved
		//if(isset($_POST['cache-save-sidebar'])){
			
			//$cache = $_POST['cache-save-sidebar'];
			$cache = htmlspecialchars($_GET['funkycache']);

			
			if($cache == 'DISABLED'){
				Flash::set('success', 'Funky Cache now Enabled');
				Plugin::activate('funky_cache');
			} else {
				Flash::set('success', 'Funky Cache now Disabled');
				Plugin::deactivate('funky_cache');
			}

			/* Sidebar */
			redirect(get_url('plugin/dashboard/'));

		//}
		
	}
	
	function clear() {
		$log_entry = Record::findAllFrom('DashboardLogEntry');
		foreach ($log_entry as $entry) {
			$entry->delete();
		}
		redirect(get_url('plugin/dashboard/'));
	}
}