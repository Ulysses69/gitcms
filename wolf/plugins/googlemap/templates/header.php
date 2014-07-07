<?php
$map_id = Plugin::getSetting('map_id', 'googlemap');
$map_width = Plugin::getSetting('map_width', 'googlemap');
$map_height = Plugin::getSetting('map_height', 'googlemap');
?>
<script>
document.write('<style type=\"text/css\" />#<?php echo $map_id; ?>{width:<?php echo $map_width; ?>;height:<?php echo $map_height; ?>;}</style>');
</script>