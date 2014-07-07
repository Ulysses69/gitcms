<!--
<p class="button"><a href="<?php echo get_url('plugin/tweaker/documentation'); ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/tweaker/images/documentation.png" align="middle" /><?php echo __('Documentation'); ?></a></p>
<p class="button"><a href="<?php echo get_url('plugin/tweaker/settings'); ?>"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/tweaker/images/settings.png" align="middle" /><?php echo __('Settings'); ?></a></p>
-->

<div class="box">
<h2><?php echo __('Tweaker Plugin');?></h2>
<p><?php echo __('Plugin:')?> <?php echo Plugin::getSetting('version', 'tweaker'); ?></p>
<p>Tweaker plugin lets you customize admin and public settings.</p>
<br />
<h2>Notes</h2>
<p>When setting auto-generate meta to false, remember that pages without a slug or breadcrumb could break your site. It is advised to set this to false ONLY AFTER your pages have been made with slug and breadcrumb values pre-populated.</p>
</div>
