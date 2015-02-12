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
<?php if (Dispatcher::getAction() == 'index'): ?>

<p class="button"><a href="<?php echo get_url('layout/add'); ?>"><img src="<?php echo URI_PUBLIC . ADMIN_DIR . '/';?>images/new_layout.png" align="middle" alt="layout icon" /> <?php echo __('New Layout'); ?></a></p>


<?php if(Plugin::isEnabled('page_options') == true && AuthUser::hasPermission('administrator')){ ?><p class="button"><a href="<?php echo get_url('plugin/page_options'); ?>"><img src="<?php echo URI_PUBLIC;?>wolf/plugins/page_options/images/page_options.png" align="middle" alt="page options icon" /> <?php echo __('Page Options'); ?></a></p><?php } ?>
<?php if(Plugin::isEnabled('mobile_check') == true && AuthUser::hasPermission('administrator')){ ?><p class="button"><a href="<?php echo get_url('plugin/mobile_check'); ?>"><img src="<?php echo URI_PUBLIC;?>wolf/plugins/mobile_check/images/mobile.png" align="middle" alt="mobile icon" /> <?php echo __('Design & Mobile'); ?></a></p><?php } ?>
<?php if(Plugin::isEnabled('tinymce_styles') == true && AuthUser::hasPermission('administrator')){ ?><p class="button"><a href="<?php echo get_url('plugin/tinymce_styles'); ?>"><img src="<?php echo URI_PUBLIC;?>wolf/plugins/tinymce_styles/images/styles.png" align="middle" alt="styles icon" /> <?php echo __('TinyMCE Styles'); ?></a></p><?php } ?>


<div class="box">
<h2><?php echo __('What is a Layout?'); ?></h2>
<p><?php echo __('Use layouts to apply a visual look to a Web page. Layouts can contain special tags to include
  page content and other elements such as the header or footer. Click on a layout name below to
  edit it or click <strong>Remove</strong> to delete it.'); ?></p>
</div>

<?php endif; ?>