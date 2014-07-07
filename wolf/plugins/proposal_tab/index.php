<?php

Plugin::setInfos(array(
				'id' 			=> 'proposal_tab',
				'title' 		=> __('Proposal Tab'),
				'description'	=> __('Add extra meta data for search engines.')
));

//Page Goals
//Page Notes

Observer::observe('view_page_edit_tabs', 'proposal_tab_page_edit');

function proposal_tab_page_edit($page) {
	$proposal_note = '';
	$proposal_goal = '';
	global $__CMS_CONN__;
	$sql = 'SELECT proposal_goal , proposal_note FROM '.TABLE_PREFIX.'page WHERE id=?';
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	while ($proposal_tabindex = $stmt->fetchObject()) {
		$proposal_goal = $proposal_tabindex->proposal_goal;
		$proposal_note = $proposal_tabindex->proposal_note;
	}
 	?>

<?php if($proposal_note != ''){ $badge = "<span class='badge'>!</span>"; } else { $badge = ''; } ?>
<div id="proposal-container" title="Notes<?php echo $badge; ?>">

<?php if(!isset($page->id)){ ?>
<div class="proposal-container">
<p>Please save this page before creating notes.</p>
</div>
<?php } else { ?>

<ul class="proposal-container">
<li><label for="page_proposal_goalindex" title="Key purpose of this page">Page Goals</label>
<textarea name="page[proposal_goal]" id="page_proposal_goalindex" rows="3" title="Key purpose of this page"><?php echo $proposal_goal;?></textarea></li>
<li><label for="page_proposal_noteindex" title="General notes and reminders about this page">Page Notes</label>
<textarea name="page[proposal_note]" id="page_proposal_noteindex" rows="3" title="General notes and reminders about this page"><?php echo $proposal_note;?></textarea></li>
<li>
<div class="notes">
<h2>Notes</h2>
<p>Keep page focused to single topic and define relevant conversion to visitor.</p>
</div>
</li>
</ul>

<?php } ?>

</div>



<?php }

Observer::observe('page_edit_after_save', 'proposal_tab_index_save');
function proposal_tab_index_save($page){
	global $__CMS_CONN__;
	$proposal_goal = $page->proposal_goal;
	$proposal_note = $page->proposal_note;
	$sql = "UPDATE ".TABLE_PREFIX."page SET proposal_goal = '".$proposal_goal."' , proposal_note = '".$proposal_note."' WHERE id=?";
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	//$__CMS_CONN__->exec($sql)
}

function pagegoals($page,$returnstatus=''){
	global $__CMS_CONN__;
	$sql = 'SELECT proposal_goal FROM '.TABLE_PREFIX.'page WHERE id=?';
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	while ($proposal_tabindex = $stmt->fetchObject()) {
		$proposal_goal = $proposal_tabindex->proposal_goal;
	}
	if($returnstatus == 'echo'){
		echo $proposal_goal;
	} else {
		return $proposal_goal;
	}
}

function pagenotes($page,$returnstatus=''){
	global $__CMS_CONN__;
	$sql = 'SELECT proposal_note FROM '.TABLE_PREFIX.'page WHERE id=?';
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	while ($proposal_tabindex = $stmt->fetchObject()) {
		$proposal_note = $proposal_tabindex->proposal_note;
	}
	if($returnstatus == 'echo'){
		echo $proposal_note;
	} else {
		return $proposal_note;
	}
}