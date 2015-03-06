<?php
$map_id = Plugin::getSetting('map_id', 'googlemap');
$map_width = Plugin::getSetting('map_width', 'googlemap');
$map_height = Plugin::getSetting('map_height', 'googlemap');

$staticmap_width = $map_width;
$staticmap_height = $map_height;
$style_prefix = '';

// Check if static map needs to be generated at actual size (px)
if(stristr($map_width,'px') && stristr($map_height,'px')){

	$staticmap_width = preg_replace("/[^0-9]/","",$map_width);
	$staticmap_height = preg_replace("/[^0-9]/","",$map_height);

	// Reduce size to Google maximum
	if($map_width > 640 || $map_height > 640){

		$imageWidth = $staticmap_width;
		$imageHeight = $staticmap_height;
		$ar = $imageWidth / $imageHeight;

	    $staticmap_width = '100%';
	    $staticmap_height = floor($map_height / 2).'px';

	}
}




$overlay_map = false; // Default is false
// Check if javascrpt map overlaps static map, or replaces it
if($overlay_map == true){
	$staticmap_width = '100%';
	$staticmap_height = '100%';
	$style_prefix = ".js #googlemap-print{display:block;}";
	// TO DO: Add support for googlemap id to be contained in wrapper, so js googlemap overlay can fill container 100%
}




?>
<script>
document.write('<style type=\"text/css\" /><?php echo $style_prefix; ?>#<?php echo $map_id; ?>{width:<?php echo $staticmap_width; ?>;height:<?php echo $staticmap_height; ?>;}</style>');
</script>