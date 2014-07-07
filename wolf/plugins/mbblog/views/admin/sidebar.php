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

echo "<p class='button'><a href='".get_url('plugin/mbblog/')."'><img src='".URL_PUBLIC."wolf/plugins/mbblog/images/navigate_48.png' align='middle' alt='Blog Main Page Icon' />Post List</a></p>
<p class='button'><a href='".get_url('plugin/mbblog/addPost')."'><img src='".URL_PUBLIC."wolf/plugins/mbblog/images/add_48.png' align='middle' alt='Add Post Icon' />Add New Post</a></p>
<p class='button'><a href='".get_url('plugin/mbblog/settings')."'><img src='".URL_PUBLIC."wolf/plugins/mbblog/images/spanner_48.png' align='middle' alt='Blog Settings Icon' />Blog Settings</a></p>

<div class='box'>
	<h2>mbBlog Support</h2>
	<p>For support visit <a href='http://www.mikebarlow.co.uk'>www.mikebarlow.co.uk</a>.<br />
	This was a hobby project so support isn't full time but I will endeavour to answer questions and update the script as much as possible!<br /><br />
	
	Feedback / Suggestions are more then welcome.</p>
</div>";
?>