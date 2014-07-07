<?php

$PDO = Record::getConnection();
$driver = strtolower($PDO->getAttribute(Record::ATTR_DRIVER_NAME));

if ($driver == 'mysql')
{
    //$PDO->exec("ALTER TABLE ".TABLE_PREFIX."page ADD robots varchar(255) NULL default NULL");
    //$PDO->exec("ALTER TABLE ".TABLE_PREFIX."user ADD user_pic VARCHAR(255) NULL default NULL , ADD canonical VARCHAR(255) NULL default NULL");
    $PDO->exec("ALTER TABLE ".TABLE_PREFIX."user ADD user_pic VARCHAR(255) NULL default NULL");
}
else if ($driver == 'sqlite')
{
	//someday will add this option if needed
	//$PDO->exec("CREATE INDEX comment_page_id ON comment (page_id)");
	//$PDO->exec("CREATE INDEX comment_created_on ON comment (created_on)");
    
    //$PDO->exec("ALTER TABLE page ADD comment_status tinyint(1) NOT NULL default '0'");
    //$PDO->exec("ALTER TABLE comment ADD ip char(100) NOT NULL default '0'");	
}