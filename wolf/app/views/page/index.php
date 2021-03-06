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
<!-- <h1><?php echo __('Pages'); ?></h1> -->

<div id="site-map-def">
	<div class="page"><?php echo __('Page'); ?> (<a href="#" id="toggle_reorder" onclick="toggle_reorder = !toggle_reorder; toggle_copy = false; $$('.handle_reorder').each(function(e) { e.style.display = toggle_reorder ? 'inline': 'none'; }); $$('.handle_copy').each(function(e) { e.style.display = toggle_copy ? 'inline': 'none'; }); return false;"><?php echo __('reorder'); ?></a> <?php echo __('or'); ?> <a id="toggle_copy" href="#" onclick="toggle_copy = !toggle_copy; toggle_reorder = false; $$('.handle_copy').each(function(e) { e.style.display = toggle_copy ? 'inline': 'none'; }); $$('.handle_reorder').each(function(e) { e.style.display = toggle_reorder ? 'inline': 'none'; }); return false;"><?php echo __('copy'); ?></a>)</div>
	<div class="status"><?php echo __('Status'); ?></div>
	<?php if(Plugin::isEnabled('funky_cache') == true){ ?><div class="cache"><?php echo __('Cached'); ?></div><?php } ?>
	<!-- <div class="view"><?php echo __('View'); ?></div> -->
	<div class="modify"><?php echo __('Action'); ?></div>
</div>

<ul id="site-map-root">
	<li id="page-0" class="node level-0">
	  <div class="page" style="padding-left: 4px">
		<span class="w1">
<?php if ($root->is_protected && ! AuthUser::hasPermission('administrator') && ! AuthUser::hasPermission('developer')): ?>
		  <img align="middle" class="icon" src="images/page.png" alt="page icon" /> <span class="title"><?php echo $root->breadcrumb; ?></span>
<?php else: ?>
		  <a href="<?php echo get_url('page/edit/1'); ?>" title="/"><img align="middle" class="icon" src="images/page.png" alt="page icon" /> <span class="title"><?php echo $root->breadcrumb; ?></span></a>
<?php endif; ?>
		</span>
	  </div>
	  <div class="status published-status"><?php echo __('Published'); ?></div>
	  <?php if(Plugin::isEnabled('funky_cache') == true){ ?><div class="cache"><?php if($root->funky_cache_enabled == true){ echo "Yes"; } else { echo "No"; } ?></div><?php } ?>
	  <div class="view-page"><a href="<?php echo URL_PUBLIC; ?>" target="_blank"><img src="images/magnify.png" align="middle" alt="<?php echo __('View Page'); ?>" title="<?php echo __('View Page'); ?>" /></a></div>
	  <div class="modify">
		  <a href="<?php echo get_url('page/add/1'); ?>"><img src="images/plus.png" align="middle" title="<?php echo __('Add child'); ?>" alt="<?php echo __('Add child'); ?>" /></a>&nbsp; 
		  <img class="remove" src="images/icon-remove-disabled.gif" align="middle" alt="<?php echo __('remove icon disabled'); ?>" title="<?php echo __('Remove unavailable'); ?>"/>
	  </div>
	</li>
</ul>

<?php echo $content_children; ?>

