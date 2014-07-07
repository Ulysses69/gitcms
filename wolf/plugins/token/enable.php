<?php

/*
 * Token - Wolf CMS URL token plugin
 *
 * Copyright (c) 2012 Steven Henderson
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 *
 */

/* Prevent direct access. */
if (!defined("FRAMEWORK_STARTING_MICROTIME")) {
    die("All your base are belong to us!");
}

$pdo   = Record::getConnection();
$table = TABLE_PREFIX . "token_tokens";

if (preg_match('/^mysql/', DB_DSN)) {
    /* Schema for MySQL */
    $pdo->exec("CREATE TABLE $table (
        id          	INT(11) NOT NULL AUTO_INCREMENT,
        placeholder    	VARCHAR(255),
    	literal_main 	VARCHAR(255),
    	literal_mobile 	VARCHAR(255),
        PRIMARY KEY (id)
        ) DEFAULT CHARSET=utf8");
} else {
    /* Otherwise assume SQLite */
    $pdo->exec("CREATE TABLE $table (
        id          	INTEGER PRIMARY KEY AUTOINCREMENT,
	    placeholder     VARCHAR(255),
		literal_main 	VARCHAR(255),
		literal_mobile 	VARCHAR(255)
        )");
}

/*
$pdo   = Record::getConnection();
$table = TABLE_PREFIX . "token_404s";

if (preg_match('/^mysql/', DB_DSN)) {
    // Schema for MySQL
    $pdo->exec("CREATE TABLE $table (
        id          	INT(11) NOT NULL AUTO_INCREMENT,
    	placeholder		VARCHAR(255),
        PRIMARY KEY (id)
        ) DEFAULT CHARSET=utf8");
} else {
    // Otherwise assume SQLite
    $pdo->exec("CREATE TABLE $table (
        id          	INTEGER PRIMARY KEY AUTOINCREMENT,
		placeholder		VARCHAR(255)
        )");
}
*/
