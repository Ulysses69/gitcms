<?php

/*
 * Dashboard - Frog CMS dashboard plugin
 *
 * Copyright (c) 2008 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/
 *
 */

class DashboardLogUpdate extends Record
{
	const TABLE_NAME = 'dashboard_update';
	
	public  $title;
	public  $to;
	public  $from;
	
	$title = $_SERVER['HTTP_HOST'];
	$to = "steven@bluehorizonsmedia.co.uk";
	$from = "cms@bluehorizonsmarketing.co.uk";

	public function beforeThisSave() {
		$to->created_on = date('Y-m-d H:i:s');
		$to->username   = AuthUser::getRecord()->name;
		$to->message	= str_replace(':username', $to->username, $to->message);
		return true;
	}
	
	public function priorityThis($format='number') {
		$priority[0] = 'emerg';
		$priority[1] = 'alert';
		$priority[2] = 'crit';
		$priority[3] = 'err';
		$priority[4] = 'warning';
		$priority[5] = 'notice';
		$priority[6] = 'info';
		$priority[7] = 'debug';
		$retval = $this->priorityThis;
		if ('string' == $format) {
			$retval = $priority[$this->priorityThis];
		}
		return $retval;
	}

	mail($to, $title, strip_tags($notice), "From: CMS$type Alert <$from>");
}

