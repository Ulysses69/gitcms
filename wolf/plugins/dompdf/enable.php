<?php

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

/* Ensure no other PDF class is enabled alongside dompdf. */
if(Plugin::isEnabled('tcpdf') != true){
	Flash::set('error', __('A PDF Class is already installed.'));
}

exit();