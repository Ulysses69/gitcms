<?php
AutoLoader::addFolder(dirname(__FILE__) . '/models');

$table_name = TABLE_PREFIX.RelatedPages::TABLE_NAME;

// Connection
$pdo = Record::getConnection();
$driver = strtolower($pdo->getAttribute(Record::ATTR_DRIVER_NAME));

if ($driver == 'mysql') {
  // Create table

  $pdo->query("CREATE TABLE $table_name (
    id                  int(11) unsigned NOT NULL AUTO_INCREMENT,
    page_id             int(11) unsigned NOT NULL,
    related_page_id     int(11) unsigned NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
}
else if ($driver == 'sqlite') {
  // Create table
  $pdo->query("CREATE TABLE $table_name (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    page_id     INTEGER NOT NULL,
    related_page_id     INTEGER NOT NULL
  )");
}
?>