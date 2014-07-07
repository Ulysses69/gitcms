<?php

$File = $_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/tinymce_imagemanager/status.txt';
chmod($File, 0777);
$Handle = fopen($File, 'w');
$Data = "disabled";
fwrite($Handle, $Data);
fclose($Handle);

exit();