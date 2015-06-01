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
<h2><?php echo __('Features');?></h2>
<p>


<ul>

<?php if(Plugin::isEnabled('clientdetails') == true){ ?>
<li><h3>Tokens (shortcuts)</h3>
	<ul>
	<li><a href="<?php echo get_url('plugin/help_docs/clientdetails#name'); ?>">Client name</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/clientdetails#address'); ?>">Client address</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/clientdetails#telephone'); ?>">Client telephone</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/clientdetails#email'); ?>">Client email</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/clientdetails#clientlocation'); ?>">Client location</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/clientdetails#hours'); ?>">Client open hours</a></li>
	<?php if(Plugin::isEnabled('clientdetails') == true){ ?>
	<?php if(!AuthUser::hasPermission('client')) { ?>
	<li><a href="<?php echo get_url('plugin/help_docs/clientdetails#copyright'); ?>">Copyright</a></li>
	<?php } ?>
	<?php } ?>
	<?php if(!AuthUser::hasPermission('client')) { ?>
	<li><a href="<?php echo get_url('plugin/help_docs/clientdetails#analytics'); ?>">Analytics</a></li>
	<?php } ?>
	</ul>
</li>
<?php } else {?>
<li><h3>Snippets</h3>
	<ul>
	<li><a href="<?php echo get_url('plugin/help_docs/snippets#name'); ?>">Client name</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/snippets#address'); ?>">Client address</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/snippets#telephone'); ?>">Client telephone</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/snippets#email'); ?>">Client email</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/snippets#clientlocation'); ?>">Client location</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/snippets#hours'); ?>">Client open hours</a></li>
	<?php if(!AuthUser::hasPermission('client')) { ?>
	<li><a href="<?php echo get_url('plugin/help_docs/snippets#copyright'); ?>">Blue Horizons copyright</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/snippets#analytics'); ?>">Analytics</a></li>
	<?php } ?>
	</ul>
</li>
<?php } ?>

<!--
<?php if(!AuthUser::hasPermission('client')) { ?>
<li><h3>Pages</h3>
	<ul>
	<li><a href="<?php echo get_url('plugin/help_docs/pages#banners'); ?>">Banner</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/pages#prices'); ?>">Prices</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/pages#events'); ?>">Events</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/pages#faq'); ?>">FAQ</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/pages#offers'); ?>">Offers</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/pages#testimonials'); ?>">Testimonials</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/pages#articles'); ?>">Articles</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/pages#news'); ?>">News</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/pages#newsletters'); ?>">Newsletters</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/pages#gallery'); ?>">Gallery</a></li>
	</ul>
</li>
<?php } ?>
-->

<li><h3>Tabs</h3>
	<ul>
	<li><a href="<?php echo get_url('plugin/help_docs/tabs#body'); ?>">body</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/tabs#scripts'); ?>">scripts</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/tabs#mobile'); ?>">mobile</a></li>
	<!--
	<li><a href="<?php echo get_url('plugin/help_docs/tabs#pagegoal'); ?>">pagegoal</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/tabs#notes'); ?>">notes</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/tabs#redirect'); ?>">redirect</a></li>
	-->
	<?php if(!AuthUser::hasPermission('client')) { ?>
	<li><a href="<?php echo get_url('plugin/help_docs/tabs#formbody'); ?>">formbody</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/tabs#thankyou'); ?>">thankyou</a></li>
	<?php } ?>
	<?php if(Plugin::isEnabled('backup_restore') == true){ ?>
	<li><a href="<?php echo get_url('plugin/help_docs/tabs#backup'); ?>">backup</a></li>
	<?php } ?>
	<?php if(Plugin::isEnabled('related_pages') == true){ ?>
	<li><a href="<?php echo get_url('plugin/help_docs/tabs#relatedpages'); ?>">related</a></li>
	<?php } ?>
	</ul>
</li>

<?php if(!AuthUser::hasPermission('client')) { ?>
<li><h3>Features</h3>
	<ul>
	<li><a href="<?php echo get_url('plugin/help_docs/features#pagetitle'); ?>">Page title</a></li>
	<?php if(Plugin::isEnabled('seobox') == true){?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#linktitle'); ?>">Link title</a></li>
	<?php } ?>
	<?php if(Plugin::isEnabled('robots') == true){ ?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#robots'); ?>">Robots</a></li>
	<?php } ?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#copyrightDate'); ?>">Copyright date</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/features#currentid'); ?>">Page identifier</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/features#pagenotes'); ?>">Page notes</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/features#currentparent'); ?>">Parent and class</a></li>
	<?php if(function_exists('pagelevel')) ?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#pagelevel'); ?>">Page level</a></li>
	<?php ; ?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#randomsnippet'); ?>">Random</a></li>
	<?php if(!function_exists('announcements')) ?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#announcements'); ?>">Announcements</a></li>
	<?php ; ?>
	<?php if(!function_exists('testimonials')) ?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#testimonials'); ?>">Testimonials</a></li>
	<?php ; ?>
	<?php if(!function_exists('facebookfeed')) ?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#facebookfeed'); ?>">Facebook Feed</a></li>
	<?php ; ?>
	<?php if(function_exists('teamitems')) ?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#team'); ?>">Team Widget</a></li>
	<?php ; ?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#pageoptions'); ?>">Page options</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/features#searchbox'); ?>">Search box</a></li>
	<?php if(Plugin::isEnabled('banner') == true){?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#banner'); ?>">Banner</a></li>
	<?php } ?>
	<?php if(function_exists('crcSrc')) ?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#crcsrc'); ?>">Parent Image</a></li>
	<?php ; ?>
	<?php if(Plugin::isEnabled('social') == true){?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#social'); ?>">Social Links</a></li>
	<?php } ?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#filelist'); ?>">File list</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/features#thumblist'); ?>">Thumbnail list / gallery</a></li>
	<?php if(function_exists('randomsrc')) ?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#randomsrc'); ?>">Random image</a></li>
	<?php ; ?>
	<?php if(function_exists('simplebanner')) ?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#simplebanner'); ?>">Simple Banner</a></li>
	<?php ; ?>
	<li><a href="<?php echo get_url('plugin/help_docs/features#newsitems'); ?>">News Items</a></li>
	</ul>
</li>
<li><h3>Navigation</h3>
	<ul>
	<li><a href="<?php echo get_url('plugin/help_docs/menus#breadcrumbs'); ?>">breadcrumbs()</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/menus#fullmenu'); ?>">fullmenu()</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/menus#simplemenu'); ?>">simplemenu()</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/menus#sidemenu'); ?>">sidemenu()</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/menus#submenu'); ?>">submenu()</a></li>
	<li><a href="<?php echo get_url('plugin/help_docs/menus#stickymenu'); ?>">stickymenu()</a></li>
	</ul>
</li>
<li><h3>Forms</h3>
	<ul>
	<?php if((AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('client')) || (AuthUser::hasPermission('client') && Page::findById(27)->status_id != 1)){ ?><li><a href="<?php echo get_url('plugin/help_docs/forms#appointmentForm'); ?>">Appointment Request</a></li><?php } ?>
	<?php if((AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('client')) || (AuthUser::hasPermission('client') && Page::findById(28)->status_id != 1)){ ?><li><a href="<?php echo get_url('plugin/help_docs/forms#callbackForm'); ?>">Call Back</a></li><?php } ?>
	<?php if((AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('client')) || (AuthUser::hasPermission('client') && Page::findById(29)->status_id != 1)){ ?><li><a href="<?php echo get_url('plugin/help_docs/forms#consultationForm'); ?>">Consultation</a></li><?php } ?>
	<?php if((AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('client')) || (AuthUser::hasPermission('client') && Page::findById(86)->status_id != 1)){ ?><li><a href="<?php echo get_url('plugin/help_docs/forms#contactForm'); ?>">Contact</a></li><?php } ?>
	<?php if((AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('client')) || (AuthUser::hasPermission('client') && Page::findById(30)->status_id != 1)){ ?><li><a href="<?php echo get_url('plugin/help_docs/forms#friendForm'); ?>">Tell Friend</a></li><?php } ?>
	<?php if((AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('client')) || (AuthUser::hasPermission('client') && Page::findById(31)->status_id != 1)){ ?><li><a href="<?php echo get_url('plugin/help_docs/forms#informationForm'); ?>">Information Evening</a></li><?php } ?>
	<?php if((AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('client')) || (AuthUser::hasPermission('client') && Page::findById(32)->status_id != 1)){ ?><li><a href="<?php echo get_url('plugin/help_docs/forms#preregistrationForm'); ?>">Pre-Registration</a></li><?php } ?>
	<?php if((AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('client')) || (AuthUser::hasPermission('client') && Page::findById(33)->status_id != 1)){ ?><li><a href="<?php echo get_url('plugin/help_docs/forms#questionForm'); ?>">Question</a></li><?php } ?>
	<?php if((AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('client')) || (AuthUser::hasPermission('client') && Page::findById(34)->status_id != 1)){ ?><li><a href="<?php echo get_url('plugin/help_docs/forms#referralForm'); ?>">Dental Referral</a></li><?php } ?>
	<?php if((AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('client')) || (AuthUser::hasPermission('client') && Page::findById(35)->status_id != 1)){ ?><li><a href="<?php echo get_url('plugin/help_docs/forms#requestForm'); ?>">Brochure Request</a></li><?php } ?>
	<?php if(AuthUser::hasPermission('administrator') && !AuthUser::hasPermission('client')){ ?><li><a href="<?php echo get_url('plugin/help_docs/forms#techfeedbackForm'); ?>">Technical Feedback</a></li><?php } ?>
	</ul>
</li>
</ul>
<?php } ?>

</p>

</div>
