<?php


	$markerLat = $latitude;
	$markerLong = $longitude;

	if(isset($draggable) && $draggable == 'true'){
		$draggable = 'true';
	} else {
		$draggable = 'false';
	}
	



	#Build viewport
	$viewport = array();
	if($viewport_width != '') array_push($viewport, 'width='.$viewport_width);
	if($viewport_scale != '') array_push($viewport, 'initial-scale='.$viewport_scale);
	if($viewport_zoom != '') array_push($viewport, 'maximum-scale='.$viewport_zoom);
	$viewport = implode(',',$viewport);

	#Libraries (ie; places)
	$map_libraries = '';
	if($map_libraries != '') $map_libraries = '&map_libraries='.$map_libraries;

	#Markers (id,lat,long,icon,iconWidth,iconHeight,iconX,iconY,iconPointX,iconPointY,shadow,shadowWidth,shadowHeight,shadowX,shadowY,shadowPointX,shadowPointY)
	$markers = array(	array($marker_id, $markerLat, $markerLong, $marker_img, $marker_img_width, $marker_img_height, $marker_img_x, $marker_img_y, $marker_img_point_x, $marker_img_point_y, $marker_shadow_img, $marker_shadow_img_width, $marker_shadow_img_height, $marker_shadow_img_x, $marker_shadow_img_y, $marker_shadow_img_point_x, $marker_shadow_img_point_y));
	//$markers = array(	array('default','52.517683','13.447179','googlemapflag.png','20','32','0','0','0','32','googlemapflag_shadow.png','37','32','0','0','0','32'));
	//$markers = array(	array('default','52.511467','13.394393','googlemapflag.png','20','32','0','0','0','32','googlemapflag_shadow.png','37','32','0','0','0','32'), array('geo','52.517683','13.447179','googlemapflag.png','20','32','0','0','0','32','googlemapflag_shadow.png','37','32','0','0','0','32'));
	$markerCount = count($markers);

	//print_r ($markers);
	//exit;

	if(isset($marker) && $marker != 'false'){
		if(isset($marker_position) && $marker_position == '') $marker_position = 'myLatLong';
		if(isset($marker_tooltip) && $marker_tooltip != '') $marker_tooltip = ",\r\t\t".'title: "'.$marker_tooltip.'"';
	}

	if(isset($marker_entrance) && $marker_entrance != ''){
		$draggable = $draggable;
		if(isset($marker_entrance) && $marker_entrance != '') $marker_entrance = ",\r\t\t".'animation: google.maps.Animation.'.$marker_entrance;
	}
	



$api_params = '';
$api_params .= '?sensor='.$sensor;
$api_params .= $map_libraries;
if(isset($api_version)) $api_params .= '&amp;v='.$api_version;
if(isset($region)) $api_params .= '&amp;region='.$region;

?>

<script src="http://maps.googleapis.com/maps/api/js<?php echo $api_params; ?>"></script>
<script>
<?php if(isset($marker) && $marker != 'false'){ ?>
var markers = [];
var iterator = 0;
<?php } ?>
/* Enable new look */
google.maps.visualRefresh = true;
var map;


<?php if(isset($marker) && $marker != 'false'){ ?>
var mapmarkers = [<?php
$missingshadow = false;
for ($row = 0; $row < $markerCount; $row++) {
	for ($col = 0; $col < count($markers[$row][$col]); $col++) {
	  $id = $markers[$row][0];
	  $lat = $markers[$row][1];
	  $long = $markers[$row][2];
	  $icon = $markers[$row][3];
	  $iconWidth = $markers[$row][4];
	  $iconHeight = $markers[$row][5];
	  $iconX = $markers[$row][6]; if($row == 0 && $markers[0][1] == '') $iconX = $latitude; #Set first icon latitude to map latitude, if not specified
	  $iconY = $markers[$row][7]; if($row == 0 && $markers[0][2] == '') $iconY = $longitude; #Set first icon longitude to map longitude, if not specified
	  $iconPointX = $markers[$row][8];
	  $iconPointY = $markers[$row][9];
	  $shadow = $markers[$row][10];
	  $shadowWidth = $markers[$row][11];
	  $shadowHeight = $markers[$row][12];
	  $shadowX = $markers[$row][13];
	  $shadowY = $markers[$row][14];
	  $shadowPointX = $markers[$row][15];
	  $shadowPointY = $markers[$row][16];
	  if($shadow == '') $missingshadow = true;
	}
?>[<?php echo '"'.$id.'", "'.$lat.'", "'.$long.'", "'.$icon.'", "'.$iconWidth.'", "'.$iconHeight.'", "'.$iconX.'", "'.$iconY.'", "'.$iconPointX.'", "'.$iconPointY.'", "'.$shadow.'", "'.$shadowWidth.'", "'.$shadowHeight.'", "'.$shadowX.'", "'.$shadowY.'", "'.$shadowPointX.'", "'.$shadowPointY.'"'; ?>]<?php if($row < $markerCount && $markerCount != 1){ echo ", "; }
}?>];





var maplocations = [<?php
for ($row = 0; $row < $markerCount; $row++) {
	for ($col = 0; $col < count($markers[$row][$col]); $col++) {
	}
	?>new google.maps.LatLng(<?php echo $markers[$row][1]; ?>, <?php echo $markers[$row][2]; ?>)<?php if($row < $markerCount && $markerCount != 1) echo ", ";
}
?>];
<?php } ?>




function initialize() {
<?php if($map_styling == 'StyledMapType'){ ?>

	var setstyle = [
	<?php
		$features = array();


/*** Graphics ***/

		if($road_local_element_visibility != 'off'){
		$style = '';
		if($road_local_element_hue == 'on') 				$style .= '{ hue: "'.$road_local_element_hue.'" },'."\n			";
		if($road_local_element_saturation == 'on') 			$style .= '{ saturation: '.$road_local_element_saturation.' },'."\n			";
		if($road_local_element_lightness == 'on') 			$style .= '{ lightness: '.$road_local_element_lightness.' },'."\n			";
		if($road_local_element_gamma == 'on') 				$style .= '{ gamma: '.$road_local_element_gamma.' },';
		$features[] = '{ featureType: "road.local",
			elementType: "geometry",
			stylers: [
			'.$style.'
			{ visibility: "'.$road_local_element_visibility.'" }
			] }';
		} else {
			$features[] = "\t".'{ featureType: "road.local",
				elementType: "geometry",
				stylers: [
				{ visibility: "off" }
				] }';
			}
		if($road_arterial_element_visibility != 'off'){
		$style = '';
		if($road_arterial_element_hue == 'on') 				$style .= '{ hue: "'.$road_arterial_element_hue.'" },'."\n			";
		if($road_arterial_element_saturation == 'on') 		$style .= '{ saturation: '.$road_arterial_element_saturation.' },'."\n			";
		if($road_arterial_element_lightness == 'on') 		$style .= '{ lightness: '.$road_arterial_element_lightness.' },'."\n			";
		if($road_local_element_hue == 'on')			 	$style .= '{ gamma: '.$road_arterial_element_gamma.' },';
		$features[] = "\t".'{ featureType: "road.arterial",
			elementType: "geometry",
			stylers: [ 
			'.$style.'
			{ visibility: "'.$road_arterial_element_visibility.'" }
			] }';
		} else {
			$features[] = "\t".'{ featureType: "road.arterial",
				elementType: "geometry",
				stylers: [
				{ visibility: "off" }
				] }';
			}
		if($road_highway_element_visibility != 'off'){
		$style = '';
		if($road_highway_element_hue == 'on')				$style .= '{ hue: "'.$road_highway_element_hue.'" },'."\n			";
		if($road_highway_element_saturation == 'on')		$style .= '{ saturation: '.$road_highway_element_saturation.' },'."\n			";
		if($road_highway_element_lightness == 'on')			$style .= '{ lightness: '.$road_highway_element_lightness.' },'."\n			";
		if($road_highway_element_gamma == 'on')				$style .= '{ gamma: '.$road_highway_element_gamma.' },';
		$features[] = "\t".'{ featureType: "road.highway",
			elementType: "geometry",
			stylers: [
			'.$style.'
			{ visibility: "'.$road_highway_element_visibility.'" }
			] }';
		} else {
			$features[] = "\t".'{ featureType: "road.highway",
				elementType: "geometry",
				stylers: [
				{ visibility: "off" }
				] }';
			}
		if($element_visibility != 'off'){
		$style = '';
		if($element_hue == 'on') 							$style .= '{ hue: "'.$element_hue.'" },'."\n			";
		if($element_saturation == 'on') 					$style .= '{ saturation: '.$element_saturation.' },'."\n			";
		if($element_lightness == 'on') 						$style .= '{ lightness: '.$element_lightness.' },'."\n			";
		if($element_gamma == 'on') 							$style .= '{ gamma: '.$element_gamma.' },';
		$features[] = "\t".'{ featureType: "landscape.man_made",
			elementType: "geometry",
			stylers: [ 
			'.$style.'
			{ visibility: "'.$element_visibility.'" }
			] }';
		} else {
			$features[] = "\t".'{ featureType: "landscape.man_made",
				elementType: "geometry",
				stylers: [
				{ visibility: "off" }
				] }';
			}
		if($natural_element_visibility != 'off'){
		$style = '';
		if($natural_element_hue == 'on')					$style .= '{ hue: "'.$natural_element_hue.'" },'."\n			";
		if($natural_element_saturation == 'on')				$style .= '{ saturation: '.$natural_element_saturation.' },'."\n			";
		if($natural_element_lightness == 'on')				$style .= '{ lightness: '.$natural_element_lightness.' },'."\n			";
		if($natural_element_gamma == 'on')					$style .= '{ gamma: '.$natural_element_gamma.' },';
		$features[] = "\t".'{ featureType: "landscape.natural",
			elementType: "geometry",
			stylers: [
			'.$style.'
			{ visibility: "'.$natural_element_visibility.'" }
			] }';
		} else {
			$features[] = "\t".'{ featureType: "landscape.natural",
				elementType: "geometry",
				stylers: [
				{ visibility: "off" }
				] }';
			}
		if($water_element_visibility != 'off'){
		$style = '';
		if($water_element_hue == 'on')						$style .= '{ hue: "'.$water_element_hue.'" },'."\n			";
		if($water_element_saturation == 'on')				$style .= '{ saturation: '.$water_element_saturation.' },'."\n			";
		if($water_element_lightness == 'on')				$style .= '{ lightness: '.$water_element_lightness.' },'."\n			";
		if($water_element_gamma == 'on')					$style .= '{ gamma: '.$water_element_gamma.' },';
		$features[] = "\t".'{ featureType: "water",
			elementType: "geometry",
			stylers: [
			'.$style.'
			{ visibility: "'.$water_element_visibility.'" }
			] }';
		} else {
			$features[] = "\t".'{ featureType: "water",
				elementType: "geometry",
				stylers: [
				{ visibility: "off" }
				] }';
			}
		if($poi_visibility != 'off'){
		$style = '';
		if($poi_hue == 'on')								$style .= '{ hue: "'.$poi_hue.'" },'."\n			";
		if($poi_saturation == 'on')							$style .= '{ saturation: '.$poi_saturation.' },'."\n			";
		if($poi_lightness == 'on')							$style .= '{ lightness: '.$poi_lightness.' },'."\n			";
		if($poi_gamma == 'on')								$style .= '{ gamma: '.$poi_gamma.' },';
		$features[] = "\t".'{ featureType: "poi",
			elementType: "geometry",
			stylers: [
			'.$style.'
			{ visibility: "'.$poi_visibility.'" }
			] }';
		} else {
			$features[] = "\t".'{ featureType: "poi",
				elementType: "geometry",
				stylers: [
				{ visibility: "off" }
				] }';
			}


/*** Labels ***/

		if($road_local_element_label_visibility != 'off'){
		$style = '';
		if($road_local_element_label_hue == 'on')			$style .= '{ hue: "'.$road_local_element_label_hue.'" },'."\n			";
		if($road_local_element_label_saturation == 'on')	$style .= '{ saturation: '.$road_local_element_label_saturation.' },'."\n			";
		if($road_local_element_label_lightness == 'on')		$style .= '{ lightness: '.$road_local_element_label_lightness.' },'."\n			";
		if($road_local_element_label_gamma == 'on')			$style .= '{ gamma: '.$road_local_element_label_gamma.' },';
		$features[] = "\t".'{ featureType: "road.local",
			elementType: "labels",
			stylers: [
			'.$style.'
			{ visibility: "'.$road_local_element_label_visibility.'" }
			] }';
		} else {
			$features[] = "\t".'{ featureType: "road.local",
				elementType: "labels",
				stylers: [
				{ visibility: "off" }
				] }';
			}
		if($road_arterial_element_label_visibility != 'off'){
		$style = '';
		if($road_arterial_element_label_hue == 'on')		$style .= '{ hue: "'.$road_arterial_element_label_hue.'" },'."\n			";
		if($road_arterial_element_label_saturation == 'on')	$style .= '{ saturation: '.$road_arterial_element_label_saturation.' },'."\n			";
		if($road_arterial_element_label_lightness == 'on')	$style .= '{ lightness: '.$road_arterial_element_label_lightness.' },'."\n			";
		if($road_arterial_element_label_gamma == 'on')		$style .= '{ gamma: '.$road_arterial_element_label_gamma.' },';
		$features[] = "\t".'{ featureType: "road.arterial",
			elementType: "labels",
			stylers: [ 
			'.$style.'
			{ visibility: "'.$road_arterial_element_label_visibility.'" }
			] }';
		} else {
			$features[] = "\t".'{ featureType: "road.arterial",
				elementType: "labels",
				stylers: [
				{ visibility: "off" }
				] }';
			}
		if($road_highway_element_label_visibility != 'off'){
		$style = '';
		if($road_highway_element_label_hue == 'on')			$style .= '{ hue: "'.$road_highway_element_label_hue.'" },'."\n			";
		if($road_highway_element_label_saturation == 'on')	$style .= '{ saturation: '.$road_highway_element_label_saturation.' },'."\n			";
		if($road_highway_element_label_lightness == 'on')	$style .= '{ lightness: '.$road_highway_element_label_lightness.' },'."\n			";
		if($road_highway_element_label_gamma == 'on')		$style .= '{ gamma: '.$road_highway_element_label_gamma.' },';
		$features[] = "\t".'{ featureType: "road.highway",
			elementType: "labels",
			stylers: [
			'.$style.'
			{ visibility: "'.$road_highway_element_label_visibility.'" }
			] }';
		} else {
			$features[] = "\t".'{ featureType: "road.highway",
				elementType: "labels",
				stylers: [
				{ visibility: "off" }
				] }';
			}
		if($element_label_visibility != 'off'){
		$style = '';
		if($element_label_hue == 'on')						$style .= '{ hue: "'.$element_label_hue.'" },'."\n			";
		if($element_label_saturation == 'on')				$style .= '{ saturation: '.$element_label_saturation.' },'."\n			";
		if($element_label_lightness == 'on')				$style .= '{ lightness: '.$element_label_lightness.' },'."\n			";
		if($element_label_gamma == 'on')					$style .= '{ gamma: '.$element_label_gamma.' },';
		$features[] = "\t".'{ featureType: "landscape.man_made",
			elementType: "labels",
			stylers: [
			'.$style.'
			{ visibility: "'.$element_label_visibility.'" }
			] }';
		} else {
			$features[] = "\t".'{ featureType: "landscape.man_made",
				elementType: "labels",
				stylers: [
				{ visibility: "off" }
				] }';
			}
		if($natural_element_label_visibility != 'off'){
		$style = '';
		if($natural_element_label_hue == 'on')				$style .= '{ hue: "'.$natural_element_label_hue.'" },'."\n			";
		if($natural_element_label_saturation == 'on')		$style .= '{ saturation: '.$natural_element_label_saturation.' },'."\n			";
		if($natural_element_label_lightness == 'on')		$style .= '{ lightness: '.$natural_element_label_lightness.' },'."\n			";
		if($natural_element_label_gamma == 'on')			$style .= '{ gamma: '.$natural_element_label_gamma.' },';
		$features[] = "\t".'{ featureType: "landscape.natural",
			elementType: "labels",
			stylers: [ 
			'.$style.'
			{ visibility: "'.$natural_element_label_visibility.'" }
			] }';
		} else {
			$features[] = "\t".'{ featureType: "landscape.natural",
				elementType: "labels",
				stylers: [
				{ visibility: "off" }
				] }';
			}
		if($water_element_label_visibility != 'off'){
		$style = '';
		if($water_element_label_hue == 'on')				$style .= '{ hue: "'.$water_element_label_hue.'" },'."\n			";
		if($water_element_label_saturation == 'on')			$style .= '{ saturation: '.$water_element_label_saturation.' },'."\n			";
		if($water_element_label_lightness == 'on')			$style .= '{ lightness: '.$water_element_label_lightness.' },'."\n			";
		if($water_element_label_gamma == 'on')				$style .= '{ gamma: '.$water_element_label_gamma.' },';
		$features[] = "\t".'{ featureType: "water",
			elementType: "labels",
			stylers: [
			'.$style.'
			{ visibility: "'.$water_element_label_visibility.'" }
			] }';
		} else {
			$features[] = "\t".'{ featureType: "water",
				elementType: "labels",
				stylers: [
				{ visibility: "off" }
				] }';
			}
		if($poi_label_visibility != 'off'){
		$style = '';
		if($poi_label_hue == 'on')							$style .= '{ hue: "'.$poi_label_hue.'" },'."\n			";
		if($poi_label_saturation == 'on')					$style .= '{ saturation: '.$poi_label_saturation.' },'."\n			";
		if($poi_label_lightness == 'on')					$style .= '{ lightness: '.$poi_label_lightness.' },'."\n			";
		if($poi_label_gamma == 'on')						$style .= '{ gamma: '.$poi_label_gamma.' },';
		$features[] = "\t".'{ featureType: "poi",
			elementType: "labels",
			stylers: [
			'.$style.'
			{ visibility: "'.$poi_label_visibility.'" }
			] }';
		} else {
			$features[] = "\t".'{ featureType: "poi",
				elementType: "labels",
				stylers: [
				{ visibility: "off" }
				] }';
			}
		$featurelist = implode(",\r", $features);
		echo $featurelist; ?>
	];
	<?php } ?>
	
	var mapOptions = {
		zoom: <?php echo $zoom; ?>,
		<?php if($streetview == 'FALSE' && !defined('CMS_BACKEND')){ /* Disable streetview pegman icon */ ?>
		streetViewControl: false,
		<?php } ?>
		<?php if($map_styling != 'StyledMapType'){ ?>
		mapTypeId: google.maps.MapTypeId.<?php echo $map_type; ?>,
		<?php /* Placeholder background color backgroundColor: "#ffffff", */ ?>
		<?php } ?>
		center: new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo $longitude; ?>)<?php if($navigation_control != 'DEFAULT' && $map_ui != 'true'){ ?>,
		navigation_controlControlOptions: {style: google.maps.NavigationControlStyle.<?php echo $navigation_control; ?>}
		<?php } ?><?php if($zoom_control != 'DEFAULT' && $map_ui != 'true' && $map_styling != 'StyledMapType'){ ?>,
		zoomControlOptions: {style: google.maps.ZoomControlStyle.<?php echo $zoom_control; ?>}<?php } ?><?php if($map_control == 'false' && $map_styling != 'StyledMapType'){ ?>,
		mapTypeControl: false<?php } ?><?php if($map_ui == 'true'){ ?>,
		scaleControl: false, /* Disable map scale element */
		disableDefaultUI: true<?php } ?><?php if($map_styling == 'StyledMapType'){ ?>,
	<?php if (!defined('CMS_BACKEND')) {
	if($zoom_control == 'FALSE'){ /* Disable zoom + and - options */
	?>
		zoomControl: false,
	<?php }
	if($navigation_control == 'FALSE'){ /* Disable navigation/pan - Not working yet */
	?>
		navigationControl: false,
		panControl: false,

	<?php }
	} ?>
		mapTypeControlOptions: { mapTypeIds: [google.maps.MapTypeId.<?php echo $map_type; ?>, 'styleMap'] },
		mapTypeId: 'styleMap'
		<?php } ?>
	
	};
	
	map = new google.maps.Map(document.getElementById("<?php echo $map_id; ?>"), mapOptions);
	<?php if($map_styling == 'StyledMapType'){ ?>;
	var map_styling = new google.maps.StyledMapType(setstyle, {name: "Custom"});
	map.mapTypes.set('styleMap', map_styling);
	<?php } ?>

	clearTimeout(0);

	<?php
	if (!defined('CMS_BACKEND')) {
	if(Plugin::isEnabled('seobox') == true && Plugin::getSetting('clientanalyticsstatus', 'seobox') == true && Plugin::getSetting('clientanalyticslinks', 'seobox') == 'on' && function_exists('analyticsPush')){ echo "\r";?>
	/* Track Google Maps - Push or debug */
	function trackmap(category,action){
		if(action == 'Zoomed'){
			var getzoom = map.getZoom();
			var setzoom = <?php echo $zoom; ?>;
			if(getzoom > setzoom){ action = 'Zoomed In'; }
			if(getzoom < setzoom){ action = 'Zoomed Out'; }
		}
		<?php
		/* Push or debug */
		if(DEBUG == true){
			echo "alert('Category: '  + \"\\t\" + category + \"\\n\" + 'Action:		' + action);"."\n";
			//echo "alert(category + ', ' + action);";
			//echo analyticsPush(false, '_trackEvent', category, action, 'thisRef', '0', 'true');
		} else {
		?>
		pageTracker._trackEvent(
			category,
			action
		);
		<?php } ?>
	};
	
	google.maps.event.addListener(map, 'click', function(){trackmap('Google Map','Clicked');});
	google.maps.event.addListener(map, 'dragend', function(){trackmap('Google Map','Dragged');});
	google.maps.event.addListener(map, 'zoom_changed', function(){trackmap('Google Map','Zoomed');});
	google.maps.event.addListener(map, 'maptypeid_changed', function(){var maptype = map.getMapTypeId(); trackmap('Google Map',maptype[0].toUpperCase() + maptype.substring(1) + ' Type');});
	google.maps.event.addListener(map.getStreetView(), 'visible_changed', function(){if(this.getVisible() == true){trackmap('Google Map','Streetview');}});

	<?php
	}
	}?>
	google.maps.event.addDomListener(window, 'resize', function(){ var center = map.getCenter(); google.maps.event.trigger(map, 'resize'); map.setCenter(center); });

	<?php if($marker != 'false'){ ?>drop();<?php } ?>

}

<?php if(count($markers) > 0 && $marker != 'false'){ ?>

function drop() {
	for (var i = 0; i < maplocations.length; i++) {
	setTimeout(function(){
	  addMarker(maplocations.length)
	}, <?php echo $marker_delay; ?>000 + (i * <?php echo $marker_scatter; ?> + 1000))
	}
}

function addMarker(lastid) {
	var image = new google.maps.MarkerImage( mapmarkers[iterator][3],
		<?php // This marker is 20 pixels wide by 32 pixels tall. ?>
		new google.maps.Size(mapmarkers[iterator][4], mapmarkers[iterator][5]),
		<?php // The origin for this image is 0,0. ?>
		new google.maps.Point(mapmarkers[iterator][6],mapmarkers[iterator][7]),
		<?php // The anchor for this image is the base of the flagpole at 0,32. ?>
		new google.maps.Point(mapmarkers[iterator][8], mapmarkers[iterator][9]));
	var shadow = new google.maps.MarkerImage(mapmarkers[iterator][10],
		  <?php // The shadow image is larger in the horizontal dimension ?>
		<?php // while the position and offset are the same as for the main image. ?>
		new google.maps.Size(mapmarkers[iterator][11], mapmarkers[iterator][12]),
		new google.maps.Point(mapmarkers[iterator][13],mapmarkers[iterator][14]),
		new google.maps.Point(mapmarkers[iterator][15], mapmarkers[iterator][16]));

	var marker = new google.maps.Marker({
		position: maplocations[iterator],
		map: map,
		<?php if(isset($marker) && $marker == 'true'){ ?><?php if($missingshadow != true){ ?>shadow: shadow,<?php } ?>
		icon: image,<?php } ?>
		draggable: <?php echo $draggable; ?>
		<?php echo $marker_entrance; ?>
	});

	<?php if($draggable == 'true') {; ?>

	google.maps.event.addListener(marker, 'dragend', function(event){
		var point = event.latLng;
		var lat = point.lat().toFixed(5);
		var lng = point.lng().toFixed(5);
		document.getElementById("alatitude").value = lat;
		document.getElementById("alongitude").value = lng;
		map.setCenter(marker.position);
	});
	
	google.maps.event.addListener(marker, 'dragstart', function(event){
		var point = event.latLng;
		var lat = point.lat().toFixed(5);
		var lng = point.lng().toFixed(5);
		document.getElementById("alatitude").value = lat;
		document.getElementById("alongitude").value = lng;
	});

	<?php } ?>



	markers.push(marker);
	iterator++
}

<?php } ?>

function getUserLocation() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var pos = new google.maps.LatLng(position.coords.latitude,
			position.coords.longitude);
			map.panTo(pos);
			marker.setPosition(pos);
			marker.setMap(map);
		}, function() {
			<?php // Can find the users location ?>
			<?php // Cheat for the talk ?>
			marker.setPosition(new google.maps.LatLng(14.597466, 121.0092));
			marker.setMap(map);
		})
	} else {
	  marker.setPosition(new google.maps.LatLng(14.597466, 121.0092));
	  marker.setMap(map);
	}
}

window.addEventListener ?
window.addEventListener("load",runScripts,false) :
window.attachEvent && window.attachEvent("onload",runScripts);

function runScripts(){
	initialize();
	setTimeout("initialize()", 500);
}
</script>

<?php
/* Generate static map for PDF output */
/* Perhaps also check to make sure there is no screen width query in screen.css or that explicit width and height is set (not percentage) */
//if(isset($_GET['media']) && $_GET['media'] == 'pdf'){
	

if(!defined('CMS_BACKEND')){
	$staticmap_scale = 2;
	$staticmap_pixels = false;

	if($staticmap_scale != 2){ $staticmap_scale = 1; }

	$map_width = Plugin::getSetting('map_width', 'googlemap');
	$map_height = Plugin::getSetting('map_height', 'googlemap');
	$map_width = str_replace('px','',$map_width);
	$map_height = str_replace('px','',$map_height);
	$zoom = Plugin::getSetting('zoom', 'googlemap');

	// Check if static map needs to be generated at actual size (px)
	$staticmap_width = preg_replace("/[^0-9]/","",$map_width);
	$staticmap_height = preg_replace("/[^0-9]/","",$map_height);
	if(!stristr($map_width,'%') && !stristr($map_height,'%')){
		$staticmap_pixels = true;

		// Reduce size to Google maximum
		if($map_width > 640 || $map_height > 640){

			$imageWidth = $staticmap_width;
			$imageHeight = $staticmap_height;
			$ar = $imageWidth / $imageHeight;
			
			$zoom = ($zoom - 1);
			
			if ($ar < 1) { // "tall" crop
			    $staticmap_height = 640;
			    $staticmap_width = floor($staticmap_height / $ar);
			}
			else { // "wide" or square crop
			    $staticmap_width = 640;
			    $staticmap_height = floor($staticmap_width / $ar);
			}

		}
	}

	// Set reasonable dimensions for PDF page
	if(stristr($map_width,'%')){
	
		// Set defaults to A4 portrait
		$map_width = '670'; $map_height = '370';
		$staticmap_width = $map_width;
		$staticmap_height = $map_height;

		// Check for PDF dimension settings
		$pdf_size = ''; $pdf_orientation = '';
		if(Plugin::getSetting('pdf_size', 'page_options')) $pdf_size = Plugin::getSetting('pdf_size', 'page_options');
		if(Plugin::getSetting('pdf_orientation', 'page_options')) $pdf_orientation = Plugin::getSetting('pdf_orientation', 'page_options');

		if($pdf_size == 'A5' && $pdf_orientation == 'P'){
			$map_width = '310'; $map_height = '210';
		}
	
	}

	if($icon != '' && !stristr(URL_ABSOLUTE,'.local') && $marker == 'true'){
	//if($icon != '' && $marker == 'true'){
		if(!stristr($icon,'//')){
			$icon = URL_ABSOLUTE.ltrim($icon,'/');
		}
		// Live site: relative marker
		$marker = '&markers=icon:'.$icon.'|'.$latitude.','.$longitude;
	} else {
		// Test site: absolute marker
		$marker = '&markers=icon:http://maps.gstatic.com/mapfiles/markers2/marker.png|'.$latitude.','.$longitude;
		//$marker = '&maptype=roadmap';
	}
	?>
	<img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $latitude; ?>,<?php echo $longitude; ?><?php echo $marker; ?>&zoom=<?php echo $zoom; ?>&size=<?php echo $staticmap_width; ?>x<?php echo $staticmap_height; ?>&scale=<?php echo $staticmap_scale; ?>&sensor=false" id="googlemap-print" />
<?php } ?>