<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2009,2010 Martijn van der Kleijn <martijn.niji@gmail.com>
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
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @copyright Philippe Archambault, 2008
 * @copyright Martijn van der Kleijn, 2009-2010
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 *
 * @version $Id$
 */
?>
<!-- <h1><?php echo __(ucfirst($action).' snippet'); ?></h1> -->

<form action="<?php echo $action=='edit' ? get_url('snippet/edit/'.$snippet->id): get_url('snippet/add'); ; ?>" method="post">
    <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo $csrf_token; ?>" />
    <div class="form-area">
        <h3><?php echo __('Name'); ?></h3>
        <div id="meta-pages" class="pages">
            <p class="title">
                <input class="textbox" id="snippet_name" maxlength="100" name="snippet[name]" size="255" type="text" value="<?php echo $snippet->name; ?>" />
            </p>
        </div>

        <h3><?php echo __('Body'); ?></h3>
        <div id="pages" class="pages">
            <div class="page" style="">
                <textarea class="textarea" cols="40" id="snippet_content" name="snippet[content]" rows="20" style="width: 100%"><?php echo htmlentities($snippet->content, ENT_COMPAT, 'UTF-8'); ?></textarea>
                <p>
                    <label for="snippet_filter_id"><?php echo __('Filter'); ?></label>
                    <select id="snippet_filter_id" name="snippet[filter_id]" onchange="setTextAreaToolbar('snippet_content', this[this.selectedIndex].value)">
                        <option value=""<?php if($snippet->filter_id == '') echo ' selected="selected"'; ?>>&#8212; <?php echo __('none'); ?> &#8212;</option>
                        <?php foreach ($filters as $filter): ?>
                        <option value="<?php echo $filter; ?>"<?php if($snippet->filter_id == $filter) echo ' selected="selected"'; ?>><?php echo Inflector::humanize($filter); ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
            </div>
        </div>
    </div>

<?php if (isset($snippet->updated_on)): ?>
    <p id="lastupdate">
    <small><?php echo __('Last updated by'); ?> <?php echo $snippet->updated_by_name; ?> <?php echo __('on'); ?> <?php echo date('D, j M Y', strtotime($snippet->updated_on)); ?></small>
    </p>
<?php endif; ?>

    <p class="buttons">
        <input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="<?php echo __('Save then close'); ?>" value="<?php echo __('Save'); ?>" />
    	<input class="button" id="site-update-page" name="continue" type="submit" accesskey="e" title="<?php echo __('Save then continue editing'); ?>" value="<?php echo __('Update'); ?>" />
    	<a href="<?php echo get_url('page'); ?>" id="site-cancel-page" class="button" title="<?php echo __('Close without saving'); ?>"><?php echo __('Cancel'); ?></a>
    </p>
</form>

<script type="text/javascript">
// <![CDATA[
    function setConfirmUnload(on, msg) {
        window.onbeforeunload = (on) ? unloadMessage : null;
        return true;
    }

    function unloadMessage() {
        return '<?php echo __('You have modified this page.  If you navigate away from this page without first saving your data, the changes will be lost.'); ?>';
    }

    $j(document).ready(function() {
        // Prevent accidentally navigating away
        $j(':input').bind('change', function() { setConfirmUnload(true); });
        $j('form').submit(function() { setConfirmUnload(false); return true; });
    });
    
  setTextAreaToolbar('snippet_content', '<?php echo $snippet->filter_id; ?>');
  document.getElementById('snippet_name').focus();
// ]]>
</script>