<?php

if (!defined('GMAP_VERSION')) {	define('GMAP_VERSION', '4.0.0'); }
if (!defined('GMAP_ROOT')) {	define('GMAP_ROOT', URI_PUBLIC.'wolf/plugins/googlemap/images'); }
if (!defined('GMAP_PATH')) {	define('GMAP_PATH', $_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/googlemap/images'); }

Plugin::setInfos(array(
	'id'					=> 'googlemap',
	'title'					=> 'GoogleMap (API v3)',
	'description'			=> 'Allows you to embed Google Maps.',
	'version'				=> GMAP_VERSION,
	'license'				=> 'GPLv3',
	'author'				=> 'Steven Henderson',
	'website'				=> 'http://www.bluehorizonsmarketing.co.uk/',
	'update_url'			=> 'http://www.bluehorizonsmarketing.co.uk/plugins.xml',
	'require_frog_version'	=> '0.9.5'
));

if(!AuthUser::hasPermission('client') && Plugin::isEnabled('dashboard') == true) {
	Plugin::addController('googlemap', 'GoogleMap', 'administrator', false);
} else {
	Plugin::addController('googlemap', 'GoogleMap', 'administrator', true);
}

if(!function_exists('displayGoogleMap')){
function displayGoogleMap(){

		$sensor = Plugin::getSetting('sensor', 'googlemap');
		$infowindow = Plugin::getSetting('infowindow', 'googlemap');
		$directions = Plugin::getSetting('directions', 'googlemap');
		$autodisplay = Plugin::getSetting('autodisplay', 'googlemap');
		$viewport_width = Plugin::getSetting('viewport_width', 'googlemap');
		$viewport_scale = Plugin::getSetting('viewport_scale', 'googlemap');
		$viewport_zoom = Plugin::getSetting('viewport_zoom', 'googlemap');
		$latitude = Plugin::getSetting('latitude', 'googlemap');
		$longitude = Plugin::getSetting('longitude', 'googlemap');
		$zoom = Plugin::getSetting('zoom', 'googlemap');
		$zoom_control = Plugin::getSetting('zoom_control', 'googlemap');
		$navigation_control = Plugin::getSetting('navigation_control', 'googlemap');
		$map_id = Plugin::getSetting('map_id', 'googlemap');
		$map_width = Plugin::getSetting('map_width', 'googlemap');
		$map_height = Plugin::getSetting('map_height', 'googlemap');
		$map_code = Plugin::getSetting('map_code', 'googlemap');
		$map_ui = Plugin::getSetting('map_ui', 'googlemap');
		$map_type = Plugin::getSetting('map_type', 'googlemap');
		$map_control = Plugin::getSetting('map_control', 'googlemap');
		$map_libraries = Plugin::getSetting('map_libraries', 'googlemap');
		$map_styling = Plugin::getSetting('map_styling', 'googlemap');
		$road_local_element_visibility = Plugin::getSetting('road_local_element_visibility', 'googlemap');
		$road_local_element_hue_status = Plugin::getSetting('road_local_element_hue_status', 'googlemap');
		$road_local_element_hue = Plugin::getSetting('road_local_element_hue', 'googlemap');
		$road_local_element_saturation = Plugin::getSetting('road_local_element_saturation', 'googlemap');
		$road_local_element_gamma = Plugin::getSetting('road_local_element_gamma', 'googlemap');
		$road_local_element_lightness = Plugin::getSetting('road_local_element_lightness', 'googlemap');
		$road_local_element_lightness_invert = Plugin::getSetting('road_local_element_lightness_invert', 'googlemap');
		$road_arterial_element_visibility = Plugin::getSetting('road_arterial_element_visibility', 'googlemap');
		$road_arterial_element_hue_status = Plugin::getSetting('road_arterial_element_hue_status', 'googlemap');
		$road_arterial_element_hue = Plugin::getSetting('road_arterial_element_hue', 'googlemap');
		$road_arterial_element_saturation = Plugin::getSetting('road_arterial_element_saturation', 'googlemap');
		$road_arterial_element_gamma = Plugin::getSetting('road_arterial_element_gamma', 'googlemap');
		$road_arterial_element_lightness = Plugin::getSetting('road_arterial_element_lightness', 'googlemap');
		$road_arterial_element_lightness_invert = Plugin::getSetting('road_arterial_element_lightness_invert', 'googlemap');
		$road_highway_element_visibility = Plugin::getSetting('road_highway_element_visibility', 'googlemap');
		$road_highway_element_hue_status = Plugin::getSetting('road_highway_element_hue_status', 'googlemap');
		$road_highway_element_hue = Plugin::getSetting('road_highway_element_hue', 'googlemap');
		$road_highway_element_saturation = Plugin::getSetting('road_highway_element_saturation', 'googlemap');
		$road_highway_element_gamma = Plugin::getSetting('road_highway_element_gamma', 'googlemap');
		$road_highway_element_lightness = Plugin::getSetting('road_highway_element_lightness', 'googlemap');
		$road_highway_element_lightness_invert = Plugin::getSetting('road_highway_element_lightness_invert', 'googlemap');
		$element_visibility = Plugin::getSetting('element_visibility', 'googlemap');
		$element_hue_status = Plugin::getSetting('element_hue_status', 'googlemap');
		$element_hue = Plugin::getSetting('element_hue', 'googlemap');
		$element_saturation = Plugin::getSetting('element_saturation', 'googlemap');
		$element_gamma = Plugin::getSetting('element_gamma', 'googlemap');
		$element_lightness = Plugin::getSetting('element_lightness', 'googlemap');
		$element_lightness_invert = Plugin::getSetting('element_lightness_invert', 'googlemap');
		$natural_element_visibility = Plugin::getSetting('natural_element_visibility', 'googlemap');
		$natural_element_hue_status = Plugin::getSetting('natural_element_hue_status', 'googlemap');
		$natural_element_hue = Plugin::getSetting('natural_element_hue', 'googlemap');
		$natural_element_saturation = Plugin::getSetting('natural_element_saturation', 'googlemap');
		$natural_element_gamma = Plugin::getSetting('natural_element_gamma', 'googlemap');
		$natural_element_lightness = Plugin::getSetting('natural_element_lightness', 'googlemap');
		$natural_element_lightness_invert = Plugin::getSetting('natural_element_lightness_invert', 'googlemap');
		$water_element_visibility = Plugin::getSetting('water_element_visibility', 'googlemap');
		$water_element_hue_status = Plugin::getSetting('water_element_hue_status', 'googlemap');
		$water_element_hue = Plugin::getSetting('water_element_hue', 'googlemap');
		$water_element_saturation = Plugin::getSetting('water_element_saturation', 'googlemap');
		$water_element_gamma = Plugin::getSetting('water_element_gamma', 'googlemap');
		$water_element_lightness = Plugin::getSetting('water_element_lightness', 'googlemap');
		$water_element_lightness_invert = Plugin::getSetting('water_element_lightness_invert', 'googlemap');
		$poi_visibility = Plugin::getSetting('poi_visibility', 'googlemap');
		$poi_hue_status = Plugin::getSetting('poi_hue_status', 'googlemap');
		$poi_hue = Plugin::getSetting('poi_hue', 'googlemap');
		$poi_saturation = Plugin::getSetting('poi_saturation', 'googlemap');
		$poi_gamma = Plugin::getSetting('poi_gamma', 'googlemap');
		$poi_lightness = Plugin::getSetting('poi_lightness', 'googlemap');
		$poi_lightness_invert = Plugin::getSetting('poi_lightness_invert', 'googlemap');
		$road_local_element_label_visibility = Plugin::getSetting('road_local_element_label_visibility', 'googlemap');
		$road_local_element_label_hue_status = Plugin::getSetting('road_local_element_label_hue_status', 'googlemap');
		$road_local_element_label_hue = Plugin::getSetting('road_local_element_label_hue', 'googlemap');
		$road_local_element_label_saturation = Plugin::getSetting('road_local_element_label_saturation', 'googlemap');
		$road_local_element_label_gamma = Plugin::getSetting('road_local_element_label_gamma', 'googlemap');
		$road_local_element_label_lightness = Plugin::getSetting('road_local_element_label_lightness', 'googlemap');
		$road_local_element_label_lightness_invert = Plugin::getSetting('road_local_element_label_lightness_invert', 'googlemap');
		$road_arterial_element_label_visibility = Plugin::getSetting('road_arterial_element_label_visibility', 'googlemap');
		$road_arterial_element_label_hue_status = Plugin::getSetting('road_arterial_element_label_hue_status', 'googlemap');
		$road_arterial_element_label_hue = Plugin::getSetting('road_arterial_element_label_hue', 'googlemap');
		$road_arterial_element_label_saturation = Plugin::getSetting('road_arterial_element_label_saturation', 'googlemap');
		$road_arterial_element_label_gamma = Plugin::getSetting('road_arterial_element_label_gamma', 'googlemap');
		$road_arterial_element_label_lightness = Plugin::getSetting('road_arterial_element_label_lightness', 'googlemap');
		$road_arterial_element_label_lightness_invert = Plugin::getSetting('road_arterial_element_label_lightness_invert', 'googlemap');
		$road_highway_element_label_visibility = Plugin::getSetting('road_highway_element_label_visibility', 'googlemap');
		$road_highway_element_label_hue_status = Plugin::getSetting('road_highway_element_label_hue_status', 'googlemap');
		$road_highway_element_label_hue = Plugin::getSetting('road_highway_element_label_hue', 'googlemap');
		$road_highway_element_label_saturation = Plugin::getSetting('road_highway_element_label_saturation', 'googlemap');
		$road_highway_element_label_gamma = Plugin::getSetting('road_highway_element_label_gamma', 'googlemap');
		$road_highway_element_label_lightness = Plugin::getSetting('road_highway_element_label_lightness', 'googlemap');
		$road_highway_element_label_lightness_invert = Plugin::getSetting('road_highway_element_label_lightness_invert', 'googlemap');
		$element_label_visibility = Plugin::getSetting('element_label_visibility', 'googlemap');
		$element_label_hue_status = Plugin::getSetting('element_label_hue_status', 'googlemap');
		$element_label_hue = Plugin::getSetting('element_label_hue', 'googlemap');
		$element_label_saturation = Plugin::getSetting('element_label_saturation', 'googlemap');
		$element_label_gamma = Plugin::getSetting('element_label_gamma', 'googlemap');
		$element_label_lightness = Plugin::getSetting('element_label_lightness', 'googlemap');
		$element_label_lightness_invert = Plugin::getSetting('element_label_lightness_invert', 'googlemap');
		$natural_element_label_visibility = Plugin::getSetting('natural_element_label_visibility', 'googlemap');
		$natural_element_label_hue_status = Plugin::getSetting('natural_element_label_hue_status', 'googlemap');
		$natural_element_label_hue = Plugin::getSetting('natural_element_label_hue', 'googlemap');
		$natural_element_label_saturation = Plugin::getSetting('natural_element_label_saturation', 'googlemap');
		$natural_element_label_gamma = Plugin::getSetting('natural_element_label_gamma', 'googlemap');
		$natural_element_label_lightness = Plugin::getSetting('natural_element_label_lightness', 'googlemap');
		$natural_element_label_lightness_invert = Plugin::getSetting('natural_element_label_lightness_invert', 'googlemap');
		$water_element_label_visibility = Plugin::getSetting('water_element_label_visibility', 'googlemap');
		$water_element_label_hue_status = Plugin::getSetting('water_element_label_hue_status', 'googlemap');
		$water_element_label_hue = Plugin::getSetting('water_element_label_hue', 'googlemap');
		$water_element_label_saturation = Plugin::getSetting('water_element_label_saturation', 'googlemap');
		$water_element_label_gamma = Plugin::getSetting('water_element_label_gamma', 'googlemap');
		$water_element_label_lightness = Plugin::getSetting('water_element_label_lightness', 'googlemap');
		$water_element_label_lightness_invert = Plugin::getSetting('water_element_label_lightness_invert', 'googlemap');
		$poi_label_visibility = Plugin::getSetting('poi_label_visibility', 'googlemap');
		$poi_label_hue_status = Plugin::getSetting('poi_label_hue_status', 'googlemap');
		$poi_label_hue = Plugin::getSetting('poi_label_hue', 'googlemap');
		$poi_label_saturation = Plugin::getSetting('poi_label_saturation', 'googlemap');
		$poi_label_gamma = Plugin::getSetting('poi_label_gamma', 'googlemap');
		$poi_label_lightness = Plugin::getSetting('poi_label_lightness', 'googlemap');
		$poi_label_lightness_invert = Plugin::getSetting('poi_label_lightness_invert', 'googlemap');
		$road_local_element_saturation_status_status = Plugin::getSetting('road_local_element_saturation_status', 'googlemap');
		$road_local_element_gamma_status_status = Plugin::getSetting('road_local_element_gamma_status', 'googlemap');
		$road_local_element_lightness_status = Plugin::getSetting('road_local_element_lightness_status', 'googlemap');
		$road_arterial_element_saturation_status = Plugin::getSetting('road_arterial_element_saturation_status', 'googlemap');
		$road_arterial_element_gamma_status = Plugin::getSetting('road_arterial_element_gamma_status', 'googlemap');
		$road_arterial_element_lightness_status = Plugin::getSetting('road_arterial_element_lightness_status', 'googlemap');
		$road_highway_element_saturation_status = Plugin::getSetting('road_highway_element_saturation_status', 'googlemap');
		$road_highway_element_gamma_status = Plugin::getSetting('road_highway_element_gamma_status', 'googlemap');
		$road_highway_element_lightness_status = Plugin::getSetting('road_highway_element_lightness_status', 'googlemap');
		$element_saturation_status = Plugin::getSetting('element_saturation_status', 'googlemap');
		$element_gamma_status = Plugin::getSetting('element_gamma_status', 'googlemap');
		$element_lightness_status = Plugin::getSetting('element_lightness', 'googlemap');
		$natural_element_saturation_status = Plugin::getSetting('natural_element_saturation_status', 'googlemap');
		$natural_element_gamma_status = Plugin::getSetting('natural_element_gamma_status', 'googlemap');
		$natural_element_lightness_status = Plugin::getSetting('natural_element_lightness_status', 'googlemap');
		$water_element_saturation_status = Plugin::getSetting('water_element_saturation_status', 'googlemap');
		$water_element_gamma_status = Plugin::getSetting('water_element_gamma_status', 'googlemap');
		$water_element_lightness_status = Plugin::getSetting('water_element_lightness_status', 'googlemap');
		$poi_saturation_status = Plugin::getSetting('poi_saturation_status', 'googlemap');
		$poi_gamma_status = Plugin::getSetting('poi_gamma_status', 'googlemap');
		$poi_lightness_status = Plugin::getSetting('poi_lightness_status', 'googlemap');
		$road_local_element_label_saturation_status = Plugin::getSetting('road_local_element_label_saturation_status', 'googlemap');
		$road_local_element_label_gamma_status = Plugin::getSetting('road_local_element_label_gamma_status', 'googlemap');
		$road_local_element_label_lightness_status = Plugin::getSetting('road_local_element_label_lightness_status', 'googlemap');
		$road_arterial_element_label_saturation_status = Plugin::getSetting('road_arterial_element_label_saturation_status', 'googlemap');
		$road_arterial_element_label_gamma_status = Plugin::getSetting('road_arterial_element_label_gamma_status', 'googlemap');
		$road_arterial_element_label_lightness_status = Plugin::getSetting('road_arterial_element_label_lightness_status', 'googlemap');
		$road_highway_element_label_saturation_status = Plugin::getSetting('road_highway_element_label_saturation_status', 'googlemap');
		$road_highway_element_label_gamma_status = Plugin::getSetting('road_highway_element_label_gamma_status', 'googlemap');
		$road_highway_element_label_lightness_status = Plugin::getSetting('road_highway_element_label_lightness_status', 'googlemap');
		$element_label_saturation_status = Plugin::getSetting('element_label_saturation_status', 'googlemap');
		$element_label_gamma_status = Plugin::getSetting('element_label_gamma_status', 'googlemap');
		$element_label_lightness_status = Plugin::getSetting('element_label_lightness_status', 'googlemap');
		$natural_element_label_saturation_status = Plugin::getSetting('natural_element_label_saturation_status', 'googlemap');
		$natural_element_label_gamma_status = Plugin::getSetting('natural_element_label_gamma_status', 'googlemap');
		$natural_element_label_lightness_status = Plugin::getSetting('natural_element_label_lightness_status', 'googlemap');
		$water_element_label_saturation_status = Plugin::getSetting('water_element_label_saturation_status', 'googlemap');
		$water_element_label_gamma_status = Plugin::getSetting('water_element_label_gamma_status', 'googlemap');
		$water_element_label_lightness_status = Plugin::getSetting('water_element_label_lightness_status', 'googlemap');
		$poi_label_saturation_status = Plugin::getSetting('poi_label_saturation_status', 'googlemap');
		$poi_label_gamma_status = Plugin::getSetting('poi_label_gamma_status', 'googlemap');
		$poi_label_lightness_status = Plugin::getSetting('poi_label_lightness_status', 'googlemap');
		$marker = Plugin::getSetting('marker', 'googlemap');
		$marker_id = Plugin::getSetting('marker_id', 'googlemap');
		$marker_entrance = Plugin::getSetting('marker_entrance', 'googlemap');
		$marker_delay = Plugin::getSetting('marker_delay', 'googlemap');
		$marker_scatter = Plugin::getSetting('marker_scatter', 'googlemap');
		$marker_img = Plugin::getSetting('marker_img', 'googlemap');
		$marker_img_width = Plugin::getSetting('marker_img_width', 'googlemap');
		$marker_img_height = Plugin::getSetting('marker_img_height', 'googlemap');
		$marker_img_x = Plugin::getSetting('marker_img_x', 'googlemap');
		$marker_img_y = Plugin::getSetting('marker_img_y', 'googlemap');
		$marker_img_point_x = Plugin::getSetting('marker_img_point_x', 'googlemap');
		$marker_img_point_y = Plugin::getSetting('marker_img_point_y', 'googlemap');
		$marker_shadow_img = Plugin::getSetting('marker_shadow_img', 'googlemap');
		$marker_shadow_img_width = Plugin::getSetting('marker_shadow_img_width', 'googlemap');
		$marker_shadow_img_height = Plugin::getSetting('marker_shadow_img_height', 'googlemap');
		$marker_shadow_img_x = Plugin::getSetting('marker_shadow_img_x', 'googlemap');
		$marker_shadow_img_y = Plugin::getSetting('marker_shadow_img_y', 'googlemap');
		$marker_shadow_img_point_x = Plugin::getSetting('marker_shadow_img_point_x', 'googlemap');
		$marker_shadow_img_point_y = Plugin::getSetting('marker_shadow_img_point_y', 'googlemap');
		$streetview = Plugin::getSetting('streetview', 'googlemap');

		$api_version = Plugin::getSetting('api_version', 'googlemap');
		$region = Plugin::getSetting('region', 'googlemap');
	
		//if($map_id != null && $map_code != ''){
		if($map_id != null){
			
			if(defined('DEBUG') && DEBUG == 'true'){

				include("templates/header.php");
				include("templates/footer.php");

			} else {

				ob_start();
				include("templates/header.php");
				$header = ob_get_contents();
				ob_end_clean();
				$header = strtr($header, array("\t\t" => "", "\t" => "", "\n" => "", "\r" => ""));
				echo $header;
	
				ob_start();
				include("templates/footer.php");
				$footer = ob_get_contents();
				ob_end_clean();
				$footer = strtr($footer, array("\t\t" => "", "\t" => "", "\n" => "", "\r" => ""));
				echo $footer;
			
			}

			include "templates/body.php";
		}

}
if (Plugin::isEnabled('googlemap')) {
	//Observer::observe('page_found', 'add_javascript');
	//Plugin::addJavascript('googlemap', 'js/jquery.toggleLegendChildren.js');
	//Plugin::addJavascript('googlemap', 'js/jquery.miniColors.js');
	//Plugin::addJavascript('googlemap', 'js/scripts.js');
	//Plugin::addJavascript('googlemap', 'jquery.miniColors.css');
}

if (Plugin::isEnabled('googlemap')) {
	function add_javascript($page) {	
		$map_id = Plugin::getSetting('map_id', 'googlemap');
		$map_code = Plugin::getSetting('map_code', 'googlemap');
	
		if($map_code == ''){
	
			$sensor = Plugin::getSetting('sensor', 'googlemap');
			$infowindow = Plugin::getSetting('infowindow', 'googlemap');
			$directions = Plugin::getSetting('directions', 'googlemap');
			$autodisplay = Plugin::getSetting('autodisplay', 'googlemap');
			$viewport_width = Plugin::getSetting('viewport_width', 'googlemap');
			$viewport_scale = Plugin::getSetting('viewport_scale', 'googlemap');
			$viewport_zoom = Plugin::getSetting('viewport_zoom', 'googlemap');
			$latitude = Plugin::getSetting('latitude', 'googlemap');
			$longitude = Plugin::getSetting('longitude', 'googlemap');
			$zoom = Plugin::getSetting('zoom', 'googlemap');
			$zoom_control = Plugin::getSetting('zoom_control', 'googlemap');
			$navigation_control = Plugin::getSetting('navigation_control', 'googlemap');
			$map_width = Plugin::getSetting('map_width', 'googlemap');
			$map_height = Plugin::getSetting('map_height', 'googlemap');
			$map_ui = Plugin::getSetting('map_ui', 'googlemap');
			$map_type = Plugin::getSetting('map_type', 'googlemap');
			$map_control = Plugin::getSetting('map_control', 'googlemap');
			$map_libraries = Plugin::getSetting('map_libraries', 'googlemap');
			$map_styling = Plugin::getSetting('map_styling', 'googlemap');
			$road_local_element_visibility = Plugin::getSetting('road_local_element_visibility', 'googlemap');
			$road_local_element_hue_status = Plugin::getSetting('road_local_element_hue_status', 'googlemap');
			$road_local_element_hue = Plugin::getSetting('road_local_element_hue', 'googlemap');
			$road_local_element_saturation = Plugin::getSetting('road_local_element_saturation', 'googlemap');
			$road_local_element_gamma = Plugin::getSetting('road_local_element_gamma', 'googlemap');
			$road_local_element_lightness = Plugin::getSetting('road_local_element_lightness', 'googlemap');
			$road_local_element_lightness_invert = Plugin::getSetting('road_local_element_lightness_invert', 'googlemap');
			$road_arterial_element_visibility = Plugin::getSetting('road_arterial_element_visibility', 'googlemap');
			$road_arterial_element_hue_status = Plugin::getSetting('road_arterial_element_hue_status', 'googlemap');
			$road_arterial_element_hue = Plugin::getSetting('road_arterial_element_hue', 'googlemap');
			$road_arterial_element_saturation = Plugin::getSetting('road_arterial_element_saturation', 'googlemap');
			$road_arterial_element_gamma = Plugin::getSetting('road_arterial_element_gamma', 'googlemap');
			$road_arterial_element_lightness = Plugin::getSetting('road_arterial_element_lightness', 'googlemap');
			$road_arterial_element_lightness_invert = Plugin::getSetting('road_arterial_element_lightness_invert', 'googlemap');
			$road_highway_element_visibility = Plugin::getSetting('road_highway_element_visibility', 'googlemap');
			$road_highway_element_hue_status = Plugin::getSetting('road_highway_element_hue_status', 'googlemap');
			$road_highway_element_hue = Plugin::getSetting('road_highway_element_hue', 'googlemap');
			$road_highway_element_saturation = Plugin::getSetting('road_highway_element_saturation', 'googlemap');
			$road_highway_element_gamma = Plugin::getSetting('road_highway_element_gamma', 'googlemap');
			$road_highway_element_lightness = Plugin::getSetting('road_highway_element_lightness', 'googlemap');
			$road_highway_element_lightness_invert = Plugin::getSetting('road_highway_element_lightness_invert', 'googlemap');
			$element_visibility = Plugin::getSetting('element_visibility', 'googlemap');
			$element_hue_status = Plugin::getSetting('element_hue_status', 'googlemap');
			$element_hue = Plugin::getSetting('element_hue', 'googlemap');
			$element_saturation = Plugin::getSetting('element_saturation', 'googlemap');
			$element_gamma = Plugin::getSetting('element_gamma', 'googlemap');
			$element_lightness = Plugin::getSetting('element_lightness', 'googlemap');
			$element_lightness_invert = Plugin::getSetting('element_lightness_invert', 'googlemap');
			$natural_element_visibility = Plugin::getSetting('natural_element_visibility', 'googlemap');
			$natural_element_hue_status = Plugin::getSetting('natural_element_hue_status', 'googlemap');
			$natural_element_hue = Plugin::getSetting('natural_element_hue', 'googlemap');
			$natural_element_saturation = Plugin::getSetting('natural_element_saturation', 'googlemap');
			$natural_element_gamma = Plugin::getSetting('natural_element_gamma', 'googlemap');
			$natural_element_lightness = Plugin::getSetting('natural_element_lightness', 'googlemap');
			$natural_element_lightness_invert = Plugin::getSetting('natural_element_lightness_invert', 'googlemap');
			$water_element_visibility = Plugin::getSetting('water_element_visibility', 'googlemap');
			$water_element_hue_status = Plugin::getSetting('water_element_hue_status', 'googlemap');
			$water_element_hue = Plugin::getSetting('water_element_hue', 'googlemap');
			$water_element_saturation = Plugin::getSetting('water_element_saturation', 'googlemap');
			$water_element_gamma = Plugin::getSetting('water_element_gamma', 'googlemap');
			$water_element_lightness = Plugin::getSetting('water_element_lightness', 'googlemap');
			$water_element_lightness_invert = Plugin::getSetting('water_element_lightness_invert', 'googlemap');
			$poi_visibility = Plugin::getSetting('poi_visibility', 'googlemap');
			$poi_hue_status = Plugin::getSetting('poi_hue_status', 'googlemap');
			$poi_hue = Plugin::getSetting('poi_hue', 'googlemap');
			$poi_saturation = Plugin::getSetting('poi_saturation', 'googlemap');
			$poi_gamma = Plugin::getSetting('poi_gamma', 'googlemap');
			$poi_lightness = Plugin::getSetting('poi_lightness', 'googlemap');
			$poi_lightness_invert = Plugin::getSetting('poi_lightness_invert', 'googlemap');
			$road_local_element_label_visibility = Plugin::getSetting('road_local_element_label_visibility', 'googlemap');
			$road_local_element_label_hue_status = Plugin::getSetting('road_local_element_label_hue_status', 'googlemap');
			$road_local_element_label_hue = Plugin::getSetting('road_local_element_label_hue', 'googlemap');
			$road_local_element_label_saturation = Plugin::getSetting('road_local_element_label_saturation', 'googlemap');
			$road_local_element_label_gamma = Plugin::getSetting('road_local_element_label_gamma', 'googlemap');
			$road_local_element_label_lightness = Plugin::getSetting('road_local_element_label_lightness', 'googlemap');
			$road_local_element_label_lightness_invert = Plugin::getSetting('road_local_element_label_lightness_invert', 'googlemap');
			$road_arterial_element_label_visibility = Plugin::getSetting('road_arterial_element_label_visibility', 'googlemap');
			$road_arterial_element_label_hue_status = Plugin::getSetting('road_arterial_element_label_hue_status', 'googlemap');
			$road_arterial_element_label_hue = Plugin::getSetting('road_arterial_element_label_hue', 'googlemap');
			$road_arterial_element_label_saturation = Plugin::getSetting('road_arterial_element_label_saturation', 'googlemap');
			$road_arterial_element_label_gamma = Plugin::getSetting('road_arterial_element_label_gamma', 'googlemap');
			$road_arterial_element_label_lightness = Plugin::getSetting('road_arterial_element_label_lightness', 'googlemap');
			$road_arterial_element_label_lightness_invert = Plugin::getSetting('road_arterial_element_label_lightness_invert', 'googlemap');
			$road_highway_element_label_visibility = Plugin::getSetting('road_highway_element_label_visibility', 'googlemap');
			$road_highway_element_label_hue_status = Plugin::getSetting('road_highway_element_label_hue_status', 'googlemap');
			$road_highway_element_label_hue = Plugin::getSetting('road_highway_element_label_hue', 'googlemap');
			$road_highway_element_label_saturation = Plugin::getSetting('road_highway_element_label_saturation', 'googlemap');
			$road_highway_element_label_gamma = Plugin::getSetting('road_highway_element_label_gamma', 'googlemap');
			$road_highway_element_label_lightness = Plugin::getSetting('road_highway_element_label_lightness', 'googlemap');
			$road_highway_element_label_lightness_invert = Plugin::getSetting('road_highway_element_label_lightness_invert', 'googlemap');
			$element_label_visibility = Plugin::getSetting('element_label_visibility', 'googlemap');
			$element_label_hue_status = Plugin::getSetting('element_label_hue_status', 'googlemap');
			$element_label_hue = Plugin::getSetting('element_label_hue', 'googlemap');
			$element_label_saturation = Plugin::getSetting('element_label_saturation', 'googlemap');
			$element_label_gamma = Plugin::getSetting('element_label_gamma', 'googlemap');
			$element_label_lightness = Plugin::getSetting('element_label_lightness', 'googlemap');
			$element_label_lightness_invert = Plugin::getSetting('element_label_lightness_invert', 'googlemap');
			$natural_element_label_visibility = Plugin::getSetting('natural_element_label_visibility', 'googlemap');
			$natural_element_label_hue_status = Plugin::getSetting('natural_element_label_hue_status', 'googlemap');
			$natural_element_label_hue = Plugin::getSetting('natural_element_label_hue', 'googlemap');
			$natural_element_label_saturation = Plugin::getSetting('natural_element_label_saturation', 'googlemap');
			$natural_element_label_gamma = Plugin::getSetting('natural_element_label_gamma', 'googlemap');
			$natural_element_label_lightness = Plugin::getSetting('natural_element_label_lightness', 'googlemap');
			$natural_element_label_lightness_invert = Plugin::getSetting('natural_element_label_lightness_invert', 'googlemap');
			$water_element_label_visibility = Plugin::getSetting('water_element_label_visibility', 'googlemap');
			$water_element_label_hue_status = Plugin::getSetting('water_element_label_hue_status', 'googlemap');
			$water_element_label_hue = Plugin::getSetting('water_element_label_hue', 'googlemap');
			$water_element_label_saturation = Plugin::getSetting('water_element_label_saturation', 'googlemap');
			$water_element_label_gamma = Plugin::getSetting('water_element_label_gamma', 'googlemap');
			$water_element_label_lightness = Plugin::getSetting('water_element_label_lightness', 'googlemap');
			$water_element_label_lightness_invert = Plugin::getSetting('water_element_label_lightness_invert', 'googlemap');
			$poi_label_visibility = Plugin::getSetting('poi_label_visibility', 'googlemap');
			$poi_label_hue_status = Plugin::getSetting('poi_label_hue_status', 'googlemap');
			$poi_label_hue = Plugin::getSetting('poi_label_hue', 'googlemap');
			$poi_label_saturation = Plugin::getSetting('poi_label_saturation', 'googlemap');
			$poi_label_gamma = Plugin::getSetting('poi_label_gamma', 'googlemap');
			$poi_label_lightness = Plugin::getSetting('poi_label_lightness', 'googlemap');
			$poi_label_lightness_invert = Plugin::getSetting('poi_label_lightness_invert', 'googlemap');
			$road_local_element_saturation_status_status = Plugin::getSetting('road_local_element_saturation_status', 'googlemap');
			$road_local_element_gamma_status_status = Plugin::getSetting('road_local_element_gamma_status', 'googlemap');
			$road_local_element_lightness_status = Plugin::getSetting('road_local_element_lightness_status', 'googlemap');
			$road_arterial_element_saturation_status = Plugin::getSetting('road_arterial_element_saturation_status', 'googlemap');
			$road_arterial_element_gamma_status = Plugin::getSetting('road_arterial_element_gamma_status', 'googlemap');
			$road_arterial_element_lightness_status = Plugin::getSetting('road_arterial_element_lightness_status', 'googlemap');
			$road_highway_element_saturation_status = Plugin::getSetting('road_highway_element_saturation_status', 'googlemap');
			$road_highway_element_gamma_status = Plugin::getSetting('road_highway_element_gamma_status', 'googlemap');
			$road_highway_element_lightness_status = Plugin::getSetting('road_highway_element_lightness_status', 'googlemap');
			$element_saturation_status = Plugin::getSetting('element_saturation_status', 'googlemap');
			$element_gamma_status = Plugin::getSetting('element_gamma_status', 'googlemap');
			$element_lightness_status = Plugin::getSetting('element_lightness', 'googlemap');
			$natural_element_saturation_status = Plugin::getSetting('natural_element_saturation_status', 'googlemap');
			$natural_element_gamma_status = Plugin::getSetting('natural_element_gamma_status', 'googlemap');
			$natural_element_lightness_status = Plugin::getSetting('natural_element_lightness_status', 'googlemap');
			$water_element_saturation_status = Plugin::getSetting('water_element_saturation_status', 'googlemap');
			$water_element_gamma_status = Plugin::getSetting('water_element_gamma_status', 'googlemap');
			$water_element_lightness_status = Plugin::getSetting('water_element_lightness_status', 'googlemap');
			$poi_saturation_status = Plugin::getSetting('poi_saturation_status', 'googlemap');
			$poi_gamma_status = Plugin::getSetting('poi_gamma_status', 'googlemap');
			$poi_lightness_status = Plugin::getSetting('poi_lightness_status', 'googlemap');
			$road_local_element_label_saturation_status = Plugin::getSetting('road_local_element_label_saturation_status', 'googlemap');
			$road_local_element_label_gamma_status = Plugin::getSetting('road_local_element_label_gamma_status', 'googlemap');
			$road_local_element_label_lightness_status = Plugin::getSetting('road_local_element_label_lightness_status', 'googlemap');
			$road_arterial_element_label_saturation_status = Plugin::getSetting('road_arterial_element_label_saturation_status', 'googlemap');
			$road_arterial_element_label_gamma_status = Plugin::getSetting('road_arterial_element_label_gamma_status', 'googlemap');
			$road_arterial_element_label_lightness_status = Plugin::getSetting('road_arterial_element_label_lightness_status', 'googlemap');
			$road_highway_element_label_saturation_status = Plugin::getSetting('road_highway_element_label_saturation_status', 'googlemap');
			$road_highway_element_label_gamma_status = Plugin::getSetting('road_highway_element_label_gamma_status', 'googlemap');
			$road_highway_element_label_lightness_status = Plugin::getSetting('road_highway_element_label_lightness_status', 'googlemap');
			$element_label_saturation_status = Plugin::getSetting('element_label_saturation_status', 'googlemap');
			$element_label_gamma_status = Plugin::getSetting('element_label_gamma_status', 'googlemap');
			$element_label_lightness_status = Plugin::getSetting('element_label_lightness_status', 'googlemap');
			$natural_element_label_saturation_status = Plugin::getSetting('natural_element_label_saturation_status', 'googlemap');
			$natural_element_label_gamma_status = Plugin::getSetting('natural_element_label_gamma_status', 'googlemap');
			$natural_element_label_lightness_status = Plugin::getSetting('natural_element_label_lightness_status', 'googlemap');
			$water_element_label_saturation_status = Plugin::getSetting('water_element_label_saturation_status', 'googlemap');
			$water_element_label_gamma_status = Plugin::getSetting('water_element_label_gamma_status', 'googlemap');
			$water_element_label_lightness_status = Plugin::getSetting('water_element_label_lightness_status', 'googlemap');
			$poi_label_saturation_status = Plugin::getSetting('poi_label_saturation_status', 'googlemap');
			$poi_label_gamma_status = Plugin::getSetting('poi_label_gamma_status', 'googlemap');
			$poi_label_lightness_status = Plugin::getSetting('poi_label_lightness_status', 'googlemap');
			$marker = Plugin::getSetting('marker', 'googlemap');
			$marker_id = Plugin::getSetting('marker_id', 'googlemap');
			$marker_entrance = Plugin::getSetting('marker_entrance', 'googlemap');
			$marker_delay = Plugin::getSetting('marker_delay', 'googlemap');
			$marker_scatter = Plugin::getSetting('marker_scatter', 'googlemap');
			$marker_img = Plugin::getSetting('marker_img', 'googlemap');
			$marker_img_width = Plugin::getSetting('marker_img_width', 'googlemap');
			$marker_img_height = Plugin::getSetting('marker_img_height', 'googlemap');
			$marker_img_x = Plugin::getSetting('marker_img_x', 'googlemap');
			$marker_img_y = Plugin::getSetting('marker_img_y', 'googlemap');
			$marker_img_point_x = Plugin::getSetting('marker_img_point_x', 'googlemap');
			$marker_img_point_y = Plugin::getSetting('marker_img_point_y', 'googlemap');
			$marker_shadow_img = Plugin::getSetting('marker_shadow_img', 'googlemap');
			$marker_shadow_img_width = Plugin::getSetting('marker_shadow_img_width', 'googlemap');
			$marker_shadow_img_height = Plugin::getSetting('marker_shadow_img_height', 'googlemap');
			$marker_shadow_img_x = Plugin::getSetting('marker_shadow_img_x', 'googlemap');
			$marker_shadow_img_y = Plugin::getSetting('marker_shadow_img_y', 'googlemap');
			$marker_shadow_img_point_x = Plugin::getSetting('marker_shadow_img_point_x', 'googlemap');
			$marker_shadow_img_point_y = Plugin::getSetting('marker_shadow_img_point_y', 'googlemap');
			$streetview = Plugin::getSetting('streetview', 'googlemap');
	
			ob_start();
			$page->includeSnippet('registerfunctions'); // Include custom functions snippet
			$page->_executeLayout();
			$page = ob_get_contents();
			ob_end_clean();
			//if (stristr($page, 'id="'.$map_id.'"')){
			if (stristr($page, 'id="'.$map_id.'"')){
	
				ob_start();
				include("templates/header.php");
				$header = ob_get_contents();
				ob_end_clean();
	
				$header = str_replace("<
	<script", "<script", $header);
				$page = preg_replace('</head>', $header."\n</head", $page, 1);
	
				ob_start();
				include("templates/footer.php");
				$footer = ob_get_contents();
				ob_end_clean();
				// Slim header output
				//$footer = strtr($footer, array("\t" => "", "\n" => "", "\r" => ""));
	
				//$footer = str_replace('<<script', '<script', $footer);
				$page = preg_replace('</body>', "$footer\n</body", $page, 1);
	
				//Remove mysterious extra less-than symbol appearing at start of included templates
				$page = str_replace("<
	<script", "<script", $page);
				$page = str_replace("<<script", "<script", $page);
			}
	
			echo $page;
	
			exit();
		}
	
	}

}
}