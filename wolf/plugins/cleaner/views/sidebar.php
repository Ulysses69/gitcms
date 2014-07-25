<?php

  /* Ensure plugin update is enabled ONLY when new version */
  if (CLEANER_VERSION > Plugin::getSetting('version', 'cleaner')){
	  define('CLEANER_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/cleaner/enable.php";
  }

?>

<div class="box">
<h2><?php echo __('Cleaner');?></h2>
<p>About cleaner.</p>
<?php if (!AuthUser::hasPermission('client')) { ?>
<p>Additional information not for clients.</p>
<?php } ?>
</div>
