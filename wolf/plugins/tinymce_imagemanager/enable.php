<?php

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

/* Ensure TinyMCE plugin is enabled */
if(Plugin::isEnabled('tinymce') != true){
	Flash::set('error', __('TinyMCE plugin must first be enabled'));
}

$File = $_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/tinymce_imagemanager/status.txt';
chmod($File, 0777);
$Handle = fopen($File, 'w');
$Data = "enabled";
fwrite($Handle, $Data);
fclose($Handle);

exit();