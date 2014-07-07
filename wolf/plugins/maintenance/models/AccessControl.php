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
 * @subpackage models
 *
 * @author Andrew Waters <andrew@band-x.org>
 * @version 1.1.0
 * @license http://creativecommons.org/licenses/MIT MIT License
 * @copyright band-x Media Limited, 2009 - 2010
 */

/**
 * Class MaintenanceAccessControl
 *
 * CRUD access to Whitelisted addresses and internal Settings
 *
 * @since Maintenance version 1.1.0
 */


if(!defined('IN_CMS')) { exit(); }

class MaintenanceAccessControl extends Record {

	const TABLE_NAME = "maintenance_allowed";

	public $id;
	public $ip;
	public $name;
	public $notes;
	public $enabled;
	public $status;

	/* public function getAllowed($id=NULL) { */
	public static function getAllowed($id=NULL) {
		$conditions = ($id) ? "id='$id'" : "";
		return Record::findAllFrom('MaintenanceAccessControl', $conditions);
	}

	/* public function isAllowed($ip) { */
	public static function isAllowed($ip) {
		$resultCount = Record::countFrom('MaintenanceAccessControl', "ip='$ip' AND enabled='yes'");
		if($resultCount == 0) return FALSE;
		if($resultCount >= 1) return TRUE;
	}

	/* public function updateIpAccess($id, $status) { */
	public static function updateIpAccess($id, $status) {
		$currentAccess = Record::findOneFrom('MaintenanceAccessControl', "id='$id'");
		$currentAccess->enabled = $status;
		$currentAccess->save();
	}

	/* public function addAccess($my_POST) { */
	public static function addAccess($my_POST) {
		Record::insert('MaintenanceAccessControl', array(
			'ip' => filter_var($my_POST['ip'], FILTER_SANITIZE_STRING),
			'name' => filter_var($my_POST['name'], FILTER_SANITIZE_STRING),
			'notes' => filter_var($my_POST['notes'], FILTER_SANITIZE_STRING),
			'enabled' => filter_var($my_POST['enabled'], FILTER_SANITIZE_STRING)
		));
	}

	/* public function deleteAccess($id) { */
	public static function deleteAccess($id) {
		Record::deleteWhere('MaintenanceAccessControl', "id='$id'");
	}

	/* public function switchStatus($newStatus) { */
	public static function switchStatus($newStatus) {
		Plugin::setAllSettings(array('maintenanceMode' => $newStatus), 'maintenance');
	}

	/* public function editAccess($my_POST) { */
	public static function editAccess($my_POST) {
		$thisAccess = Record::findByIdFrom('MaintenanceAccessControl', $my_POST['id']);
		foreach($my_POST as $key=>$value) {
			$thisAccess->$key = filter_var($value, FILTER_SANITIZE_STRING);
		}
		$thisAccess->save();
	}

}