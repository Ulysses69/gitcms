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
?>
<div class="box help">
<!-- <h1><?php echo __('Menus'); ?></h1> -->

<h2 id="breadcrumbs">Breadcrumbs</h2>
<p>Example 1 Returns breadcrumbs with custom seperator.</p>
<code>$this->breadcrumbs('&amp;gt;')</code>

<h2 id="fullmenu">Full Menu</h2>
<p>Example 1 Displays full multi-level menu and excludes a dozen pages (expects slug values).</p>
<code>fullmenu($this,'','',array('home','accessibility','terms','privacy','copyright'))</code>
<p>Example 2 Displays full multi-level menu starting from specified level (services).</p>
<code>fullmenu($this,'services/')</code>

<h2 id="simplemenu">Simple Menu</h2>
<?php if(Plugin::isEnabled('related_pages') == true){ ?>
<p>List items are automatically selected when <a href="<?php echo get_url('plugin/help_docs/tabs#relatedpages'); ?>">related pages</a> are open.</p>
<?php } ?>
<p>Example 1 Displays top single-level menu.</p>
<code>simplemenu($this)</code>

<p>Example 2 Displays menu with ul id 'nav' and excludes pages (expects slug values) .</p>
<code>simplemenu($this,'Menu heading',array('home','accessibility','terms','privacy','copyright'),'nav')</code>

<p>Example 3 Displays menu without ul.</p>
<code>simplemenu($this,'Menu heading',array('home','accessibility','terms','privacy','copyright'),'',false)</code>

<h2 id="sidemenu">Side Menu</h2>
<p>Example 1 Displays relative multi-level menu with second level parent rather than the home page.</p>
<code>sidemenu($this)</code>

<p>Example 2 Displays relative multi-level menu and excludes second article (expects slug values).</p>
<code>sidemenu($this,'',array('my-second-article'))</code>

<h2 id="submenu">Sub Menu</h2>
<p>Example 1 Displays relative single-level menu.</p>
<code>submenu($this)</code>

<h2 id="stickymenu">Sticky menu</h2>
<p>Example 1 Returns menu of faq pages.</p>
<code>stickymenu($this,'/faq')</code>

</div>
