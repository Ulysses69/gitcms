<?php

/**
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
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
if (!defined('IN_CMS')) { exit(); }

/**
 * The help_docs plugin serves as a basic plugin template.
 *
 * This help_docs plugin makes use/provides the following features:
 * - A controller without a tab
 * - Three views (sidebar, documentation and settings)
 * - A documentation page
 * - A sidebar
 * - A settings page (that does nothing except display some text)
 * - Code that gets run when the plugin is enabled (enable.php)
 *
 * Note: to use the settings and documentation pages, you will first need to enable
 * the plugin!
 *
 * @package wolf
 * @subpackage plugin.help_docs
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @version 1.0.0
 * @since Wolf version 0.5.5
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Martijn van der Kleijn, 2008
 */

/**
 * Use this HelpController and this help_docs plugin as the basis for your
 * new plugins if you want.
 */
class HelpDocsController extends PluginController {

	public function __construct() {
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/help_docs/views/sidebar'));
	}

	public function index() {
		$this->documentation();
	}

	public function documentation() {
		$this->display('help_docs/views/pages/documentation');
	}

	public function menus() {
		$this->display('help_docs/views/pages/menus');
	}

	public function forms() {
		$this->display('help_docs/views/pages/forms');
	}

	public function features() {
		$this->display('help_docs/views/pages/features');
	}

	public function tabs() {
		$this->display('help_docs/views/pages/tabs');
	}

	public function snippets() {
		$this->display('help_docs/views/pages/snippets');
	}

	public function clientdetails() {
		$this->display('help_docs/views/pages/clientdetails');
	}

	public function pages() {
		$this->display('help_docs/views/pages/pages');
	}

	function settings() {
		/** You can do this...
		$tmp = Plugin::getAllSettings('help_docs');
		$settings = array('my_setting1' => $tmp['setting1'],
						  'setting2' => $tmp['setting2'],
						  'a_setting3' => $tmp['setting3']
						 );
		$this->display('comment/views/settings', $settings);
		 *
		 * Or even this...
		 */

		$this->display('help_docs/views/settings', Plugin::getAllSettings('help_docs'));
	}
}