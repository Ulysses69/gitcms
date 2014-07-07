<?php

$version = Plugin::getSetting('version', 'banner5');


/*
$PDO = Record::getConnection();
$driver = strtolower($PDO->getAttribute(Record::ATTR_DRIVER_NAME));
if ($driver == 'mysql'){
	$query = $PDO->query("SELECT * FROM ".TABLE_PREFIX."page WHERE behavior_id = 'tagger'");
	if(!$query->rowCount()){
		$PDO->exec("INSERT INTO ".TABLE_PREFIX."page (id, title, slug, breadcrumb, keywords, description, parent_id, layout_id, behavior_id, status_id, created_on, published_on, updated_on, created_by_id, updated_by_id, position, is_protected) VALUES('', 'Banner', 'banner5', 'Banner', '', '', '1', '0', 'tagger', '101', '".date('Y-m-d H:i:s')."', NULL, NULL, '1', '1', '2', '0')");
		$PDO->exec("INSERT INTO ".TABLE_PREFIX."page_part (id, name, filter_id, content, content_html, page_id) VALUES('', 'body', '', '<?php\r\n\$pages = \$this->tagger->pagesByTag();\r\nif(\$pages){\r\necho \"<h3>Pages tagged with ''\".\$this->tagger->tag().\"''</h3>\";\r\n      foreach(\$pages as \$slug => \$page)\r\n{\r\n		echo ''<h3><a href=\"''.\$slug.''\">''.\$page.''</a></h3>'';\r\n	}\r\n} else {\r\n	echo \"There are no items with this tag.\";\r\n}\r\n?>', '<?php\r\n\$pages = \$this->tagger->pagesByTag();\r\nif(\$pages){\r\necho \"<h3>Pages tagged with ''\".\$this->tagger->tag().\"''</h3>\";\r\n      foreach(\$pages as \$slug => \$page)\r\n{\r\n		echo ''<h3><a href=\"''.\$slug.''\">''.\$page.''</a></h3>'';\r\n	}\r\n} else {\r\n	echo \"There are no items with this tag.\";\r\n}\r\n?>', '".$PDO->lastInsertId()."')");
	}
}
$PDO->exec("INSERT INTO ".TABLE_PREFIX."snippet (name, filter_id, content, content_html, created_on, created_by_id) VALUES ('banner5', '', '<h3>Banner</h3>\r\n<?php tagger(\'count\'); ?>', '<h3>Banner</h3>\r\n<?php tagger(\'count\'); ?>', '".date('Y-m-d H:i:s')."', 1)");
*/

/* Ensure Elements plugin is enabled */
//if(Plugin::isEnabled('elements') == true){

	// Check if settings were found for banner5
	if (!$version || $version == null) {
	    // Check if we're upgrading from a previous version.
	    $upgrade = checkForOldInstall();
	
	    // Upgrading from previous installation
	    if ($upgrade) {
	        // Retrieve the old settings.
	        $PDO = Record::getConnection();
	        $tablename = TABLE_PREFIX.'banner5';

	        $sql_check = "SELECT COUNT(*) FROM $tablename";
	        $sql = "SELECT * FROM $tablename";
	
	        $result = $PDO->query($sql_check);
	
	        // Checking if old banner5 table is OK
	        if ($result && $result->fetchColumn() != 1) {
	            $result->closeCursor();
	            Flash::set('error', __('Banner - upgrade needed, but invalid upgrade scenario detected!'));
	            return;
	        }
	        
	        if (!$result) {
	            Flash::set('error', __('Banner - upgrade need detected earlier, but unable to retrieve table information!'));
	            return;
	        }
	
	        // Fetch the old installation's records.
	        $result = $PDO->query($sql);
	
	        if ($result && $row = $result->fetchObject()) {
	            $settings = array('version' => $version,
	                              'bannerid' => $row->bannerid,
	                              'bannerwidth' => $row->bannerwidth,
	                              'bannerheight' => $row->bannerheight,
	                              'bannerradius' => $row->bannerradius,
	                              'bannercode' => $row->bannercode,
	                              'bannerimages' => $row->bannerimages,
	                              'bannerinclude' => $row->bannerinclude,
	                              'bannerexclude' => $row->bannerexclude,
	                              'imagesarray' => $row->imagesarray,
	                              'descriptionsarray' => $row->descriptionsarray,
	                              'pref_controls' => $row->pref_controls,
	                              'pref_random' => $row->pref_random,
	                              'pref_preload' => $row->pref_preload,
	                              'pref_transition' => $row->pref_transition,
	                              'pref_burns' => $row->pref_burns,
	                              'pref_burntime' => $row->pref_burntime,
	                              'pref_time' => $row->pref_time,
	                              'pref_pause' => $row->pref_pause,
	                              'pref_delay' => $row->pref_delay
	                             );
	            $result->closeCursor();
	        }
	        else {
	            Flash::set('error', __('Banner - upgrade needed, but unable to retrieve old settings!'));
	            return;
	        }
	    }
	    // This is a clean install.
	    else {
	        $settings = array(	'version' => '0.5.0',
	        			'bannerid' => 'banner',
	        			'bannerwidth' => '600',
	        			'bannerheight' => '199',
	        			'bannerradius' => '0',
	        			'bannercode' => '',
	        			'bannerimages' => '/public/images/banner/',
	        			'bannerinclude' => 'home',
	        			'bannerexclude' => '',
	        			'imagesarray' => '',
	        			'descriptionsarray' => '',
					    'pref_controls' => 'false',
						'pref_random' => 'false',
						'pref_preload' => '0',
						'pref_transition' => 'noTransition',
						'pref_burns' => 'none',
						'pref_burntime' => '5',
						'pref_time' => '1',
						'pref_pause' => '4',
						'pref_delay' => '4'
	
	                         );
	    }
	
	    // Store settings.
	    if (Plugin::setAllSettings($settings, 'banner5')) {
	        if ($upgrade)
	            Flash::set('success', __('Banner - plugin settings copied from old installation.'));
	        else
	            Flash::set('success', __('Banner - plugin settings initialized.'));
	    }
	    else
	        Flash::set('error', __('Banner - unable to store plugin settings!'));

	}

//} else {
//	Flash::set('error', __('Elements plugin must be enabled to install Banner plugin.'));
//}
        
/**
 * This function checks to see if there is a valid old installation with regards to the DB.
 * 
 * @return boolean
 */
function checkForOldInstall() {
    $tablename = TABLE_PREFIX.'banner5';
    $PDO = Record::getConnection();

    $sql = "SELECT COUNT(*) FROM $tablename";

    $result = $PDO->query($sql);

    if ($result != null) {
        $result->closeCursor();
        return true;
    }
    else
        return false;
}

?>