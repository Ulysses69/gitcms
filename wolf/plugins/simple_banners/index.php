<?php

if (!defined('SIMPLE_BANNERS_VERSION')) { define('SIMPLE_BANNERS_VERSION', '0.1.0'); }
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
		function bannerimgs($folder){
	        //$icon_set_array = array();
	        $blacklist = array('.', '..', '.DS_Store', 'Thumbs.db', '_thumbs');
	        $output = '';
	        $folder = '/public/images/'.$folder;
	        $path = $_SERVER{'DOCUMENT_ROOT'}.$folder;
	        if($handle = opendir($path)) {
	            while (false !== ($file = readdir($handle))) {
	                if(!in_array($file, $blacklist)) {
	                    //$icon_set_array[] = array(ucfirst($file), $file);
	                    $output .= '<img src="'.$folder.'/'.$file.'" alt="" />';
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

			$data = '';
            $display = Plugin::getSetting('display', 'simple_banners');
            $bannerduration = Plugin::getSetting('bannerduration', 'simple_banners');
            $images_home_FOLDER = Plugin::getSetting('images_home_FOLDER', 'simple_banners');
	        $images_main_FOLDER = Plugin::getSetting('images_main_FOLDER', 'simple_banners');

	        $home_folder = '/public/images/'.$images_home_FOLDER;
	        $main_folder = '/public/images/'.$images_main_FOLDER;

            if($display == 'show'){
                if($images_home_FOLDER != '' && $page->slug == ''){
					//echo 'Home Banner Folder: ' . $home_folder;
					$home_images = bannerimgs($images_home_FOLDER);
					echo "\n".'<div class="simplebanners">';
					echo $home_images;
					echo '</div>'."\n";
				}
                if($images_main_FOLDER != '' && $page->slug != ''){
					//echo 'Main Banner Folder: ' . $main_folder;
					$main_images = bannerimgs($images_main_FOLDER);
					echo "\n".'<div class="simplebanners">';
					echo $main_images;
					echo '</div>'."\n";
				}
            }

		}
	}

