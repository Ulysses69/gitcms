<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2009 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
*/

/* Security measure */
if (!defined('IN_CMS')) {
	exit();
}

/**
 * Provides Page not found page types.
 *
 * @package plugins
 * @subpackage page_not_found
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @copyright Philippe Archambault, 2008
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 *
 * @version $Id$
 */

Plugin::setInfos(array(
		'id'		  => 'page_not_found',
		'title'	   => __('Page not found'),
		'description' => __('Provides Page not found page types.'),
		'version'	 => '1.1.0',
		'website'	 => 'http://www.wolfcms.org/',
		'update_url'  => 'http://www.wolfcms.org/plugin-versions.xml'
));

Behavior::add('page_not_found', '');
Observer::observe('page_not_found', 'behavior_page_not_found');

/**
 *
 * @global <type> $__CMS_CONN__
 */
function behavior_page_not_found() {

	$sql = 'SELECT * FROM '.TABLE_PREFIX."page WHERE behavior_id='page_not_found'";

	$stmt = Record::getConnection()->prepare($sql);
	$stmt->execute();

	$page = $stmt->fetchObject();

	if ($page) {
		$page = Page::find_page_by_uri($page->slug);


		if (is_object($page)) {
			
			/* Try and find content. Feature not finished. */
			$searchkey = substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1);
			if(Plugin::isEnabled('searchbox') == true && (strlen($searchkey) < 30 || $page->slug == 'notfound')){
				if(isset($_SERVER['HTTP_REFERER'])){ $referrer = $_SERVER['HTTP_REFERER']; } else { $referrer = ''; }
				if($referrer == ''){ $referrer = 'Error'; }
				$redirect = str_replace(URL_ABSOLUTE, URL_ABSOLUTE.'search', URL_ABSOLUTE.$_SERVER['REQUEST_URI'].'?404='.$referrer);
				//$redirect = str_replace(URL_ABSOLUTE, URL_ABSOLUTE.'search', URL_ABSOLUTE.$_SERVER['REQUEST_URI'].'?404=http://www.google.com');
				//exit;

				//header("HTTP/1.0 404 Not Found");
				//header("Status: 404 Not Found");

				header("Location: ".$redirect);
				//echo "site search for: ".$redirect;
				exit;
			}

			header("HTTP/1.0 404 Not Found");
			header("Status: 404 Not Found");


			$page->includeSnippet('registerfunctions'); // Include custom functions snippet
			if((isset($_GET['media']) && $_GET['media'] == 'contrast')){
				$page->layout_id = 12; // Force layout change, except for pages not found
				ob_start();
				$page->_executeLayout();
				$page = ob_get_contents();
				ob_end_clean();
				$page = str_replace('href="'.URL_PUBLIC, 'href="'.URL_PUBLIC.'contrast/', $page);
				$page = str_replace('contrast/mobile/','mobile/', $page);
				echo $page;
				exit();
			}
			if((isset($_GET['media']) && $_GET['media'] == 'print')){
				$page->layout_id = 5; // Force layout change, except for pages not found
				ob_start();
				$page->_executeLayout();
				$page = ob_get_contents();
				ob_end_clean();
				$page = str_replace('href="'.URL_PUBLIC, 'href="'.URL_PUBLIC.'print/', $page);
				$page = str_replace('print/mobile/','mobile/', $page);
				echo $page;
				exit();
			}
			if((isset($_GET['media']) && $_GET['media'] == 'mobile')){
				$page->layout_id = 7; // Force layout change, except for pages not found
				ob_start();
				$page->_executeLayout();
				$page = ob_get_contents();
				ob_end_clean();
				$page = str_replace('href="'.URL_PUBLIC, 'href="'.URL_PUBLIC.'mobile/', $page);
				echo $page;
				exit();
			}

			$page->_executeLayout();
			exit(); // need to exit otherwise true error page will be sent
		}
	}
}