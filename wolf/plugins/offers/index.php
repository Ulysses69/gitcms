<?php

Plugin::setInfos(array(
    'id'          			=> 'offers',
    'title'       			=> __('Offers Page Type'),
    'description' 			=> __('Offers Page Type.'),
    'version'     			=> '1.0.0',
    'license'     			=> 'GPL',
    'require_wolf_version' 		=> '0.5.5'
));

Behavior::add('Offers', '');


?>