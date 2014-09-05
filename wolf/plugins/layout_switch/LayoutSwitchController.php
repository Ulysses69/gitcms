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
 * The layout_switch plugin serves as a basic plugin template.
 *
 * This layout_switch plugin makes use/provides the following features:
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
 * @subpackage plugin.layout_switch
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @version 1.0.0
 * @since Wolf version 0.5.5
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Martijn van der Kleijn, 2008
 */

/**
 * Use this LayoutSwitchController and this layout_switch plugin as the basis for your
 * new plugins if you want.
 */
class LayoutSwitchController extends PluginController {

	public function __construct() {
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/layout_switch/views/sidebar'));
	}

	public function index() {
		$this->documentation();
	}

	public function documentation() {
		$this->display('layout_switch/views/documentation');
	}

	function settings() {
		/** You can do this...
		$tmp = Plugin::getAllSettings('layout_switch');
		$settings = array('my_setting1' => $tmp['setting1'],
						  'setting2' => $tmp['setting2'],
						  'a_setting3' => $tmp['setting3']
						 );
		$this->display('comment/views/settings', $settings);
		 *
		 * Or even this...
		 */

		$this->display('layout_switch/views/settings', Plugin::getAllSettings('layout_switch'));
	}

}

