<?php
if((isset($_SERVER['HTTP_USER_AGENT']) && $_SESSION['userAgent'] == $_SERVER['HTTP_USER_AGENT']) && isset($_POST["send"])) {
	$postcheck = TRUE;
}

#Create posted array
$postedArray = array('send','Send','submit','Submit');

?>