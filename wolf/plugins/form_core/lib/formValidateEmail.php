<?php

/* Validate Email */
function validEmail($email){
	$isValid = true;
	$atIndex = strrpos($email, "@");
	if (is_bool($atIndex) && !$atIndex){
		$isValid = false;
	} else {
		$domain = substr($email, $atIndex+1);
		$local = substr($email, 0, $atIndex);
		$localLen = strlen($local);
		$domainLen = strlen($domain);
		if ($localLen < 1 || $localLen > 64){
			$isValid = false; // Local part length exceeded
		} else if ($domainLen < 1 || $domainLen > 255){
			$isValid = false; // Domain part length exceeded
		} else if ($local[0] == '.' || $local[$localLen-1] == '.'){
			$isValid = false; // Local part starts or ends with '.'
		} else if (preg_match('/\\.\\./', $local)){
			$isValid = false; // Local part has two consecutive dots
		} else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)){
			$isValid = false; // Character not valid in domain part
		} else if (preg_match('/\\.\\./', $domain)){
			$isValid = false; // Domain part has two consecutive dots
		} else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))){
			if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))){
				$isValid = false; // Character not valid in local part unless local part is quoted
			}
		}
		//if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))){
		//	$isValid = false; // Domain not found in DNS
		//}
	}
	return $isValid;
}

?>