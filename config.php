<?php

// Database settings:
define('DB_DSN', 'mysql:dbname=db_name;host=localhost;port=3306');
define('DB_USER', 'db_username');
define('DB_PASS', 'db_password');
define('TABLE_PREFIX', '');

// Produce PHP error messages for debugging?
define('DEBUG', true);

// Check for updates on system and installed plugins?
define('CHECK_UPDATES', false);

// The number of seconds before timeout, in case of problems.
define('CHECK_TIMEOUT', 3);
//define('AMIN_THEME', 'default');
define('AMIN_THEME', 'blue_horizons');
$fullURL = !empty($_SERVER['HTTPS']) == 'on' ? 'https://' : 'http://';
$fullURL .= $_SERVER['SERVER_PORT'] != '80' ? $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"] : $_SERVER['SERVER_NAME'];

define('URL_ABSOLUTE', $fullURL.'/');

// The relative URL
define('URL_PUBLIC', '/');

// Use httpS for the backend?
// Before enabling this, please make sure you have a working HTTP+SSL installation.
define('USE_HTTPS', false);

// The directory name of your administration (you will need to change it manually)
define('ADMIN_DIR', 'admin');

// Friendly URLs
define('USE_MOD_REWRITE', true);

// Add a suffix to pages (simluating static pages '.html')
define('URL_SUFFIX', '.html');

// Set the timezone of your choice.
// Go here for more information on the available timezones:
// http://php.net/timezones
define('DEFAULT_TIMEZONE', 'Europe/London');

// Use poormans cron solution instead of real one.
// Only use if cron is truly not available, this works better in terms of timing
// if you have a lot of traffic.
define('USE_POORMANSCRON', false);

// Rough interval in seconds at which poormans cron should trigger.
// No traffic == no poormans cron run.
define('POORMANSCRON_INTERVAL', 3600);