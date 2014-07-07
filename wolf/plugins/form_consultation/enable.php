<?php

/* Ensure Elements plugin is enabled */
if(Plugin::isEnabled('elements') != true){
	Flash::set('error', __('Elements plugin must first be enabled'));
}

Observer::notify('plugin_after_enable', 'check_form_consultation');
function check_form_consultation(){
	if(function_exists('consultationForm')){
		Flash::set('error', __('Please disable currently-enabled consultation form before enabling.'));
		return;
	}
}

?>