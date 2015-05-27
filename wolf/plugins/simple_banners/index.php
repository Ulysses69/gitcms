<?php

if (!defined('SIMPLE_BANNERS_VERSION')) { define('SIMPLE_BANNERS_VERSION', '0.2.0'); }
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
		function bannerimgs($folder,$id=''){
	        //$icon_set_array = array();
	        $blacklist = array('.', '..', '.DS_Store', 'Thumbs.db', '_thumbs');
	        $output = ''; $jsoutput = ''; $blank = '';
	        $folder = '/public/images/'.$folder;
	        $path = $_SERVER{'DOCUMENT_ROOT'}.$folder;
	        $i = 1;
	        if($handle = opendir($path)) {
	            while (false !== ($file = readdir($handle))) {
	                if(!in_array($file, $blacklist)) {
						if($i == 1){
							$blank = '<img class="blank" src="'.$folder.'/'.$file.'" alt="" />';
							$output .= $blank;
							$filename = substr($file, 0 , (strrpos($file, ".")));
							$jsoutput .= '<img class="'.$id.$filename.'" src="'.$folder.'/'.$file.'" alt="" />';
						} else {
							$filename = substr($file, 0 , (strrpos($file, ".")));
							$jsoutput .= '<img class="'.$id.$filename.'" src="'.$folder.'/'.$file.'" alt="" />';
						}
	                    //$icon_set_array[] = array(ucfirst($file), $file);
	                    $i++;
	                }
	            }

	            if($i == 2){
					$output = str_replace(' class="blank"', '', $output);
					//$jsoutput = $jsoutput;
					//$output .= $jsoutput;
					//$output .= ' ' . $blank;
					//$output .= $output . $output;

				} else if($i > 2) {
					$output .= "\n<script>document.write('<div class=\"slides\">".$jsoutput."</div>');</script>";
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

					//echo 'Home Banner Folder: ' . $home_folder;
					$home_images = bannerimgs($images_home_FOLDER,'home');
					
					if(substr_count($home_images, '<img') >= 1){
						$output .= "\n".'<div class="simplebanner home">'."\n";
						$output .= $home_images."\n";
						$output .= '</div>'."\n";
					//} else {
						//echo $home_images."\n";
						
						if($bannercontainer == 'show'){
							$output = '<div id="banner">' . $output . '</div>';
						}
		
					}

				}
                if($images_main_FOLDER != '' && $page->slug != ''){

					//echo 'Main Banner Folder: ' . $main_folder;
					$main_images = bannerimgs($images_main_FOLDER,'main');
					
					if(substr_count($main_images, '<img') >= 1){
						$output .= "\n".'<div class="simplebanner main">'."\n";
						$output .= $main_images."\n";
						$output .= '</div>'."\n";
					//} else {
						//echo $main_images."\n";

						if($bannercontainer == 'show'){
							$output = '<div id="banner">' . $output . '</div>';
						}

					}
				
				}

				echo $output;

            }

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
			            closedir($handle);
			            for ($p=1; $p <= $i; $p++){
							$child = ($i - $p) + 1;
							$duration = (($p - 2) * $bannerduration) + $bannerduration;
							$imgs .= '.simplebanner.home .slides img:nth-child('.$child.'){-webkit-animation-delay:'.$duration.'s; animation-delay:'.$duration.'s;}'."\n";
							$homeimgs++;
						}

						$division = 1 / $p;
						$res = ceil((round($division * 100) * $bannerduration) / $p);

						// Match percentages to number of images
						$keyframes .= '@-webkit-keyframes home {'."\n";
						$keyframes .= '  0%{opacity:0;}'."\n";
						$keyframes .= '  '.$res.'%{opacity:1;}'."\n";
						$keyframes .= '  '.($res * 4).'%{opacity:1;}'."\n";
						$keyframes .= '  '.(($res * 4) + $res).'%{opacity:0;}'."\n";
						$keyframes .= '}'."\n";

						$keyframes .= '@keyframes home {'."\n";
						$keyframes .= '  0%{opacity:0;}'."\n";
						$keyframes .= '  '.$res.'%{opacity:1;}'."\n";
						$keyframes .= '  '.($res * 4).'%{opacity:1;}'."\n";
						$keyframes .= '  '.(($res * 4) + $res).'%{opacity:0;}'."\n";
						$keyframes .= '}'."\n";

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
			            closedir($handle);
			            for ($p=1; $p <= $i; $p++){
							$child = ($i - $p) + 1;
							$duration = (($p - 2) * $bannerduration) + $bannerduration;
							$imgs .= '.simplebanner.main .slides img:nth-child('.$child.'){-webkit-animation-delay:'.$duration.'s; animation-delay:'.$duration.'s;}'."\n";
							$mainimgs++;
						}

						$division = 1 / $p;
						$res = ceil((round($division * 100) * $bannerduration) / $p);
						
						// Match percentages to number of images
						$keyframes .= '@-webkit-keyframes main {'."\n";
						$keyframes .= '  0%{opacity:0;}'."\n";
						$keyframes .= '  '.$res.'%{opacity:1;}'."\n";
						$keyframes .= '  '.($res * 4).'%{opacity:1;}'."\n";
						$keyframes .= '  '.(($res * 4) + $res).'%{opacity:0;}'."\n";
						$keyframes .= '}'."\n";

						$keyframes .= '@keyframes main {'."\n";
						$keyframes .= '  0%{opacity:0;}'."\n";
						$keyframes .= '  '.$res.'%{opacity:1;}'."\n";
						$keyframes .= '  '.($res * 4).'%{opacity:1;}'."\n";
						$keyframes .= '  '.(($res * 4) + $res).'%{opacity:0;}'."\n";
						$keyframes .= '}'."\n";

			        }
				}
				
				if($homeimgs > 1 || $mainimgs > 1){

					echo '.simplebanner {'."\n";
					echo '	position:relative;'."\n";
					echo '	overflow:hidden'."\n";
					echo '}'."\n";
	
					echo $keyframes;

					echo '.simplebanner .slides img {'."\n";
					echo '	position:absolute;'."\n";
					echo '	left:0;'."\n";
					echo '	top:0;'."\n";
					echo '	opacity:0;'."\n";
					// Number of images by bannerduration
					echo '}'."\n";
	
					if($homeimgs > 0){
						echo '.simplebanner.home .slides img {'."\n";
						echo '	-webkit-animation:home '.(($homeimgs * $bannerduration)).'s infinite;'."\n";
						echo '	animation:home '.(($homeimgs * $bannerduration)).'s infinite;'."\n";
						echo '}'."\n";
					}
					if($mainimgs > 0){
						echo '.simplebanner.main .slides img {'."\n";
						echo '	-webkit-animation:main '.(($mainimgs * $bannerduration)).'s infinite;'."\n";
						echo '	animation:main '.(($mainimgs * $bannerduration)).'s infinite;'."\n";
						echo '}'."\n";
					}
	
					echo '.js .simplebanner img.blank {'."\n";
					echo '	position:relative;'."\n";
					echo '  -webkit-animation:none;'."\n";
					echo '  animation:none;'."\n";
					echo '  opacity:0 !important;'."\n";
					echo '}'."\n";
	
	    			echo $imgs;
    			
				}

            }
            
            // TO DO:
            // writeJScripts($page);

		}

	}

