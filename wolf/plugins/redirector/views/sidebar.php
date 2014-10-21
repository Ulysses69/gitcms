<?php

  /* Ensure plugin update is enabled ONLY when new version */
  if (REDIRECTOR_VERSION > Plugin::getSetting('version', 'redirector')){
	  define('REDIRECTOR_INCLUDE',1);
	  include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/redirector/enable.php";
  }

?>


<?php

/*
 * Redirector - Wolf CMS URL redirection plugin
 *
 * Copyright (c) 2010 Design Spike
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://themes.designspike.ca/redirector/help/
 *
 */

?>
<div class="box">
<h2><?php echo __('Redirector').' '.Plugin::getSetting('version', 'redirector'); ?></h2>
<p>Pages can be re-directed by simply specifying the page URL to be re-directed from and the page URL it is to be re-directed to.</p>
<!-- <p>Set the duration of the re-direct using the status option. If using temporary re-direct, be sure to remove the re-direct when it is no longer needed or set to permanent if circumstances require.</p> -->
<p>Care should be taken with format of entered URLs. Either use relative URL or absolute URL starting with http etc.</p>
</div>

<?php include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC.'wolf/plugins/_htaccess/views/sidebar.php'; ?>
