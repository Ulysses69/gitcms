<?php

/* Exclude fields from being posted to email */
$exclude_from_email = array('Send','Submit','send','submit','Submit X','Submit Y');
/* Exclude from domain */
$unwanted = array("www.", "http://", "https://", "/");

$successredirect = true;
$labelsasvalue = false;
$adminemail = 'support@bluehorizonsmedia.co.uk';
/* Set upload form send address - cannot be local TLD as attachments class will not send attachments for local submitted forms */
$formsEmail = 'website@bluehorizonsmedia.co.uk';
$domainBits = explode('.', $_SERVER['SERVER_NAME']); $tld = $domainBits[sizeof($domainBits)-1];
if($tld != 'local' && $tld != 'dev' && $tld != 'test') $formsEmail = "website@".str_replace($unwanted,'',URL_ABSOLUTE);

$asterisk = ' <em title="Required" class="required">is required</em>';
//$formconfirmation = true; /* Do/Don't display form on submission */
$displayform = true;
$errors = '';
$message = '';
$postedmessage = '';
$mandatorymessage = '<span class="required">Fields marked</span> '.$asterisk.' <span class="required">must be completed</span>';
$hideFormWrap = '';


/* For uploader */
$upload_error = '';
//$upload_max_folder_size = 52428800; // Maximum size of folder in bytes is 50MB
$upload_allowed_file_size = 1048576; // Maximum size in bytes is 1MB
//$upload_allowed_file_size = 10240; // Maximum size in bytes is 10kb
$upload_allowed_extensions = array('.jpeg','.jpg','.tiff','.rar','.zip','.sit');
$upload_dir = $_SERVER['DOCUMENT_ROOT']."/public/uploads/tmp/";
// Filesize formatter
if(!function_exists('filesize_formatted')){
	function filesize_formatted($upload_size){
		//$upload_size = filesize($upload_path);
		$upload_units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
		$upload_power = $upload_size > 0 ? floor(log($upload_size, 1024)) : 0;
		return number_format($upload_size / pow(1024, $upload_power), 2, '.', ',') . ' ' . $upload_units[$upload_power];
	}
}


if($formtarget != ''){
	$formtarget = $formtarget;
} else {
	if($parentpage->funky_cache_enabled == 1){
		// Form is cached (not working yet)
		$formtarget = strtok($_SERVER['REQUEST_URI'],'?').$formanchor;
	} else {
		// Form is not cached
		$formtarget = strtok($_SERVER['REQUEST_URI'],'?').$formanchor;
	}
}




/* Check if mobile is set to n */
if(isset($_GET['mobile'])){ $mobile_set = htmlspecialchars($_GET['mobile']); } else { $mobile_set = '';  }
$mobile_string_var = '?mobile=n'; $mobile_string = '';
if($mobile_set == 'n'){
	if(stristr($formtarget,'#')){
		$formtarget = str_replace('#',$mobile_string_var.'#',$formtarget);
	} else {
		$formtarget .= $mobile_string_var;
	}
}




if($formsize == true){
	$formsize = ' class="small"';
} else {
	$formsize = '';
}

/* Check if Google Analytics should be used */
$gacode = Plugin::getSetting('clientanalytics', 'seobox');
if($gacode != ''){
	$analytics = true;
} else {
	$analytics = false;
}

$clientname = clientname();
ob_start();$parentpage->includeSnippet('mailinglist');$mailinglist = ob_get_clean();
ob_start();$parentpage->includeSnippet('privacy');$privacy = ob_get_clean();
if(function_exists('clientdetails_telephone')){
	$clientphone = clientdetails_telephone(); } else {
	ob_start();$parentpage->includeSnippet('telephone');$clientphone = ob_get_clean(); }
if(function_exists('clientdetails_email')){
	$clientemail = clientdetails_email(); } else {
	ob_start();$parentpage->includeSnippet('email');$clientemail = ob_get_clean(); }
if(function_exists('clientdetails_address')){
	$clientaddress = clientdetails_address(); } else {
	ob_start();$parentpage->includeSnippet('address');$clientaddress = ob_get_clean(); }

$mailing_list = 'Join the mailing list <span>for news, offers and important updates.</span>';
$mailing_list_consent = 'I consent to joining the mailing list.';
$mailing_list_noconsent = 'I have not consented to joining a mailing list.';

$timeout = 20 * 60; /* 20 minutes */
$message_too_fast = "<p class=\"warning\"><strong>Sorry, your information could not be sent due to a connection problem.</strong> Please submit your information again in 2 minutes or call us on ".$clientphone.".</p>";
$message_too_slow = "<p class=\"warning\"><strong>For your own security, the form has timed out after ".($timeout / 60)." minutes of inactivity.</strong> Please submit your information again or call us on ".$clientphone.".</p>";
$message_is_malicious = "<p class=\"warning\"><strong>The form could not be sent as insecure information was detected.</strong> Please try carefully providing your information again or call us on ".$clientphone.".</p>";

/* Log Form Errors to Google Analytics */
if($analytics == true){
	
	/*
	if(DEBUG == true){
		$message_too_slow .= "<script type='text/javascript'>alert('".ucfirst($parentpage->slug)." Form Error: Timed Out');</script>";
	} else {
		$message_too_slow .= "<script type='text/javascript'>_gaq.push(['_trackEvent', 'Forms', '".ucfirst($parentpage->slug)." Form', 'Error: Timed Out']);</script>";
	}
	if(DEBUG == true){
		$message_is_malicious .= "<script type='text/javascript'>alert('".ucfirst($parentpage->slug)." Form Error: Malicious Content');</script>";
	} else {
		$message_is_malicious .= "<script type='text/javascript'>_gaq.push(['_trackEvent', 'Forms', '".ucfirst($parentpage->slug)." Form', 'Error: Malicious Content']);</script>";
	}
	*/
	
	if(function_exists('analyticsPush')){
		/* $message_too_fast analaytics are appended to in formLogic, where session timer is passed */
		//$message_too_slow .= analyticsPush(true, '_trackEvent', 'Forms', ucfirst($parentpage->slug).' Form', 'Error: Timed Out', '0', 'true');
		//$message_is_malicious .= analyticsPush(true, '_trackEvent', 'Forms', ucfirst($parentpage->slug).' Form', 'Error: Malicious Content', '0', 'true');
		$message_too_slow .= analyticsPush(true, '_trackEvent', "'Forms'", "'".ucwords($parentpage->slug)." Form'", "'Error: Timed Out'", '0', 'true');
		$message_is_malicious .= analyticsPush(true, '_trackEvent', "'Forms'", "'".ucwords($parentpage->slug)." Form'", "'Error: Malicious Content'", '0', 'true');

	}
}

//$message_successful = "<p class=\"success\" id=\"reply\"><strong>Your information has been sent successfully.</strong></p>\n";
$malicious = false;
$contactmethods = array();
$badStrings = array(
"content-type:",
"mime-version:",
"content-transfer-encoding:",
"multipart/mixed",
"charset=",
"bcc:",
"cc:",
"src:",
"href=",
"http:",
"script>",
"url=",
"link=");

if($formsize == true) $formclass = ' small';


?>