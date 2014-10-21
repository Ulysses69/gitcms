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

/* Prevent direct access. */
if (!defined("FRAMEWORK_STARTING_MICROTIME")) {
	die("All your base are belong to us!");
}

/* Ensure htaccess plugin is enabled */
if(Plugin::isEnabled('_htaccess') != true){
	Flash::set('error', __('_htaccess plugin must first be enabled'));
}

/* Get plugin settings (if they exist) */
$version = Plugin::getSetting('version', 'redirector');

/* Set version setting */
$settings = array('version' => REDIRECTOR_VERSION);

$pdo   = Record::getConnection();
$table = TABLE_PREFIX . "redirector_redirects";

/* Check for table */
$red_sql = "SELECT * FROM ".$table."";
$red_q = Record::getConnection()->query($red_sql);
$red_f = $red_q->fetchAll(PDO::FETCH_OBJ);

// Check existing plugin settings (table must not exist)
if ((!$version || $version == null) && !is_array($red_f)) {

	// This is a clean install.
	
	if (preg_match('/^mysql/', DB_DSN)) {
		/* Schema for MySQL */
		$pdo->exec("CREATE TABLE $table (
			id		  INT(11) NOT NULL AUTO_INCREMENT,
			url	 	VARCHAR(255),
			destination VARCHAR(255),
			hits		INT(11) DEFAULT 0 NOT NULL,
			status	  INT(3) DEFAULT 0 NOT NULL,
			created_on  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id)
			) DEFAULT CHARSET=utf8");	
	} else {
		/* Otherwise assume SQLite */
		$pdo->exec("CREATE TABLE $table (
			id		  INTEGER PRIMARY KEY AUTOINCREMENT,
			url	 	VARCHAR(255),
			destination VARCHAR(255),
			hits		INT(11) DEFAULT 0 NOT NULL,
			status	  INT(3) DEFAULT 301 NOT NULL,
			created_on  DATETIME DEFAULT NULL
			)");
	}
	
	$pdo   = Record::getConnection();
	$table = TABLE_PREFIX . "redirector_404s";
	
	if (preg_match('/^mysql/', DB_DSN)) {
		/* Schema for MySQL */
		$pdo->exec("CREATE TABLE $table (
			id		  INT(11) NOT NULL AUTO_INCREMENT,
			url		 VARCHAR(255),
			hits		INT(11) DEFAULT 1 NOT NULL,
			status	  INT(3) DEFAULT 1 NOT NULL,
			created_on  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id)
			) DEFAULT CHARSET=utf8");	
	} else {
		/* Otherwise assume SQLite */
		$pdo->exec("CREATE TABLE $table (
			id		  INTEGER PRIMARY KEY AUTOINCREMENT,
			url		 VARCHAR(255),
			hits		INT(11) DEFAULT 1 NOT NULL,
			status	  INT(3) DEFAULT 1 NOT NULL,
			created_on  DATETIME DEFAULT NULL
			)");
	}

} else {

	// Store settings.
	if (isset($settings) && Plugin::setAllSettings($settings, 'redirector')) {
		if (REDIRECTOR_VERSION > $version){
			Flash::set('success', __('Redirector - plugin settings updated.'));
		}
	}

}