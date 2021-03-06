<?php

	if(!defined('IN_CMS')) { exit(); }

	$time = time();

	global $__CMS_CONN__;
	$sql = "	INSERT INTO `".TABLE_PREFIX."plugin_settings` (`plugin_id`,`name`,`value`)
				VALUES
					('maintenance', 'maintenanceMode', 'off'),
					('maintenance', 'maintenanceView', 'static'),
					('maintenance', 'maintenanceBackdoorStatus', 'off'),
					('maintenance', 'maintenanceBackdoorKey', '$time'),
					('maintenance', 'maintenanceRedirectURL', 'http://www.google.co.uk'),
					('maintenance', 'maintenanceAuthorizedAccess', 'off');";
	$pdo = $__CMS_CONN__->prepare($sql);
	$pdo->execute();

	$createAllowedTable = "
		CREATE TABLE `".TABLE_PREFIX."maintenance_allowed` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`ip` varchar(20) DEFAULT NULL,
			`name` varchar(128) DEFAULT NULL,
			`notes` varchar(1024) DEFAULT NULL,
			`enabled` enum('yes','no') DEFAULT NULL,
			PRIMARY KEY (`id`)
		)";
	$stmt = $__CMS_CONN__->prepare($createAllowedTable);
	$stmt->execute();

	$createPageContent = "
		CREATE TABLE `".TABLE_PREFIX."maintenance_page` (
			`id` int(1) DEFAULT NULL,
			`value` varchar(4096) DEFAULT NULL
		)";
	$stmt = $__CMS_CONN__->prepare($createPageContent);
	$stmt->execute();

	$maintenanceHTML = '<html>
	<head>
		<title>Maintenance Mode</title>
		<style>
			body {
				background: #B6B6B6;
				color: #000000;
				font: 75% Tahoma, Verdana, Arial, Helvetica, sans-serif;
				text-align: center;
			}
			#offlineHolder {
				margin: 100px auto;
				padding: 20px;
				width: 300px;
				height: 60px;
				background-color: white;
				border-radius: 15px;
				-moz-border-radius: 15px;
				-webkit-border-radius: 15px;
			}
		</style>
	</head>
	<body>
		<div id="offlineHolder">
			<p><strong>We are currently offline for maintenance.</strong></p>
			<p>We will be back online soon.</p>
		</div>
	</body>
</html>';

	$addMaintenancePage = "
			INSERT INTO `".TABLE_PREFIX."maintenance_page` (`id`,`value`)
				VALUES
					('1', '$maintenanceHTML')
				;";
	$pdo = $__CMS_CONN__->prepare($addMaintenancePage);
	$pdo->execute();


	$checkLocalhost = "SELECT * FROM ".TABLE_PREFIX."maintenance_allowed";
	$pdo = $__CMS_CONN__->prepare($checkLocalhost);
	$pdo->execute();
	$checkLocalhostCount = $pdo->rowCount();

	if($checkLocalhostCount == 0) {
		$addLocalhost = "
				INSERT INTO `".TABLE_PREFIX."maintenance_allowed` (`id`,`ip`,`name`,`notes`,`enabled`)
					VALUES
						('', '127.0.0.1', 'Localhost', 'This is a useful IP to allow when running a L/M/W AMP Stack as it\'s probably yours', 'yes')
					;";
		$pdo = $__CMS_CONN__->prepare($addLocalhost);
		$pdo->execute();
	}

	exit();