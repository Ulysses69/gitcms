<?php

// TODO: We need to make a public/events/images dir for event images.

$PDO = Record::getConnection();
$tp = TABLE_PREFIX . 'events_';
$tables = array();

$tables[] = "CREATE TABLE IF NOT EXISTS {$tp}categories (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL
)";

$tables[] = "CREATE TABLE IF NOT EXISTS {$tp}events (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	start_date DATETIME NOT NULL,
	link VARCHAR(255) DEFAULT NULL,
	cost DECIMAL(10,2) DEFAULT NULL,
	description TEXT DEFAULT NULL,
	category_id INT(11) DEFAULT NULL,
	attraction_id INT(11) DEFAULT NULL,
	venue_id INT(11) DEFAULT NULL
)";

$tables[] = "CREATE TABLE IF NOT EXISTS {$tp}attractions (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	email VARCHAR(255) DEFAULT NULL,
	phone VARCHAR(255) DEFAULT NULL,
	link VARCHAR(255) DEFAULT NULL,
	bio TEXT
)";

$tables[] = "CREATE TABLE IF NOT EXISTS {$tp}venues (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	street VARCHAR(255) DEFAULT NULL,
	suburb VARCHAR(255) DEFAULT NULL,
	state VARCHAR(255) DEFAULT NULL,
	postcode VARCHAR(10) DEFAULT NULL,
	country VARCHAR(255) DEFAULT NULL,
	link VARCHAR(255) DEFAULT NULL,
	phone VARCHAR(255) DEFAULT NULL,
	contact_name VARCHAR(255) DEFAULT NULL,
	contact_email VARCHAR(255) DEFAULT NULL,
	description TEXT
)";

foreach ($tables as $sql) {
	$PDO->exec($sql);
}
