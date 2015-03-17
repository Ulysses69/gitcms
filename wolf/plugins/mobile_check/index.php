<?php

if (!defined('MOBILE_VERSION')) { define('MOBILE_VERSION', '1.9.2'); }
if (!defined('MOBILE_ROOT')) { define('MOBILE_ROOT', URI_PUBLIC.'wolf/plugins/mobile_check'); }
Plugin::setInfos(array(
	'id'					=> 'mobile_check',
	'title'					=> 'Mobile Tools',
	'description'			=> 'Mobile detection checker.',
	'version'				=> MOBILE_VERSION,
	'license'				=> 'GPLv3',
	'require_wolf_version'	=> '0.5.5'
));

//define('MOBILE_CHECK', URI_PUBLIC.'wolf/plugins/mobile_check');
if(Plugin::getSetting('enable', 'mobile_check') == true){
	if (!defined('MOBILE_CHECK')) { define('MOBILE_CHECK', 'Enabled'); }
} else {
	if (!defined('MOBILE_CHECK')) { define('MOBILE_CHECK', 'Disabled'); }
}
if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
	Plugin::addController('mobile_check', 'Mobile', 'administrator', false);
}

if(!function_exists('getMobileCheck')){
function getMobileCheck(){
	$mobile_enable = Plugin::getSetting('enable', 'mobile_check');
	return $mobile_enable;
}
}

if(!function_exists('desktopText')){
function desktopText(){
	$desktop_text = Plugin::getSetting('desktop_text', 'mobile_check');
	return $desktop_text;
}
}

if(!function_exists('mobileLogo')){
function mobileLogo(){
	$logo = Plugin::getSetting('logo', 'mobile_check');
	$logo_url = Plugin::getSetting('logo_url', 'mobile_check');
	$clientname = clientname(); ?>

	<div id="logo">
		<a href="/">
		<?php if($logo == 'logo' && $logo_url != ''){ ?>
			<img src="<?php echo $logo_url; ?>" alt="<?php echo $clientname; ?>" /><?php
		} else {
			echo $clientname;
		} ?>
		</a>
	</div>

	<?php //return $mobile_enable;
}
}

if(!function_exists('mobileTopNav')){
function mobileTopNav(){

	$topnav = Plugin::getSetting('topnav', 'mobile_check');
	$topnavhome = Plugin::getSetting('topnavhome', 'mobile_check');
	$background_url = Plugin::getSetting('background_url', 'mobile_check');

	$header_banner_home = Plugin::getSetting('header_banner_home', 'mobile_check');
	$header_banner = Plugin::getSetting('header_banner', 'mobile_check');

	/* Build page object, set page to home page id, 1 */
	$page = Page::findById(1);
	$uri = $_SERVER['REQUEST_URI'];
	/* Filter out virtual pages (such as success pages) */
	if(stristr($uri,'/success'.URL_SUFFIX)){
		$uri = str_replace('/success', '', $uri);
	}
	$find = str_replace(array(URL_SUFFIX,'mobile/','search/'),array('','',''),$uri);
	$parent = $page->find($find);

	if(is_object($parent)){
	
		if($parent->url == ''){
			/* Handle banners */
			if($header_banner_home != ''){
				echo $header_banner_home;
			}
		}
	
		if($parent->url != ''){
			if($topnav == 'labels'){ ?>
	
			<ul id="menu">
			<li id="gomenu"><a href="/" title="Go to menu">Menu</a></li>
			</ul><?php } else if($topnav == 'icons'){ ?>
		
			<ul id="menu">
			<li id="gomenu" title="Go to menu"><a href="/"><img src='/inc/img/mobile/menu.png' /></a></li>
			</ul><?php } else {}
	
			/* Handle banners */
			if($header_banner != ''){
				echo $header_banner;
			}
	
		}

	}

}
}

if(!function_exists('mobileHomeNav')){
function mobileHomeNav($parent){

	$topnav = Plugin::getSetting('topnav', 'mobile_check');
	$topnavhome = Plugin::getSetting('topnavhome', 'mobile_check');
	$background_url = Plugin::getSetting('background_url', 'mobile_check');

	/* Build page object, set page to home page id, 1 */
	$page = Page::findById(1);
	$uri = $_SERVER['REQUEST_URI'];
	/* Filter out virtual pages (such as success pages) */
	if(stristr($uri,'/success'.URL_SUFFIX)){
		$uri = str_replace('/success', '', $uri);
	}
	$find = str_replace(array(URL_SUFFIX,'mobile/','search/'),array('','',''),$uri);
	$parent = $page->find($find);

	if(is_object($parent)){

		if($parent && $parent->url == ''){
			$parent->includeSnippet('mobilemenu');
		}
	
		if($parent->url != '' && $topnav == 'menu'){
			//echo '<div role="navigation" id="nav"><ul>';
			//ob_start();
			$parent->includeSnippet('mobilemenu');
			//$menu = ob_get_contents();
	  		//ob_end_clean();
	  		//echo strip_tags($menu,'<li><a>');
			//echo '</ul></div>';
	
		}
	
	}

}
}


if(!function_exists('mobileHead')){
function mobileHead(){
	
	$topnav = Plugin::getSetting('topnav', 'mobile_check');
	$topnavhome = Plugin::getSetting('topnavhome', 'mobile_check');
	$background_url = Plugin::getSetting('background_url', 'mobile_check');

	/* Build page object, set page to home page id, 1 */
	$page = Page::findById(1);
	$uri = $_SERVER['REQUEST_URI'];
	/* Filter out virtual pages (such as success pages) */
	if(stristr($uri,'/success'.URL_SUFFIX)){
		$uri = str_replace('/success', '', $uri);
	}
	$find = str_replace(array(URL_SUFFIX,'mobile/','search/'),array('','',''),$uri);
	$parent = $page->find($find);


	// Check if page is unavailable/503
	//if($DATABASE_UNAVAILABLE == true) $parent = $page->find('template');


	//echo '<script>alert("'.$parent->url.'");</script>';
	

	if(is_object($parent)){
		if($parent->url == '' && $topnavhome != 'disabled'){
			?>
			<script>document.write("<link rel='stylesheet' href='/inc/css/nav.css' type='text/css'>");</script>
			<script src='/inc/js/nav.js'></script>
			<?php
		}
		
		if($parent->url != '' && $topnav == 'menu'){ ?>
			<script>document.write("<link rel='stylesheet' href='/inc/css/nav.css' type='text/css'>");</script>
			<script src='/inc/js/nav.js'></script>
			<?php
		}
	}
}
}


if(!function_exists('mobileFoot')){
function mobileFoot(){

	$topnav = Plugin::getSetting('topnav', 'mobile_check');
	$topnavhome = Plugin::getSetting('topnavhome', 'mobile_check');
	$background_url = Plugin::getSetting('background_url', 'mobile_check');

	/* Build page object, set page to home page id, 1 */
	$page = Page::findById(1);
	$uri = $_SERVER['REQUEST_URI'];
	/* Filter out virtual pages (such as success pages) */
	if(stristr($uri,'/success'.URL_SUFFIX)){
		$uri = str_replace('/success', '', $uri);
	}
	$find = str_replace(array(URL_SUFFIX,'mobile/','search/'),array('','',''),$uri);
	$parent = $page->find($find);
	
	if(is_object($parent)){

		if($parent->url == '' && $topnavhome != 'disabled'){ ?>
			<script src="/inc/js/toggle.js"></script>
			<?php
		}
	
		if($parent->url != '' && $topnav == 'menu'){ ?>
			<script src="/inc/js/toggle.js"></script>
			<?php
		}
		
	}

}
}



if(!function_exists('getmobilecontent')){
function getmobilecontent($parent,$scripts=false){
	$homecontent = Plugin::getSetting('homecontent', 'mobile_check');
	if($parent->slug != '' || ($parent->slug == '' && $homecontent != 'disabled')){
		mobilecontent($parent,true);
	}
}
}



if(!function_exists('mobilesidebar')){
function mobilesidebar($parent){
	if(Plugin::getSetting('sidebar', 'mobile_check') != 'false' && (strlen($parent->content('sidebar')) > 0 && $parent->slug != '' && $parent->slug != 'news')){ ?>
	<div id="sidebar">
	<?php echo $parent->content('sidebar', true); ?>
	</div>
	<?php }
}
}