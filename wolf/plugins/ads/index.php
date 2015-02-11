<?php

if (!defined('ADS_VERSION')) { define('ADS_VERSION', '0.1.0'); }
Plugin::setInfos(array(
	'id'		  	=> 'ads',
	'title'	   		=> 'Ads',
	'description' 	=> 'Adverts and Call to action boxes',
	'version'		=> ADS_VERSION
));

Behavior::add('Ads', '');

/* Check if this plugin is enabled */
if(Plugin::isEnabled('ads')){
	if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
		AutoLoader::addFolder(dirname(__FILE__) . '/models');
		AuthUser::load();
		Plugin::addController('ads', 'Ads', 'administrator', true);
	}
}

Observer::observe('view_page_edit_tabs', 'ads_page_edit');


if(!function_exists('ad')){
	function ad($parent){
		$pagead_sql = 'SELECT ad FROM '.TABLE_PREFIX.'page WHERE id='.$parent->id;
		$pagead_q = Record::getConnection()->query($pagead_sql);
		$pagead_f = $pagead_q->fetchAll(PDO::FETCH_OBJ);
		foreach ($pagead_f as $pagead){
			$pageadid = $pagead->ad;
			$ad_sql = 'SELECT * FROM '.TABLE_PREFIX.'ads_boxes WHERE id='.$pageadid;
			$ad_q = Record::getConnection()->query($ad_sql);
			if($ad_q){
				$ad_f = $ad_q->fetchAll(PDO::FETCH_OBJ);
				foreach ($ad_f as $ad){
					$showurl = false;
					$id = $ad->id;
					$label = $ad->boxlabel;
					$content = $ad->boxcontent;
					$url = $ad->boxlinkurl;
					$status = $ad->boxstatus;
					$open = ''; $close = '';
					if($status != ''){
						echo '<div class="ad" id="ad'.$id.'">'."\n";
						if($url != '' && !stristr($content,'</a>')){ $showurl = true; }
						if($showurl == true){ echo '<a href="'.$url.'">'; }
						echo "<span>".$content."</span>";
						if($showurl == true){ echo '</a>'; }
						echo "\n</div>\n";
					}
				}
			}
		}
	}
}

if(!function_exists('ads_page_edit')){
function ads_page_edit($page) {
	
	/* Get adverts */
	$adverts = array();
	$ads_sql = "SELECT * FROM ".TABLE_PREFIX."ads_boxes ORDER BY boxlabel";
	$ads_q = Record::getConnection()->query($ads_sql);
	$ads_f = $ads_q->fetchAll(PDO::FETCH_OBJ);
	foreach ($ads_f as $ads) {
		$label = stripslashes($ads->boxlabel);
		$id = stripslashes($ads->id);
		//array_push($adverts,$label);
		$adverts[$label] = $id;
	}


	global $__CMS_CONN__;
	$sql = 'SELECT ad FROM '.TABLE_PREFIX.'page WHERE id=?';
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	while ($ads = $stmt->fetchObject()) {
		$pageadid = $ads->ad;
	}
	?>

<div id="ads-container" title="Ad">

<?php if(!isset($page->id)){ ?>
<p>Please save this page before setting ad.</p>
<?php } else { ?>
<?php if($adverts){ ?>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
<p>Advert or Call to action</p>
<ul>
<li><label for="ad0"><input <?php if ($pageadid == '') echo 'checked="checked"'; ?> type="radio" id="ad0" name="page[ad]" value="" /><span>None</span></label></li>
<?php 
$i = 0; 
//foreach ($adverts as $ad_label) {
foreach ($adverts as $label => $id) {
	//echo '<li>' . $ad . '</li>';
	?><li><label for="ad<?php echo $id; ?>"><input <?php if ($pageadid == $id) echo 'checked="checked"'; ?> type="radio" id="ad<?php echo $id; ?>" name="page[ad]" value="<?php echo $id; ?>" /><span><?php echo $label; $i++ ?></span></label></li><?php
} ?>
</ul>
<br />
<p><a href="/<?php echo ADMIN_DIR; ?>/plugin/ads">View ads</a></p>
</td>
</tr>
</table>
<?php } else { ?>
<p>There are no ads. <a href="/<?php echo ADMIN_DIR; ?>/plugin/ads">Create ad</a></p>
<?php } ?>
<?php } ?>

</div>

<?php }}