<?php

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

/* Ensure no other PDF class is enabled alongside tcpdf. */
if(Plugin::isEnabled('dompdf') != true){
	Flash::set('error', __('A PDF Class is already installed.'));
}

exit();