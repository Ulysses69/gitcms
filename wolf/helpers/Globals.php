<?php

//class Globals {
	global $redirectedpages;

	$fullmenu			= '';
	$navigation			= '';
	$redirectedpages	= array();

    function setglobal($global_name='',$global_value='') {
        if(!defined($global_name)) define($global_name, $global_value);
        //$output = "<p>".$global_name.": global</p>";
        //if(NAVIGATION != 'true'){
		//	$output .= "<p>NAVIGATION: not set</p>";
		//}
		//return $output;
    }

    function getglobal($global_name,$global_value) {
        //return $output;
    }

//}
