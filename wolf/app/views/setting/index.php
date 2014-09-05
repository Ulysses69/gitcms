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
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @copyright Martijn van der Kleijn, 2009-2010
 * @copyright Philippe Archambault, 2008
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 *
 * @version $Id$
 */
?>

<script type="text/javascript">
	// <![CDATA[
	$j(function () {
		var tabContainers = $j('div.tabs > div.pages > div');

		$j('div.tabs ul.tabNavigation a').click(function () {
			tabContainers.hide().filter(this.hash).show();

			$j('div.tabs ul.tabNavigation a').removeClass('here');
			$j(this).addClass('here');

			return false;
		}).filter(':first').click();
	});
	// ]]>
</script>

<!-- <h1><?php echo __('Administration'); ?></h1> -->

<div id="admin-area" class="form-area">
	<div class="content tabs">
		<ul class="tabNavigation">
			<li class="tab"><a href="#settings"><?php echo __('Settings'); ?></a></li>
			<li class="tab"><a href="#plugins"><?php echo __('Plugins'); ?></a></li>
		</ul>

		<div class="pages">
			<div id="settings" class="page">
				<form action="<?php echo get_url('setting'); ?>" method="post">
					<input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo $csrf_token; ?>" />
					<fieldset style="padding: 0.5em;">
				<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Site options'); ?></legend>
					<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td class="label"><label for="setting_admin_title"><?php echo __('Client name'); ?></label></td>
							<td class="field"><input class="textbox" id="setting_admin_title" maxlength="255" name="setting[admin_title]" size="255" type="text" value="<?php echo htmlentities(Setting::get('admin_title'), ENT_COMPAT, 'UTF-8'); ?>" /></td>
							<td class="help"><?php echo __('Use <strong>&lt;img src="img_path" /&gt;</strong> to set image as title.'); ?></td>
						</tr>
						<!-- <tr>
							<td class="label"><label for="setting_admin_email"><?php echo __('Site email'); ?></label></td>
							<td class="field"><input class="textbox" id="setting_admin_email" maxlength="255" name="setting[admin_email]" size="255" type="text" value="<?php echo Setting::get('admin_email'); ?>" /></td>
							<td class="help"><?php echo __('When emails are sent, this email address will be used as the sender.'); ?></td>
						</tr>
						<tr>
							<td class="label"><label for="setting_language"><?php echo __('Language'); ?></label></td>
							<td class="field">
								<select class="select" id="setting_language" name="setting[language]">
									<?php
										$current_language = Setting::get('language');
										foreach (Setting::getLanguages() as $code => $label): ?>
									<option value="<?php echo $code; ?>"<?php if ($code == $current_language) echo ' selected="selected"'; ?>><?php echo __($label); ?></option>
									<?php endforeach; ?>
								</select>
							</td>
							<td class="help"><?php echo __('This will set language of the backend.'); ?><br /><?php echo __('Help us <a href=":url">translate</a>!', array(':url' => get_url('translate'))); ?></td>
						</tr>
						<tr>
							<td class="label"><label for="setting_theme"><?php echo __('Administration Theme'); ?></label></td>
							<td class="field">
								<select class="select" id="setting_theme" name="setting[theme]" onchange="$('css_theme').href = 'themes/' + this[this.selectedIndex].value + '/styles.css';">
									<?php
										$current_theme = Setting::get('theme');
										foreach (Setting::getThemes() as $code => $label): ?>
									<option value="<?php echo $code; ?>"<?php if ($code == $current_theme) echo ' selected="selected"'; ?>><?php echo __($label); ?></option>
									<?php endforeach; ?>
								</select>
							</td>
							<td class="help"><?php echo __('This will change the backend theme.'); ?></td>
						</tr> -->
						<tr>
							<td class="label"><label for="setting_default_tab"><?php echo __('Default tab'); ?></label></td>
							<td class="field">
								<select class="select" id="setting_default_tab" name="setting[default_tab]">
									<?php $current_default_tab = Setting::get('default_tab');?>
									<option value="page"<?php if ($current_default_tab == 'page') echo ' selected="selected"'; ?>><?php echo __('Pages'); ?></option>
									<option value="snippet"<?php if ($current_default_tab == 'snippet') echo ' selected="selected"'; ?>><?php echo __('Snippets'); ?></option>
									<option value="layout"<?php if ($current_default_tab == 'layout') echo ' selected="selected"'; ?>><?php echo __('Layouts'); ?></option>
									<option value="user"<?php if ($current_default_tab == 'user') echo ' selected="selected"'; ?>><?php echo __('Users'); ?></option>
									<option value="setting"<?php if ($current_default_tab == 'setting') echo ' selected="selected"'; ?>><?php echo __('Administration'); ?></option>
									<?php
										foreach(Plugin::$controllers as $key=>$controller):
											if ($controller->show_tab === true) { ?>
									<option value="plugin/<?php echo $key; ?>"<?php if ('plugin/'.$key == $current_default_tab) echo ' selected="selected"'; ?>><?php echo $controller->label; ?></option>
									<?php   }
										endforeach; ?>
								</select>
							</td>
							<td class="help"><?php echo __('Specify default tab (page) when logged in.'); ?></td>
						</tr>
				</table>
		</fieldset>
		<fieldset style="padding: 0.5em">
			<legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Page options'); ?></legend>
				<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td class="label"><label for="setting_allow_html_title"><?php echo __('Allow HTML in Title'); ?></label></td>
							<td class="field">
								<input type="checkbox" id="setting_allow_html_title" name="setting[allow_html_title]" <?php if (Setting::get('allow_html_title') == 'on') echo ' checked="checked"'; ?> class="checkbox" />
							</td>
							<td class="help"><?php echo __('Allow or disallow HTML code in a page\'s title.'); ?></td>
						</tr>
						<tr>
							<td class="label"><label for="setting_default_status_id-draft"><?php echo __('Default Status'); ?></label></td>
							<td class="field">
								<input class="radio" id="setting_default_status_id-draft" name="setting[default_status_id]" size="10" type="radio" value="<?php echo Page::STATUS_DRAFT; ?>"<?php if (Setting::get('default_status_id') == Page::STATUS_DRAFT) echo ' checked="checked"'; ?> class="radio" /><label for="setting_default_status_id-draft"> <?php echo __('Draft'); ?> </label> &nbsp;
								<input class="radio" id="setting_default_status_id-published" name="setting[default_status_id]" size="10" type="radio" value="<?php echo Page::STATUS_PUBLISHED; ?>"<?php if (Setting::get('default_status_id') == Page::STATUS_PUBLISHED) echo ' checked="checked"'; ?> class="radio" /><label for="setting_default_status_id-published"> <?php echo __('Published'); ?> </label>
							</td>
							<td class="help"><?php echo __('Specify page status when saved.'); ?></td>
						</tr>
						<tr>
							<td class="label"><label for="setting_default_filter_id"><?php echo __('Default Filter'); ?></label></td>
							<td class="field">
								<select class="select" id="setting_default_filter_id" name="setting[default_filter_id]">
								<?php $current_default_filter_id = Setting::get('default_filter_id'); ?>
									<option value=""<?php if ($current_default_filter_id == '') echo ' selected="selected"'; ?>>&#8212; <?php echo __('none'); ?> &#8212;</option>
								<?php
									foreach (Filter::findAll() as $filter_id):
										echo '<!-- Filter should be here -->';//if (isset($loaded_filters[$filter_id])): ?>
									<option value="<?php echo $filter_id; ?>"<?php if ($filter_id == $current_default_filter_id) echo ' selected="selected"'; ?>><?php echo Inflector::humanize($filter_id); ?></option>
								<?php //endif; ?>
								<?php endforeach; ?>
								</select>
							</td>
							<td class="help"><?php echo __('Default filter for pages, NOT snippets or layouts'); ?></td>
						</tr>
					</table>
					</fieldset>

					<p class="buttons">
						<input class="button" id="site-save-page" name="commit" type="submit" accesskey="s" title="<?php echo __('Save then close'); ?>" value="<?php echo __('Save'); ?>" />
					</p>
				</form>
			</div>
			
			
			<div id="plugins" class="page">
				<table class="index">
					<thead>
						<tr>
							<th class="plugin"><?php echo __('Plugin'); ?></th>
							<!-- <th class="pluginSettings"><?php echo __('Settings'); ?></th>
							<th class="website"><?php echo __('Website'); ?></th> -->
							<?php if(CHECK_UPDATES != false){ ?><th class="version"><?php echo __('Version'); ?></th>
							<th class="latest"><?php echo __('Latest'); ?></th><?php } ?>
							<th class="enabled"><?php echo __('Enabled'); ?></th>
							<th class="installed"><?php echo __('Uninstall'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$loaded_plugins = Plugin::$plugins;
							$loaded_filters = Filter::$filters;
							foreach(Plugin::findAll() as $plugin):
								$disabled = (isset($plugin->require_wolf_version) and $plugin->require_wolf_version > CMS_VERSION);
								if(isset($plugin->website)){ $website = $plugin->website; } else { $website = ''; }
								if(isset($plugin->description)){ $description = $plugin->description; } else { $description = ''; }
						?>
						<tr<?php if ($disabled) echo ' class="disabled"'; ?>>
							<td class="plugin">
								<h4>
								<?php
									if (isset($loaded_plugins[$plugin->id]) && Plugin::hasDocumentationPage($plugin->id) )
										echo '<a href="'.get_url('plugin/'.$plugin->id.'/documentation').'">'.$plugin->title.'</a>';
									else
										echo __($plugin->title);
								?>
									<span class="from"><?php if (isset($plugin->author)) echo ' '.__('by').' '.$plugin->author; ?></span>
								</h4>
								<p><?php echo __($description); ?> <?php if ($disabled) echo '<span class="notes">'.__('This plugin CANNOT be enabled! It requires Wolf version :v.', array(':v' => $plugin->require_wolf_version)).'</span>'; ?></p>
							</td>
							<!-- <td class="pluginSettings">
								<?php
									if (isset($loaded_plugins[$plugin->id]) && Plugin::hasSettingsPage($plugin->id) )
										echo '<a href="'.get_url('plugin/'.$plugin->id.'/settings').'">'.__('Settings').'</a>';
									else
										echo __('n/a');
								?>
							</td>
							<td class="website"><a href="<?php echo $website; ?>" target="_blank"><?php echo __('Website') ?></a></td> -->
							<?php if(CHECK_UPDATES != false){ ?><td class="version"><?php echo $plugin->version; ?></td>
							<td class="latest"><?php echo Plugin::checkLatest($plugin); ?></td><?php } ?>
							<td class="enabled"><input type="checkbox" class="checkbox" name="enabled_<?php echo $plugin->id; ?>" value="<?php echo $plugin->id; ?>"<?php if (isset($loaded_plugins[$plugin->id])) echo ' checked="checked"'; if ($disabled) echo ' disabled="disabled"'; ?> onclick="new Ajax.Request('<?php echo get_url('setting'); ?>'+(this.checked ? '/activate_plugin/':'/deactivate_plugin/')+this.value, {method: 'get'});" /></td>
							<td class="uninstall"><a href="<?php echo get_url('setting'); ?>" name="uninstall_<?php echo $plugin->id; ?>" onclick="if (confirm('<?php echo __('Are you sure you wish to uninstall this plugin?'); ?>')) { new Ajax.Request('<?php echo get_url('setting/uninstall_plugin/'.$plugin->id); ?>', {method: 'get'}); }"><?php echo __('Uninstall'); ?></a></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			
		</div>
	</div>
</div>