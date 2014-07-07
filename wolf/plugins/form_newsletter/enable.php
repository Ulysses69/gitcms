<?php

/* Ensure Elements plugin is enabled */
if(Plugin::isEnabled('elements') != true){
	Flash::set('error', __('Elements plugin must first be enabled'));
}

?>