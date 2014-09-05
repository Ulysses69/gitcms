<?php

class GoogleMapController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/googlemap/views/sidebar'));
	}
	public function index(){
		$this->generate();
	}
	public function generate(){
		$this->display('googlemap/views/settings');
	}

	public function settings(){
		$settings = Plugin::getAllSettings('googlemap');
		if (!$settings) {
			Flash::set('error', 'Google Map - '.__('unable to retrieve plugin settings.'));
			return;
		}
		$this->display('googlemap/views/settings', $settings);
	}
	public function save_settings(){

		$tablename = TABLE_PREFIX.'googlemap';

		/*
		$sensor = $_POST['sensor'];
		$infowindow = $_POST['infowindow'];
		$directions = $_POST['directions'];
		$autodisplay = $_POST['autodisplay'];
		$viewport_width = $_POST['viewport_width'];
		$viewport_scale = $_POST['viewport_scale'];
		$viewport_zoom = $_POST['viewport_zoom'];
		$latitude = $_POST['latitude'];
		$longitude = $_POST['longitude'];
		$zoom = $_POST['zoom'];
		$zoom_control = $_POST['zoom_control'];
		$navigation_control = $_POST['navigation_control'];
		$map_id = $_POST['map_id'];
		$map_width = $_POST['map_width'];
		$map_height = $_POST['map_height'];
		$map_code = $_POST['map_code'];
		$map_ui = $_POST['map_ui'];
		$map_type = $_POST['map_type'];
		$map_control = $_POST['map_control'];
		$map_libraries = $_POST['map_libraries'];
		$map_styling = $_POST['map_styling'];
		$road_local_element_visibility = $_POST['road_local_element_visibility'];
		$road_local_element_hue_status = $_POST['road_local_element_hue_status'];
		$road_local_element_hue = $_POST['road_local_element_hue'];
		$road_local_element_saturation = $_POST['road_local_element_saturation'];
		$road_local_element_gamma = $_POST['road_local_element_gamma'];
		$road_local_element_lightness = $_POST['road_local_element_lightness'];
		$road_local_element_lightness_invert = $_POST['road_local_element_lightness_invert'];
		$road_arterial_element_visibility = $_POST['road_arterial_element_visibility'];
		$road_arterial_element_hue_status = $_POST['road_arterial_element_hue_status'];
		$road_arterial_element_hue = $_POST['road_arterial_element_hue'];
		$road_arterial_element_saturation = $_POST['road_arterial_element_saturation'];
		$road_arterial_element_gamma = $_POST['road_arterial_element_gamma'];
		$road_arterial_element_lightness = $_POST['road_arterial_element_lightness'];
		$road_arterial_element_lightness_invert = $_POST['road_arterial_element_lightness_invert'];
		$road_highway_element_visibility = $_POST['road_highway_element_visibility'];
		$road_highway_element_hue_status = $_POST['road_highway_element_hue_status'];
		$road_highway_element_hue = $_POST['road_highway_element_hue'];
		$road_highway_element_saturation = $_POST['road_highway_element_saturation'];
		$road_highway_element_gamma = $_POST['road_highway_element_gamma'];
		$road_highway_element_lightness = $_POST['road_highway_element_lightness'];
		$road_highway_element_lightness_invert = $_POST['road_highway_element_lightness_invert'];
		$element_visibility = $_POST['element_visibility'];
		$element_hue_status = $_POST['element_hue_status'];
		$element_hue = $_POST['element_hue'];
		$element_saturation = $_POST['element_saturation'];
		$element_gamma = $_POST['element_gamma'];
		$element_lightness = $_POST['element_lightness'];
		$element_lightness_invert = $_POST['element_lightness_invert'];
		$natural_element_visibility = $_POST['natural_element_visibility'];
		$natural_element_hue_status = $_POST['natural_element_hue_status'];
		$natural_element_hue = $_POST['natural_element_hue'];
		$natural_element_saturation = $_POST['natural_element_saturation'];
		$natural_element_gamma = $_POST['natural_element_gamma'];
		$natural_element_lightness = $_POST['natural_element_lightness'];
		$natural_element_lightness_invert = $_POST['natural_element_lightness_invert'];
		$water_element_visibility = $_POST['water_element_visibility'];
		$water_element_hue_status = $_POST['water_element_hue_status'];
		$water_element_hue = $_POST['water_element_hue'];
		$water_element_saturation = $_POST['water_element_saturation'];
		$water_element_gamma = $_POST['water_element_gamma'];
		$water_element_lightness = $_POST['water_element_lightness'];
		$water_element_lightness_invert = $_POST['water_element_lightness_invert'];
		$poi_visibility = $_POST['poi_visibility'];
		$poi_hue_status = $_POST['poi_hue_status'];
		$poi_hue = $_POST['poi_hue'];
		$poi_saturation = $_POST['poi_saturation'];
		$poi_gamma = $_POST['poi_gamma'];
		$poi_lightness = $_POST['poi_lightness'];
		$poi_lightness_invert = $_POST['poi_lightness_invert'];
		$road_local_element_label_visibility = $_POST['road_local_element_label_visibility'];
		$road_local_element_label_hue_status = $_POST['road_local_element_label_hue_status'];
		$road_local_element_label_hue = $_POST['road_local_element_label_hue'];
		$road_local_element_label_saturation = $_POST['road_local_element_label_saturation'];
		$road_local_element_label_gamma = $_POST['road_local_element_label_gamma'];
		$road_local_element_label_lightness = $_POST['road_local_element_label_lightness'];
		$road_local_element_label_lightness_invert = $_POST['road_local_element_label_lightness_invert'];
		$road_arterial_element_label_visibility = $_POST['road_arterial_element_label_visibility'];
		$road_arterial_element_label_hue_status = $_POST['road_arterial_element_label_hue_status'];
		$road_arterial_element_label_hue = $_POST['road_arterial_element_label_hue'];
		$road_arterial_element_label_saturation = $_POST['road_arterial_element_label_saturation'];
		$road_arterial_element_label_gamma = $_POST['road_arterial_element_label_gamma'];
		$road_arterial_element_label_lightness = $_POST['road_arterial_element_label_lightness'];
		$road_arterial_element_label_lightness_invert = $_POST['road_arterial_element_label_lightness_invert'];
		$road_highway_element_label_visibility = $_POST['road_highway_element_label_visibility'];
		$road_highway_element_label_hue_status = $_POST['road_highway_element_label_hue_status'];
		$road_highway_element_label_hue = $_POST['road_highway_element_label_hue'];
		$road_highway_element_label_saturation = $_POST['road_highway_element_label_saturation'];
		$road_highway_element_label_gamma = $_POST['road_highway_element_label_gamma'];
		$road_highway_element_label_lightness = $_POST['road_highway_element_label_lightness'];
		$road_highway_element_label_lightness_invert = $_POST['road_highway_element_label_lightness_invert'];
		$element_label_visibility = $_POST['element_label_visibility'];
		$element_label_hue_status = $_POST['element_label_hue_status'];
		$element_label_hue = $_POST['element_label_hue'];
		$element_label_saturation = $_POST['element_label_saturation'];
		$element_label_gamma = $_POST['element_label_gamma'];
		$element_label_lightness = $_POST['element_label_lightness'];
		$element_label_lightness_invert = $_POST['element_label_lightness_invert'];
		$natural_element_label_visibility = $_POST['natural_element_label_visibility'];
		$natural_element_label_hue_status = $_POST['natural_element_label_hue_status'];
		$natural_element_label_hue = $_POST['natural_element_label_hue'];
		$natural_element_label_saturation = $_POST['natural_element_label_saturation'];
		$natural_element_label_gamma = $_POST['natural_element_label_gamma'];
		$natural_element_label_lightness = $_POST['natural_element_label_lightness'];
		$natural_element_label_lightness_invert = $_POST['natural_element_label_lightness_invert'];
		$water_element_label_visibility = $_POST['water_element_label_visibility'];
		$water_element_label_hue_status = $_POST['water_element_label_hue_status'];
		$water_element_label_hue = $_POST['water_element_label_hue'];
		$water_element_label_saturation = $_POST['water_element_label_saturation'];
		$water_element_label_gamma = $_POST['water_element_label_gamma'];
		$water_element_label_lightness = $_POST['water_element_label_lightness'];
		$water_element_label_lightness_invert = $_POST['water_element_label_lightness_invert'];
		$poi_label_visibility = $_POST['poi_label_visibility'];
		$poi_label_hue_status = $_POST['poi_label_hue_status'];
		$poi_label_hue = $_POST['poi_label_hue'];
		$poi_label_saturation = $_POST['poi_label_saturation'];
		$poi_label_gamma = $_POST['poi_label_gamma'];
		$poi_label_lightness = $_POST['poi_label_lightness'];
		$poi_label_lightness_invert = $_POST['poi_label_lightness_invert'];
		$road_local_element_saturation_status_status = $_POST['road_local_element_saturation_status'];
		$road_local_element_gamma_status_status = $_POST['road_local_element_gamma_status'];
		$road_local_element_lightness_status = $_POST['road_local_element_lightness_status'];
		$road_arterial_element_saturation_status = $_POST['road_arterial_element_saturation_status'];
		$road_arterial_element_gamma_status = $_POST['road_arterial_element_gamma_status'];
		$road_arterial_element_lightness_status = $_POST['road_arterial_element_lightness_status'];
		$road_highway_element_saturation_status = $_POST['road_highway_element_saturation_status'];
		$road_highway_element_gamma_status = $_POST['road_highway_element_gamma_status'];
		$road_highway_element_lightness_status = $_POST['road_highway_element_lightness_status'];
		$element_saturation_status = $_POST['element_saturation_status'];
		$element_gamma_status = $_POST['element_gamma_status'];
		$element_lightness_status = $_POST['element_lightness'];
		$natural_element_saturation_status = $_POST['natural_element_saturation_status'];
		$natural_element_gamma_status = $_POST['natural_element_gamma_status'];
		$natural_element_lightness_status = $_POST['natural_element_lightness_status'];
		$water_element_saturation_status = $_POST['water_element_saturation_status'];
		$water_element_gamma_status = $_POST['water_element_gamma_status'];
		$water_element_lightness_status = $_POST['water_element_lightness_status'];
		$poi_saturation_status = $_POST['poi_saturation_status'];
		$poi_gamma_status = $_POST['poi_gamma_status'];
		$poi_lightness_status = $_POST['poi_lightness_status'];
		$road_local_element_label_saturation_status = $_POST['road_local_element_label_saturation_status'];
		$road_local_element_label_gamma_status = $_POST['road_local_element_label_gamma_status'];
		$road_local_element_label_lightness_status = $_POST['road_local_element_label_lightness_status'];
		$road_arterial_element_label_saturation_status = $_POST['road_arterial_element_label_saturation_status'];
		$road_arterial_element_label_gamma_status = $_POST['road_arterial_element_label_gamma_status'];
		$road_arterial_element_label_lightness_status = $_POST['road_arterial_element_label_lightness_status'];
		$road_highway_element_label_saturation_status = $_POST['road_highway_element_label_saturation_status'];
		$road_highway_element_label_gamma_status = $_POST['road_highway_element_label_gamma_status'];
		$road_highway_element_label_lightness_status = $_POST['road_highway_element_label_lightness_status'];
		$element_label_saturation_status = $_POST['element_label_saturation_status'];
		$element_label_gamma_status = $_POST['element_label_gamma_status'];
		$element_label_lightness_status = $_POST['element_label_lightness_status'];
		$natural_element_label_saturation_status = $_POST['natural_element_label_saturation_status'];
		$natural_element_label_gamma_status = $_POST['natural_element_label_gamma_status'];
		$natural_element_label_lightness_status = $_POST['natural_element_label_lightness_status'];
		$water_element_label_saturation_status = $_POST['water_element_label_saturation_status'];
		$water_element_label_gamma_status = $_POST['water_element_label_gamma_status'];
		$water_element_label_lightness_status = $_POST['water_element_label_lightness_status'];
		$poi_label_saturation_status = $_POST['poi_label_saturation_status'];
		$poi_label_gamma_status = $_POST['poi_label_gamma_status'];
		$poi_label_lightness_status = $_POST['poi_label_lightness_status'];
		$marker = $_POST['marker'];
		$marker_id = $_POST['marker_id'];
		$marker_entrance = $_POST['marker_entrance'];
		$marker_delay = $_POST['marker_delay'];
		$marker_scatter = $_POST['marker_scatter'];
		$marker_img = $_POST['marker_img'];
		$marker_img_width = $_POST['marker_img_width'];
		$marker_img_height = $_POST['marker_img_height'];
		$marker_img_x = $_POST['marker_img_x'];
		$marker_img_y = $_POST['marker_img_y'];
		$marker_img_point_x = $_POST['marker_img_point_x'];
		$marker_img_point_y = $_POST['marker_img_point_y'];
		$marker_shadow_img = $_POST['marker_shadow_img'];
		$marker_shadow_img_width = $_POST['marker_shadow_img_width'];
		$marker_shadow_img_height = $_POST['marker_shadow_img_height'];
		$marker_shadow_img_x = $_POST['marker_shadow_img_x'];
		$marker_shadow_img_y = $_POST['marker_shadow_img_y'];
		$marker_shadow_img_point_x = $_POST['marker_shadow_img_point_x'];
		$marker_shadow_img_point_y = $_POST['marker_shadow_img_point_y'];
		*/


		if(isset($_POST['sensor'])) { $sensor = $_POST['sensor']; } else { $sensor = ''; }
		if(isset($_POST['infowindow'])) { $infowindow = $_POST['infowindow']; } else { $infowindow = ''; }
		if(isset($_POST['directions'])) { $directions = $_POST['directions']; } else { $directions = ''; }
		if(isset($_POST['autodisplay'])) { $autodisplay = $_POST['autodisplay']; } else { $autodisplay = ''; }
		if(isset($_POST['viewport_width'])) { $viewport_width = $_POST['viewport_width']; } else { $viewport_width = ''; }
		if(isset($_POST['viewport_scale'])) { $viewport_scale = $_POST['viewport_scale']; } else { $viewport_scale = ''; }
		if(isset($_POST['viewport_zoom'])) { $viewport_zoom = $_POST['viewport_zoom']; } else { $viewport_zoom = ''; }
		if(isset($_POST['latitude'])) { $latitude = $_POST['latitude']; } else { $latitude = ''; }
		if(isset($_POST['longitude'])) { $longitude = $_POST['longitude']; } else { $longitude = ''; }
		if(isset($_POST['zoom'])) { $zoom = $_POST['zoom']; } else { $zoom = ''; }
		if(isset($_POST['zoom_control'])) { $zoom_control = $_POST['zoom_control']; } else { $zoom_control = ''; }
		if(isset($_POST['navigation_control'])) { $navigation_control = $_POST['navigation_control']; } else { $navigation_control = ''; }
		if(isset($_POST['map_id'])) { $map_id = $_POST['map_id']; } else { $map_id = ''; }
		if(isset($_POST['map_width'])) { $map_width = $_POST['map_width']; } else { $map_width = ''; }
		if(isset($_POST['map_height'])) { $map_height = $_POST['map_height']; } else { $map_height = ''; }
		if(isset($_POST['map_code'])) { $map_code = $_POST['map_code']; } else { $map_code = ''; }
		if(isset($_POST['map_ui'])) { $map_ui = $_POST['map_ui']; } else { $map_ui = ''; }
		if(isset($_POST['map_type'])) { $map_type = $_POST['map_type']; } else { $map_type = ''; }
		if(isset($_POST['map_control'])) { $map_control = $_POST['map_control']; } else { $map_control = ''; }
		if(isset($_POST['map_libraries'])) { $map_libraries = $_POST['map_libraries']; } else { $map_libraries = ''; }
		if(isset($_POST['map_styling'])) { $map_styling = $_POST['map_styling']; } else { $map_styling = ''; }
		if(isset($_POST['road_local_element_visibility'])) { $road_local_element_visibility = $_POST['road_local_element_visibility']; } else { $road_local_element_visibility = ''; }
		if(isset($_POST['road_local_element_hue_status'])) { $road_local_element_hue_status = $_POST['road_local_element_hue_status']; } else { $road_local_element_hue_status = ''; }
		if(isset($_POST['road_local_element_hue'])) { $road_local_element_hue = $_POST['road_local_element_hue']; } else { $road_local_element_hue = ''; }
		if(isset($_POST['road_local_element_saturation'])) { $road_local_element_saturation = $_POST['road_local_element_saturation']; } else { $road_local_element_saturation = ''; }
		if(isset($_POST['road_local_element_gamma'])) { $road_local_element_gamma = $_POST['road_local_element_gamma']; } else { $road_local_element_gamma = ''; }
		if(isset($_POST['road_local_element_lightness'])) { $road_local_element_lightness = $_POST['road_local_element_lightness']; } else { $road_local_element_lightness = ''; }
		if(isset($_POST['road_local_element_lightness_invert'])) { $road_local_element_lightness_invert = $_POST['road_local_element_lightness_invert']; } else { $road_local_element_lightness_invert = ''; }
		if(isset($_POST['road_arterial_element_visibility'])) { $road_arterial_element_visibility = $_POST['road_arterial_element_visibility']; } else { $road_arterial_element_visibility = ''; }
		if(isset($_POST['road_arterial_element_hue_status'])) { $road_arterial_element_hue_status = $_POST['road_arterial_element_hue_status']; } else { $road_arterial_element_hue_status = ''; }
		if(isset($_POST['road_arterial_element_hue'])) { $road_arterial_element_hue = $_POST['road_arterial_element_hue']; } else { $road_arterial_element_hue = ''; }
		if(isset($_POST['road_arterial_element_saturation'])) { $road_arterial_element_saturation = $_POST['road_arterial_element_saturation']; } else { $road_arterial_element_saturation = ''; }
		if(isset($_POST['road_arterial_element_gamma'])) { $road_arterial_element_gamma = $_POST['road_arterial_element_gamma']; } else { $road_arterial_element_gamma = ''; }
		if(isset($_POST['road_arterial_element_lightness'])) { $road_arterial_element_lightness = $_POST['road_arterial_element_lightness']; } else { $road_arterial_element_lightness = ''; }
		if(isset($_POST['road_arterial_element_lightness_invert'])) { $road_arterial_element_lightness_invert = $_POST['road_arterial_element_lightness_invert']; } else { $road_arterial_element_lightness_invert = ''; }
		if(isset($_POST['road_highway_element_visibility'])) { $road_highway_element_visibility = $_POST['road_highway_element_visibility']; } else { $road_highway_element_visibility = ''; }
		if(isset($_POST['road_highway_element_hue_status'])) { $road_highway_element_hue_status = $_POST['road_highway_element_hue_status']; } else { $road_highway_element_hue_status = ''; }
		if(isset($_POST['road_highway_element_hue'])) { $road_highway_element_hue = $_POST['road_highway_element_hue']; } else { $road_highway_element_hue = ''; }
		if(isset($_POST['road_highway_element_saturation'])) { $road_highway_element_saturation = $_POST['road_highway_element_saturation']; } else { $road_highway_element_saturation = ''; }
		if(isset($_POST['road_highway_element_gamma'])) { $road_highway_element_gamma = $_POST['road_highway_element_gamma']; } else { $road_highway_element_gamma = ''; }
		if(isset($_POST['road_highway_element_lightness'])) { $road_highway_element_lightness = $_POST['road_highway_element_lightness']; } else { $road_highway_element_lightness = ''; }
		if(isset($_POST['road_highway_element_lightness_invert'])) { $road_highway_element_lightness_invert = $_POST['road_highway_element_lightness_invert']; } else { $road_highway_element_lightness_invert = ''; }
		if(isset($_POST['element_visibility'])) { $element_visibility = $_POST['element_visibility']; } else { $element_visibility = ''; }
		if(isset($_POST['element_hue_status'])) { $element_hue_status = $_POST['element_hue_status']; } else { $element_hue_status = ''; }
		if(isset($_POST['element_hue'])) { $element_hue = $_POST['element_hue']; } else { $element_hue = ''; }
		if(isset($_POST['element_saturation'])) { $element_saturation = $_POST['element_saturation']; } else { $element_saturation = ''; }
		if(isset($_POST['element_gamma'])) { $element_gamma = $_POST['element_gamma']; } else { $element_gamma = ''; }
		if(isset($_POST['element_lightness'])) { $element_lightness = $_POST['element_lightness']; } else { $element_lightness = ''; }
		if(isset($_POST['element_lightness_invert'])) { $element_lightness_invert = $_POST['element_lightness_invert']; } else { $element_lightness_invert = ''; }
		if(isset($_POST['natural_element_visibility'])) { $natural_element_visibility = $_POST['natural_element_visibility']; } else { $natural_element_visibility = ''; }
		if(isset($_POST['natural_element_hue_status'])) { $natural_element_hue_status = $_POST['natural_element_hue_status']; } else { $natural_element_hue_status = ''; }
		if(isset($_POST['natural_element_hue'])) { $natural_element_hue = $_POST['natural_element_hue']; } else { $natural_element_hue = ''; }
		if(isset($_POST['natural_element_saturation'])) { $natural_element_saturation = $_POST['natural_element_saturation']; } else { $natural_element_saturation = ''; }
		if(isset($_POST['natural_element_gamma'])) { $natural_element_gamma = $_POST['natural_element_gamma']; } else { $natural_element_gamma = ''; }
		if(isset($_POST['natural_element_lightness'])) { $natural_element_lightness = $_POST['natural_element_lightness']; } else { $natural_element_lightness_invert = ''; }
		if(isset($_POST['natural_element_lightness_invert'])) { $natural_element_lightness_invert = $_POST['natural_element_lightness_invert']; } else { $var = ''; }
		if(isset($_POST['water_element_visibility'])) { $water_element_visibility = $_POST['water_element_visibility']; } else { $water_element_visibility = ''; }
		if(isset($_POST['water_element_hue_status'])) { $water_element_hue_status = $_POST['water_element_hue_status']; } else { $water_element_hue_status = ''; }
		if(isset($_POST['water_element_hue'])) { $water_element_hue = $_POST['water_element_hue']; } else { $water_element_hue = ''; }
		if(isset($_POST['water_element_saturation'])) { $water_element_saturation = $_POST['water_element_saturation']; } else { $water_element_saturation = ''; }
		if(isset($_POST['water_element_gamma'])) { $water_element_gamma = $_POST['water_element_gamma']; } else { $water_element_gamma = ''; }
		if(isset($_POST['water_element_lightness'])) { $water_element_lightness = $_POST['water_element_lightness']; } else { $water_element_lightness = ''; }
		if(isset($_POST['water_element_lightness_invert'])) { $water_element_lightness_invert = $_POST['water_element_lightness_invert']; } else { $water_element_lightness_invert = ''; }
		if(isset($_POST['poi_visibility'])) { $poi_visibility = $_POST['poi_visibility']; } else { $poi_visibility = ''; }
		if(isset($_POST['poi_hue_status'])) { $poi_hue_status = $_POST['poi_hue_status']; } else { $poi_hue_status = ''; }
		if(isset($_POST['poi_hue'])) { $poi_hue = $_POST['poi_hue']; } else { $poi_hue = ''; }
		if(isset($_POST['poi_saturation'])) { $poi_saturation = $_POST['poi_saturation']; } else { $poi_saturation = ''; }
		if(isset($_POST['poi_gamma'])) { $poi_gamma = $_POST['poi_gamma']; } else { $poi_gamma = ''; }
		if(isset($_POST['poi_lightness'])) { $poi_lightness = $_POST['poi_lightness']; } else { $poi_lightness = ''; }
		if(isset($_POST['poi_lightness_invert'])) { $poi_lightness_invert = $_POST['poi_lightness_invert']; } else { $poi_lightness_invert = ''; }
		if(isset($_POST['road_local_element_label_visibility'])) { $road_local_element_label_visibility = $_POST['road_local_element_label_visibility']; } else { $road_local_element_label_visibility = ''; }
		if(isset($_POST['road_local_element_label_hue_status'])) { $road_local_element_label_hue_status = $_POST['road_local_element_label_hue_status']; } else { $road_local_element_label_hue_status = ''; }
		if(isset($_POST['road_local_element_label_hue'])) { $road_local_element_label_hue = $_POST['road_local_element_label_hue']; } else { $road_local_element_label_hue = ''; }
		if(isset($_POST['road_local_element_label_saturation'])) { $road_local_element_label_saturation = $_POST['road_local_element_label_saturation']; } else { $road_local_element_label_saturation = ''; }
		if(isset($_POST['road_local_element_label_gamma'])) { $road_local_element_label_gamma = $_POST['road_local_element_label_gamma']; } else { $road_local_element_label_gamma = ''; }
		if(isset($_POST['road_local_element_label_lightness'])) { $road_local_element_label_lightness = $_POST['road_local_element_label_lightness']; } else { $road_local_element_label_lightness = ''; }
		if(isset($_POST['road_local_element_label_lightness_invert'])) { $road_local_element_label_lightness_invert = $_POST['road_local_element_label_lightness_invert']; } else { $road_local_element_label_lightness_invert = ''; }
		if(isset($_POST['road_arterial_element_label_visibility'])) { $road_arterial_element_label_visibility = $_POST['road_arterial_element_label_visibility']; } else { $road_arterial_element_label_visibility = ''; }
		if(isset($_POST['road_arterial_element_label_hue_status'])) { $road_arterial_element_label_hue_status = $_POST['road_arterial_element_label_hue_status']; } else { $road_arterial_element_label_hue_status = ''; }
		if(isset($_POST['road_arterial_element_label_hue'])) { $road_arterial_element_label_hue = $_POST['road_arterial_element_label_hue']; } else { $road_arterial_element_label_hue = ''; }
		if(isset($_POST['road_arterial_element_label_saturation'])) { $road_arterial_element_label_saturation = $_POST['road_arterial_element_label_saturation']; } else { $road_arterial_element_label_saturation = ''; }
		if(isset($_POST['road_arterial_element_label_gamma'])) { $road_arterial_element_label_gamma = $_POST['road_arterial_element_label_gamma']; } else { $road_arterial_element_label_gamma = ''; }
		if(isset($_POST['road_arterial_element_label_lightness'])) { $road_arterial_element_label_lightness = $_POST['road_arterial_element_label_lightness']; } else { $road_arterial_element_label_lightness = ''; }
		if(isset($_POST['road_arterial_element_label_lightness_invert'])) { $road_arterial_element_label_lightness_invert = $_POST['road_arterial_element_label_lightness_invert']; } else { $road_arterial_element_label_lightness_invert = ''; }
		if(isset($_POST['road_highway_element_label_visibility'])) { $road_highway_element_label_visibility = $_POST['road_highway_element_label_visibility']; } else { $road_highway_element_label_visibility = ''; }
		if(isset($_POST['road_highway_element_label_hue_status'])) { $road_highway_element_label_hue_status = $_POST['road_highway_element_label_hue_status']; } else { $road_highway_element_label_hue_status = ''; }
		if(isset($_POST['road_highway_element_label_hue'])) { $road_highway_element_label_hue = $_POST['road_highway_element_label_hue']; } else { $road_highway_element_label_hue = ''; }
		if(isset($_POST['road_highway_element_label_saturation'])) { $road_highway_element_label_saturation = $_POST['road_highway_element_label_saturation']; } else { $road_highway_element_label_saturation = ''; }
		if(isset($_POST['road_highway_element_label_gamma'])) { $road_highway_element_label_gamma = $_POST['road_highway_element_label_gamma']; } else { $road_highway_element_label_gamma = ''; }
		if(isset($_POST['road_highway_element_label_lightness'])) { $road_highway_element_label_lightness = $_POST['road_highway_element_label_lightness']; } else { $road_highway_element_label_lightness = ''; }
		if(isset($_POST['road_highway_element_label_lightness_invert'])) { $road_highway_element_label_lightness_invert = $_POST['road_highway_element_label_lightness_invert']; } else { $road_highway_element_label_lightness_invert = ''; }
		if(isset($_POST['element_label_visibility'])) { $element_label_visibility = $_POST['element_label_visibility']; } else { $element_label_visibility = ''; }
		if(isset($_POST['element_label_hue_status'])) { $element_label_hue_status = $_POST['element_label_hue_status']; } else { $element_label_hue_status = ''; }
		if(isset($_POST['element_label_hue'])) { $element_label_hue = $_POST['element_label_hue']; } else { $element_label_hue = ''; }
		if(isset($_POST['element_label_saturation'])) { $element_label_saturation = $_POST['element_label_saturation']; } else { $element_label_saturation = ''; }
		if(isset($_POST['element_label_gamma'])) { $element_label_gamma = $_POST['element_label_gamma']; } else { $element_label_gamma = ''; }
		if(isset($_POST['element_label_lightness'])) { $element_label_lightness = $_POST['element_label_lightness']; } else { $element_label_lightness = ''; }
		if(isset($_POST['element_label_lightness_invert'])) { $element_label_lightness_invert = $_POST['element_label_lightness_invert']; } else { $element_label_lightness_invert = ''; }
		if(isset($_POST['natural_element_label_visibility'])) { $natural_element_label_visibility = $_POST['natural_element_label_visibility']; } else { $natural_element_label_visibility = ''; }
		if(isset($_POST['natural_element_label_hue_status'])) { $natural_element_label_hue_status = $_POST['natural_element_label_hue_status']; } else { $natural_element_label_hue_status = ''; }
		if(isset($_POST['natural_element_label_hue'])) { $natural_element_label_hue = $_POST['natural_element_label_hue']; } else { $natural_element_label_hue = ''; }
		if(isset($_POST['natural_element_label_saturation'])) { $natural_element_label_saturation = $_POST['natural_element_label_saturation']; } else { $natural_element_label_saturation = ''; }
		if(isset($_POST['natural_element_label_gamma'])) { $natural_element_label_gamma = $_POST['natural_element_label_gamma']; } else { $natural_element_label_gamma = ''; }
		if(isset($_POST['natural_element_label_lightness'])) { $natural_element_label_lightness = $_POST['natural_element_label_lightness']; } else { $natural_element_label_lightness = ''; }
		if(isset($_POST['natural_element_label_lightness_invert'])) { $natural_element_label_lightness_invert = $_POST['natural_element_label_lightness_invert']; } else { $natural_element_label_lightness_invert = ''; }
		if(isset($_POST['water_element_label_visibility'])) { $water_element_label_visibility = $_POST['water_element_label_visibility']; } else { $water_element_label_visibility = ''; }
		if(isset($_POST['water_element_label_hue_status'])) { $water_element_label_hue_status = $_POST['water_element_label_hue_status']; } else { $water_element_label_hue_status = ''; }
		if(isset($_POST['water_element_label_hue'])) { $water_element_label_hue = $_POST['water_element_label_hue']; } else { $water_element_label_hue = ''; }
		if(isset($_POST['water_element_label_saturation'])) { $water_element_label_saturation = $_POST['water_element_label_saturation']; } else { $water_element_label_saturation = ''; }
		if(isset($_POST['water_element_label_gamma'])) { $water_element_label_gamma = $_POST['water_element_label_gamma']; } else { $water_element_label_gamma = ''; }
		if(isset($_POST['water_element_label_lightness'])) { $water_element_label_lightness = $_POST['water_element_label_lightness']; } else { $water_element_label_lightness = ''; }
		if(isset($_POST['water_element_label_lightness_invert'])) { $water_element_label_lightness_invert = $_POST['water_element_label_lightness_invert']; } else { $water_element_label_lightness_invert = ''; }
		if(isset($_POST['poi_label_visibility'])) { $poi_label_visibility = $_POST['poi_label_visibility']; } else { $poi_label_visibility = ''; }
		if(isset($_POST['poi_label_hue_status'])) { $poi_label_hue_status = $_POST['poi_label_hue_status']; } else { $poi_label_hue_status = ''; }
		if(isset($_POST['poi_label_hue'])) { $poi_label_hue = $_POST['poi_label_hue']; } else { $poi_label_hue = ''; }
		if(isset($_POST['poi_label_saturation'])) { $poi_label_saturation = $_POST['poi_label_saturation']; } else { $poi_label_saturation = ''; }
		if(isset($_POST['poi_label_gamma'])) { $poi_label_gamma = $_POST['poi_label_gamma']; } else { $poi_label_gamma = ''; }
		if(isset($_POST['poi_label_lightness'])) { $poi_label_lightness = $_POST['poi_label_lightness']; } else { $poi_label_lightness = ''; }
		if(isset($_POST['poi_label_lightness_invert'])) { $poi_label_lightness_invert = $_POST['poi_label_lightness_invert']; } else { $poi_label_lightness_invert = ''; }
		if(isset($_POST['road_local_element_saturation_status_status'])) { $road_local_element_saturation_status = $_POST['road_local_element_saturation_status']; } else { $road_local_element_saturation_status = ''; }
		if(isset($_POST['road_local_element_gamma_status_status'])) { $road_local_element_gamma_status = $_POST['road_local_element_gamma_status']; } else { $road_local_element_gamma_status = ''; }
		if(isset($_POST['road_local_element_lightness_status'])) { $road_local_element_lightness_status = $_POST['road_local_element_lightness_status']; } else { $road_local_element_lightness_status = ''; }
		if(isset($_POST['road_arterial_element_saturation_status'])) { $road_arterial_element_saturation_status = $_POST['road_arterial_element_saturation_status']; } else { $road_arterial_element_saturation_status = ''; }
		if(isset($_POST['road_arterial_element_gamma_status'])) { $road_arterial_element_gamma_status = $_POST['road_arterial_element_gamma_status']; } else { $road_arterial_element_gamma_status = ''; }
		if(isset($_POST['road_arterial_element_lightness_status'])) { $road_arterial_element_lightness_status = $_POST['road_arterial_element_lightness_status']; } else { $road_arterial_element_lightness_status = ''; }
		if(isset($_POST['road_highway_element_saturation_status'])) { $road_highway_element_saturation_status = $_POST['road_highway_element_saturation_status']; } else { $road_highway_element_saturation_status = ''; }
		if(isset($_POST['road_highway_element_gamma_status'])) { $road_highway_element_gamma_status = $_POST['road_highway_element_gamma_status']; } else { $road_highway_element_gamma_status = ''; }
		if(isset($_POST['road_highway_element_lightness_status'])) { $road_highway_element_lightness_status = $_POST['road_highway_element_lightness_status']; } else { $road_highway_element_lightness_status = ''; }
		if(isset($_POST['element_saturation_status'])) { $element_saturation_status = $_POST['element_saturation_status']; } else { $element_saturation_status = ''; }
		if(isset($_POST['element_gamma_status'])) { $element_gamma_status = $_POST['element_gamma_status']; } else { $element_gamma_status = ''; }
		if(isset($_POST['element_lightness_status'])) { $element_lightness = $_POST['element_lightness']; } else { $element_lightness = ''; }
		if(isset($_POST['natural_element_saturation_status'])) { $natural_element_saturation_status = $_POST['natural_element_saturation_status']; } else { $natural_element_saturation_status = ''; }
		if(isset($_POST['natural_element_gamma_status'])) { $natural_element_gamma_status = $_POST['natural_element_gamma_status']; } else { $natural_element_gamma_status = ''; }
		if(isset($_POST['natural_element_lightness_status'])) { $natural_element_lightness_status = $_POST['natural_element_lightness_status']; } else { $natural_element_lightness_status = ''; }
		if(isset($_POST['water_element_saturation_status'])) { $water_element_saturation_status = $_POST['water_element_saturation_status']; } else { $water_element_saturation_status = ''; }
		if(isset($_POST['water_element_gamma_status'])) { $water_element_gamma_status = $_POST['water_element_gamma_status']; } else { $water_element_gamma_status = ''; }
		if(isset($_POST['water_element_lightness_status'])) { $water_element_lightness_status = $_POST['water_element_lightness_status']; } else { $water_element_lightness_status = ''; }
		if(isset($_POST['poi_saturation_status'])) { $poi_saturation_status = $_POST['poi_saturation_status']; } else { $poi_saturation_status = ''; }
		if(isset($_POST['poi_gamma_status'])) { $poi_gamma_status = $_POST['poi_gamma_status']; } else { $poi_gamma_status = ''; }
		if(isset($_POST['poi_lightness_status'])) { $poi_lightness_status = $_POST['poi_lightness_status']; } else { $poi_lightness_status = ''; }
		if(isset($_POST['road_local_element_label_saturation_status'])) { $road_local_element_label_saturation_status = $_POST['road_local_element_label_saturation_status']; } else { $road_local_element_label_saturation_status = ''; }
		if(isset($_POST['road_local_element_label_gamma_status'])) { $road_local_element_label_gamma_status = $_POST['road_local_element_label_gamma_status']; } else { $road_local_element_label_gamma_status = ''; }
		if(isset($_POST['road_local_element_label_lightness_status'])) { $road_local_element_label_lightness_status = $_POST['road_local_element_label_lightness_status']; } else { $road_local_element_label_lightness_status = ''; }
		if(isset($_POST['road_arterial_element_label_saturation_status'])) { $road_arterial_element_label_saturation_status = $_POST['road_arterial_element_label_saturation_status']; } else { $road_arterial_element_label_saturation_status = ''; }
		if(isset($_POST['road_arterial_element_label_gamma_status'])) { $road_arterial_element_label_gamma_status = $_POST['road_arterial_element_label_gamma_status']; } else { $road_arterial_element_label_gamma_status = ''; }
		if(isset($_POST['road_arterial_element_label_lightness_status'])) { $road_arterial_element_label_lightness_status = $_POST['road_arterial_element_label_lightness_status']; } else { $road_arterial_element_label_lightness_status = ''; }
		if(isset($_POST['road_highway_element_label_saturation_status'])) { $road_highway_element_label_saturation_status = $_POST['road_highway_element_label_saturation_status']; } else { $road_highway_element_label_saturation_status = ''; }
		if(isset($_POST['road_highway_element_label_gamma_status'])) { $road_highway_element_label_gamma_status = $_POST['road_highway_element_label_gamma_status']; } else { $road_highway_element_label_gamma_status = ''; }
		if(isset($_POST['road_highway_element_label_lightness_status'])) { $road_highway_element_label_lightness_status = $_POST['road_highway_element_label_lightness_status']; } else { $road_highway_element_label_lightness_status = ''; }
		if(isset($_POST['element_label_saturation_status'])) { $element_label_saturation_status = $_POST['element_label_saturation_status']; } else { $element_label_saturation_status = ''; }
		if(isset($_POST['element_label_gamma_status'])) { $element_label_gamma_status = $_POST['element_label_gamma_status']; } else { $element_label_gamma_status = ''; }
		if(isset($_POST['element_label_lightness_status'])) { $element_label_lightness_status = $_POST['element_label_lightness_status']; } else { $element_label_lightness_status = ''; }
		if(isset($_POST['natural_element_label_saturation_status'])) { $natural_element_label_saturation_status = $_POST['natural_element_label_saturation_status']; } else { $natural_element_label_saturation_status = ''; }
		if(isset($_POST['natural_element_label_gamma_status'])) { $natural_element_label_gamma_status = $_POST['natural_element_label_gamma_status']; } else { $natural_element_label_gamma_status = ''; }
		if(isset($_POST['natural_element_label_lightness_status'])) { $natural_element_label_lightness_status = $_POST['natural_element_label_lightness_status']; } else { $natural_element_label_lightness_status = ''; }
		if(isset($_POST['water_element_label_saturation_status'])) { $water_element_label_saturation_status = $_POST['water_element_label_saturation_status']; } else { $water_element_label_saturation_status = ''; }
		if(isset($_POST['water_element_label_gamma_status'])) { $water_element_label_gamma_status = $_POST['water_element_label_gamma_status']; } else { $water_element_label_gamma_status = ''; }
		if(isset($_POST['water_element_label_lightness_status'])) { $water_element_label_lightness_status = $_POST['water_element_label_lightness_status']; } else { $water_element_label_lightness_status = ''; }
		if(isset($_POST['poi_label_saturation_status'])) { $poi_label_saturation_status = $_POST['poi_label_saturation_status']; } else { $poi_label_saturation_status = ''; }
		if(isset($_POST['poi_label_gamma_status'])) { $poi_label_gamma_status = $_POST['poi_label_gamma_status']; } else { $poi_label_gamma_status = ''; }
		if(isset($_POST['poi_label_lightness_status'])) { $poi_label_lightness_status = $_POST['poi_label_lightness_status']; } else { $poi_label_lightness_status = ''; }
		if(isset($_POST['marker'])) { $marker = $_POST['marker']; } else { $marker = ''; }
		if(isset($_POST['marker_id'])) { $marker_id = $_POST['marker_id']; } else { $marker_id = ''; }
		if(isset($_POST['marker_entrance'])) { $marker_entrance = $_POST['marker_entrance']; } else { $marker_entrance = ''; }
		if(isset($_POST['marker_delay'])) { $marker_delay = $_POST['marker_delay']; } else { $marker_delay = ''; }
		if(isset($_POST['marker_scatter'])) { $marker_scatter = $_POST['marker_scatter']; } else { $marker_scatter = ''; }
		if(isset($_POST['marker_img'])) { $marker_img = $_POST['marker_img']; } else { $marker_img = ''; }
		if(isset($_POST['marker_img_width'])) { $marker_img_width = $_POST['marker_img_width']; } else { $marker_img_width = ''; }
		if(isset($_POST['marker_img_height'])) { $marker_img_height = $_POST['marker_img_height']; } else { $marker_img_height = ''; }
		if(isset($_POST['marker_img_x'])) { $marker_img_x = $_POST['marker_img_x']; } else { $marker_img_x = ''; }
		if(isset($_POST['marker_img_y'])) { $marker_img_y = $_POST['marker_img_y']; } else { $marker_img_y = ''; }
		if(isset($_POST['marker_img_point_x'])) { $marker_img_point_x = $_POST['marker_img_point_x']; } else { $marker_img_point_x = ''; }
		if(isset($_POST['marker_img_point_y'])) { $marker_img_point_y = $_POST['marker_img_point_y']; } else { $marker_img_point_y = ''; }
		if(isset($_POST['marker_shadow_img'])) { $marker_shadow_img = $_POST['marker_shadow_img']; } else { $marker_shadow_img = ''; }
		if(isset($_POST['marker_shadow_img_width'])) { $marker_shadow_img_width = $_POST['marker_shadow_img_width']; } else { $marker_shadow_img_width = ''; }
		if(isset($_POST['marker_shadow_img_height'])) { $marker_shadow_img_height = $_POST['marker_shadow_img_height']; } else { $marker_shadow_img_height = ''; }
		if(isset($_POST['marker_shadow_img_x'])) { $marker_shadow_img_x = $_POST['marker_shadow_img_x']; } else { $marker_shadow_img_x = ''; }
		if(isset($_POST['marker_shadow_img_y'])) { $marker_shadow_img_y = $_POST['marker_shadow_img_y']; } else { $marker_shadow_img_y = ''; }
		if(isset($_POST['marker_shadow_img_point_x'])) { $marker_shadow_img_point_x = $_POST['marker_shadow_img_point_x']; } else { $marker_shadow_img_point_x = ''; }
		if(isset($_POST['marker_shadow_img_point_y'])) { $marker_shadow_img_point_y = $_POST['marker_shadow_img_point_y']; } else { $marker_shadow_img_point_y = ''; }
		if(isset($_POST['streetview'])) { $streetview = $_POST['streetview']; } else { $streetview = ''; }

		if($latitude == null || $longitude == null || $latitude == '' || $longitude == ''){
			if(Plugin::isEnabled('clientdetails') == true){
				$clientaddress = str_replace('(Blue Horizons)','',clientdetails_address(true));
				$encoded_clientaddress = str_replace(' ','+',$clientaddress);
				$encoded_clientaddress = str_replace('++','+',$encoded_clientaddress);
				$encoded_clientaddress = str_replace('&','%26',$encoded_clientaddress);
				// Get co-ordinates from full address
				$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?sensor=false&address='.$encoded_clientaddress);
				$output = json_decode($geocode);
				if(is_object($output)){
					//echo 'Address Output: '.$output;
					//exit;
					$latitude = $output->results[0]->geometry->location->lat;
					$longitude = $output->results[0]->geometry->location->lng;
				} else {
					$postcode = clientdetails_postcode();
					$encoded_postcode = str_replace(' ','+',$postcode);
					// Get co-ordinates from postcode as fallback
					$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?sensor=false&address='.$encoded_postcode);
					$output = json_decode($geocode);

					//echo 'Postcode Output: <pre>'.print_r($output).'</pre>';
					//exit;

					if(is_object($output)){
						$latitude = $output->result[0]->geometry->location->lat;
						$longitude = $output->result[0]->geometry->location->lng;
					}
				}
			}
		} else {
			//$latitude = '';
			//$longitude = '';
		}
		if($marker_img != '' || $marker_shadow_img != ''){
			$marker_img_icon = 'marker.png';
			$marker_shadow_img_icon = 'shadow.png';

			/*
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
			*/

			if($marker_img != ''){
				if (file_exists($_SERVER{'DOCUMENT_ROOT'}.'/public/images/'.$marker_img_icon)) {
					$marker_path = '/public/images/';
					$marker_img = $marker_path.$marker_img_icon;
					$marker_path = $_SERVER{'DOCUMENT_ROOT'}.$marker_path;
				} else {
					$marker_path = '/wolf/plugins/googlemap/images/';
					$marker_img = $marker_path.$marker_img_icon;
					$marker_path = $_SERVER{'DOCUMENT_ROOT'}.$marker_path;
				}
			}
			if($marker_shadow_img != ''){
				if (file_exists($_SERVER{'DOCUMENT_ROOT'}.'/public/images/'.$marker_shadow_img_icon)) {
					$marker_path = '/public/images/';
					$marker_shadow_img = $marker_path.$marker_shadow_img_icon;
					$marker_path = $_SERVER{'DOCUMENT_ROOT'}.$marker_path;
				} else {
					$marker_path = '/wolf/plugins/googlemap/images/';
					$marker_shadow_img = $marker_path.$marker_shadow_img_icon;
					$marker_path = $_SERVER{'DOCUMENT_ROOT'}.$marker_path;
				}
			}

			if($marker_img != ''){
				if(((!empty($marker_img)) && $marker_img_width == '' && $marker_img_height == '') && file_exists($marker_path.$marker_img_icon)){
					list($marker_img_width, $marker_img_height) = getimagesize($marker_path.$marker_img_icon);
					if($marker_img_x == '') 				$marker_img_x = '0';
					if($marker_img_y == '') 				$marker_img_y = '0';
					if($marker_img_point_x == '') 			$marker_img_point_x = '0';
					if($marker_img_point_y == '') 			$marker_img_point_y = '32';
				}
			}
			if($marker_shadow_img != ''){
				if(((!empty($marker_shadow_img)) && $marker_shadow_img_width == '' && $marker_shadow_img_height == '') && file_exists($marker_path.$marker_shadow_img_icon)){
					list($marker_shadow_img_width, $marker_shadow_img_height) = getimagesize($marker_path.$marker_shadow_img_icon);
					if($marker_shadow_img_x == '') 			$marker_shadow_img_x = '0';
					if($marker_shadow_img_y == '') 			$marker_shadow_img_y = '0';
					if($marker_shadow_img_point_x == '') 	$marker_shadow_img_point_x = '0';
					if($marker_shadow_img_point_y == '') 	$marker_shadow_img_point_y = '32';
				}
			}
		} else {
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
		}

		$settings = array(	'version' => GMAP_VERSION,
						'sensor' => $sensor,
						'infowindow' => $infowindow,
						'directions' => $directions,
						'autodisplay' => $autodisplay,
						'viewport_width' => $viewport_width,
						'viewport_scale' => $viewport_scale,
						'viewport_zoom' => $viewport_zoom,
						'latitude' => $latitude,
						'longitude' => $longitude,
						'zoom' => $zoom,
						'zoom_control' => $zoom_control,
						'navigation_control' => $navigation_control,
						'map_id' => $map_id,
						'map_width' => $map_width,
						'map_height' => $map_height,
						'map_code' => $map_code,
						'map_ui' => $map_ui,
						'map_type' => $map_type,
						'map_control' => $map_control,
						'map_libraries' => $map_libraries,
						'map_styling' => $map_styling,
						'road_local_element_visibility' => $road_local_element_visibility,
						'road_local_element_hue_status' => $road_local_element_hue_status,
						'road_local_element_hue' => $road_local_element_hue,
						'road_local_element_saturation' => $road_local_element_saturation,
						'road_local_element_gamma' => $road_local_element_gamma,
						'road_local_element_lightness' => $road_local_element_lightness,
						'road_local_element_lightness_invert' => $road_local_element_lightness_invert,
						'road_arterial_element_visibility' => $road_arterial_element_visibility,
						'road_arterial_element_hue_status' => $road_arterial_element_hue_status,
						'road_arterial_element_hue' => $road_arterial_element_hue,
						'road_arterial_element_saturation' => $road_arterial_element_saturation,
						'road_arterial_element_gamma' => $road_arterial_element_gamma,
						'road_arterial_element_lightness' => $road_arterial_element_lightness,
						'road_arterial_element_lightness_invert' => $road_arterial_element_lightness_invert,
						'road_highway_element_visibility' => $road_highway_element_visibility,
						'road_highway_element_hue_status' => $road_highway_element_hue_status,
						'road_highway_element_hue' => $road_highway_element_hue,
						'road_highway_element_saturation' => $road_highway_element_saturation,
						'road_highway_element_gamma' => $road_highway_element_gamma,
						'road_highway_element_lightness' => $road_highway_element_lightness,
						'road_highway_element_lightness_invert' => $road_highway_element_lightness_invert,
						'element_visibility' => $element_visibility,
						'element_hue_status' => $element_hue_status,
						'element_hue' => $element_hue,
						'element_saturation' => $element_saturation,
						'element_gamma' => $element_gamma,
						'element_lightness' => $element_lightness,
						'element_lightness_invert' => $element_lightness_invert,
						'natural_element_visibility' => $natural_element_visibility,
						'natural_element_hue_status' => $natural_element_hue_status,
						'natural_element_hue' => $natural_element_hue,
						'natural_element_saturation' => $natural_element_saturation,
						'natural_element_gamma' => $natural_element_gamma,
						'natural_element_lightness' => $natural_element_lightness,
						'natural_element_lightness_invert' => $natural_element_lightness_invert,
						'water_element_visibility' => $water_element_visibility,
						'water_element_hue_status' => $water_element_hue_status,
						'water_element_hue' => $water_element_hue,
						'water_element_saturation' => $water_element_saturation,
						'water_element_gamma' => $water_element_gamma,
						'water_element_lightness' => $water_element_lightness,
						'water_element_lightness_invert' => $water_element_lightness_invert,
						'poi_visibility' => $poi_visibility,
						'poi_hue_status' => $poi_hue_status,
						'poi_hue' => $poi_hue,
						'poi_saturation' => $poi_saturation,
						'poi_gamma' => $poi_gamma,
						'poi_lightness' => $poi_lightness,
						'poi_lightness_invert' => $poi_lightness_invert,
						'road_local_element_label_visibility' => $road_local_element_label_visibility,
						'road_local_element_label_hue_status' => $road_local_element_label_hue_status,
						'road_local_element_label_hue' => $road_local_element_label_hue,
						'road_local_element_label_saturation' => $road_local_element_label_saturation,
						'road_local_element_label_gamma' => $road_local_element_label_gamma,
						'road_local_element_label_lightness' => $road_local_element_label_lightness,
						'road_local_element_label_lightness_invert' => $road_local_element_label_lightness_invert,
						'road_arterial_element_label_visibility' => $road_arterial_element_label_visibility,
						'road_arterial_element_label_hue_status' => $road_arterial_element_label_hue_status,
						'road_arterial_element_label_hue' => $road_arterial_element_label_hue,
						'road_arterial_element_label_saturation' => $road_arterial_element_label_saturation,
						'road_arterial_element_label_gamma' => $road_arterial_element_label_gamma,
						'road_arterial_element_label_lightness' => $road_arterial_element_label_lightness,
						'road_arterial_element_label_lightness_invert' => $road_arterial_element_label_lightness_invert,
						'road_highway_element_label_visibility' => $road_highway_element_label_visibility,
						'road_highway_element_label_hue_status' => $road_highway_element_label_hue_status,
						'road_highway_element_label_hue' => $road_highway_element_label_hue,
						'road_highway_element_label_saturation' => $road_highway_element_label_saturation,
						'road_highway_element_label_gamma' => $road_highway_element_label_gamma,
						'road_highway_element_label_lightness' => $road_highway_element_label_lightness,
						'road_highway_element_label_lightness_invert' => $road_highway_element_label_lightness_invert,
						'element_label_visibility' => $element_label_visibility,
						'element_label_hue_status' => $element_label_hue_status,
						'element_label_hue' => $element_label_hue,
						'element_label_saturation' => $element_label_saturation,
						'element_label_gamma' => $element_label_gamma,
						'element_label_lightness' => $element_label_lightness,
						'element_label_lightness_invert' => $element_label_lightness_invert,
						'natural_element_label_visibility' => $natural_element_label_visibility,
						'natural_element_label_hue_status' => $natural_element_label_hue_status,
						'natural_element_label_hue' => $natural_element_label_hue,
						'natural_element_label_saturation' => $natural_element_label_saturation,
						'natural_element_label_gamma' => $natural_element_label_gamma,
						'natural_element_label_lightness' => $natural_element_label_lightness,
						'natural_element_label_lightness_invert' => $natural_element_label_lightness_invert,
						'water_element_label_visibility' => $water_element_label_visibility,
						'water_element_label_hue_status' => $water_element_label_hue_status,
						'water_element_label_hue' => $water_element_label_hue,
						'water_element_label_saturation' => $water_element_label_saturation,
						'water_element_label_gamma' => $water_element_label_gamma,
						'water_element_label_lightness' => $water_element_label_lightness,
						'water_element_label_lightness_invert' => $water_element_label_lightness_invert,
						'poi_label_visibility' => $poi_label_visibility,
						'poi_label_hue_status' => $poi_label_hue_status,
						'poi_label_hue' => $poi_label_hue,
						'poi_label_saturation' => $poi_label_saturation,
						'poi_label_gamma' => $poi_label_gamma,
						'poi_label_lightness' => $poi_label_lightness,
						'poi_label_lightness_invert' => $poi_label_lightness_invert,
						'road_local_element_saturation_status_status' => $road_local_element_saturation_status,
						'road_local_element_gamma_status_status' => $road_local_element_gamma_status,
						'road_local_element_lightness_status' => $road_local_element_lightness_status,
						'road_arterial_element_saturation_status' => $road_arterial_element_saturation_status,
						'road_arterial_element_gamma_status' => $road_arterial_element_gamma_status,
						'road_arterial_element_lightness_status' => $road_arterial_element_lightness_status,
						'road_highway_element_saturation_status' => $road_highway_element_saturation_status,
						'road_highway_element_gamma_status' => $road_highway_element_gamma_status,
						'road_highway_element_lightness_status' => $road_highway_element_lightness_status,
						'element_saturation_status' => $element_saturation_status,
						'element_gamma_status' => $element_gamma_status,
						'element_lightness_status' => $element_lightness,
						'natural_element_saturation_status' => $natural_element_saturation_status,
						'natural_element_gamma_status' => $natural_element_gamma_status,
						'natural_element_lightness_status' => $natural_element_lightness_status,
						'water_element_saturation_status' => $water_element_saturation_status,
						'water_element_gamma_status' => $water_element_gamma_status,
						'water_element_lightness_status' => $water_element_lightness_status,
						'poi_saturation_status' => $poi_saturation_status,
						'poi_gamma_status' => $poi_gamma_status,
						'poi_lightness_status' => $poi_lightness_status,
						'road_local_element_label_saturation_status' => $road_local_element_label_saturation_status,
						'road_local_element_label_gamma_status' => $road_local_element_label_gamma_status,
						'road_local_element_label_lightness_status' => $road_local_element_label_lightness_status,
						'road_arterial_element_label_saturation_status' => $road_arterial_element_label_saturation_status,
						'road_arterial_element_label_gamma_status' => $road_arterial_element_label_gamma_status,
						'road_arterial_element_label_lightness_status' => $road_arterial_element_label_lightness_status,
						'road_highway_element_label_saturation_status' => $road_highway_element_label_saturation_status,
						'road_highway_element_label_gamma_status' => $road_highway_element_label_gamma_status,
						'road_highway_element_label_lightness_status' => $road_highway_element_label_lightness_status,
						'element_label_saturation_status' => $element_label_saturation_status,
						'element_label_gamma_status' => $element_label_gamma_status,
						'element_label_lightness_status' => $element_label_lightness_status,
						'natural_element_label_saturation_status' => $natural_element_label_saturation_status,
						'natural_element_label_gamma_status' => $natural_element_label_gamma_status,
						'natural_element_label_lightness_status' => $natural_element_label_lightness_status,
						'water_element_label_saturation_status' => $water_element_label_saturation_status,
						'water_element_label_gamma_status' => $water_element_label_gamma_status,
						'water_element_label_lightness_status' => $water_element_label_lightness_status,
						'poi_label_saturation_status' => $poi_label_saturation_status,
						'poi_label_gamma_status' => $poi_label_gamma_status,
						'poi_label_lightness_status' => $poi_label_lightness_status,
						'marker' => $marker,
						'marker_id' => $marker_id,
						'marker_entrance' => $marker_entrance,
						'marker_delay' => $marker_delay,
						'marker_scatter' => $marker_scatter,
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
						'marker_shadow_img_point_y' => $marker_shadow_img_point_y,
						'streetview' => $streetview
						);




			if (Plugin::setAllSettings($settings, 'googlemap'))
				Flash::set('success', 'Google Map - '.__('plugin settings saved: Lat: '.$latitude.' Long: '.$longitude));
			else
				Flash::set('error', 'Google Map - '.__('plugin settings not saved!'));
   
			if(function_exists('funky_cache_delete_all')){
				funky_cache_delete_all();
			}
			redirect(get_url('plugin/googlemap/settings'));
		//}
	}

}