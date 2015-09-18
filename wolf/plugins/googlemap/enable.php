<?php

/* Get defined constants such as version */
include PLUGINS_ROOT . '/'.basename(dirname(__FILE__)).'/index.php';

/* Get plugin settings (if they exist) */
$version = Plugin::getSetting('version', 'googlemap');

/* Set version setting */
$settings = array('version' => GMAP_VERSION);

// Check for existing settings
if(!Plugin::getSetting('sensor', 'googlemap')) $settings['sensor'] = 'false';
if(!Plugin::getSetting('infowindow', 'googlemap')) $settings['infowindow'] = '';
if(!Plugin::getSetting('directions', 'googlemap')) $settings['directions'] = 'false';
if(!Plugin::getSetting('autodisplay', 'googlemap')) $settings['autodisplay'] = 'false';
if(!Plugin::getSetting('viewport_width', 'googlemap')) $settings['viewport_width'] = 'device-width';
if(!Plugin::getSetting('viewport_scale', 'googlemap')) $settings['viewport_scale'] = '1.0';
if(!Plugin::getSetting('viewport_zoom', 'googlemap')) $settings['viewport_zoom'] = '1.0';
if(!Plugin::getSetting('streetview', 'googlemap')) $settings['streetview'] = 'DEFAULT';
if(!Plugin::getSetting('streetview_position', 'googlemap')) $settings['streetview_position'] = 'LEFT_TOP';
/*
if(!Plugin::getSetting('latitude', 'googlemap')) $settings['latitude'] = '';
if(!Plugin::getSetting('longitude', 'googlemap')) $settings['longitude'] = '';
*/
if(!Plugin::getSetting('zoom', 'googlemap')) $settings['zoom'] = '16';
if(!Plugin::getSetting('zoom_control', 'googlemap')) $settings['zoom_control'] = 'default';
if(!Plugin::getSetting('zoom_control_position', 'googlemap')) $settings['zoom_control_position'] = 'LEFT_TOP';
if(!Plugin::getSetting('navigation_control', 'googlemap')) $settings['navigation_control'] = 'default';
if(!Plugin::getSetting('map_id', 'googlemap')) $settings['map_id'] = 'googlemap';
if(!Plugin::getSetting('map_width', 'googlemap')) $settings['map_width'] = '100%';
if(!Plugin::getSetting('map_height', 'googlemap')) $settings['map_height'] = '500px';
if(!Plugin::getSetting('map_code', 'googlemap')) $settings['map_code'] = '<div id="googlemap"></div>';
if(!Plugin::getSetting('map_ui', 'googlemap')) $settings['map_ui'] = 'false';
if(!Plugin::getSetting('map_type', 'googlemap')) $settings['map_type'] = 'ROADMAP';
if(!Plugin::getSetting('map_control', 'googlemap')) $settings['map_control'] = 'false';
if(!Plugin::getSetting('map_libraries', 'googlemap')) $settings['map_libraries'] = '';
if(!Plugin::getSetting('map_styling', 'googlemap')) $settings['map_styling'] = 'false';
if(!Plugin::getSetting('map_link', 'googlemap')) $settings['map_link'] = '';
if(!Plugin::getSetting('map_output_type', 'googlemap')) $settings['map_output_type'] = '';
if(!Plugin::getSetting('road_local_element_visibility', 'googlemap')) $settings['road_local_element_visibility'] = 'on';
if(!Plugin::getSetting('road_local_element_hue_status', 'googlemap')) $settings['road_local_element_hue_status'] = 'false';
if(!Plugin::getSetting('road_local_element_hue', 'googlemap')) $settings['road_local_element_hue'] = '#ffffff';
if(!Plugin::getSetting('road_local_element_saturation', 'googlemap')) $settings['road_local_element_saturation'] = '0';
if(!Plugin::getSetting('road_local_element_gamma', 'googlemap')) $settings['road_local_element_gamma'] = '0';
if(!Plugin::getSetting('road_local_element_lightness', 'googlemap')) $settings['road_local_element_lightness'] = '0';
if(!Plugin::getSetting('road_local_element_lightness_invert', 'googlemap')) $settings['road_local_element_lightness_invert'] = 'false';
if(!Plugin::getSetting('road_arterial_element_visibility', 'googlemap')) $settings['road_arterial_element_visibility'] = 'on';
if(!Plugin::getSetting('road_arterial_element_hue_status', 'googlemap')) $settings['road_arterial_element_hue_status'] = 'false';
if(!Plugin::getSetting('road_arterial_element_hue', 'googlemap')) $settings['road_arterial_element_hue'] = '#ffffff';
if(!Plugin::getSetting('road_arterial_element_saturation', 'googlemap')) $settings['road_arterial_element_saturation'] = '0';
if(!Plugin::getSetting('road_arterial_element_gamma', 'googlemap')) $settings['road_arterial_element_gamma'] = '0';
if(!Plugin::getSetting('road_arterial_element_lightness', 'googlemap')) $settings['road_arterial_element_lightness'] = '0';
if(!Plugin::getSetting('road_arterial_element_lightness_invert', 'googlemap')) $settings['road_arterial_element_lightness_invert'] = 'false';
if(!Plugin::getSetting('road_highway_element_visibility', 'googlemap')) $settings['road_highway_element_visibility'] = 'off';
if(!Plugin::getSetting('road_highway_element_hue_status', 'googlemap')) $settings['road_highway_element_hue_status'] = 'false';
if(!Plugin::getSetting('road_highway_element_hue', 'googlemap')) $settings['road_highway_element_hue'] = '#ffffff';
if(!Plugin::getSetting('road_highway_element_saturation', 'googlemap')) $settings['road_highway_element_saturation'] = '0';
if(!Plugin::getSetting('road_highway_element_gamma', 'googlemap')) $settings['road_highway_element_gamma'] = '0';
if(!Plugin::getSetting('road_highway_element_lightness', 'googlemap')) $settings['road_highway_element_lightness'] = '0';
if(!Plugin::getSetting('road_highway_element_lightness_invert', 'googlemap')) $settings['road_highway_element_lightness_invert'] = 'false';
if(!Plugin::getSetting('element_visibility', 'googlemap')) $settings['element_visibility'] = 'on';
if(!Plugin::getSetting('element_hue_status', 'googlemap')) $settings['element_hue_status'] = 'false';
if(!Plugin::getSetting('element_hue', 'googlemap')) $settings['element_hue'] = '#ffffff';
if(!Plugin::getSetting('element_saturation', 'googlemap')) $settings['element_saturation'] = '0';
if(!Plugin::getSetting('element_gamma', 'googlemap')) $settings['element_gamma'] = '0';
if(!Plugin::getSetting('element_lightness', 'googlemap')) $settings['element_lightness'] = '0';
if(!Plugin::getSetting('element_lightness_invert', 'googlemap')) $settings['element_lightness_invert'] = 'off';
if(!Plugin::getSetting('natural_element_visibility', 'googlemap')) $settings['natural_element_visibility'] = 'on';
if(!Plugin::getSetting('natural_element_hue_status', 'googlemap')) $settings['natural_element_hue_status'] = 'false';
if(!Plugin::getSetting('natural_element_hue', 'googlemap')) $settings['natural_element_hue'] = '#ffffff';
if(!Plugin::getSetting('natural_element_saturation', 'googlemap')) $settings['natural_element_saturation'] = '0';
if(!Plugin::getSetting('natural_element_gamma', 'googlemap')) $settings['natural_element_gamma'] = '0';
if(!Plugin::getSetting('natural_element_lightness', 'googlemap')) $settings['natural_element_lightness'] = '0';
if(!Plugin::getSetting('natural_element_lightness_invert', 'googlemap')) $settings['natural_element_lightness_invert'] = 'off';
if(!Plugin::getSetting('water_element_visibility', 'googlemap')) $settings['water_element_visibility'] = 'on';
if(!Plugin::getSetting('water_element_hue_status', 'googlemap')) $settings['water_element_hue_status'] = 'false';
if(!Plugin::getSetting('water_element_hue', 'googlemap')) $settings['water_element_hue'] = '#ffffff';
if(!Plugin::getSetting('water_element_saturation', 'googlemap')) $settings['water_element_saturation'] = '0';
if(!Plugin::getSetting('water_element_gamma', 'googlemap')) $settings['water_element_gamma'] = '0';
if(!Plugin::getSetting('water_element_lightness', 'googlemap')) $settings['water_element_lightness'] = '0';
if(!Plugin::getSetting('water_element_lightness_invert', 'googlemap')) $settings['water_element_lightness_invert'] = 'false';
if(!Plugin::getSetting('poi_visibility', 'googlemap')) $settings['poi_visibility'] = 'on';
if(!Plugin::getSetting('poi_hue_status', 'googlemap')) $settings['poi_hue_status'] = 'false';
if(!Plugin::getSetting('poi_hue', 'googlemap')) $settings['poi_hue'] = '#ffffff';
if(!Plugin::getSetting('poi_saturation', 'googlemap')) $settings['poi_saturation'] = '0';
if(!Plugin::getSetting('poi_gamma', 'googlemap')) $settings['poi_gamma'] = '0';
if(!Plugin::getSetting('poi_lightness', 'googlemap')) $settings['poi_lightness'] = '0';
if(!Plugin::getSetting('poi_lightness_invert', 'googlemap')) $settings['poi_lightness_invert'] = 'false';
if(!Plugin::getSetting('road_local_element_label_visibility', 'googlemap')) $settings['road_local_element_label_visibility'] = 'on';
if(!Plugin::getSetting('road_local_element_label_hue_status', 'googlemap')) $settings['road_local_element_label_hue_status'] = 'false';
if(!Plugin::getSetting('road_local_element_label_hue', 'googlemap')) $settings['road_local_element_label_hue'] = '#ffffff';
if(!Plugin::getSetting('road_local_element_label_saturation', 'googlemap')) $settings['road_local_element_label_saturation'] = '0';
if(!Plugin::getSetting('road_local_element_label_gamma', 'googlemap')) $settings['road_local_element_label_gamma'] = '0';
if(!Plugin::getSetting('road_local_element_label_lightness', 'googlemap')) $settings['road_local_element_label_lightness'] = '0';
if(!Plugin::getSetting('road_local_element_label_lightness_invert', 'googlemap')) $settings['road_local_element_label_lightness_invert'] = 'false';
if(!Plugin::getSetting('road_arterial_element_label_visibility', 'googlemap')) $settings['road_arterial_element_label_visibility'] = 'on';
if(!Plugin::getSetting('road_arterial_element_label_hue_status', 'googlemap')) $settings['road_arterial_element_label_hue_status'] = 'false';
if(!Plugin::getSetting('road_arterial_element_label_hue', 'googlemap')) $settings['road_arterial_element_label_hue'] = '#ffffff';
if(!Plugin::getSetting('road_arterial_element_label_saturation', 'googlemap')) $settings['road_arterial_element_label_saturation'] = '0';
if(!Plugin::getSetting('road_arterial_element_label_gamma', 'googlemap')) $settings['road_arterial_element_label_gamma'] = '0';
if(!Plugin::getSetting('road_arterial_element_label_lightness', 'googlemap')) $settings['road_arterial_element_label_lightness'] = '0';
if(!Plugin::getSetting('road_arterial_element_label_lightness_invert', 'googlemap')) $settings['road_arterial_element_label_lightness_invert'] = 'false';
if(!Plugin::getSetting('road_highway_element_label_visibility', 'googlemap')) $settings['road_highway_element_label_visibility'] = 'off';
if(!Plugin::getSetting('road_highway_element_label_hue_status', 'googlemap')) $settings['road_highway_element_label_hue_status'] = 'false';
if(!Plugin::getSetting('road_highway_element_label_hue', 'googlemap')) $settings['road_highway_element_label_hue'] = '#ffffff';
if(!Plugin::getSetting('road_highway_element_label_saturation', 'googlemap')) $settings['road_highway_element_label_saturation'] = '0';
if(!Plugin::getSetting('road_highway_element_label_gamma', 'googlemap')) $settings['road_highway_element_label_gamma'] = '0';
if(!Plugin::getSetting('road_highway_element_label_lightness', 'googlemap')) $settings['road_highway_element_label_lightness'] = '0';
if(!Plugin::getSetting('road_highway_element_label_lightness_invert', 'googlemap')) $settings['road_highway_element_label_lightness_invert'] = 'false';
if(!Plugin::getSetting('element_label_visibility', 'googlemap')) $settings['element_label_visibility'] = 'on';
if(!Plugin::getSetting('element_label_hue_status', 'googlemap')) $settings['element_label_hue_status'] = 'false';
if(!Plugin::getSetting('element_label_hue', 'googlemap')) $settings['element_label_hue'] = '#ffffff';
if(!Plugin::getSetting('element_label_saturation', 'googlemap')) $settings['element_label_saturation'] = '0';
if(!Plugin::getSetting('element_label_gamma', 'googlemap')) $settings['element_label_gamma'] = '0';
if(!Plugin::getSetting('element_label_lightness', 'googlemap')) $settings['element_label_lightness'] = '0';
if(!Plugin::getSetting('element_label_lightness_invert', 'googlemap')) $settings['element_label_lightness_invert'] = 'off';
if(!Plugin::getSetting('natural_element_label_visibility', 'googlemap')) $settings['natural_element_label_visibility'] = 'on';
if(!Plugin::getSetting('natural_element_label_hue_status', 'googlemap')) $settings['natural_element_label_hue_status'] = 'false';
if(!Plugin::getSetting('natural_element_label_hue', 'googlemap')) $settings['natural_element_label_hue'] = '#ffffff';
if(!Plugin::getSetting('natural_element_label_saturation', 'googlemap')) $settings['natural_element_label_saturation'] = '0';
if(!Plugin::getSetting('natural_element_label_gamma', 'googlemap')) $settings['natural_element_label_gamma'] = '0';
if(!Plugin::getSetting('natural_element_label_lightness', 'googlemap')) $settings['natural_element_label_lightness'] = '0';
if(!Plugin::getSetting('natural_element_label_lightness_invert', 'googlemap')) $settings['natural_element_label_lightness_invert'] = 'off';
if(!Plugin::getSetting('water_element_label_visibility', 'googlemap')) $settings['water_element_label_visibility'] = 'on';
if(!Plugin::getSetting('water_element_label_hue_status', 'googlemap')) $settings['water_element_label_hue_status'] = 'false';
if(!Plugin::getSetting('water_element_label_hue', 'googlemap')) $settings['water_element_label_hue'] = '#ffffff';
if(!Plugin::getSetting('water_element_label_saturation', 'googlemap')) $settings['water_element_label_saturation'] = '0';
if(!Plugin::getSetting('water_element_label_gamma', 'googlemap')) $settings['water_element_label_gamma'] = '0';
if(!Plugin::getSetting('water_element_label_lightness', 'googlemap')) $settings['water_element_label_lightness'] = '0';
if(!Plugin::getSetting('water_element_label_lightness_invert', 'googlemap')) $settings['water_element_label_lightness_invert'] = 'false';
if(!Plugin::getSetting('poi_label_visibility', 'googlemap')) $settings['poi_label_visibility'] = 'on';
if(!Plugin::getSetting('poi_label_hue_status', 'googlemap')) $settings['poi_label_hue_status'] = 'false';
if(!Plugin::getSetting('poi_label_hue', 'googlemap')) $settings['poi_label_hue'] = '#ffffff';
if(!Plugin::getSetting('poi_label_saturation', 'googlemap')) $settings['poi_label_saturation'] = '0';
if(!Plugin::getSetting('poi_label_gamma', 'googlemap')) $settings['poi_label_gamma'] = '0';
if(!Plugin::getSetting('poi_label_lightness', 'googlemap')) $settings['poi_label_lightness'] = '0';
if(!Plugin::getSetting('poi_label_lightness_invert', 'googlemap')) $settings['poi_label_lightness_invert'] = 'false';
if(!Plugin::getSetting('road_local_element_saturation_status_status', 'googlemap')) $settings['road_local_element_saturation_status'] = 'false';
if(!Plugin::getSetting('road_local_element_gamma_status_status', 'googlemap')) $settings['road_local_element_gamma_status'] = 'false';
if(!Plugin::getSetting('road_local_element_lightness_status', 'googlemap')) $settings['road_local_element_lightness_status'] = 'false';
if(!Plugin::getSetting('road_arterial_element_saturation_status', 'googlemap')) $settings['road_arterial_element_saturation_status'] = 'false';
if(!Plugin::getSetting('road_arterial_element_gamma_status', 'googlemap')) $settings['road_arterial_element_gamma_status'] = 'false';
if(!Plugin::getSetting('road_arterial_element_lightness_status', 'googlemap')) $settings['road_arterial_element_lightness_status'] = 'false';
if(!Plugin::getSetting('road_highway_element_saturation_status', 'googlemap')) $settings['road_highway_element_saturation_status'] = 'false';
if(!Plugin::getSetting('road_highway_element_gamma_status', 'googlemap')) $settings['road_highway_element_gamma_status'] = 'false';
if(!Plugin::getSetting('road_highway_element_lightness_status', 'googlemap')) $settings['road_highway_element_lightness_status'] = 'false';
if(!Plugin::getSetting('element_saturation_status', 'googlemap')) $settings['element_saturation_status'] = 'false';
if(!Plugin::getSetting('element_gamma_status', 'googlemap')) $settings['element_gamma_status'] = 'false';
if(!Plugin::getSetting('element_lightness_status', 'googlemap')) $settings['element_lightness'] = 'false';
if(!Plugin::getSetting('natural_element_saturation_status', 'googlemap')) $settings['natural_element_saturation_status'] = 'false';
if(!Plugin::getSetting('natural_element_gamma_status', 'googlemap')) $settings['natural_element_gamma_status'] = 'false';
if(!Plugin::getSetting('natural_element_lightness_status', 'googlemap')) $settings['natural_element_lightness_status'] = 'false';
if(!Plugin::getSetting('water_element_saturation_status', 'googlemap')) $settings['water_element_saturation_status'] = 'false';
if(!Plugin::getSetting('water_element_gamma_status', 'googlemap')) $settings['water_element_gamma_status'] = 'false';
if(!Plugin::getSetting('water_element_lightness_status', 'googlemap')) $settings['water_element_lightness_status'] = 'false';
if(!Plugin::getSetting('poi_saturation_status', 'googlemap')) $settings['poi_saturation_status'] = 'false';
if(!Plugin::getSetting('poi_gamma_status', 'googlemap')) $settings['poi_gamma_status'] = 'false';
if(!Plugin::getSetting('poi_lightness_status', 'googlemap')) $settings['poi_lightness_status'] = 'false';
if(!Plugin::getSetting('road_local_element_label_saturation_status', 'googlemap')) $settings['road_local_element_label_saturation_status'] = 'false';
if(!Plugin::getSetting('road_local_element_label_gamma_status', 'googlemap')) $settings['road_local_element_label_gamma_status'] = 'false';
if(!Plugin::getSetting('road_local_element_label_lightness_status', 'googlemap')) $settings['road_local_element_label_lightness_status'] = 'false';
if(!Plugin::getSetting('road_arterial_element_label_saturation_status', 'googlemap')) $settings['road_arterial_element_label_saturation_status'] = 'false';
if(!Plugin::getSetting('road_arterial_element_label_gamma_status', 'googlemap')) $settings['road_arterial_element_label_gamma_status'] = 'false';
if(!Plugin::getSetting('road_arterial_element_label_lightness_status', 'googlemap')) $settings['road_arterial_element_label_lightness_status'] = 'false';
if(!Plugin::getSetting('road_highway_element_label_saturation_status', 'googlemap')) $settings['road_highway_element_label_saturation_status'] = 'false';
if(!Plugin::getSetting('road_highway_element_label_gamma_status', 'googlemap')) $settings['road_highway_element_label_gamma_status'] = 'false';
if(!Plugin::getSetting('road_highway_element_label_lightness_status', 'googlemap')) $settings['road_highway_element_label_lightness_status'] = 'false';
if(!Plugin::getSetting('element_label_saturation_status', 'googlemap')) $settings['element_label_saturation_status'] = 'false';
if(!Plugin::getSetting('element_label_gamma_status', 'googlemap')) $settings['element_label_gamma_status'] = 'false';
if(!Plugin::getSetting('element_label_lightness_status', 'googlemap')) $settings['element_label_lightness_status'] = 'false';
if(!Plugin::getSetting('natural_element_label_saturation_status', 'googlemap')) $settings['natural_element_label_saturation_status'] = 'false';
if(!Plugin::getSetting('natural_element_label_gamma_status', 'googlemap')) $settings['natural_element_label_gamma_status'] = 'false';
if(!Plugin::getSetting('natural_element_label_lightness_status', 'googlemap')) $settings['natural_element_label_lightness_status'] = 'false';
if(!Plugin::getSetting('water_element_label_saturation_status', 'googlemap')) $settings['water_element_label_saturation_status'] = 'false';
if(!Plugin::getSetting('water_element_label_gamma_status', 'googlemap')) $settings['water_element_label_gamma_status'] = 'false';
if(!Plugin::getSetting('water_element_label_lightness_status', 'googlemap')) $settings['water_element_label_lightness_status'] = 'false';
if(!Plugin::getSetting('poi_label_saturation_status', 'googlemap')) $settings['poi_label_saturation_status'] = 'false';
if(!Plugin::getSetting('poi_label_gamma_status', 'googlemap')) $settings['poi_label_gamma_status'] = 'false';
if(!Plugin::getSetting('poi_label_lightness_status', 'googlemap')) $settings['poi_label_lightness_status'] = 'false';
if(!Plugin::getSetting('marker', 'googlemap')) $settings['marker'] = 'true';
if(!Plugin::getSetting('marker_id', 'googlemap')) $settings['marker_id'] = 'default';
if(!Plugin::getSetting('marker_entrance', 'googlemap')) $settings['marker_entrance'] = 'DROP';
if(!Plugin::getSetting('marker_delay', 'googlemap')) $settings['marker_delay'] = '3';
if(!Plugin::getSetting('marker_scatter', 'googlemap')) $settings['marker_scatter'] = '500';
/*
if(!Plugin::getSetting('marker_img', 'googlemap')) $settings['marker_img'] = '';
if(!Plugin::getSetting('marker_img_width', 'googlemap')) $settings['marker_img_width'] = '';
if(!Plugin::getSetting('marker_img_height', 'googlemap')) $settings['marker_img_height'] = '';
if(!Plugin::getSetting('marker_img_x', 'googlemap')) $settings['marker_img_x'] = '';
if(!Plugin::getSetting('marker_img_y', 'googlemap')) $settings['marker_img_y'] = '';
if(!Plugin::getSetting('marker_img_point_x', 'googlemap')) $settings['marker_img_point_x'] = '';
if(!Plugin::getSetting('marker_img_point_y', 'googlemap')) $settings['marker_img_point_y'] = '';
if(!Plugin::getSetting('marker_shadow_img', 'googlemap')) $settings['marker_shadow_img'] = '';
if(!Plugin::getSetting('marker_shadow_img_width', 'googlemap')) $settings['marker_shadow_img_width'] = '';
if(!Plugin::getSetting('marker_shadow_img_height', 'googlemap')) $settings['marker_shadow_img_height'] = '';
if(!Plugin::getSetting('marker_shadow_img_x', 'googlemap')) $settings['marker_shadow_img_x'] = '';
if(!Plugin::getSetting('marker_shadow_img_y', 'googlemap')) $settings['marker_shadow_img_y'] = '';
if(!Plugin::getSetting('marker_shadow_img_point_x', 'googlemap')) $settings['marker_shadow_img_point_x'] = '';
if(!Plugin::getSetting('marker_shadow_img_point_y', 'googlemap')) $settings['marker_shadow_img_point_y'] = '';
*/
if(!Plugin::getSetting('api_version', 'googlemap')) $settings['api_version'] = '3.17';
if(!Plugin::getSetting('region', 'googlemap')) $settings['region'] = 'GB';

// Check if settings were found for googlemap
if (!$version || $version == null) {

	if(Plugin::isEnabled('clientdetails') == true){
		if($latitude == null || $longitude == null){
			$clientaddress = str_replace('(Blue Horizons)','',Plugin::getSetting('clientaddress', 'clientdetails'));
			$encoded_clientaddress = str_replace(' ','+',$clientaddress);
			$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$encoded_clientaddress.'&sensor=false');
			$output = json_decode($geocode);
			if(is_object($output)){
				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;
			}
		}
	} else {
		$latitude = '';
		$longitude = '';
	}
	$marker_img_icon = 'marker.png';
	$marker_shadow_img_icon = 'shadow.png';
	if (file_exists($_SERVER{'DOCUMENT_ROOT'}.'/public/images/'.$marker_img_icon) && file_exists($_SERVER{'DOCUMENT_ROOT'}.'/public/images/'.$marker_shadow_img_icon)) {
		$marker_path = '/public/images/';
		$marker_img = $marker_path.$marker_img_icon;
		$marker_shadow_img = $marker_path.$marker_shadow_img_icon;
		$marker_path = $_SERVER{'DOCUMENT_ROOT'}.$marker_path;
	} else {
		$marker_path = '/wolf/plugins/googlemap/images/';
		$marker_img = $marker_path.$marker_img_icon;
		$marker_shadow_img = $marker_path.$marker_shadow_img_icon;
		$marker_path = $_SERVER{'DOCUMENT_ROOT'}.$marker_path;
	}
	$marker_img_width = '';
	$marker_img_height = '';
	$marker_img_x = '';
	$marker_img_y = '';
	$marker_img_point_x = '';
	$marker_img_point_y = '';
	$marker_shadow_img_width = '';
	$marker_shadow_img_height = '';
	$marker_shadow_img_x = '';
	$marker_shadow_img_y = '';
	$marker_shadow_img_point_x = '';
	$marker_shadow_img_point_y = '';
	if(((!empty($marker_img) || $marker_img != '') && $marker_img_width == '' && $marker_img_height == '') && file_exists($marker_path.$marker_img_icon)){
		list($marker_img_width, $marker_img_height) = getimagesize($marker_path.$marker_img_icon);
		$marker_img_x = '0';
		$marker_img_y = '0';
		$marker_img_point_x = '0';
		$marker_img_point_y = '32';
	}
	if(((!empty($marker_shadow_img) || $marker_shadow_img != '') && $marker_shadow_img_width == '' && $marker_shadow_img_height == '') && file_exists($marker_path.$marker_shadow_img_icon)){
		list($marker_shadow_img_width, $marker_shadow_img_height) = getimagesize($marker_path.$marker_shadow_img_icon);
		$marker_shadow_img_x = '0';
		$marker_shadow_img_y = '0';
		$marker_shadow_img_point_x = '0';
		$marker_shadow_img_point_y = '32';
	}

	$settings = array(	'latitude' => $latitude,
						'longitude' => $longitude,
						'marker_img' => $marker_img,
						'marker_img_width' => $marker_img_width,
						'marker_img_height' => $marker_img_height,
						'marker_img_x' => $marker_img_x,
						'marker_img_y' => $marker_img_y,
						'marker_img_point_x' => $marker_img_point_x,
						'marker_img_point_y' => $marker_img_point_y,
						'marker_shadow_img' => $marker_shadow_img,
						'marker_shadow_img_width' => $marker_shadow_img_width,
						'marker_shadow_img_height' => $marker_shadow_img_height,
						'marker_shadow_img_x' => $marker_shadow_img_x,
						'marker_shadow_img_y' => $marker_shadow_img_y,
						'marker_shadow_img_point_x' => $marker_shadow_img_point_x,
						'marker_shadow_img_point_y' => $marker_shadow_img_point_y);

	// Store settings.
	if (Plugin::setAllSettings($settings, 'googlemap')) {
		Flash::set('success', __('Googlemap - plugin settings setup.'));
	}
	else
		Flash::set('error', __('Googlemap - unable to save plugin settings.'));



} else {

	// Upgrade from previous installation
	if (GMAP_VERSION > $version) {

		// Retrieve the old settings.
		$PDO = Record::getConnection();
		$tablename = TABLE_PREFIX.'plugin_settings';

		$sql_check = "SELECT COUNT(*) FROM $tablename WHERE plugin_id='".'googlemap'."'";
		$sql = "SELECT * FROM $tablename WHERE plugin_id='".'googlemap'."'";

		$result = $PDO->query($sql_check);

		if (!$result) {
			Flash::set('error', __('Googlemap - unable to access plugin settings.'));
			return;
		}

		// Fetch the old installation's records.
		$result = $PDO->query($sql);

		if(Plugin::isEnabled('clientdetails') == true){
			/* Get latitude and longitude from client address if possible */
			//$latitude = Plugin::getSetting('latitude', 'googlemap');
			//$longitude = Plugin::getSetting('longitude', 'googlemap');
			//if($latitude == null || $longitude == null){
				$clientaddress = str_replace('(Blue Horizons)','',Plugin::getSetting('clientaddress', 'clientdetails'));
				$encoded_clientaddress = str_replace(' ','+',$clientaddress);
				$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$encoded_clientaddress.'&sensor=false');
				$output = json_decode($geocode);
				if(is_object($output)){
					$latitude = $output->results[0]->geometry->location->lat;
					$longitude = $output->results[0]->geometry->location->lng;
				}
			//}
		} else {
			$latitude = '';
			$longitude = '';
		}

		if ($result && $row = $result->fetchObject()) {

			$result->closeCursor();
			if(defined('GMAP_INCLUDE')){ header('Location: '.URL_PUBLIC.ADMIN_DIR.'/plugin/googlemap'); }
		}
	}


	// Store settings.
	if (isset($settings) && Plugin::setAllSettings($settings, 'googlemap')) {
		if (GMAP_VERSION > $version){
			Flash::set('success', __('Googlemap - plugin settings updated.'));
		}
	}

}


?>