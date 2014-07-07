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
<!-- <h1><?php echo __('Tabs'); ?></h1> -->

<h2 id="body">body</h2>
<p>The body tab contains the main page content. A typcial example would be as follows.</p>
<code>&#60;h1&#62;Welcome to the home page&#60;/h1&#62;<br/>
&#60;p&#62;The home page has some great stuff to tell you.&#60;/p&#62;</code>

<h2 id="scripts">scripts</h2>
<p>The scripts tab contains code such as forms and snippets. A typcial example would be as follows.</p>
<code>&#60;?php contactForm(clientemail($this),clientname(),'Enquiry','Contact form',true,'text');?&#62;</code>

<h2 id="mobile">mobile</h2>
<?php if(Plugin::getSetting('enable', 'mobile_check') == true){ ?>
<p>If content is specified in the mobile tab, it will be used in place of the body tab content. A typcial example would be as follows.</p>
<code>&#60;h1&#62;Welcome to the mobile home page&#60;/h1&#62;<br/>
&#60;p&#62;The mobile home page has some great stuff to tell you.&#60;/p&#62;</code>
<?php } else { 
if(Plugin::isEnabled('mobile_check') == true){ $mobile_plugin = '<a href="'.URL_PUBLIC.ADMIN_DIR.'/plugin/mobile_check">enabled</a>'; } else { $mobile_plugin = 'enabled'; } ?>
<p>When mobile detection is <?php echo $mobile_plugin; ?>, content specified in the mobile tab, will be used in place of the body tab content.</p>
<?php } ?>

<!--
<h2 id="pagegoal">pagegoal</h2>
<p>The pagegoal tab highlights business objectives of a page and does not appear on a live site</p>

<h2 id="notes">notes</h2>
<p>The notes tab summarises any ideas or features and appears on a live site until ideas are implemented and then removed from the tab.</p>

<h2 id="redirect">redirect</h2>
<p>Redirect the page to any specified URL. An example to an offsite page could be as follows.</p>
<code>http://www.bluehorizonsmarketing.co.uk</code>
-->

<?php if(!AuthUser::hasPermission('client')) { ?>
<h2 id="formbody">formbody</h2>
<p>The formbody tab is used by forms, to preceed a form with content. Content is removed once form has been submitted/sent.</p>
<code>If you would like to contact us, fill out the contact form or email your message to [email]. Please take care to write in simple and clear English including any facts that could help us to answer your question.</code>

<h2 id="thankyou">thankyou</h2>
<p>The thankyou tab is used by forms, to display content back to the user when they submit a form (in place of formbody).</p>
<code>Your question has been emailed to us and will be answered within 24 business hours. Before you go ... so that we can contact you regarding any queries, please take a moment to ensure the information you provided is correct. Your submitted information [formdata]</code>
<?php } ?>

<?php if(Plugin::isEnabled('backup_restore') == true){ ?>
<h2 id="backup">backup</h2>
<p>A backup tab is useful for temporarily making a copy of content (such as the body tab) before making changes to it.</p>
<?php } ?>

<?php if(Plugin::isEnabled('related_pages') == true){ ?>
<h2 id="relatedpages">related</h2>
<p>Returns list of pages that have been selected as related to page 11.</p>
<code>relatedmenu($this,11)</code>
<?php } ?>

</div>
