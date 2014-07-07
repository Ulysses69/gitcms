<?php

  /* Ensure plugin update is enabled ONLY when new version */
  if (PAGEOPTIONS_VERSION > Plugin::getSetting('version', 'page_options')){
	  define('PAGEOPTIONS_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/page_options/enable.php";
  }

?>

<div class="box">
<h2><?php echo __('Page Options');?></h2>
<p>Manage the appearance of page options such as links to <strong>Print</strong> or jump to <strong>Top of Page</strong>.</p>
<p>Links are <strong>text</strong> by default, but URL (relative or absolute) can be specified to display an icon.</p>
</div>

<div class="box">
<h2><?php echo __('PDF Options');?></h2>
<p>Logo width and height can be set specifically, or leave blank to auto assign (default).</p>
</div>
