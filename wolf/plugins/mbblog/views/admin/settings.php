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
 * @file		settings.php
 * @date		28/04/2010
 * 
*/
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}
?>
<style>
#mbblog tr, #mbblog td { padding: 5px; }
</style>
<!-- <h1>Blog Settings</h1> -->
<br /><br />
<div id='mbblog'>

	<?php echo (isset($errorDesc)) ? $errorDesc : ''; ?>

	<form method='post' action='<?php echo get_url('plugin/mbblog/settings'); ?>'>
		<table width='100%' cellspacing='5' cellpadding='5' border='0'>
			<tr>
				<td><strong>Blog Posts per Page</strong></td>
				<td><input type='text' name='setting[postspp]' size='40' value="<?php echo $settings['postspp']; ?>" /></td>
			</tr>
			<tr>
				<td><strong>Blog Date Format **</strong></td>
				<td><input type='text' name='setting[dateformat]' size='40' value="<?php echo $settings['dateformat']; ?>" /></td>
			</tr>
			<tr>
				<td><strong>Blog Title</strong></td>
				<td><input type='text' name='setting[blogtitle]' size='40' value="<?php echo $settings['blogtitle']; ?>" /></td>
			</tr>
			<tr>
				<td><strong>Blog Path (Leave blank for homepage)</strong></td>
				<td><input type='text' name='setting[blogpath]' size='40' value="<?php echo $settings['blogpath']; ?>" /></td>
			</tr>
			<tr>
				<td colspan='2'>
					<br />
					<input type='submit' name='save' value='Save Settings' />
				</td>
			</tr>
		</table>
	</form>
	
	<br />
	** For help with date formating please visit the following link: <a href='http://www.php.net/date' target='_blank'>http://www.php.net/date</a>
</div>
