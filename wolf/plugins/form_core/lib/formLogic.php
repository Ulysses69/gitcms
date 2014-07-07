<?php

if(isset($_SESSION['logic'])) {
	/* Ensure session timer is equal to required fields left (or posted fields). */
	/* Also account for flash-posted data ... maybe initiate session timer when flash form loads? */
	//if(time() - $_SESSION['logic'] < (2*(sizeof($required) - $_SESSION['errorcount'])) && isset($_POST["send"])){
	if(time() - $_SESSION['logic'] < ((1*(sizeof($required) - $_SESSION['errorcount'])) || 1*(count($_POST))) && isset($_POST["send"])){
		$malicious = true;
		$submitTime = time() - $_SESSION['logic'];

		/* Log Form Errors to Google Analytics */
		if($analytics == true){

			/*
			if(DEBUG == true){
				$message_too_fast .= "<script type='text/javascript'>alert('".ucfirst($parentpage->slug)." Form Error: Submitted in ".$submitTime." second');</script>";
			} else { 
				$message_too_fast .= "<script type='text/javascript'>_gaq.push(['_trackEvent', 'Forms', '".ucfirst($parentpage->slug)." Form', 'Error: Submitted in ".$submitTime." seconds']);</script>";
			}
			*/

			if(function_exists('analyticsPush')){
				$message_too_fast .= analyticsPush(true, '_trackEvent', "'Errors'", "'".ucwords($parentpage->breadcrumb)." Form'", "'Submitted in ".$submitTime." seconds'", '0', 'true')."\n";
			}

		}

		/* Form was posted too promptly */
		$postmessage = $message_too_fast;

	} else if (time() - $_SESSION['logic'] > $timeout && isset($_POST["send"])){

		/* Form was posted too late */
		$malicious = true;
		$postmessage = $message_too_slow;

	} else {
		// End timer logic
	}
	unset($_SESSION['logic']);
	//session_regenerate_id();
} else {
	if(!isset($_SESSION['ipAddress']))
		$_SESSION['ipAddress'] = $_SERVER['REMOTE_ADDR'];
	
	if(!isset($_SESSION['userAgent']))
		$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
}
$_SESSION['logic'] = time();
$_SESSION['errorcount'] = 0;

?>