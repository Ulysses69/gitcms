<?php

if (!defined('SOCIAL_VERSION')) { define('SOCIAL_VERSION', '1.0.2'); }
if (!defined('SOCIAL_ROOT')) { define('SOCIAL_ROOT', URI_PUBLIC.'wolf/plugins/social'); }
Plugin::setInfos(array(
	'id'					=> 'social',
	'title'					=> 'Social',
	'description'			=> 'Set social',
	'version'				=> SOCIAL_VERSION,
	'license'				=> 'GPLv3',
	'require_wolf_version'	=> '0.5.5'
));


if (strpos($_SERVER['PHP_SELF'], ADMIN_DIR . '/index.php')) {
	if(!AuthUser::hasPermission('client')){
		//if(Plugin::isEnabled('dashboard') == true) {
			//Plugin::addController('social', 'Social', 'administrator', false);
		//} else {
			Plugin::addController('social', 'Social', 'administrator', true);
		//}
	}
}

/* Check if this plugin is enabled */
//if(Plugin::isEnabled('social')){

	/* Page options - new */
	if(!function_exists('socialLinks')){
		function socialLinks(){
            
            $data = '';
            $display = Plugin::getSetting('display', 'social');
            $appearance = Plugin::getSetting('appearance', 'social');
            if($display == 'show'){

                function sociallink($data, $name='', $title=''){                
                    $appearance = Plugin::getSetting('appearance', 'social'); 
                    $icon_set = Plugin::getSetting('icon_set', 'social');                
                    $facebook_URL = Plugin::getSetting('facebook_URL', 'social');
                    $twitter_URL = Plugin::getSetting('twitter_URL', 'social');
                    $linkedin_URL = Plugin::getSetting('linkedin_URL', 'social');
                    $pinterest_URL = Plugin::getSetting('pinterest_URL', 'social');
                    $youtube_URL = Plugin::getSetting('youtube_URL', 'social');
                    $googleplus_URL = Plugin::getSetting('googleplus_URL', 'social');
                    $vimeo_URL = Plugin::getSetting('vimeo_URL', 'social');
                    $instagram_URL = Plugin::getSetting('instagram_URL', 'social');

                    $output = '';
                    if($name != '' && $title != ''){                    
                        $url = ${$name.'_URL'};
                        if($appearance == 'image'){
                            $open = '<img src="'.URI_PUBLIC.'wolf/plugins/social/icons/'.$icon_set.'/'.$name.'.png" alt="';
                            $close = '" />';
                        } else {
                            $open = '';
                            $close = '';
                        }
                        if(${$name.'_URL'} != ''){ 
                            if($appearance == 'image'){
                                $output .= '<span class="'.$name.'"><a href="'.$url.'">'.$open.$title.$close.'</a></span> ';
                            } else {
                                $output .= '<li class="'.$name.'"><a href="'.$url.'">'.$open.$title.$close.'</a></li>'."\n";
                            }
                        }
                    }

                    return $output;
                }

                $data .= sociallink($data, 'facebook', 'Facebook'); 
                $data .= sociallink($data, 'twitter', 'Twitter'); 
                $data .= sociallink($data, 'linkedin', 'Linkedin'); 
                $data .= sociallink($data, 'pinterest', 'Pinterest'); 
                $data .= sociallink($data, 'youtube', 'Youtube'); 
                $data .= sociallink($data, 'googleplus', 'Google Plus'); 
                $data .= sociallink($data, 'vimeo', 'Vimeo'); 
                $data .= sociallink($data, 'instagram', 'Instagram'); 

                if($appearance == 'image'){
                    echo '<div class="social">'."\n".$data.'</div>';
                } else {
                    echo '<ul class="social">'."\n".$data.'</ul>';
                }

            }

		}
	}

//}