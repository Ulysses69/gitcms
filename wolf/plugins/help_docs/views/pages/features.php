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
<!-- <h1><?php echo __('Pages'); ?></h1> -->

<h2 id="pagetitle">Page title</h2>
<p>Example 1 Displays default page title AND search results-friendly title where relevant.</p>
<code>pagetitle($this)</code>

<?php if(Plugin::isEnabled('seobox') == true){?>
<h2 id="linktitle">Link title</h2>
<p>Sets title attribute for links. <a href="/<?php echo ADMIN_DIR; ?>/plugin/seobox">Change settings</a></p>
<p>Example 1 Displays title attribute for current page link.</p>
<code>linktitle($this)</code>
<p>Example 2 Returns title attribute for string, class or function use.</p>
<code>linktitle($child,false)</code>
<?php } ?>

<?php if(Plugin::isEnabled('robots') == true){ ?>
<h2 id="robots">Robots</h2>
<p>Example 1 Displays robots meta. Go to page and select Robots tab.</p>
<code>robots($this,FALSE)</code>
<?php } ?>

<h2 id="copyrightDate">Copyright date</h2>
<p>Example 1 Returns either the current date, or to and from (ie; 2001 - 2010).</p>
<code>copyrightDate($this)</code>

<h2 id="currentid">Page identifier</h2>
<p>Example 1 Returns slug id and value (ie; id="slug") with preceding space character. Home page returns 'home' as slug value.</p>
<code>currentid($this->slug)</code>

<h2 id="pagenotes">Page notes</h2>
<p>Example 1 Returns notes for page. Comment-out a note to both retain it and hide it.</p>
<code>contentNotes($this)</code>

<h2 id="currentparent">Parent and class</h2>
<p>Example 1 Returns level 2 parent slug value (ie; slug level below home page).</p>
<code>currentparent()</code>
<p>Example 2 Returns level 2 parent slug value as class (ie; class="parent") and specified 'customclass'. Preceding space character optional.</p>
<code>currentparent(" class customclass")</code>
<p>Example 3 Returns level 2 parent slug value as id (ie; id="parent"). Preceding space character optional.</p>
<code>currentparent(" id")</code>

<?php if(function_exists('pagelevel')) ?>
<h2 id="pagelevel">Page level</h2>
<p>Example 1 Returns page level (ie; home page or sitemap would return 1).</p>
<code>pagelevel($this)</code>
<?php ; ?>
    
<h2 id="randomsnippet">Random</h2>
<p>Example 1 Returns random testimonial excerpt with read more links to content.</p>
<code>randomsnippet($this,'/testimonials/','Read more','2');</code>
<p>Example 2 Returns random testimonial content.</p>
<code>randomsnippet($this,'/testimonials/','');</code>

<?php if(function_exists('announcements')) ?>
<h2 id="announcements">Announcements</h2>
<p>Unlike other pages, the announcements page can can display an announcement on pages when the excerpt tab is populated and the page is set to published or hidden. If the page is set to hidden, the excerpt can be used to link to any other pages than itself (the page will be returned by on-site search though).</p>
<p>Example 1 Returns announcements (if page is available and excerpt is set).</p>
<code>announcements();</code>
<?php ; ?>

<?php if(function_exists('testimonials')) ?>
<h2 id="testimonials">Testimonials</h2>
<p>Example 1 Returns random testimonial excerpts grouped into 3s.</p>
<code>testimonials($this,'/testimonials/',3);</code>
<p>Example 2 Returns random testimonial excerpts grouped per testimonial.</p>
<code>testimonials($this,'/testimonials/','');</code>
<p>Example 3 fade in/out 2 testimonials at a time.</p>
<code>testimonials('fade','/testimonials/',2);</code>
<?php ; ?>

<?php if(function_exists('facebookfeed')) ?>
<h2 id="facebookfeed">Facebook Feed</h2>
<p>Example Returns 4 comments from facebook twitter account</p>
<p>Facebook API Format: '<u title="Your API application ID">appId</u>', '<u title="Your API application secret">secret</u>', '<u title="Your Facebook account name">page ID</u>', '<u title="return or echo">return</u>', '<u title="Number of comments to show">number of comments</u>'</p>
<code>facebookfeed('153262362', 'd1b5d3b2d6', 'google', 'return', 4);</code>
<?php ; ?>

<?php if(function_exists('teamitems')) ?>
<h2 id="team">Team widget</h2>
<p>Teams can be ordered by either: group, jobtitle, name or position.</p>
<p>Grouping teams can be by group or jobtitle, when team is ordered manually by position. Each jobtitle is displayed once, so ensure team order is correct).</p>
<p>Available presentational layouts: list, names, basic, standard, bling, full</p>
<p>Example 1 Returns team ordered by name, A-Z.</p>
<code>teamitems($this, 'team', 'descend', 'name', 'basic');</code>
<p>Example 2 Returns team ordered by name, Z-A.</p>
<code>teamitems($this, 'team', 'ascend', 'name', 'basic');</code>
<p>Example 3 Returns team manually ordered by position and grouped by jobtitle.</p>
<code>teamitems($this, 'team', 'ascend', 'name', 'basic', null, 'jobtitle');</code>
<p>Example 4 Returns team manually ordered by position, images set as background and team grouped by jobtitle.</p>
<code>teamitems($this, 'team', 'ascend', 'name', 'basic', 'background', 'jobtitle');</code>
<p>Example 5 Returns team as list (name, position, qualifications) manually ordered by page position.</p>
<code>teamitems($this, 'team', 'descend', 'position', 'list');</code>
<p>Example 6 Returns team as full page with symantic commas turned off manually ordered by page position.</p>
<code>teamitems($this, 'team', 'descend', 'position', 'full', null, 'off', 'off');</code>
$commas

<?php ; ?>

<h2 id="pageoptions">Page options</h2>
<?php if(Plugin::isEnabled('seobox') == true){?>
<p>All pageoptions() are now handled by the <a href="../page_options">page options</a> page.</p>
<p>Following example will ignore any passed paremeters after $this (print array etc), and use the page options settings instead.</p>
<code>pageoptions($this,array(array($this->url,'print','Print','Print view','text')),'Viewing options')</code>
<p>This is all that is now required.</p>
<code>pageoptions($this)</code>
<?php } else { ?>
<p>Example 1 Displays page options menu.</p>
<code>pageoptions($this,array(array($this->url,'print','Print','Print view','text')),'Viewing options')</code>
<p>Example 2 Displays page options menu with image icon.</p>
<code>pageoptions($this,array(array($this->url,'print','Print','Print view','/inc/img/print.gif')),'Viewing options')</code>
<?php } ?>

<h2 id="searchbox">Search box</h2>
<?php if(Plugin::isEnabled('form_core') == false){?><p class="warning"><strong>Notice:</strong> the search plugin must first be enabled.</p><?php } ?>
<p>Example 1 Displays search box.</p>
<code>searchbox('Search')</code>
<p>Example 2 Displays search box with custom search button.</p>
<code>searchbox('Search','search','/inc/img/search.gif')</code>

<?php if(Plugin::isEnabled('banner') == true){?>
<h2 id="banner">Banner</h2>
<p>Banner can be displayed in layout.</p>
<p>Example 1 Displays banner in layout.</p>
<code>setBanner()</code>
<?php } ?>

<?php if(function_exists('crcSrc')) ?>
<h2 id="crcsrc">Parent Image</h2>
<p>Banner image can be displayed using URI. No image tag is returned if image does not exist.</p>
<p>Example 1 Displays banner using parent slug to get image from banner folder.</p>
<code>crcSrc('/public/images/banner/'.currentparent('').'.jpg');</code>
<?php ; ?>
    
<?php if(Plugin::isEnabled('social') == true){?>
<h2 id="social">Social Links</h2>
<p>Social network links can be displayed in layout. Appearance can be changed in <a href="../social">settings</a>.</p>
<p>Example 1 Displays social links in layout.</p>
<code>socialLinks()</code>
<?php } ?>

<h2 id="filelist">File list</h2>
<p>Example 1 Displays list of documents from files folder, sorted by name in ascending order.</p>
<code>setFiles('/public/files/','name','ascend')</code>

<p>Example 2 Displays 2 documents, sorted by date in descending order displaying size, and restricted to pdf and doc.</p>
<code>setFiles('/public/documents/','date','descend',true,'2',array('pdf','doc'))</code>

<h2 id="thumblist">Thumbnail list / gallery</h2>
<p>Example 1 Displays thumbnail links from banner folder, sorted by name in ascending order and class (gallery-group) name applied.</p>
<code>setThumbs('/public/images/banner/','name','ascend','gallery-group')</code>

<p>Example 2 Displays images from banner folder, sorted by name in ascending order and class (gallery-group) name applied.</p>
<code>setPics('/public/images/banner/','name','ascend','gallery-group')</code>

<?php if(function_exists('randomsrc')) ?>
<h2 id="randomsrc">Random image</h2>
<p>Example Displays random image from specified folder.</p>
<code>randomsrc($this, '/public/images/banner/')</code>
<?php ; ?>

<h2 id="newsitems">News Items</h2>
<p>News or article archives can be displayed in varying ways. By default, excerpts are displayed with links to full article (if excerpt contains content).</p>
<p>Example 1 Displays all articles using 0 limit and setting excerpt display to false.</p>
<code>newsitems($this,'articles',0,'created_on','descend',null,true,false)</code>

<p>Example 2 limits articles to 3 in ascending order and displaying hidden pages is set to false.</p>
<code>newsitems($this,'articles',3,'created_on','ascend',null,false,true)</code>

<p>Example 3 limits news articles to 2 and grouped by year and adds false parameter to hide rss link.</p>
<code>newsitems($this->find('/news/'),'news',2,'created_on','descend','year',true,true,false)</code>

</div>
