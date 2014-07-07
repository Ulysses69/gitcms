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
<!-- <h1><?php echo __('Snippets'); ?></h1> -->

<h2 id="name">Client name</h2>
<p>Example 1 Returns client name. Used in terms and emails. <a href="/<?php echo ADMIN_DIR; ?>/setting">View settings</a></p>
<code>clientname()</code>
<p>Example 2 Displays client name in title/description. <a href="/<?php echo ADMIN_DIR; ?>/setting">View snippet</a></p>
<code>[client]</code>

<h2 id="address">Client address</h2>
<p>Example 1 Displays client address. <a href="/<?php echo ADMIN_DIR; ?>/snippet/edit/18">View snippet</a></p>
<code>clientaddress($this)</code>
<p>Example 2 Displays client address  in title/description. <a href="/<?php echo ADMIN_DIR; ?>/snippet/edit/18">View snippet</a></p>
<code>[address]</code>

<h2 id="telephone">Client telephone</h2>
<p>Example 1 Displays client telephone number (eg; +44 (0)1242 236600). <a href="/<?php echo ADMIN_DIR; ?>/snippet/edit/19">View snippet</a></p>
<code>telephone($this,'telephone')</code>
<p>Example 2 Displays client telephone number in title/description. <a href="/<?php echo ADMIN_DIR; ?>/snippet/edit/19">View snippet</a></p>
<code>[telephone]</code>

<h2 id="email">Client email</h2>
<p>Example 1 Displays client email address. <a href="/<?php echo ADMIN_DIR; ?>/snippet/edit/23">View snippet</a></p>
<code>email()</code>
<p>Example 2 Displays client email address in title/description/content. <a href="/<?php echo ADMIN_DIR; ?>/snippet/edit/23">View snippet</a></p>
<code>[email]</code>

<h2 id="clientlocation">Client location</h2>
<p>Example 1 Displays client location (city/county). <a href="/<?php echo ADMIN_DIR; ?>/snippet/edit/30">View snippet</a></p>
<code>location()</code>
<p>Example 2 Displays client location in title/description. <a href="/<?php echo ADMIN_DIR; ?>/snippet/edit/30">View snippet</a></p>
<code>[location]</code>

<h2 id="hours">Client open hours</h2>
<p>Example 1 Displays client opening/closing hours. <a href="/<?php echo ADMIN_DIR; ?>/snippet/edit/28">View snippet</a></p>
<code>hours()</code>
<p>Example 2 Displays client opening/closing hours in title/description. <a href="/<?php echo ADMIN_DIR; ?>/snippet/edit/28">View snippet</a></p>
<code>hours()</code>

<h2 id="copyright">Blue Horizons copyright</h2>
<p>Example 1 Displays Blue Horizons name and backlink. <?php if(Plugin::isEnabled('copyright') == true){?><a href="/<?php echo ADMIN_DIR; ?>/plugin/copyright">View settings</a><?php } ?></p>
<code>setCopyright($this)</code>
<p>Example 2 Displays just the backlink. <?php if(Plugin::isEnabled('copyright') == true){?><a href="/<?php echo ADMIN_DIR; ?>/page/edit/59">View copyright</a><?php } ?></p>
<code>displayCopyright($this)</code>

<h2 id="analytics">Google analytics ID</h2>
<p>Example 1 Inserts analytics code (eg; UA-XXXXX-X). <a href="/<?php echo ADMIN_DIR; ?>/snippet/edit/14">View snippet</a></p>
<code>setanalytics($this)</code>

</div>
