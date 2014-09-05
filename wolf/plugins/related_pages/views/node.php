<ul>
	<?php foreach($children as $child): ?>
	<?php switch ($child->status_id) {
		  case Page::STATUS_DRAFT: $visibility = __('Draft'); break;
		  case Page::STATUS_PREVIEW: $visibility = __('Preview'); break;
		  case Page::STATUS_PUBLISHED: $visibility = __('Published'); break;
		  case Page::STATUS_HIDDEN: $visibility = __('Hidden'); break;
	} ?>
	<?php $exclude_pages = array('2','8','9','10','13','14','15','17','18','19','21','42','53','59','64','65','67','69','75','95','99','111','112','113','114'); ?>
	<?php if($visibility == 'Draft' || in_array($child->id,$exclude_pages)){ ?><!-- <?php } ?>
	<li id="page-<?php echo $child->id; ?>-<?php echo $level; ?>" class="node level-<?php echo $level; if ( ! $child->has_children) echo ' no-children'; else if ($child->is_expanded) echo ' children-visible'; else echo ' children-hidden'; ?>">
		<?php if ($child->has_children): ?><img align="top" alt="toggle children" class="expander" src="<?php echo URI_PUBLIC . ADMIN_DIR ?>/images/<?php echo $child->is_expanded ? 'collapse': 'expand'; ?>.png" /><?php endif; ?>
		<input type="checkbox" value="<?php echo $child->id; ?>"<?php if ($child->is_related){ ?> checked="checked"<?php } ?><?php if ($pageid == $child->id){?> disabled="disabled"<?php } ?> /> <?php echo $child->breadcrumb; //echo $child->title; ?>

		<?php if (! empty($child->behavior_id)): ?> <small class="info">(<?php echo Inflector::humanize($child->behavior_id); ?>)</small><?php endif; ?>
		<img align="top" class="busy" id="busy-<?php echo $child->id; ?>" src="<?php echo URI_PUBLIC . ADMIN_DIR ?>/images/spinner.gif" style="display: none;" title="" />

		<span class="status">
		<?php echo $visibility; ?>
		</span>

		<?php if ($child->is_expanded) echo $child->children_rows; ?>
	</li>
	<?php if($visibility == 'Draft' || in_array($child->id,$exclude_pages)){ ?> --><?php } ?>
	<?php endforeach; ?>
</ul>
