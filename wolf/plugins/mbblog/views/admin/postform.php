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
 * @file		add_post.php
 * @date		28/09/2009
 * 
*/
if(!defined("CMS_ROOT"))
{
	die("Invalid Action");
}
?>
<style>
#mbblog .shortText
{
	width: 50%;
	height: 100px;
}
#mbblog .longText
{
	width:90%;
	height: 150px;
}
#mbblog tr, #mbblog td { padding: 5px; }
</style>
<!-- <h1><?php echo ($act == 'add') ? 'Add New' : 'Edit'; ?> Post</h1> -->
<br /><br />
<div id='mbblog'>

	<?php echo (isset($errorDesc)) ? $errorDesc : ''; ?>

	<form method='post' action='<?php echo ($act == 'add') ? get_url('plugin/mbblog/addPost') : get_url('plugin/mbblog/editPost/'.$post->id);  ?>'>
		<table width='100%' cellspacing='5' cellpadding='5' border='0'>
			<tr>
				<td><strong>Blog Title</strong></td>
				<td><input type='text' name='post[posttitle]' size='40' value="<?php echo (isset($post->posttitle)) ? $post->posttitle : ''; ?>" /></td>
			</tr>
			<tr>
				<td><strong>Blog Author</strong></td>
				<td><input type='text' name='post[author]' size='40' value="<?php echo (isset($post->author)) ? $post->author : AuthUser::getRecord()->name; ?>" /></td>
			</tr>
			<tr>
				<td colspan='2'>
					<strong>Blog Intro (optional)</strong>
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<textarea cols='10' rows='10' name='post[shortbody]' class='shortText'><?php echo (isset($post->shortbody)) ? $post->shortbody : ''; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<strong>Blog Body</strong>
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<textarea cols='50' rows='15' name='post[body]' class='longText'><?php echo (isset($post->body)) ? $post->body : ''; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<input type='submit' name='<?php echo ($act == 'add') ? 'add' : 'edit'; ?>' value='<?php echo ($act == 'add') ? 'Add' : 'Edit'; ?> Post' />
				</td>
			</tr>
		</table>
	</form>
</div>
