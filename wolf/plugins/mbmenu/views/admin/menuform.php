<?php
/**
 * mbMenu
 * 
 * Menu Management Plugin for WolfCMS
 * Please keep this message intact when redistributing this plugin.
 * 
 * @author		Mike Barlow
 * @email		mike@mikebarlow.co.uk
 * 
 * @file		/models/menuform.php
 * @date		02/05/2010
 * 
*/// check for some constants
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}
?>
<style>
#mbmenu tr, #mbmenu td { padding: 5px; }
</style>
<!-- <h1><?php echo ($act == 'add') ? 'Add New' : 'Edit'; ?> Menu</h1> -->
<br /><br />
<div id='mbmenu'>

	<?php echo (isset($errorDesc)) ? $errorDesc : ''; ?>

	<form method='post' action='<?php echo ($act == 'add') ? get_url('plugin/mbmenu/addMenu') : get_url('plugin/mbmenu/editMenu/'.$menu->id);  ?>'>
		<table width='100%' cellspacing='5' cellpadding='5' border='0'>
			<tr>
				<td><strong>Menu Title</strong></td>
				<td><input type='text' name='menu[menutitle]' size='40' value="<?php echo (isset($menu->menutitle)) ? $menu->menutitle : ''; ?>" /></td>
			</tr>
			<tr>
				<td><strong>Menu Code</strong></td>
				<td><input type='text' name='menu[menucode]' size='40' value="<?php echo (isset($menu->menucode)) ? $menu->menucode : ''; ?>" /></td>
			</tr>
			<tr>
				<td><strong>Active</strong></td>
				<td><input type='checkbox' name='menu[active]' value="1" <?php echo (isset($menu->active) && $menu->active == 1) ? 'checked="checked"'  : ''; ?> /></td>
			</tr>
			<tr>
				<td colspan='2'>
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<input type='submit' name='<?php echo ($act == 'add') ? 'add' : 'edit'; ?>' value='<?php echo ($act == 'add') ? 'Add' : 'Edit'; ?> Menu' />
				</td>
			</tr>
		</table>
	</form>
</div>
