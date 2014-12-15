<?php

/* Get defined constants such as version */
include PLUGINS_ROOT . '/'.basename(dirname(__FILE__)).'/index.php';

/* Get plugin settings (if they exist) */
$version = Plugin::getSetting('version', 'ads');

/* Set version setting */
$settings = array('version' => ADS_VERSION);

$update = false;

// Check existing plugin settings
//if (!$version || $version == null) {

	// Boxes table
	$pdo = Record::getConnection();
	$boxes_table = TABLE_PREFIX . "ads_boxes";

	/* Check for boxes table */
	$box_sql = "SELECT * FROM ".$boxes_table."";
	$box_q = Record::getConnection()->query($box_sql);
	if($box_q){ $box_f = $box_q->fetchAll(PDO::FETCH_OBJ); }
	
	// This is a clean install. Table does not exist.
	if(!isset($box_f) || !is_array($box_f)){

		// Setup database.
		if (preg_match('/^mysql/', DB_DSN)) {
			// Schema for MySQL
			$pdo->exec("CREATE TABLE $boxes_table (
				id		  INT(11) NOT NULL AUTO_INCREMENT,
				boxlabel   VARCHAR(255),
				boxcontent 	VARCHAR(255),
				boxlinkurl 	VARCHAR(255),
				boxstatus 	VARCHAR(3) NOT NULL DEFAULT 'yes',
				itemkey 	VARCHAR(255),
				PRIMARY KEY (id)
				) DEFAULT CHARSET=utf8");	
		} else {
			// Otherwise assume SQLite
			$pdo->exec("CREATE TABLE $boxes_table (
				id		  INTEGER PRIMARY KEY AUTOINCREMENT,
				boxlabel   VARCHAR(255),
				boxcontent 	VARCHAR(255),
				boxlinkurl 	VARCHAR(255),
				boxstatus 	VARCHAR(3),
				itemkey 	VARCHAR(255)
				)");
		}

		// Store settings.
		if (Plugin::setAllSettings($settings, 'ads')) {
			Flash::set('success', __('Ads - database "') . $boxes_table . __('" created.'));
		} else {
			Flash::set('error', __('Ads - unable to create "') . $boxes_table . __('" database.'));
		}

	} else {

		Flash::set('success', __('Ads - database "') . $boxes_table . __('" found.'));

	}

	

	// Ad column
	$pdo = Record::getConnection();

	/* Check for ad column */
	$ad_sql = "SHOW COLUMNS FROM ".TABLE_PREFIX."page LIKE ad";
	$ad_q = Record::getConnection()->query($ad_sql);
	if($ad_q){ $ad_f = true; }

	// This is a clean install. Column does not exist.
	if(!isset($ad_f)){

		if (preg_match('/^mysql/', DB_DSN)) {
			$pdo->exec("ALTER TABLE ".TABLE_PREFIX."page ADD ad VARCHAR(255) NULL default NULL");
		}

		Flash::set('success', __('Ads - column "ad" created.'));

	} else {
		
		Flash::set('error', __('Ads - unable to create "ad" column.'));

	}


//} else {

	// Upgrade from previous installation (if needed)
	if ($version && ADS_VERSION > $version) {

		// Retrieve the old settings.
		$pdo = Record::getConnection();
		$boxes_tablename = TABLE_PREFIX.'plugin_settings';

		$sql_check = "SELECT COUNT(*) FROM $boxes_tablename WHERE plugin_id='".'ads'."'";
		$sql = "SELECT * FROM $boxes_tablename WHERE plugin_id='".'ads'."'";

		$result = $pdo->query($sql_check);

		if (!$result) {
			Flash::set('error', __('Ads - unable to access "') . $boxes_tablename . __('" data.'));
			return;
		}

		// Fetch the old installation's records.
		$result = $pdo->query($sql);

		if ($result && $row = $result->fetchObject()) {

			$result->closeCursor();
			if(defined('ADS_INCLUDE')){ header('Location: '.URL_PUBLIC.ADMIN_DIR.'/plugin/'.'ads'); }
		}
		
		$update = true;

	}


	// Store update settings.
	if($update == true){
		if (isset($settings) && Plugin::setAllSettings($settings, 'ads')) {
			if (ADS_VERSION > $version){
				Flash::set('success', __('Ads - plugin settings updated.'));
			}
		}
	}

//}


?>