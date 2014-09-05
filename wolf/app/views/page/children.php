<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2009 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */

/**
 * @package wolf
 * @subpackage views
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */
?>

<ul<?php if ($level == 1) echo ' id="site-map"'; ?>>
<?php foreach($childrens as $child): ?>

<?php
  /* Get form page parts value */
  $profilepage = false;
  if(Plugin::isEnabled('page_part_forms') == true){
	  $form_sql = "SELECT * FROM ".TABLE_PREFIX."page_metadata";
	  $form_q = Record::getConnection()->query($form_sql);
	  $form_f = $form_q->fetchAll(PDO::FETCH_OBJ);
	  foreach ($form_f as $form) {
	  	 /* Only check for pages with form part, not pages whose children are set to for mparts */
	  	 if($child->id == $form->page_id && $form->keyword == 'page_part_forms'){
		 	$profilepage = true;
		 }
	  }
  }
?>

<?php switch ($child->status_id) {
	  case Page::STATUS_DRAFT:  $status = 'draft'; break;
	  case Page::STATUS_PREVIEW:  $status = 'preview'; break;
	  case Page::STATUS_PUBLISHED: $status = 'published'; break;
	  case Page::STATUS_HIDDEN: $status = 'hidden'; break;
	  } if((!$child->is_protected && AuthUser::hasPermission('client')) || !AuthUser::hasPermission('client')){ ?>
	<li id="page_<?php echo $child->id; ?>" class="node status-<?php echo $status; ?> level-<?php echo $level; if ( ! $child->has_children) echo ' no-children'; else if ($child->is_expanded) echo ' children-visible'; else echo ' children-hidden'; ?>">
	  <div class="page">
		<span class="w1"><?php if(stristr($child->behavior_id, 'archive')){ $pageicon = 'archive'; } else if(stristr($child->behavior_id, 'Form')){ $pageicon = 'form'; } else if($profilepage == true){ $pageicon = 'profile'; } else if(stristr($child->behavior_id, 'Gallery')){ $pageicon = 'gallery'; } else if(function_exists('robotredirect') && robotredirect($child,'return') != ''){ $pageicon = 'redirect'; } else { $pageicon = 'page'; } ?>
		  <?php if ($child->has_children): ?><img align="middle" alt="toggle children" class="expander" src="images/<?php echo $child->is_expanded ? 'collapse': 'expand'; ?>.png" title="" /><?php endif; ?>
<?php if (! AuthUser::hasPermission('administrator') && ! AuthUser::hasPermission('developer') && $child->is_protected): ?>
<img align="middle" class="icon" src="images/<?php echo $pageicon; ?><?php if($child->is_protected) echo '-protected'; ?>.png" alt="page icon" /> <span class="title protected"><?php echo $child->breadcrumb; ?> </span> <img class="handle_reorder" src="images/drag_to_sort.gif" alt="<?php echo __('Drag and Drop'); ?>" align="middle" /> <img class="handle_copy" src="images/drag_to_copy.gif" alt="<?php echo __('Drag to Copy'); ?>" align="middle" />
<?php else: ?>
<a href="<?php echo get_url('page/edit/'.$child->id); ?>" title="<?php echo $child->slug; ?>"><img align="middle" class="icon" src="images/<?php echo $pageicon; ?><?php if($child->is_protected) echo '-protected'; ?>.png" alt="page icon" /> <span class="title"><?php echo $child->breadcrumb; ?> </span></a> <img class="handle_reorder" src="images/drag_to_sort.gif" alt="<?php echo __('Drag and Drop'); ?>" align="middle" /> <img class="handle_copy" src="images/drag_to_copy.gif" alt="<?php echo __('Drag to Copy'); ?>" align="middle" />
<?php endif; ?>
		  <?php if (! empty($child->behavior_id)): ?> <small class="info">(<?php echo Inflector::humanize($child->behavior_id); ?>)</small><?php endif; ?> 
		  <img align="middle" alt="" class="busy" id="busy-<?php echo $child->id; ?>" src="images/spinner.gif" style="display: none;" title="" />
		</span>
	  </div>
	<?php echo '<div class="status '.$status.'-status">'.__(ucfirst($status)).'</div>'; ?>
	  <?php if(Plugin::isEnabled('funky_cache') == true){ ?><div class="cache"><?php if($child->funky_cache_enabled == true){ echo "Yes"; } else { echo "No"; } ?></div><?php } ?>
	  <div class="view-page"><a href="<?php echo URL_PUBLIC; echo (USE_MOD_REWRITE == false) ? '?' : ''; echo $child->getUri(); if(stristr($child->slug, '.') === FALSE){ $SUFFIX = URL_SUFFIX; } else { $SUFFIX = ''; } echo ($child->getUri() != '') ? $SUFFIX : ''; ?>" target="_blank"><img src="images/magnify.png" align="middle" alt="<?php echo __('View '.$child->breadcrumb.' Page'); ?>" title="<?php echo __('View '.$child->breadcrumb.' Page'); ?>" /></a></div>
	  <div class="modify">
		<a href="<?php echo get_url('page/add', $child->id); ?>"><img src="images/plus.png" align="middle" title="<?php echo __('Add child'); ?>" alt="<?php echo __('Add child'); ?>" /></a>&nbsp;
<?php if (! $child->is_protected || AuthUser::hasPermission('administrator') || AuthUser::hasPermission('developer')): ?>
		<a class="remove" href="<?php echo get_url('page/delete/'.$child->id.'?csrf_token='.SecureToken::generateToken(BASE_URL.'page/delete/'.$child->id)); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to delete'); ?> <?php echo $child->title; ?> <?php echo __('and its underlying pages'); ?>?');"><img src="images/icon-remove.gif" align="middle" alt="<?php echo __('Remove '.$child->breadcrumb.' page'); ?>" title="<?php echo __('Remove '.$child->breadcrumb.' page'); ?>" /></a>
<?php endif; ?>
	  </div>
<?php if ($child->is_expanded) echo $child->children_rows; ?>
	</li>
<?php } endforeach; ?>
</ul>
