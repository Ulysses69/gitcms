<?php

/* Prevent direct access. */
if (!defined("FRAMEWORK_STARTING_MICROTIME")) {
	die("All your base are belong to us!");
}

$pdo   = Record::getConnection();
$table = TABLE_PREFIX . "searchbox_searchquerys";

if (preg_match('/^mysql/', DB_DSN)) {
	/* Schema for MySQL */
	$pdo->exec("CREATE TABLE $table (
			id		INT(11) NOT NULL AUTO_INCREMENT,
			url		VARCHAR(255),
			query		VARCHAR(255),
			destination	VARCHAR(255),
			hits		INT(11) DEFAULT 0 NOT NULL,
			created_on	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id)
		) DEFAULT CHARSET=utf8");	
} else {
	/* Otherwise assume SQLite */
	$pdo->exec("CREATE TABLE $table (
			id		INTEGER PRIMARY KEY AUTOINCREMENT,
			url		VARCHAR(255),
			query		VARCHAR(255),
			destination	VARCHAR(255),
			hits		INT(11) DEFAULT 0 NOT NULL,
			created_on	DATETIME DEFAULT NULL
		)");
}

$pdo   = Record::getConnection();
$table = TABLE_PREFIX . "searchbox_matches";

if (preg_match('/^mysql/', DB_DSN)) {
	/* Schema for MySQL */
	$pdo->exec("CREATE TABLE $table (
			id		  INT(11) NOT NULL AUTO_INCREMENT,
			url		 VARCHAR(255),
			query		 VARCHAR(255),
			hits		INT(11) DEFAULT 1 NOT NULL,
			created_on  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id)
		) DEFAULT CHARSET=utf8");	
} else {
	/* Otherwise assume SQLite */
	$pdo->exec("CREATE TABLE $table (
			id		  INTEGER PRIMARY KEY AUTOINCREMENT,
		url		 VARCHAR(255),
		query		 VARCHAR(255),
		hits		INT(11) DEFAULT 1 NOT NULL,
			created_on  DATETIME DEFAULT NULL
		)");
}

