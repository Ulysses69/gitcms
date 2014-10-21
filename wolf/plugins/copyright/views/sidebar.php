<?php

  /* Ensure plugin update is enabled ONLY when new version */
  if (COPYRIGHT_VERSION > Plugin::getSetting('version', 'copyright')){
	  define('COPYRIGHT_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/copyright/enable.php";
  }

?>

<div class="box">
<h2><?php echo __('Copyright').' '.Plugin::getSetting('version', 'copyright'); ?></h2>
<p>Set copyright and legal link/text in footer.</p>
<?php if (!AuthUser::hasPermission('client')) { ?>
<p>Linkbacks are also used by the copyright page as well as the footer (if specified).</p>
<?php } ?>
</div>
