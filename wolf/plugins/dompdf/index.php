<?php

Plugin::setInfos(array(
    'id'          			=> 'dompdf',
    'title'       			=> __('PDF Classes (DOMPDF)'),
    'description' 			=> __('PDF Classes (DOMPDF).'),
    'version'     			=> '1.0.0',
    'license'     			=> 'GPL',
    'require_wolf_version' 		=> '0.5.5'
));

Behavior::add('Download', '');

if(!function_exists('downloadPDF')){
function downloadPDF($page){

}
}

?>