<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 * Copyright (C) 2008,2009 Martijn van der Kleijn <martijn.niji@gmail.com>
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

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

/**
 * The FileManager allows users to upload and manipulate files.
 *
 * @package plugins
 * @subpackage file_manager
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @version 1.0.0
 * @since Wolf version 0.5.0
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault & Martijn van der Kleijn, 2008
 */

  $out = '';
  $progres_path = '';
  $paths = explode('/', $filename); 
  $nb_path = count($paths);
  foreach ($paths as $i => $path) {
	if ($i+1 == $nb_path) {
	  $out .= $path;
	} else {
	  $progres_path .= $path.'/';
	  $out .= '<a href="'.get_url('plugin/file_manager/browse/'.rtrim($progres_path, '/')).'">'.$path.'</a> / ';
	}
  }
?>
<!-- <h1><a href="<?php echo get_url('plugin/file_manager'); ?>">public</a>/<?php echo $out; ?></h1> -->
<div class="boxed">

<div id="files-path"><a href="<?php echo get_url('plugin/file_manager'); ?>">public</a> / <?php echo $out; ?></div><?php if ($is_image) { ?>
  <img src="<?php echo BASE_FILES_DIR.'/'.$filename; ?>" />
<?php } else { ?>
<form method="post" action="<?php echo get_url('plugin/file_manager/save'); ?>">
	<div class="form-area">
		<p class="content">
			<input type="hidden" name="file[name]" value="<?php echo $filename; ?>" />
			<textarea class="textarea" id="file_content" name="file[content]" style="width: 100%; height: 400px;" rows="20" cols="40"><?php echo htmlentities($content, ENT_COMPAT, 'UTF-8'); ?></textarea><br />
		</p>
	</div>
	<p class="buttons">
		<input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="<?php echo __('Save then close'); ?>" value="<?php echo __('Save'); ?>" />
		<input class="button" id="site-update-page" name="continue" type="submit" accesskey="e" title="<?php echo __('Save then continue editing'); ?>" value="<?php echo __('Update'); ?>" />
		<a href="<?php echo get_url('plugin/file_manager/browse/'.$progres_path); ?>" id="site-cancel-page" class="button" title="<?php echo __('Close without saving'); ?>"><?php echo __('Cancel'); ?></a>
	</p>
</form>
<?php } ?>

</div>