<?php

  /* Ensure plugin update is enabled ONLY when new version */
  if (HTACCESS_VERSION > Plugin::getSetting('version', 'htaccess')){
	  define('HTACCESS_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/_htaccess/enable.php";
  }

?>

<div class="box">
<h2><?php echo __('HTACCESS Plugin').' '.Plugin::getSetting('version', 'htaccess'); ?></h2>
<p>Control website behaviour.</p>
</div>

<div class="box warning">
<h2>Warning</h2>
<p>Server configuration changes should not be carried out without server knowledge. Incorrect configuration can result in this website being broken and this admin area being unreachable.</p>
</div>

<div class="box warning">
<h2>Note</h2>
<p>Changes made here are for quick fixes only. Changes to further admin settings will overwite changes made here.</p>
</div>
