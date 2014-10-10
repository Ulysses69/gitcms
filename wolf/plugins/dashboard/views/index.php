<!-- <h1><?php echo __('Dashboard'); ?></h1> -->

<?php error_reporting(E_ALL); ?>

<form action="<?php echo get_url('plugin/dashboard/clear'); ?>" method="post">

<input id="push_page_to_top" />

	<?php
	$logitems = 0;
	$todayitems = sizeof($log_entry_today);
	$yesterdayitems = sizeof($log_entry_yesterday);
	$olderitems = sizeof($log_entry_older);
	$itemscount = $todayitems + $yesterdayitems + $olderitems;
	?>

	<?php
	$avatar = '';
	/*
	function ExternalFileExists($location, $misc_content_type = false){
		//echo '<!-- External File Exists Status -->';
		$curl = curl_init($location);
		curl_setopt($curl,CURLOPT_NOBODY,true);
		curl_setopt($curl,CURLOPT_HEADER,true);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_TIMEOUT_MS,206);
		curl_exec($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);

		if((int)$info['http_code'] >= 200 && (int)$info['http_code'] <= 206) {
			//Response says ok.
			if($misc_content_type !== false) {
				//echo '<!-- Response OK -->';
				return strpos($info['content_type'],$misc_content_type);
			}
			return true;
		}
		return false;

	}
	*/
	if(!function_exists('ExternalFileExists')){
		  function ExternalFileExists($location,$misc_content_type = false){

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $location);
			curl_setopt($curl, CURLOPT_NOBODY, 1);
			curl_setopt($curl, CURLOPT_FAILONERROR, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_TIMEOUT_MS, 1000);
			
			if(curl_exec($curl) !== FALSE){
				return true;
			} else {
				return false;
			}
	
		}
	}
	$sourceurl = 'http://www.bluehorizonsmarketing.co.uk/public/users/';

	if(AuthUser::hasPermission('client')){
		if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/public/images/users/'.AuthUser::getRecord()->username.'.jpg')){
			$avatar .= '/public/images/users/'.AuthUser::getRecord()->username.'.jpg';
		} else if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/public/images/users/'.AuthUser::getRecord()->username.'.png')){
			$avatar .= '/public/images/users/'.AuthUser::getRecord()->username.'.png';
		} else if(file_exists($_SERVER{'DOCUMENT_ROOT'}.'/public/images/users/'.AuthUser::getRecord()->username.'.gif')){
			$avatar .= '/public/images/users/'.AuthUser::getRecord()->username.'.gif';
		} else {
			if (ExternalFileExists($sourceurl.AuthUser::getRecord()->username.'.png')) {
				$avatar = $sourceurl.AuthUser::getRecord()->username.'.png';
			} else if (ExternalFileExists($sourceurl.AuthUser::getRecord()->username.'.jpg')) {
				$avatar = $sourceurl.AuthUser::getRecord()->username.'.jpg';
			} else if (ExternalFileExists($sourceurl.AuthUser::getRecord()->username.'.gif')) {
				$avatar = $sourceurl.AuthUser::getRecord()->username.'.gif';
			} else {
				$avatar = $sourceurl.'user.png';
			}
		}
	} else {
		$png = $sourceurl.AuthUser::getRecord()->username.'.png';
		$jpg = $sourceurl.AuthUser::getRecord()->username.'.jpg';
		$gif = $sourceurl.AuthUser::getRecord()->username.'.gif';
		if(function_exists('file_get_contents')){
			echo '<!-- File Get Contents Supported -->';
			if(ExternalFileExists($png) || ExternalFileExists($jpg) || ExternalFileExists($gif)){
				echo '<!-- Get Contents -->';
				// The image exists
				if(stristr($png,'.png')){ $avatar .= $png; } else
				if(stristr($jpg,'.jpg')){ $avatar .= $jpg; } else
				if(stristr($gif,'.gif')){ $avatar .= $gif; }
			} else {
				// The image doesn't exist
				$avatar = URL_PUBLIC.ADMIN_DIR.'/images/user.png';
			}
		} else {
			 echo '<!-- File Get Contents Not Supported -->';
		}

		/*
		if (@fclose(@fopen($sourceurl.AuthUser::getRecord()->username.'.png', 'r'))) {
			$avatar .= $sourceurl.AuthUser::getRecord()->username.'.png';
		} else if (@fclose(@fopen($sourceurl.AuthUser::getRecord()->username.'.jpg', 'r'))) {
			$avatar .= $sourceurl.AuthUser::getRecord()->username.'.jpg';
		} else if (@fclose(@fopen($sourceurl.AuthUser::getRecord()->username.'.gif', 'r'))) {
			$avatar .= $sourceurl.AuthUser::getRecord()->username.'.gif';
		} else {
			//echo $sourceurl.'user.png';
			$avatar .= URL_PUBLIC.ADMIN_DIR.'/images/user.png';
		}
		*/

	}


	echo '<!-- Avatar Status -->';
	echo '<!-- Avatar: '.$avatar.' -->';
	$avatarSrc = $avatar;
	$avatarName = AuthUser::getRecord()->name;
	?>





	<?php
	/* Get analytics value */
	echo '<!-- Analytics Status -->';
	$analytics_sql = "SELECT * FROM ".TABLE_PREFIX."snippet WHERE name='analytics'";
	$analytics_q = Record::getConnection()->query($analytics_sql);
	$analytics_f = $analytics_q->fetchAll(PDO::FETCH_OBJ);
	$checkAnalytics = '';
	$checkAnalyticsID = '';
	foreach ($analytics_f as $analytics) {
		 $checkAnalytics = $analytics->content;
		 $checkAnalyticsID = $analytics->id;
	}

	/* Get copyright value */
	$copyright_sql = "SELECT * FROM ".TABLE_PREFIX."snippet WHERE name='copyright'";
	$copyright_q = Record::getConnection()->query($copyright_sql);
	$copyright_f = $copyright_q->fetchAll(PDO::FETCH_OBJ);
	$checkCopyright = '';
	$checkCopyrightID = '';
	foreach ($copyright_f as $copyright) {
		 $checkCopyright = $copyright->content;
		 $checkCopyrightID = $copyright->id;
	}

	/* Get cache value */
	if(Plugin::isEnabled('funky_cache') == true){
		$cache_sql = "SELECT * FROM ".TABLE_PREFIX."funky_cache_page";
		$cache_q = Record::getConnection()->query($cache_sql);
		$cache_f = $cache_q->fetchAll(PDO::FETCH_OBJ);
		$cacheCount = 0;
		foreach ($cache_f as $cache) {
			 $cacheCount++;
		}
	}

	/* Get client value */
	$client_sql = "SELECT * FROM ".TABLE_PREFIX."user WHERE username='client'";
	$client_q = Record::getConnection()->query($client_sql);
	$client_f = $client_q->fetchAll(PDO::FETCH_OBJ);
	$checkClientName = '';
	$checkClientID = '';
	foreach ($client_f as $client) {
	 	 $checkClientName = $client->username;
			 $checkClientPassword = $client->password;
			 $checkClientID = $client->id;
	}

	?>

	<?php $warnings = ''; ?>

	<?php if (!AuthUser::hasPermission('client')) {

		if(Plugin::isEnabled('comment') == true){
			$pendingcount = comments_count_moderatable();
			if($pendingcount == '1'){ $pendings = ' is'; } else { $pendings = 's are'; }
			if(Plugin::getSetting('numlabel', 'comment') == '1' && $pendingcount >= 1){
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/plugin/comment/moderation/"><b>Check Comments</b></a><br />'.$pendingcount.' comment'.$pendings.' pending approving.<br /><br /></li>';
			}
		}

		if(Plugin::isEnabled('clientdetails') == true){
				if(Plugin::getSetting('clientname', 'clientdetails') == 'Blue Horizons Client' || Plugin::getSetting('clientname', 'clientdetails') == ''){
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/plugin/clientdetails"><b>Specify Client Name</b></a><br />Specify the client (or company) name.<br /><br /></li>';
			}
		} else {
			if(Setting::get('admin_title') != '' && Setting::get('admin_title') == 'Blue Horizons Client'){
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/setting"><b>Specify Client Name</b></a><br />It is recommended that you set the client (or company) name.<br /><br /></li>';
			}
		}

		if(Setting::get('default_status_id') == 1){
			$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/setting"><b>Check Default Status</b></a><br />New pages are currently set to <b>Draft</b> status.<br /><br /></li>';
		}

		if(Page::findById(1)->layout_id == 10){
			$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/page/edit/1"><b>Proposal Layout Mode</b></a><br />Specify different layout when approved.<br /><br /></li>';
		}

		$favicon = $_SERVER{'DOCUMENT_ROOT'}.'/inc/img/icon.ico';
		if (file_exists($favicon)) {
			$iconsize = filesize($favicon);
			//$icondate = filemtime($favicon);
			//if($iconsize == '17062' && $icondate == '1240157004'){
			if($iconsize == '17062'){
				$warnings .= '<li class="warning"><a href="/inc/img/icon.ico" target="_blank"><b>Check Favicon</b></a><br />Do you want to use the current/default icon? <img src="/inc/img/icon.ico" class="helper" width="16" height="16" /><br /><br /></li>';
			}
		}

		if(Plugin::isEnabled('seobox') == true){
			$seo = Plugin::getSetting('clientanalyticsstatus', 'seobox');
			$clientanalyticslinks = Plugin::getSetting('clientanalyticslinks', 'seobox');
			$bots = Plugin::getSetting('bots', 'seobox');
			if(Plugin::getSetting('clientanalytics', 'seobox') == 'UA-XXXXX-X' || Plugin::getSetting('clientanalytics', 'seobox') == ''){
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/plugin/seobox"><b>Specify Analytics</b></a><br />Change default <b>UA-XXXXX-X</b> google analytics code.<br /><br /> <a href="https://www.google.com/analytics/settings/home" class="helper" target="_blank">Setup analytics</a></li>';
			}
			//if((Plugin::getSetting('clientanalytics', 'seobox') != 'UA-XXXXX-X' && Plugin::getSetting('clientanalytics', 'seobox') != '') && Plugin::getSetting('clientanalyticsstatus', 'seobox') == ''){
			if(Plugin::getSetting('clientanalytics', 'seobox') != 'UA-XXXXX-X' && ($seo == 'off' || $seo == '')){
				// Prompt to enable analytics, if analytics code is set
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/plugin/seobox"><b>Enable Analytics</b></a><br />Google Analytics is currently disabled.<br /><br /> <a href="/'.ADMIN_DIR.'/plugin/seobox" class="helper">Enable analytics</a></li>';
			}
			/*
			if($seo == 'off' || $seo == ''){
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/plugin/seobox"><b>Enable analytics</b></a><br />Google Analytics is currently disabled.<br /><br /></li>';
			}
			*/
			if($bots == 'disallow'){
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/plugin/seobox"><b>Allow Robots</b></a><br />Search engine indexing is currently disabled.<br /><br /></li>';
			}
		} else {
			if($checkAnalyticsID != '' && ($checkAnalytics == 'UA-XXXXX-X' || $checkAnalytics == '')){
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/snippet/edit/'.$checkAnalyticsID.'"><b>Specify Analytics</b></a><br />Change default <b>UA-XXXXX-X</b> google analytics code.<br /><br /> <a href="https://www.google.com/analytics/settings/home" class="helper" target="_blank">Setup analytics</a></li>';
			}
		}

		if(Plugin::isEnabled('googlemap') == true){
			if(Plugin::getSetting('latitude', 'googlemap') == '51.89413' || Plugin::getSetting('longitude', 'googlemap') == '-2.07555' || Plugin::getSetting('latitude', 'googlemap') == '' || Plugin::getSetting('longitude', 'googlemap') == ''){
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/plugin/googlemap"><b>Check Google map</b></a><br />Change flag marker position or latitude/longitude.<br /><br /></li>';
			}
		}

		if(Plugin::isEnabled('copyright') == true){
			if(Plugin::getSetting('livedate', 'copyright') == ''){
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/plugin/copyright"><b>Launch Date</b></a><br />Set the live launch date for this website. Reflected in footer copyright (if set).<br /><br /></li>';
			}

			if($checkClientPassword == '54182ec6c04a8808de3a55cd9a561d719c90e98d'){
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/user/edit/'.$checkClientID.'"><b>Check Password</b></a><br />For security, ensure '.$checkClientName.' password is changed before providing them access.<br /><br /></li>';
			}

			if(Plugin::getSetting('linkcustom', 'copyright') == '' && Plugin::getSetting('linkback', 'copyright') == ''){
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/plugin/copyright"><b>Check Copyright</b></a><br />Ensure the copyright / backlink is set for this website.<br /><br /></li>';
			}
		} else {
			if($checkCopyrightID != '' && $checkCopyright == ''){
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/snippet/edit/'.$checkCopyrightID.'"><b>Check Copyright</b></a><br />Ensure the copyright / backlink is set for this website.<br /><br /></li>';
			}
		}

		if(Plugin::isEnabled('funky_cache') == true && $cacheCount > 0){
				if($cacheCount != 1) { $cacheX = 's'; } else { $cacheX = ''; }
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/plugin/funky_cache"><b>Check Cached Pages <span class="counter">'.$cacheCount.'</span></b></a><br />Clear cached pages when making changes to pages/content.<br /><br /><span class="helper"><a href="/'.ADMIN_DIR.'/plugin/funky_cache/clear">Clear '.$cacheCount.' page'.$cacheX.'</a><!-- or <a href="/'.ADMIN_DIR.'/plugin/funky_cache/settings">Disable cache</a> --></span></li>';
		}

		if(Plugin::isEnabled('cleaner') == true){
			if(cleanCMS('check') == true){
				$warnings .= '<li class="warning"><a href="/'.ADMIN_DIR.'/plugin/cleaner"><b>Cleaning Recommended</span></b></a><br />There are files to <a href="'.get_url('plugin/cleaner').'/clean">clean</a>, according to the cleaning <a href="'.get_url('plugin/cleaner').'/settings">settings</a>.</li>';
			}
		}

		if(Plugin::isEnabled('backup_restore') == true && AuthUser::hasPermission('client')){
		$warnings .= '<li><a href="/'.ADMIN_DIR.'/plugin/backup_restore/backup"><b>Create a Backup</b></a><br />It is recommended to backup before making any other changes.<br /><br /></li>';
		$warnings .= '<li><a href="/'.ADMIN_DIR.'/plugin/backup_restore/restore"><b>Restore from Backup</b></a><br />Should you need to fix problems or revert to previous versions.<br /><br /></li>';
		}
		
		
		?>


	<?php } ?>

	<h2><img src="<?php echo $avatarSrc; ?>" width="30" height="30" class="avatar" />
	<?php
	if($warnings != ''){ ?>
		What would you like to do <?php echo $avatarName; ?>?</h2>
	<?php } else { ?>
		Hello <?php echo $avatarName; ?></h2>
	<?php } ?>

	<ul class="warnings"><?php echo $warnings; ?>

	<?php if (AuthUser::hasPermission('client')) { ?>
	<li><a href="/<?php echo ADMIN_DIR; ?>/page"><b>Manage pages</b></a><br />Add, delete, organize and update pages.<br /><br /></li>
	<?php } ?>
	</ul>


	<?php
    // Set history group count
    $history_spacer = 0;
    ?>


	
	<h2>Activity history</h2>

	<div id="history">
		<?php if(sizeof($log_entry_today) > 0){ $logitems .= sizeof($log_entry_today); ?>
		<!-- <hr > -->
		<h3><?php echo __('Today'); ?></h3>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<?php foreach ($log_entry_today as $entry): ?>
		<?php if((AuthUser::hasPermission('client') && strstr($entry->message,'Client')) || !AuthUser::hasPermission('client')){ ?>
		 <tr class="<?php print odd_even(); ?>">
			<td class="priority"><img src="<?php echo URL_PUBLIC;?>wolf/plugins/dashboard/img/<?php print $entry->priority('string') ?>.png" title="<?php print $entry->priority('string') ?>" /></td>
			<td><?php print $entry->message ?></td>
			<td class="date"><a title="<?php print $entry->created_on ?>"><?php print DateDifference::getString(new DateTime($entry->created_on)); ?></a></td>
		 </tr>
		<?php } ?>
		<?php endforeach; ?>
		</table>
		<?php $history_spacer++; if($history_spacer > 0) echo '<br/>'; } ?>
	
	
		<?php if(sizeof($log_entry_yesterday) > 0){ $logitems .= sizeof($log_entry_yesterday); ?>
		<!-- <hr > -->
		<h3><?php echo __('Yesterday'); ?></h3>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<?php foreach ($log_entry_yesterday as $entry): ?>
		<?php if((AuthUser::hasPermission('client') && strstr($entry->message,'Client')) || !AuthUser::hasPermission('client')){ ?>
		 <tr class="<?php print odd_even(); ?>">
			<td class="priority"><img src="<?php echo URL_PUBLIC;?>wolf/plugins/dashboard/img/<?php print $entry->priority('string') ?>.png" title="<?php print $entry->priority('string') ?>" /></td>
			<td><?php print $entry->message ?></td>
			<td class="date"><a title="<?php print $entry->created_on ?>"><?php print DateDifference::getString(new DateTime($entry->created_on)); ?></a></td>
		 </tr>
		 <?php } ?>
		<?php endforeach; ?>
		</table>
		<?php $history_spacer++; if($history_spacer > 0) echo '<br/>'; } ?>

	
		<?php if(sizeof($log_entry_older) > 0){ $logitems .= sizeof($log_entry_older); ?>
		<!-- <hr > -->
		<h3><?php echo __('Before yesterday'); ?></h3>
		<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<?php foreach ($log_entry_older as $entry): ?>
		<?php if((AuthUser::hasPermission('client') && strstr($entry->message,'Client')) || !AuthUser::hasPermission('client')){ ?>
		 <tr class="<?php print odd_even(); ?>">
			<td class="priority"><img src="<?php echo URL_PUBLIC;?>wolf/plugins/dashboard/img/<?php print $entry->priority('string') ?>.png" title="<?php print $entry->priority('string') ?>" /></td>
			<td><?php print $entry->message ?></td>
			<td class="date"><a title="<?php print $entry->created_on ?>"><?php print DateDifference::getString(new DateTime($entry->created_on)); ?></a></td>
		 </tr>	
		 <?php } ?>
		<?php endforeach; ?>
		</table>
		<?php } ?>
		
		

		<?php if ($logitems != 0){ ?>
		<p class="buttons">
		 <input class="button" id="site-cancel-page" name="commit" type="submit" accesskey="c" value="<?php echo __('Clear'); ?>"	title="Clear activity history" />
		 <br />
		</p>
		<?php } else { ?>
		<p id="noactivity">There is presently no history of activity.</p>
		<?php } ?>

	</div>

</form>
