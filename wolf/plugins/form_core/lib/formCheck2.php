<?php

//echo "Check 2";

/* Check all posted values */
foreach($_POST as $k => $v){
	foreach($badStrings as $v2){
		if(strpos(strtolower($v), $v2) !== false || strlen($v) > 1000){

			/* User has potentially malicious intent */
			$malicious = true;
			$postmessage = $message_is_malicious;

		}
	}
}

unset($k, $v, $v2, $badStrings);

?>