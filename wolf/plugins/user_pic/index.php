<?php

Plugin::setInfos(array(
				'id' 			=> 'user_pic',
				'title' 		=> __('User picture (Not Finished)'),
				'description'	=> __('Add picture/avatar to admin users.')
));


Observer::observe('view_page_edit_tabs', 'user_pic_page_edit');

function user_pic_page_edit($page) {
	global $__CMS_CONN__;
	$sql = 'SELECT user_pic FROM '.TABLE_PREFIX.'user WHERE id=?';
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	while ($user_picindex = $stmt->fetchObject()) {
		$user_pic = $user_picindex->user_pic;
	}
 	?>

<div id="user-pic-container" title="Robots">
<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td class="label"><label for="page_user_picindex">Links / index</label></td>
<td class="field">
<select name="page[user_pic]" id="page_user_picindex">
<?php
if ($user_pic == NULL){
	$user_pic = 'follow,index';
}
$url_array = array(
array ("Follow links and index page", 'follow,index'),
array ("Don't follow links or index page", 'nofollow,noindex'),
array ("Follow links but don't index page", 'follow,noindex'),
array ("Index page but don't follow links", 'nofollow,index'),
array ("Prevent cache preview", 'noarchive'));
foreach($url_array as $subarray) {
	list($text, $val) = $subarray;
	if($val == $user_pic){
		echo "<option value=\"$val\" selected>$text</option>";
	} else {
		echo "<option value=\"$val\">$text</option>";
	}
}
?>
</select>
</td>
</tr>
<tr>
<td class="label"><label for="page_canonicalindex">Source page</label></td>
<td class="field">
<input name="page[canonical]" id="page_canonicalindex" type="text" value="<?php echo $canonical;?>" />
</td>
</tr>
</table>
<div class="notes">
<h2>Notes</h2>
<p>Don't index this page if another page is already being indexed for the same keyword/phrase.</p>
<p>Don't follow this page if another page is better deserving of link rank or if this page is predominantly offsite links.</p>
<p>Think of each page as unique content per keyword/phrase.</p>
</div>

<?php if(Plugin::isEnabled('redirector') == true){ ?>
<a class="redirectcheck" href="/<?php echo ADMIN_DIR; ?>/plugin/redirector">Check redirects</a>
<?php } ?>

</div>

<?php }

Observer::observe('user_after_edit', 'user_pic_index_save');
function user_pic_index_save($page){
	global $__CMS_CONN__;
	$user_pic = $page->user_pic;
	$canonical = $page->canonical;
	if($canonical != NULL && ($user_pic == NULL || $user_pic == 'follow,index' || $user_pic == 'nofollow,index')){
		$user_pic = 'nofollow,noindex';
	}
	$sql = "UPDATE ".TABLE_PREFIX."user SET user_pic = '".$user_pic."' , canonical = '".$canonical."' WHERE id=?";
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	//$__CMS_CONN__->exec($sql)
}
function user_picindex($id){
	global $__CMS_CONN__;
	$sql = "SELECT user_pic FROM ".TABLE_PREFIX."user WHERE id = ?";
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($id));
	$obj = $stmt->fetchObject();
	$user_picindex = $obj->user_pic;
	$canonicalindex = $obj->canonical;
	$pageindex = $obj->index;
	if (empty($user_picindex)) {
	 	return $pageindex;
	} else {
	 	return $user_picindex;
	}
}
function user_pic($page,$returnstatus='echo'){
	global $__CMS_CONN__;
	$robotdata = '';
	$sql = 'SELECT user_pic FROM '.TABLE_PREFIX.'user WHERE id=?';
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	while ($user_picindex = $stmt->fetchObject()) {
		$user_pic = $user_picindex->user_pic;
		$canonical = $user_picindex->canonical;
	}
	if($user_pic != 'follow,index'){
		if ($user_pic != 'nofollow,noindex' || $user_pic == 'follow,noindex'){
			$robotdata .= '<meta name="user_pic" content="'.$user_pic.'" />'."\r";
		}
	}
	if($returnstatus == 'return'){
		return $robotdata;
	} else {
		echo $robotdata;
	}
}