<?php
$map_id = Plugin::getSetting('map_id', 'googlemap');
$map_width = Plugin::getSetting('map_width', 'googlemap');
$map_height = Plugin::getSetting('map_height', 'googlemap');
$map_link = Plugin::getSetting('map_link', 'googlemap');
$overlay_map = false; // Default is false

$style = '';
$staticmap_width = $map_width;
$staticmap_height = $map_height;

// Check if static map needs to be generated at actual size (px)
if(stristr($map_width,'px') && stristr($map_height,'px')){
	$overlay_map = true;

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




// Check if javascrpt map overlaps static map, or replaces it
if($overlay_map == true){
	$staticmap_width = '100%';
	$staticmap_height = '100%';
	$style = ".js #googlemap-print{display:block;}#".$map_id."{position:relative;overflow:hidden;}#".$map_id."_overlay{position:absolute;top:0;left:0;width:100%;height:100%;}";
	// TO DO: Add support for googlemap id to be contained in wrapper, so js googlemap overlay can fill container 100%
} else {
	$style = '#'.$map_id.'{width:'.$staticmap_width.';height:'.$staticmap_height.';}';
}




?>

<?php if(!isset($map_link) || (isset($map_link) && $map_link == '') || (isset($map_link) && !isset($_GET['mobile'])) || defined('CMS_BACKEND')){ ?>
<?php if(Plugin::isEnabled('mobile_check')){
$screenwidth = Plugin::getSetting('screen_width', 'mobile_check');
} ?>
<script>
<?php if($screenwidth){ ?>
//var d = document.documentElement;
if(d.clientWidth><?php echo $screenwidth; ?> || d.clientHeight><?php echo $screenwidth; ?>){
<?php }?>
document.write('<style type=\"text/css\" /><?php echo $style; ?></style>');
<?php if($screenwidth){ ?>
}
<?php }?>
</script>
<?php } ?>