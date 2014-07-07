<?php

/* Ensure plugin update is enabled ONLY when new version */
if (GMAP_VERSION > Plugin::getSetting('version', 'googlemap')){
define('GMAP_INCLUDE',1);
include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/googlemap/enable.php";
}

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


//if($latitude == null || $longitude == null){
	if(Plugin::isEnabled('clientdetails') == true){
		if(Plugin::getSetting('clientaddress_county', 'clientdetails')){
			$address = ''; $spacer = "";
			$clientname = Plugin::getSetting('clientname', 'clientdetails');
			$clientaddress_building = Plugin::getSetting('clientaddress_building', 'clientdetails');
			$clientaddress_street = Plugin::getSetting('clientaddress_street', 'clientdetails');
			$clientaddress_locality = Plugin::getSetting('clientaddress_locality', 'clientdetails');
			$clientaddress_town = Plugin::getSetting('clientaddress_town', 'clientdetails');
			$clientaddress_county = Plugin::getSetting('clientaddress_county', 'clientdetails');
			$clientaddress_postcode = Plugin::getSetting('clientaddress_postcode', 'clientdetails');
			//if($clientaddress_building != '') $address .= $clientaddress_building;
			//if($address != ''){ $spacer = " \n"; } if($clientaddress_street != '') $address .= $spacer.$clientaddress_street;
			//if($address != ''){ $spacer = " \n"; } if($clientaddress_locality != '') $address .= $spacer.$clientaddress_locality;
			//if($address != ''){ $spacer = " \n"; } if($clientaddress_town != '') $address .= $spacer.$clientaddress_town;
			//if($address != ''){ $spacer = " \n"; } if($clientaddress_county != '') $address .= $spacer.$clientaddress_county;
			//if($address != ''){ $spacer = " \n"; } if($clientaddress_postcode != '') $address .= $spacer.$clientaddress_postcode;
			$clientaddress = str_replace('(Blue Horizons)','',clientdetails_address(true));
			//$clientaddress = $clientname.' '.$clientaddress;
			$encoded_clientaddress = str_replace(' ','+',$clientaddress);
			$encoded_clientaddress = str_replace('++','+',$encoded_clientaddress);
			$encoded_clientaddress = str_replace('&','%26',$encoded_clientaddress);
			$googleurl = rtrim('http://maps.google.co.uk/maps?q='.$encoded_clientaddress,"+");
		} else {
			$address = str_replace('(Blue Horizons)','',Plugin::getSetting('clientaddress', 'clientdetails'));
			$clientname = Plugin::getSetting('clientname', 'clientdetails');
			//$address = $clientname.' '.$address;
			$encoded_clientaddress = str_replace(' ','+',$address);
			$encoded_clientaddress = str_replace('++','+',$encoded_clientaddress);
			$encoded_clientaddress = str_replace('&','%26',$encoded_clientaddress);
			$googleurl = rtrim('http://maps.google.co.uk/maps?q='.$encoded_clientaddress,"+");
		}

		$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$encoded_clientaddress.'&sensor=false');
		$output = json_decode($geocode);

		/*
		if(is_object($output)){
			if($latitude == null || $longitude == null){
				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;
			}
		}
		*/

		if($latitude == null || $longitude == null || $latitude == '' || $longitude == ''){
			if(is_object($output)){
				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;
			} else {
				$county = clientdetails_county();
				$postcode = clientdetails_postcode();
				$encoded_county = str_replace(' ','+',$county);
				$encoded_postcode = str_replace(' ','+',$postcode);
				$address = $encoded_county.'+'.$encoded_postcode;
				
				$googleurl = rtrim('http://maps.google.co.uk/maps?q='.$address,"+");
	
				// Get co-ordinates from postcode as fallback
				$url = 'http://maps.google.com/maps/api/geocode/json?sensor=false&address='.$address;
				$geocode = file_get_contents($url);
	
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				$response = curl_exec($ch);
				curl_close($ch);
				$response_a = json_decode($response);
				$lat = $response_a->results[0]->geometry->location->lat;
				$long = $response_a->results[0]->geometry->location->lng;
				$latitude = $lat;
				$longitude = $long;
	
			}
		}

	}

//}
?>

<!--
<p class="button"><a href="<?php echo get_url('plugin/googlemap/documentation'); ?>"><img src="<?php echo URL_PUBLIC; ?>frog/plugins/googlemap/images/documentation.png" align="middle" /><?php echo __('Documentation'); ?></a></p>
<p class="button"><a href="<?php echo get_url('plugin/googlemap/settings'); ?>"><img src="<?php echo URL_PUBLIC; ?>frog/plugins/googlemap/images/settings.png" align="middle" /><?php echo __('Settings'); ?></a></p>
-->

<div class="box">
<!-- <p>Google Maps API: v2</p><br/>
<p>The Google Map plugin lets you embed Google Maps in your own web pages.</p><br/> -->

<?php //if($apikey != ''){ ?>
<br/>

<script type="text/javascript">
//<![CDATA[
document.write('<style type=\"text/css\" />#<?php echo $map_id; ?>{width:100%;height:100%;background-color:#fff;#map_canvas{background-color:#fff !important}#map_canvas div div div div div div img{visibility:hidden}}}</style>');
//]]>
</script>

<div id="testmap">
<?php $draggable = 'true'; ?>
<?php include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/googlemap/templates/footer.php"; ?>

<?php ob_start();
//include $_SERVER{'DOCUMENT_ROOT'}.URL_PUBLIC."wolf/plugins/googlemap/templates/footer.php";
//$footer = ob_get_contents();
//ob_end_clean();
//$footer = strtr($footer, array("\t\t" => "", "\t" => "", "\n" => "", "\r" => ""));
//echo $footer; ?>

<?php //displayGoogleMap(); ?>
<div id="<?php echo $map_id; ?>"></div>
</div>

<br />
<a href="<?php echo $googleurl; ?>" target="_blank"><small>Large map</small></a>

<br />
<br />
<?php //} ?>


<h2>Tip</h2>
<p>Drag the flag for precision placement (don't forget to press 'save' at the end of the page).</p>

<?php if(!AuthUser::hasPermission('client')) { ?>
<br/>

<h2>Setup</h2>
<ol style="margin:10px 0 0 20px;font-size:80%">
<!--
<li>Sign up for a <a href="http://code.google.com/apis/maps/signup.html" target="_blank">Google Maps API key</a> using your <a href="http://mail.google.com/mail/signup" target="_blank">Google Account</a> (required).</li>
<li>Enter your API Key in the appropriate field to the left <a href="<?php echo $_SERVER['REQUEST_URI']; ?>#apikey" title="help">?</a></li>
<li>Enter your desired map width and height (pixel dimensions required) <a href="<?php echo $_SERVER['REQUEST_URI']; ?>#amap_width" title="help">?</a>.</li>
-->
<li>Set your latitude, longitude and other settings to your requirements.</li>
<li>Press 'Save' to keep your Google Map Plugin settings.</li>
<li>To insert your Google map on a page, simply copy/paste the following code: &lt;&#63;php displayGoogleMap();&#63;&gt;</li>
</ol>
<br/>

<h2>Configure</h2>
<p>To use <a href="<?php echo URL_PUBLIC.ADMIN_DIR; ?>/plugin/clientdetails">client address</a> rather than enter latitude and longitude manually, leave latitude and longitude empty then save this page to auto-generate a latitude and longitude.</p>
<br/>

<h2>Further reading</h2>
<!--API Key now deprecated -->
<!-- <p>For local development and testing, either a http&#58;&#47;&#47;localhost or http&#58;&#47;&#47;127.0.0.1 API Key has been provided by default.</p> -->
<p>The Google Map Plugin uses the Map Code <a href="<?php echo $_SERVER['REQUEST_URI']; ?>#amap_code" title="help">?</a> to generate the map placeholder. The Map Code requires at least one html element with an ID attribute and valid value which also needs to be declared in the Map ID <a href="<?php echo $_SERVER['REQUEST_URI']; ?>#amap_id" title="help">?</a> field. By default, a working example is provided to best illustrate this.</p>
<?php } ?>


</div>