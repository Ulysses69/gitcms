<?php if(!defined('IN_CMS')) { exit(); } ?>

<div class="box">

	<p class="button"><a href="<?php echo get_url('maintenance/switchStatus/'); ?><?php if($settings['maintenanceMode'] == 'off') { $stat = 'on'; } else { $stat = 'off'; } echo $stat; ?>" class="<?php echo $stat; ?>"><img src="<?php echo PLUGINS_URI . 'maintenance/images/' . $settings['maintenanceMode'] . '.png'; ?>" align="middle" alt="<?php echo strtoupper($settings['maintenanceMode']); ?>" /> Maintenance mode is <strong><?php echo strtoupper($settings['maintenanceMode']); ?></strong></a></p>
	<p class="button"><a href="<?php echo get_url('maintenance/access'); ?>"><img src="<?php echo PLUGINS_URI . 'maintenance/images/access.png'; ?>" align="middle" alt="Access" /> Access List</a></p>
	<p class="button"><a href="<?php echo get_url('maintenance/settings'); ?>"><img src="<?php echo PLUGINS_URI  . 'maintenance/images/settings.png'; ?>" align="middle" alt="Settings" /> Settings</a></p>

</div>