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
 * @file		index.php
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
		var agree=confirm("Are you sure? This will delete associated menu items aswell.");
	    if(agree)
	   	{
	        return true;
	    } else
	    {
	        return false;
	    }
	}
</script>
<!-- <h1>Site Menus</h1> -->
<br /><br />

<?php 
	if(!is_array($menus))
	{
		echo $menus;
	} else
	{
?>
<table width='100%' cellspacing='5' cellpadding='5' border='0'>
<tr>
	<td width='35%'><strong>Menu Name</strong></td>
	<td width='25%'><strong>Menu Code</strong></td>
	<td width='23%' align="center"><strong>Manage</strong></td>
	<td width='7%' align="center"><strong>Edit</strong></td>
	<td width='10%' align="center"><strong>Delete</strong></td>
</tr>
<?php	
		$adminDel = get_url('plugin/mbmenu/deleteMenu');
		$adminEdit = get_url('plugin/mbmenu/editMenu');
		$adminItems = get_url('plugin/mbmenu/manage');		

		foreach($menus as $key => $post)
		{
?>
	<tr>
		<td><?php echo stripslashes($post->menutitle); ?></td>
		<td><?php echo stripslashes($post->menucode); ?></td>
		<td align="center"><a href="<?php echo $adminItems."/".$post->id; ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/mbmenu/images/database_48.png" alt="Edit" width="20" /></a></td>
		<td align="center"><a href="<?php echo $adminEdit."/".$post->id; ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/mbmenu/images/paper&pencil_48.png" alt="Edit" width="20" /></a></td>
		<td align="center"><a href="<?php echo $adminDel."/".$post->id; ?>" onclick="return confirmAction();"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/mbmenu/images/cancel_48.png" alt="Delete" width="20" /></a></td>
	</tr>
<?php } ?>

</table>
<br />
<?php } ?>