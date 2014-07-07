<?php
/**
 * mbBlog
 * 
 * Simple blog plugin for WolfCMS.
 * Please keep this message intact when redistributing this plugin.
 * 
 * @author		Mike Barlow
 * @email		mike@mikebarlow.co.uk
 * 
 * @file		sidebar.php
 * @date		28/09/2009
 *
*/
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}

echo "<p class='button'><a href='".get_url('plugin/mbmenu/')."'><img src='".URL_PUBLIC."wolf/plugins/mbmenu/images/navigate_48.png' align='middle' alt='Mbmenu Main Page Icon' />Menu List</a></p>
<p class='button'><a href='".get_url('plugin/mbmenu/addMenu')."'><img src='".URL_PUBLIC."wolf/plugins/mbmenu/images/add_48.png' align='middle' alt='Add Post Icon' />Add New Menu</a></p>
<p class='button'><a href='".get_url('plugin/mbmenu/addItem')."'><img src='".URL_PUBLIC."wolf/plugins/mbmenu/images/add_48.png' align='middle' alt='Add Post Icon' />Add New Menu Item</a></p>

<div class='box'>
	<h2>Displaying Your Menus</h2>
	<p>Below the items on the item management page (click \"manage\" on the desired menu), there is some base code you can use to get you started with displaying your menu.</p>
</div>

<div class='box'>
	<h2>mbMenu Support</h2>
	<p>For support visit <a href='http://www.mikebarlow.co.uk'>www.mikebarlow.co.uk</a>.<br />
	This was a hobby project so support isn't full time but I will endeavour to answer questions and update the script as much as possible!<br /><br />
	
	Feedback / Suggestions are more then welcome.</p>
</div>";
?>