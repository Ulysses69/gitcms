<?php

/* Windows DNS Checker */
if(function_exists('checkdnsrr')){
	  	if(isset($matches)){
			if(checkdnsrr($matches[1] . '.', 'MX')) return true;
		  	if(checkdnsrr($matches[1] . '.', 'A')) return true;
		}
} else {
	function checkdnsrr($hostName, $recType = ''){
		if(!empty($hostName)){
			if($recType == '') $recType = "MX ";
			exec("nslookup -type=$recType $hostName ", $result);
			foreach ($result as $line){
				if(eregi("^$hostName ",$line)){
					return true;
				}
			}
			return false;
		 }
		 return false;
	}
}

?>