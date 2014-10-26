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
 * @file		/models/itemform.php
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
<!-- <h1><?php echo ($act == 'add') ? 'Add New' : 'Edit'; ?> Menu Item</h1> -->
<br /><br />
<div id='mbmenu'>

	<?php echo (isset($errorDesc)) ? $errorDesc : ''; ?>

	<form method='post' action='<?php echo ($act == 'add') ? get_url('plugin/mbmenu/addItem') : get_url('plugin/mbmenu/editItem/'.$item->id);  ?>'>
		<table width='100%' cellspacing='5' cellpadding='5' border='0'>
			<tr>
				<td><strong>Menu</strong></td>
				<td><select name='item[menuid]' onchange="getMenuItems(this);">
					<option>Select Menu</option>
				<?php 
					foreach($menus as $k => $menu)
					{
						$sel = '';
						if(isset($item->menuid) && ($menu->id == $item->menuid))
						{
							$sel = ' selected="selected"';
						}
						
						echo "<option value='".$menu->id."'".$sel.">".$menu->menutitle."</option>";
					}
				?>				
				</select></td>
			</tr>		
			<tr>
				<td><strong>Item Text</strong></td>
				<td><input type='text' name='item[linktext]' size='40' value="<?php echo (isset($item->linktext)) ? $item->linktext : ''; ?>" /></td>
			</tr>

			<!--
			<tr>
				<td><strong>Item URL</strong></td>
				<td><input type='text' name='item[linkurl]' size='40' value="<?php echo (isset($item->linkurl)) ? $item->linkurl : ''; ?>" /></td>
			</tr>
			-->
			<tr>
				<td><strong>Menu</strong></td>
				<td><select name='item[linkurl]' onchange="getMenuItems(this);">
					<option>Select Menu</option>
				<?php 
					foreach($menus as $k => $menu)
					{
						$sel = '';
						if(isset($item->menuid) && ($menu->id == $item->menuid))
						{
							$sel = ' selected="selected"';
						}
						
						echo "<option value='".$menu->id."'".$sel.">".$menu->menutitle."</option>";
					}
				?>				
				</select></td>
			</tr>

			<tr>
				<td><strong>Item Options</strong> (Class, id, onlick etc...)</td>
				<td><input type='text' name='item[linkoptions]' size='40' value="<?php echo (isset($item->linkoptions)) ? $item->linkoptions : ''; ?>" /></td>
			</tr>
			<tr>
				<td><strong>Item Parent</strong></td>
				<td><select name='item[linkparent]' id="linkparent"><option value='0'>No Parent</select></td>
			</tr>			
			<tr>
				<td><strong>Item Order</strong></td>
				<td><input type='text' name='item[linkorder]' size='10' value="<?php echo (isset($item->linkorder)) ? $item->linkorder : ''; ?>" /></td>
			</tr>		
			<tr>
				<td><strong>Active</strong></td>
				<td><input type='checkbox' name='item[active]' value="1" <?php echo (isset($item->active) && $item->active == 1) ? 'checked="checked"'  : ''; ?> /></td>
			</tr>
			<tr>
				<td colspan='2'>
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<input type='submit' name='<?php echo ($act == 'add') ? 'add' : 'edit'; ?>' value='<?php echo ($act == 'add') ? 'Add' : 'Edit'; ?> Menu Item' />
				</td>
			</tr>
		</table>
	</form>
</div>
<?php
	if($act == 'edit')
	{
		echo "<script type='text/javascript'>
				loadMenuItems(".$item->menuid.",".$item->linkparent.");
			  </script>";
	}
?>


