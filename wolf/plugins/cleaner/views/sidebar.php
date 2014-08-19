<?php

  /* Ensure plugin update is enabled ONLY when new version */
  if (CLEANER_VERSION > Plugin::getSetting('version', 'cleaner')){
	  define('CLEANER_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/cleaner/enable.php";
  }

?>


<?php if (!AuthUser::hasPermission('client')) { ?>

<p class="button"><a href="<?php echo get_url('plugin/cleaner'); ?>/clean"><img src="<?php echo PLUGINS_URI . 'cleaner/images/clean.png'; ?>" align="middle" alt="Access" /> Clean</a></p>
<p class="button"><a href="<?php echo get_url('plugin/cleaner'); ?>/settings"><img src="<?php echo PLUGINS_URI  . 'cleaner/images/settings.png'; ?>" align="middle" alt="Settings" /> Settings</a></p>

<br />

<?php $debug = Plugin::getSetting('debugmode', 'cleaner');
if($debug == true){ ?>
<div class="box warning">
<h2><?php echo __('Test Mode Enabled');?></h2>
<p>You can run a test preview, but no actual files or folders will be cleaned or removed in test mode.</p>
</div>
<?php } ?>

<div class="box">
<h2><?php echo __('Tip');?></h2>
<p>Slash characters are automatically formatted as required (when saved), even with mixed combinations of forward slashes and backward slashes, even trailing slashes.</p>
</div>


<?php } ?>