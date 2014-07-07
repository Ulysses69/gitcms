<?php


Plugin::setInfos(array(
	'id'					=> 'form_core',
	'title'					=> 'Form - Core',
	'version'				=> '13.0.0',
	'license'				=> 'GPLv3',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'			=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'	=> '0.9.3')
);

/*

Added post updates to postcheck.php and posted.php
posted.php now included at end of for loop, rather than in_array check

Notes:
Once submitted, either close all open instances of the browser or
re-submit the form and wait for a minute before re-submitting a second time.
This prevents multiple submissions.

*/