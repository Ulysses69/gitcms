<?php

/*
 * Funky Cache - Frog CMS caching plugin
 *
 * Copyright (c) 2008-2009 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/funky_cache
 *
 */
 
$PDO = Record::getConnection();

$table = TABLE_PREFIX . "setting";
$PDO->exec("INSERT INTO $table (name, value) 
			VALUES ('funky_cache_by_default', '1')");

/* Use system suffix for cache files.		*/
/* If no suffix is set use .html by default. */
$suffix = trim(URL_SUFFIX) ? URL_SUFFIX : ".html";
$PDO->exec("INSERT INTO $table (name, value) 
			VALUES ('funky_cache_suffix', '$suffix')");

/* By default write static files to document root. */
$PDO->exec("INSERT INTO $table (name, value) 
			VALUES ('funky_cache_folder', '/cache/')");
					
$table = TABLE_PREFIX . "page";
$PDO->exec("ALTER TABLE $table
			ADD funky_cache_enabled tinyint(1) 
			NOT NULL default 1");

$table = TABLE_PREFIX . "funky_cache_page";

$driver = strtolower($PDO->getAttribute(Record::ATTR_DRIVER_NAME));

// Table structure for table: funky_cache_page ----------------------------------------

if ($driver == 'mysql')
{
	$PDO->exec("CREATE TABLE $table (
			id int(11) NOT NULL auto_increment,
			page_id INT( 11 ) NOT NULL default '0',
			url varchar(255) default NULL,
			created_on datetime default NULL,
			PRIMARY KEY (id),
			KEY page_id (page_id),
			UNIQUE (url)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");

}

if ($driver == 'sqlite')
{/*
	$PDO->exec("CREATE TABLE $table (
		id INT,
			page_id INT,
			url varchar(255) default NULL,
			created_on datetime default NULL,
	)");
*/
		$PDO->exec("CREATE TABLE $table (
				id INTEGER NOT NULL PRIMARY KEY,
				page_id int(11) NOT NULL default '0',
			url varchar(255) default NULL,
			created_on datetime default NULL
			  )");
	$PDO->exec("CREATE INDEX cache_page_id ON $table (page_id)");
}