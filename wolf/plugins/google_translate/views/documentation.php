<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008-2010 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 */

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

 
/**
 * The Google Translate plugin allows one to translate their website
 * through a dropdown on the fly.
 *
 * @package Plugins
 * @subpackage google_translate
 *
 * @author thulium
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
?>
<h1><?php echo __('Google Translate Plugin'); ?></h1>
<p>
<p>This plugin adds a Google Translate dropdown menu to the top right corner of your website.</p>
<p>To add this, just add the code <span style="font-family:monospace;">&lt;?php gt_drop(); ?&gt;</span> just after the <span style="font-family:monospace;">&lt;body&gt;</span> tag in your layout!</p>
</p>
