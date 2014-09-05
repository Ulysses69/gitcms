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
 * @file		manage.php
 * @date		28/09/2009
 *
*/
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}
?>
<script type="text/javascript">
	function confirmAction(act)
	{
		var agree=confirm("Are you sure?");
		if(agree)
	   	{
			return true;
		} else
		{
			return false;
		}
	}
</script>
<style>
#mbmenu tr, #mbmenu td { padding: 5px; }
#mbmenu input { width: 50px; }
#mbmenu input.submit { width: auto; }
#mbmenu .padleft { padding-left: 15px !important; }
</style>
<!-- <h1>Manage Menu: <?php echo $menu->menutitle; ?></h1> -->
<br /><br />
<div id='mbmenu'>
	<?php 
		if(!is_array($menuitems))
		{
			echo $menuitems."<br />";
		} else
		{
	?>
	<form method="post" action="<?php echo get_url('plugin/mbmenu/updateOrder'); ?>">
	<input type="hidden" name="menuid" value="<?php echo $menu->id; ?>" />
	<table width='100%' cellspacing='5' cellpadding='5' border='0'>
	<tr>
		<td width='25%'><strong>Menu Name</strong></td>
		<td width='38%'><strong>Link</strong></td>
		<td width='20%'><strong>Order</strong></td>
		<td width='7%'><strong>Edit</strong></td>
		<td width='10%'><strong>Delete</strong></td>
	</tr>
	<?php
			$adminDel = get_url('plugin/mbmenu/deleteItem');
			$adminEdit = get_url('plugin/mbmenu/editItem');	
	
			foreach($menuitems as $key => $item)
			{
	?>
		<tr>
			<td><?php echo stripslashes($item->linktext); ?></td>
			<td><?php echo stripslashes($item->linkurl); ?></td>
			<td><input type="text" name="order[<?php echo $item->id; ?>]" value="<?php echo $item->linkorder; ?>" /></td>
			<td><a href="<?php echo $adminEdit."/".$item->id; ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/mbmenu/images/paper&pencil_48.png" alt="Edit" width="20" /></a></td>
			<td><a href="<?php echo $adminDel."/".$item->id; ?>" onclick="return confirmAction();"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/mbmenu/images/cancel_48.png" alt="Delete" width="20" /></a></td>
		</tr>
	<?php 
			if(isset($item->subitems) && count($item->subitems) > 0)
			{
				foreach($item->subitems as $subKey => $subItem)
				{
				?>
					<tr>
						<td class="padleft"> <?php echo stripslashes($subItem->linktext); ?></td>
						<td class="padleft"> <?php echo stripslashes($subItem->linkurl); ?></td>
						<td class="padleft"> <input type="text" name="order[<?php echo $subItem->id; ?>]" value="<?php echo $subItem->linkorder; ?>" /></td>
						<td class="padleft"> <a href="<?php echo $adminEdit."/".$subItem->id; ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/mbmenu/images/paper&pencil_48.png" alt="Edit" width="20" /></a></td>
						<td class="padleft"> <a href="<?php echo $adminDel."/".$subItem->id; ?>" onclick="return confirmAction();"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/mbmenu/images/cancel_48.png" alt="Delete" width="20" /></a></td>
					</tr>
				<?php 
				}
			}	
		} ?>
	<tr>
		<td colspan="5">
			&nbsp;
		</td>
	</tr>		
	<tr>
		<td colspan="5">
			<input type="submit" name="saveOrder" value="Save Item Order" class="submit" />
		</td>
	</tr>
	</table>
	</form>
	<br />
	<?php } ?>
	<br />
	<h1>Displaying Your Menus</h1>
	<br />
	
	To display your menus, use the code below as a basis. Place the code where you want your menu to appear in your layout:<br /><br />
	
	<code><pre>
	&lt;?php
	$menu = loadMbMenu('<?php echo $menu->menucode; ?>');
	if(count($menu) > 0)
	{
		foreach($menu as $item)
		{
			echo "&lt;a href='".$item->linkurl."'".$item->linkoptions."&gt;".$item->linktext."&lt;/a&gt;&lt;br /&gt;";
			if(isset($item->subitems) && count($item->subitems) > 0)
			{
				foreach($item->subitems as $subitem)
				{
					echo "--&lt;a href='".$subitem->linkurl."'".$subitem->linkoptions."&gt;".
					$subitem->linktext."&lt;/a&gt;&lt;br /&gt;";
				}
			}
		}
	}
	?&gt;
	</pre></code>
	
	
	
	
</div>