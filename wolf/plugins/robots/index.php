<?php

Plugin::setInfos(array(
				'id' 			=> 'robots',
				'title' 		=> __('Redirect/Robots'),
				'description'	=> __('Add page redirect and meta data for search engines.')
));

/***
# Set following pages to nofollow/noindex:
search.html
notfound.html



# Set following pages to follow/noindex:
copyright.html
accessibility.html
terms.html
privacy.html



# Add following to Printfriendly layout:
<?php //robots($this); ?>
<meta name="robots" content="noindex" />



# Check for excluded pages
if(!function_exists('robotsindex')){
	function robotsindex($page,$returnstatus) {
		# Keep disabled robots plugin references from throwing errors
		if(Plugin::isEnabled('robots') == true){
			robotsindex($page,$returnstatus);
		}
	}
}

# Google XML sitemap
if(!function_exists('xmlsitemap')){
//  NEVER: Old news stories, press releases, etc.
//  YEARLY: Contact, “About Us”, login, registration pages.
//  MONTHLY: FAQs, instructions, occasionally updated articles.
//  WEEKLY: Product info pages, website directories.
//  DAILY: Blog entry index, classifieds, small message board.
//  HOURLY: Major news site, weather information, forum.
//  ALWAYS: Stock market data, social bookmarking categories.
	function xmlsitemap($parent){
		function snippet_xml_sitemap($parent) {
			$out = '';
			// $childs = $parent->children(); # Don't include hidden pages
			$childs = $parent->children(null, array(), true);
			if (count($childs) > 0) {
				foreach ($childs as $child) {
					if(!isExcludedPage($child->slug)){
						if($child->getLoginNeeded() == Page::LOGIN_REQUIRED) continue;
						if($child->parent->behavior_id=="archive") $child->url = trim($child->parent->url . date('/Y/m/d/', strtotime($child->created_on)). $child->slug, '/');
						if($child->content('redirect') == null && !stristr(robots($child,'return'),'noindex')){
							$out .= "  <url>\n";
							$childlink = $child->url.URL_SUFFIX;
							if($childlink[0] == '/'){
								$childlink = substr($childlink, 1);
							}
							$out .= "   <loc>".URL_ABSOLUTE.$childlink."</loc>\n";
							$out .= "   <lastmod>".$child->date('%Y-%m-%d', 'updated')."</lastmod>\n";
							$out .= "   <changefreq>".($child->hasContent('changefreq') ? $child->content('changefreq'): 'weekly')."</changefreq>\n";
							$out .= "  </url>\n";
						}
						$out .= snippet_xml_sitemap($child);
					}
				}
			}
			return $out;
		}
		echo '<?'; ?>xml version="1.0" encoding="UTF-8" <?php echo '?>';
		echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		echo snippet_xml_sitemap($parent->find('/'));
		echo '</urlset>';
	}
}
	
# Mobile XML sitemap
if(!function_exists('xmlmobilesitemap')){
	function xmlmobilesitemap($parent){
		function snippet_xml_mobilesitemap($parent) {
			$out = '';
			// $childs = $parent->children(); #  Don't include hidden pages
			$childs = $parent->children(null, array(), true);
			if (count($childs) > 0) {
				foreach ($childs as $child) {
					if(!isExcludedPage($child->slug)){
						if($child->getLoginNeeded() == Page::LOGIN_REQUIRED) continue;
						if($child->parent->behavior_id=="archive") $child->url = trim($child->parent->url . date('/Y/m/d/', strtotime($child->created_on)). $child->slug, '/');
						if($child->content('redirect') == null && !stristr(robots($child,'return'),'noindex')){
						$out .= "  <url>";
						$childlink = $child->url.URL_SUFFIX;
						if($childlink[0] == '/'){
							$childlink = substr($childlink, 1);
						}
						$out .= "   <loc>".URL_ABSOLUTE.'mobile/'.$childlink."</loc>\n";
	 					$out .= "   <lastmod>".$child->date('%Y-%m-%d', 'updated')."</lastmod>";
						$out .= "   <mobile:mobile/>\n";
						$out .= "  </url>\n";
						}
						$out .= snippet_xml_mobilesitemap($child);
					}
				}
			}
			return $out;
		}
		echo '<?'; ?>xml version="1.0" encoding="UTF-8" <?php echo '?>';
		echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">';
		echo snippet_xml_mobilesitemap($parent->find('/'));
		echo '</urlset>';
	}
}
***/

Observer::observe('view_page_edit_tabs', 'robots_page_edit');

function robots_page_edit($page) {
	$redirect = '';
	$canonical = '';
	global $__CMS_CONN__;
	$sql = 'SELECT robots , redirect, canonical FROM '.TABLE_PREFIX.'page WHERE id=?';
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	while ($robotsindex = $stmt->fetchObject()) {
		$robots = $robotsindex->robots;
		$redirect = $robotsindex->redirect;
		$canonical = $robotsindex->canonical;
	}
 	?>

<div id="robots-container" title="Actions">

<?php if(!isset($page->id)){ ?>
<p>Please save this page before setting actions.</p>
<?php } else { ?>

<table cellpadding="0" cellspacing="0" border="0">

<tr>
<td class="label"><label for="page_redirectindex" title="Actual page or file to point to (on this website or other)">Point to URI</label></td>
<td class="field">
<input name="page[redirect]" title="Actual page or file to point to (on this website or other)" id="page_redirectindex" type="text" value="<?php echo $redirect;?>" />
</td>
</tr>

<tr>
<td class="label"><label for="page_canonicalindex" title="Original page or file to point to (usually same as redirect URI)">Canonical URI</label></td>
<td class="field">
<input name="page[canonical]" title="Original page or file to point to (usually same as redirect URI)" id="page_canonicalindex" type="text" value="<?php echo $canonical;?>" />
</td>
</tr>

<tr>
<td class="label"><label for="page_robotsindex" title="Tell search engines what to do when they find this page">Robots</label></td>
<td class="field">
<select name="page[robots]" id="page_robotsindex" title="Tell search engines what to do when they find this page">
<?php
if ($robots == NULL){
	$robots = 'follow,index';
}
$url_array = array(
array ("Follow links and index page", 'follow,index'),
array ("Don't follow links or index page", 'nofollow,noindex'),
array ("Follow links but don't index page", 'follow,noindex'),
array ("Index page but don't follow links", 'nofollow,index'),
array ("Prevent cache preview", 'noarchive'));
foreach($url_array as $subarray) {
	list($text, $val) = $subarray;
	if($val == $robots){
		echo "<option value=\"$val\" selected>$text</option>";
	} else {
		echo "<option value=\"$val\">$text</option>";
	}
}
?>
</select>
</td>
</tr>
</table>
<div class="notes">
<h2>Notes</h2>
<p>Don't index this page if another page is already being indexed for the same content/keyword/phrase.</p>
<p>Don't follow this page if another page is better deserving of link rank or if this page is predominantly offsite links.</p>
<p>Think of each page as unique content per keyword/phrase.</p>
</div>

<!-- Under Development -->
<?php if(Plugin::isEnabled('redirector') == true){ ?>
<a class="redirectcheck" href="/<?php echo ADMIN_DIR; ?>/plugin/redirector">Check redirects</a>
<?php } ?>

<?php } ?>

</div>
<?php }

Observer::observe('page_edit_after_save', 'robots_index_save');
function robots_index_save($page){
	global $__CMS_CONN__;
	$robots = $page->robots;
	$canonical = $page->canonical;
	$redirect = $page->redirect;
	if($canonical != NULL && ($robots == NULL || $robots == 'follow,index' || $robots == 'nofollow,index')){
		$robots = 'nofollow,noindex';
	}
	$sql = "UPDATE ".TABLE_PREFIX."page SET robots = '".$robots."' , canonical = '".$canonical."' , redirect = '".$redirect."' WHERE id=?";
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));

	if(function_exists('funky_cache_delete_all')){
		funky_cache_delete_all();
	}
	//$__CMS_CONN__->exec($sql)
}
function robotsindex($id){
	global $__CMS_CONN__;
	$sql = "SELECT robots , index FROM ".TABLE_PREFIX."page WHERE id = ?";
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($id));
	$obj = $stmt->fetchObject();
	$robotsindex = $obj->robots;
	$redirectindex = $obj->redirect;
	$canonicalindex = $obj->canonical;
	$pageindex = $obj->index;
	if (empty($robotsindex)) {
	 	return $pageindex;
	} else {
	 	return $robotsindex;
	}
}
function robots($page,$returnstatus='echo'){
	global $__CMS_CONN__;
	$robotdata = '';
	$sql = 'SELECT robots , redirect , canonical FROM '.TABLE_PREFIX.'page WHERE id=?';
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	while ($robotsindex = $stmt->fetchObject()) {
		$robots = $robotsindex->robots;
		$redirect = $robotsindex->redirect;
		$canonical = $robotsindex->canonical;
	}

	if($robots != 'follow,index'){
		if ($robots != 'nofollow,noindex' || $robots == 'follow,noindex'){
			$robotdata .= '<meta name="robots" content="'.$robots.'">'."\r";
		}
		if($canonical != NULL){
			$robotdata .= '<link rel="canonical" href="'.$canonical.'">'."\r";
		}
	}	

	if(isset($_GET['media']) && $_GET['media'] == 'standard'){
		if( Plugin::isEnabled('mobile_check') == true && Plugin::getSetting('enable', 'mobile_check') == true){
			$robotdata .= '<meta name="robots" content="follow,noindex" />'."\r";
			$robotdata .= '<link rel="canonical" href="'.str_replace('/standard/','/',URL_ABSOLUTE.ltrim($_SERVER['REQUEST_URI'], '/')).'">'."\r";
		}
	}

	if(isset($_GET['media']) && $_GET['media'] != 'mobile' && MOBILE_CHECK != 'Disabled'){
		$robotdata .= '<link rel="alternate" href="'.URL_ABSOLUTE.'mobile/'.ltrim(str_replace('standard/','/',$_SERVER['REQUEST_URI']), '/').'" media="handheld">'."\r";
	}

	if(Plugin::getSetting('enable', 'mobile_check') == true){
		$robotdata .= '<link rel="alternate" href="'.URL_ABSOLUTE.'mobile'.ltrim($_SERVER['REQUEST_URI']).'" media="handheld">'."\r";
	}

	/* Work with viewport in mobile_check plugin */
	if(Plugin::getSetting('viewport', 'mobile_check')){
		$viewport = '';
		$mobilecheck = true; if(Plugin::getSetting('enable', 'mobile_check') == false){ $mobilecheck = false;  }
		if(Plugin::getSetting('viewport', 'mobile_check') != '' && $mobilecheck == true){
			$content = Plugin::getSetting('viewport', 'mobile_check');
			/* See if screen_width set for mobiles */
			if(stristr($content, 'width=set-width') && Plugin::getSetting('screen_width', 'mobile_check') != ''){
				/* Set all devices as per mobile screen_width */
				$content = str_replace('width=set-width', 'width='.Plugin::getSetting('screen_width', 'mobile_check'), $content);
			}
			$viewport = '<meta name="viewport" content="'.$content.'">'."\r";
		}
		$robotdata .= $viewport;
	}


	if($returnstatus == 'return'){
		return $robotdata;
	} else {
		echo $robotdata;
	}


}
function robotredirect($page,$returnstatus='echo'){
	$redirect = '';
	global $__CMS_CONN__;
	$sql = 'SELECT redirect FROM '.TABLE_PREFIX.'page WHERE id=?';
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	while ($robotsindex = $stmt->fetchObject()) {
		$redirect = $robotsindex->redirect;
	}
	if($returnstatus == 'return'){
		return $redirect;
	} else {
		echo $redirect;
	}
}
function findrobotredirect($page,$pageattribute='redirect'){
	$redirect = '';
	global $__CMS_CONN__;
	$sql = 'SELECT '.$pageattribute.' FROM '.TABLE_PREFIX.'page WHERE id=?';
	$stmt = $__CMS_CONN__->prepare($sql);
	$stmt->execute(array($page->id));
	while ($robotsindex = $stmt->fetchObject()) {
		$redirect = $robotsindex->$pageattribute;
	}
	return $redirect;
}