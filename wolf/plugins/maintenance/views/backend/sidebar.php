<?php if(!defined('IN_CMS')) { exit(); } ?>

<div class="box">

	<p class="button"><a href="<?php echo get_url('maintenance/switchStatus/'); ?><?php if($settings['maintenanceMode'] == 'off') { $stat = 'on'; } else { $stat = 'off'; } echo $stat; ?>" class="<?php echo $stat; ?>"><img src="<?php echo PLUGINS_URI . 'maintenance/images/' . $settings['maintenanceMode'] . '.png'; ?>" align="middle" alt="<?php echo strtoupper($settings['maintenanceMode']); ?>" />Restricted mode is <strong><?php echo strtoupper($settings['maintenanceMode']); ?></strong></a></p>
	<p class="button"><a href="<?php echo get_url('maintenance/access'); ?>"><img src="<?php echo PLUGINS_URI . 'maintenance/images/access.png'; ?>" align="middle" alt="Access" /> Access List</a></p>
	<p class="button"><a href="<?php echo get_url('maintenance/settings'); ?>"><img src="<?php echo PLUGINS_URI  . 'maintenance/images/settings.png'; ?>" align="middle" alt="Settings" /> Settings</a></p>

</div>

<br />

<?php if(Plugin::isEnabled('searchbox') == true){ ?>
<div class="box warning">
<h2><?php echo __('Warning');?></h2>
<p>Search feature does not presently work with restricted mode on.</p>
</div>
<?php } ?>





<?php
//echo "<html><body><table>\n\n";
function logList($log_file){
	echo '<ul>';
	$f = fopen($log_file, "r");
	$used_ips = array();
	while (($line = fgetcsv($f)) !== false) {
		//echo "<tr>";
		foreach ($line as $cell) {
			//echo "<td>" . htmlspecialchars($cell) . "</td>";
		}
		//echo "</tr>\n";
		$date = $line[0];
		$time = $line[1];
		$ip = $line[2];
		if(!in_array($ip, $used_ips)){
			echo '<li><p><b>' . $ip . '</b><span> on ' . $date . ' at ' . $time . '<span></p></li>';
		}
		$used_ips[] = $ip;
	}
	fclose($f);
	echo '</ul>';
}
//echo "\n</table></body></html>";
?>


<?php
$log_file = $_SERVER["DOCUMENT_ROOT"].'/../admin-log.txt';
$mockup_file = $_SERVER["DOCUMENT_ROOT"].'/../mockup-log.txt';
?>


<div class="box warning logins">
<h2><?php echo __('Logged IPs');?></h2>

<?php if(file_exists($log_file) && filesize($log_file) > 0){ ?>
<p>Failed attempts at admin access.</p>
<?php logList($log_file); ?>
<?php } ?>

<?php if(file_exists($mockup_file) && filesize($mockup_file) > 0){ ?>
<p>Access to mockups.</p>
<?php logList($mockup_file); ?>
<?php } ?>

</div>