<?php

/* Get defined constants such as version */
include PLUGINS_ROOT . '/'.basename(dirname(__FILE__)).'/index.php';

// Get plugin settings (if they exist)
$version = Plugin::getSetting('version', 'pricelist');

//Set version setting
$settings = array('version' => PRICELIST_VERSION);

// Check for existing settings
if(!Plugin::getSetting('itempricelabel', 'pricelist')) $settings['itempricelabel'] = 'Price 1';
if(!Plugin::getSetting('itemprice2label', 'pricelist')) $settings['itemprice2label'] = 'Price 2';

// Prices table
$table = TABLE_PREFIX . "pricelist_prices";

// Check existing plugin settings
//if (!$version || $version == null || $table == FALSE) {
if ($table == FALSE) {

	$pdo   = Record::getConnection();

	if (preg_match('/^mysql/', DB_DSN)) {
	    // Schema for MySQL
	    $pdo->exec("CREATE TABLE $table (
	        id          INT(11) NOT NULL AUTO_INCREMENT,
	        itemlabel   VARCHAR(255),
	    	itemdesc 	VARCHAR(255),
	    	itemprice 	VARCHAR(255),
	    	itemprice2 	VARCHAR(255),
	    	itemkey 	VARCHAR(255),
	        PRIMARY KEY (id)
	        ) DEFAULT CHARSET=utf8");    
	} else {
	    // Otherwise assume SQLite
	    $pdo->exec("CREATE TABLE $table (
	        id          INTEGER PRIMARY KEY AUTOINCREMENT,
		    itemlabel   VARCHAR(255),
			itemdesc 	VARCHAR(255),
			itemprice 	VARCHAR(255),
			itemprice2 	VARCHAR(255),
			itemkey 	VARCHAR(255)
	        )");
	}

    // Store settings.
    if (Plugin::setAllSettings($settings, 'pricelist')) {
        Flash::set('success', __('Pricelist - database "'.$table.'" created.'));
    }
    else
        Flash::set('error', __('Pricelist - unable to create database "'.$table.'"'));



} else {

    // Upgrade from previous installation
    if (PRICELIST_VERSION > $version) {

        // Retrieve the old settings.
        $PDO = Record::getConnection();
        $tablename = TABLE_PREFIX.'plugin_settings';

        $sql_check = "SELECT COUNT(*) FROM $tablename WHERE plugin_id='".'pricelist'."'";
        $sql = "SELECT * FROM $tablename WHERE plugin_id='".'pricelist'."'";

        $result = $PDO->query($sql_check);

        if (!$result) {
			Flash::set('error', __('Pricelist - unable to access plugin settings.'));
			return;
        }

        // Fetch the old installation's records.
        $result = $PDO->query($sql);

        if ($result && $row = $result->fetchObject()) {

            $result->closeCursor();
            if(defined('PRICELIST_INCLUDE')){ header('Location: '.URL_PUBLIC.ADMIN_DIR.'/plugin/'.'pricelist'); }
        }
    }


    // Store settings.
    if (isset($settings) && Plugin::setAllSettings($settings, 'pricelist')) {
        if (PRICELIST_VERSION > $version){
			Flash::set('success', __('Pricelist - plugin settings updated.'));
		}
    }

}


?>