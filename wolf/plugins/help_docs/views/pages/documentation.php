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
<!-- <h1><?php echo __('Documentation'); ?></h1> -->


<?php if(AuthUser::hasPermission('client')) { ?>
<h2>Help documentation</h2>
<p>This help documentation is to assist with the creation and management of features within this website.</p>
<?php } else { ?>


<!-- <h2>Help documentation</h2> -->
<p>This help documentation is to assist with the creation and management of features within this website, such as page properties and navigation. Each feature listed here, is described and an example given (and where available, multiple examples).</p>
<!-- <p>Note that while some features display by default, others require the content to be printed to the screen in order to be displayed. To aid in identifying this, each example states whether it 'Returns' or 'Displays' the feature.</p> -->
<p>In cases where a feature needs to be displayed, be sure to explicitly display the feature like so:</p>
<code>echo currentid($this->slug)</code>

<h2>Default Pages</h2>
<ul>
<li><a href="/mockup.html">Mockups</a> | Create mockup pages with inserted image for preview. <a href="/<?php echo ADMIN_DIR; ?>/page/edit/118">Example page</a></li>
<li><a href="/proposal.html">Proposal</a> | Proposed content and objectives of website pages (used to confirm content).</li>
<li><a href="/siteplan.html">Site Plan</a> | Overview of site page structure (visual overview of page heirachy).</li>
<li><a href="/seoplan.html">SEO Plan</a> | SEO overview of website pages (overview of SEO over all pages).</li>
<!-- <li><a href="/elements.html">Elements</a> | Elements styling reference.</li> -->
<!-- <li><a href="/robots.txt">Robots</a> | Robots file.</li> -->
<!-- <li><a href="/serverinfo.html">Server</a> | Server info.</li> -->
</ul>

<?php } ?>


<h2>SEO</h2>
<p>Search Engine Optimisation is about optimising pages, not the website. SEM and SMM efforts should point to pages rather than home page. The home page should naturally rank well.</p>
<ul>
<li>Don't index a page if another page is already being indexed for the same content/keyword/phrase.</li>
<li>Don't follow a page if another page is better deserving of link rank or if the page is predominantly offsite links.</li>
<li>Think of each page as unique content per keyword/phrase. Spreading or duplicating unique content dilutes it rank value (be warned).</li>
</ul>

<h2>General guidelines</h2>
<ul>
<li>Not all pages have tabs pre-available.</li>
<li>Each new page tab should be created using lowercase part name.</li>
<li>To add or remove a page tab, the page must be saved/updated immediately after doing so.</li>
<li>Images can be made to popup by applying <b>Popup</b> style to corresponding link.</li>
<!-- <li>To automatically have file icons added to links, place links in an <b>Unordered list</b>.</li> -->
<?php if(!AuthUser::hasPermission('client')) { ?><li>To add/display newsletters, upload them using <b>Media</b> tab into <b>documents</b> folder. <a href="/<?php echo ADMIN_DIR; ?>/plugin/help_docs/features#filelist">Read more</a></li><?php } ?>
<li>Do not enable Tinymce filter if editing a <b>scripts</b> page tab.</li>
<li>If Tinymce filter is disabled for a page/tab by default, use caution. It is likely for good reason.</li>
<li>[client] [address] and [telephone] markers can be used in <b>body</b> tab or page <b>title</b>, page <b>name</b> and page <b>description</b> fields. <?php if(Plugin::isEnabled('clientdetails') == true){?><a href="/<?php echo ADMIN_DIR; ?>/plugin/clientdetails">Change details</a><?php } ?></li>
<li>[hours] marker should generally only be used in <b>body</b> tab. <?php if(Plugin::isEnabled('clientdetails') == true){?><a href="/<?php echo ADMIN_DIR; ?>/plugin/clientdetails">Change hours</a><?php } ?></li>
<?php if(!AuthUser::hasPermission('client')) { ?><li>[client] [address] [telephone] and [hours] markers can be used in <b>footer</b> snippet. <?php if(Plugin::isEnabled('clientdetails') == true){?><a href="/<?php echo ADMIN_DIR; ?>/plugin/clientdetails">Change details</a><?php } ?></li><?php } ?>
<li>Always upload files and/or images before linking text to them.</li>
<li>Try to name files in lowercase with <b>-</b> characters in place of spaces, ie; <b>good-filename.pdf</b> and not <b>Bad Filename.PDF</b></li>
<li>Content in <b>mobile</b> page tab will replace both <b>body</b> and <b>scripts</b> page tab content, in mobile website.</li>
<?php if(!AuthUser::hasPermission('client')) { ?>
<li>Price list should follow heading, title, description, then price (and from prefix) format as follows:</li>
<code>&#60;h2>Heading&#60;/h2><br />
&#60;ul><br />
&#60;li>First title &#60;em>from &pound;cost&#60;/em>&#60;/li><br />
&#60;li>Second title (including description) &#60;em>&pound;cost&#60;/em>&#60;/li><br />
&#60;/ul>
</code>
<?php } ?>
</ul>



<h2>Quoting guidelines</h2>
<ul>
<li><b>Block Quote</b> should be used to quote an off-page source and should only contain information directly in the quote source.  Example: <code>&#60;blockquote><br />&#60;p>Quote me.&#60;/p><br />&#60;footer>Person&#60;/footer><br />&#60;/blockquote></code></li>
<li><b>Quotation</b> should be used to 'directly quote' mid-paragraph and consequently doesn't require citation or quote marks. Example: <code>&#60;p>&#60;q>Quote me&#60;/q> said Person.&#60;/p></code></li>
<li><b>Citation</b> should be used to explicitly cite a resource and not a person. Examples: <code>&#60;p>&#60;q cite="URL">Quote me&#60;/q> said Person from &#60;cite>Book&#60;/cite>.&#60;/p></code> <code>&#60;blockquote cite="URL"><br />&#60;p>Quote me.&#60;/p><br />&#60;footer>&#60;a href="URL">Person&#60;/a>&#60;/footer><br />&#60;/blockquote></code></li>
<li><b>Pull quote</b> should emphasise part of source content by placing (copy of) itself nearby, such as in sidebar or aside etc. There is presently no semantic way to use pull quotes without text duplication (which can hamper SEO and usability).</li>
</ul>


<?php if(!AuthUser::hasPermission('client')) { ?>
<h2>Forms guidelines</h2>
<ul>
<li>Mailing list join text can be <a href="/<?php echo ADMIN_DIR; ?>/snippet/edit/31">changed</a> or disabled by leaving empty.</li>
<li>Privacy notice text can be <a href="/<?php echo ADMIN_DIR; ?>/snippet/edit/22">changed</a> or left empty.</li>
</ul>


<h2>Date guidelines</h2>
<ul>
<li><b>Created</b> is the date a page was first created and saved, regardless of status.</li>
<li><b>Published</b> is the date a page was first saved/updated with the Published status, as opposed to Draft or Hidden status.</li>
<li><b>Updated</b> is the most recent date a page was altered (this includes page order).</li>
</ul>



<?php } ?>


</div>

