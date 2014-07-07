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
<style>
.mbBlog .pagination
{
	width: 100%;
	text-align: center;
	padding-bottom: 7px;
}
.mbBlog .pagination a
{
	color: #000000;
	text-decoration: none;
	border: 1px solid #034c90;
	background-color: #cde7ff;
	color: #000000;
	float: left;
	margin-right: 5px;
	width: 20px;
	text-align: center;
}
.mbBlog .pagination a:hover
{
	color: #ffffff;
	text-decoration: none;
	border: 1px solid #034c90;
	background-color: #034c90;
	color: #FFFFFF;
	float: left;
	margin-right: 5px;
	width: 20px;
	text-align: center;
	text-decoration: none;
}
.mbBlog .pagination .page_current
{
	border: 1px solid #034c90;
	background-color: #034c90;
	color: #ffffff;
	float: left;
	margin-right: 5px;
	width: 20px;
	text-align: center;
}
</style>
<script type="text/javascript">
	function confirmAction()
	{
	    var agree=confirm("Are you sure?");
	    if (agree)
	   	{
	        return true;
	    } else
	    {
	        return false;
	    }
	}
</script>
<!-- <h1>Blog Posts</h1> -->
<br /><br />

<?php 
	if(!is_array($posts))
	{
		echo $posts;
	} else
	{
?>
<table width='100%' cellspacing='2' cellpadding='1' border='0'>
<tr>
	<td width='40%'><strong>Blog Title</strong></td>
	<td width='20%'><strong>Blog Author</strong></td>
	<td width='23%'><strong>Blog Date</strong></td>
	<td width='7%' align="center"><strong>Edit</strong></td>
	<td width='10%' align="center"><strong>Delete</strong></td>
</tr>
<?php	
		$adminDel = get_url('plugin/mbblog/deletePost');
		$adminEdit = get_url('plugin/mbblog/editPost');

		foreach($posts as $key => $post)
		{
?>
	<tr>
		<td><?php echo stripslashes($post->posttitle); ?></td>
		<td><?php echo stripslashes($post->author); ?></td>
		<td><?php echo date($dateformat, stripslashes($post->date)); ?></td>
		<td align="center"><a href="<?php echo $adminEdit."/".$post->id; ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/mbblog/images/paper&pencil_48.png" alt="Edit" width="20" /></a></td>
		<td align="center"><a href="<?php echo $adminDel."/".$post->id; ?>" onclick="return confirmAction();"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/mbblog/images/cancel_48.png" alt="Delete" width="20" /></a></td>
	</tr>
<?php } ?>

</table>
<br />
<?php	
		if(count($paging) > 0 && $paging !== false):
			echo "<div class='mbBlog'><div class='pagination'>".$paging['firstLink'].$paging['prevLink'].implode('', $paging['nums']).$paging['nextLink'].$paging['lastLink']."</div></div>";
		endif;		
	}
?>