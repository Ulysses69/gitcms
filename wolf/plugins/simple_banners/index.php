<?php

if (!defined('SIMPLE_BANNERS_VERSION')) { define('SIMPLE_BANNERS_VERSION', '0.2.1'); }
if (!defined('SIMPLE_BANNERS_ROOT')) { define('SIMPLE_BANNERS_ROOT', URI_PUBLIC.'wolf/plugins/simple_banners'); }
Plugin::setInfos(array(
	'id'					=> 'simple_banners',
	'title'					=> 'Simple Banners',
	'description'			=> 'Create simple image banner',
	'version'				=> SIMPLE_BANNERS_VERSION,
	'license'				=> 'GPLv3',
	'require_wolf_version'	=> '0.5.5'
));


if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
	if(!AuthUser::hasPermission('client')){
		//if(Plugin::isEnabled('dashboard') == true) {
			//Plugin::addController('simple_banners', 'SimpleBanners', 'administrator', false);
		//} else {
			Plugin::addController('simple_banners', 'Banner', 'administrator', true);
		//}
	}
}

	if(!function_exists('bannerimgs')){
		function bannerimgs($folder,$id='',$output_type='html'){
	        //$icon_set_array = array();
	        $blacklist = array('.', '..', '.DS_Store', 'Thumbs.db', '_thumbs');
	        $output = ''; $jsoutput = ''; $blank = '';
	        $folder = '/public/images/'.$folder;
	        $path = $_SERVER{'DOCUMENT_ROOT'}.$folder;
	        $i = 1;
	        if($handle = opendir($path)) {

				if($output_type == 'js'){
					while (false !== ($file = readdir($handle))) {
		                if(!in_array($file, $blacklist)) {
							//$filename = substr($file, 0 , (strrpos($file, ".")));
							$output .= "'".$file."',";
						}
					}
				}

	            if($output_type == 'html'){
					while (false !== ($file = readdir($handle))) {
		                if(!in_array($file, $blacklist)) {
							if($i == 1){
								$first = '<img src="'.$folder.'/'.$file.'" alt="" />';
								$output .= $first;
							}
		                }
		            }
				}

	            closedir($handle);

	        }
            return $output;
		}
	}

	/* Page options - new */
	if(!function_exists('simplebanner')){
		function simplebanner($page){

			if(!is_object($page)){
				$page = Page::findById(1);
			}

			$output = '';
            $display = Plugin::getSetting('display', 'simple_banners');
            $bannercontainer = Plugin::getSetting('bannercontainer', 'simple_banners');
            $bannerduration = Plugin::getSetting('bannerduration', 'simple_banners');
            $images_home_FOLDER = Plugin::getSetting('images_home_FOLDER', 'simple_banners');
	        $images_main_FOLDER = Plugin::getSetting('images_main_FOLDER', 'simple_banners');

	        $home_folder = '/public/images/'.$images_home_FOLDER;
	        $main_folder = '/public/images/'.$images_main_FOLDER;

            if($display == 'show'){
                if($images_home_FOLDER != '' && $page->slug == ''){
					$home_images = bannerimgs($images_home_FOLDER,'home','html');
					if(substr_count($home_images, '<img') >= 1){
						if($bannercontainer == 'show'){
							$output = '<div id="banner" class="home">' . $home_images . '</div>';
						} else {
							$output = $home_images;
						}
					}
				}
                if($images_main_FOLDER != '' && $page->slug != ''){
					$main_images = bannerimgs($images_main_FOLDER,'main','html');
					if(substr_count($main_images, '<img') >= 1){
						if($bannercontainer == 'show'){
							$output = '<div id="banner" class="main">' . $home_images . '</div>';
						} else {
							$output = $home_images;
						}
					}
				}
				echo $output;
            }

		}

	}

	/* Page options - new */
	if(!function_exists('simplebannerJS')){
		function simplebannerJS($page){

			if(!is_object($page)){
				$page = Page::findById(1);
			}

			$output = '';
			$home_banners = '';
			$main_banners = '';
            $display = Plugin::getSetting('display', 'simple_banners');

            if($display == 'show'){

	            $bannercontainer = Plugin::getSetting('bannercontainer', 'simple_banners');
	            $bannerduration = Plugin::getSetting('bannerduration', 'simple_banners');
	            $images_home_FOLDER = Plugin::getSetting('images_home_FOLDER', 'simple_banners');
		        $images_main_FOLDER = Plugin::getSetting('images_main_FOLDER', 'simple_banners');
	
		        $home_folder = '/public/images/'.$images_home_FOLDER;
		        $main_folder = '/public/images/'.$images_main_FOLDER;

                if($images_home_FOLDER != ''){
					$home_images = bannerimgs($images_home_FOLDER,'home','js');
					if(substr_count($home_images, ',') >= 1){
						$home_banners = 'var homeBanners = [' . rtrim($home_images,',') . '];';
					}
				}
                if($images_main_FOLDER != ''){
					$main_images = bannerimgs($images_main_FOLDER,'main','js');
					if(substr_count($main_images, ',') >= 1){
						$main_banners = 'var mainBanners = [' . rtrim($main_images,',') . '];';
					}
				}
				
				if($images_main_FOLDER == ''){
					$main_folder = $home_folder;
				}


				$output .= "
				    var bannerHolder = 'banner';
				    var bannerPath = '".$main_folder."/';
				    var bannerSpeed = 3;
				    var bannerTransition = 0.5;
				    var banner = document.getElementById(bannerHolder);
				    var banners = '';
				
					function hasClass(el, cls) {
						return el.className && new RegExp('(\\s|^)' + cls + '(\\s|$)').test(el.className);
					}
				
					";


				if($home_banners != ''){ $output .= $home_banners; }
				if($main_banners != ''){ $output .= $main_banners; }

				if($main_banners != ''){ $output .= "
				    banners = mainBanners;
				    ";
				}


				if($home_banners != ''){ $output .= "
					if (hasClass(banner, 'home')) { banners = homeBanners; bannerPath = '".$home_folder."/'; }
					";
				}


				$output .= "
				    banner.getElementsByTagName('img')[0].style.position = 'relative';
				    var j = banners.length;
				    var current = 0;
				    var imgs = [];
				
					for (var i = 0; i < j; i++){
					    var img = document.createElement('img');
					    img.src = bannerPath + banners[i];
					    banner.appendChild(img);
					    imgs.push(img);
				      	imgs[i].style.position = 'absolute';
					  	imgs[i].style.transition = 'opacity ' + bannerTransition + 's ease-in';
					    imgs[i].style.opacity = 0;
					}
				
					setInterval(function(){
					  for (var i = 0; i < j; i++) {
					    imgs[i].style.opacity = 0;
					  }
					  current = (current != j - 1) ? current + 1 : 0;
					  imgs[current].style.opacity = 1;
					}, (bannerSpeed * 1000));
				
					setTimeout(function(){
					    banner.getElementsByTagName('img')[0].style.opacity = 0;
					}, ((bannerSpeed * 2) * 1000));
				";

            }
            
            return $output;

		}
	}

	/* Simple Banner CSS - Used for Mobile Styling Default */
	if(!function_exists('simplebannerCSS')){
		function simplebannerCSS(){

			$page = Page::findById(1);

			$imgs = '';
			$homeimgs = 0;
			$mainimgs = 0;

            $display = Plugin::getSetting('display', 'simple_banners');
            $bannerduration = Plugin::getSetting('bannerduration', 'simple_banners');
            $images_home_FOLDER = Plugin::getSetting('images_home_FOLDER', 'simple_banners');
	        $images_main_FOLDER = Plugin::getSetting('images_main_FOLDER', 'simple_banners');

	        $home_folder = '/public/images/'.$images_home_FOLDER;
	        $main_folder = '/public/images/'.$images_main_FOLDER;

			$output = '';
			$keyframes = '';

            if($display == 'show'){
                if($images_home_FOLDER != '' && $page->slug == ''){
			        $blacklist = array('.', '..', '.DS_Store', 'Thumbs.db', '_thumbs');
			        $i = 0;
			        $folder = '/public/images/'.$images_home_FOLDER;
			        $path = $_SERVER{'DOCUMENT_ROOT'}.$folder;
			        if($handle = opendir($path)) {
			            while (false !== ($file = readdir($handle))) {
			                if(!in_array($file, $blacklist)) {
			                    $i++;
			                }
			            }
			            $homeimgs = $i;
			        }
				}
                if($images_main_FOLDER != '' && $page->slug != ''){
			        $blacklist = array('.', '..', '.DS_Store', 'Thumbs.db', '_thumbs');
			        $i = 0;
			        $folder = '/public/images/'.$images_main_FOLDER;
			        $path = $_SERVER{'DOCUMENT_ROOT'}.$folder;
			        if($handle = opendir($path)) {
			            while (false !== ($file = readdir($handle))) {
			                if(!in_array($file, $blacklist)) {
			                    $i++;
			                }
			            }
			            $mainimgs = $i;
			        }
				}
				
				if($homeimgs > 1 || $mainimgs > 1){

	    			echo '#banner {'."\n";
					echo '	position: relative;'."\n";
					echo '}'."\n";
					echo '#banner img {'."\n";
					echo '	max-width: 100% !important;'."\n";
					echo '	left: 0;'."\n";
					echo '	top: 0;'."\n";
					echo '}'."\n";

				}

            }
            
            // TO DO:
            // writeJScripts($page);

		}

	}

