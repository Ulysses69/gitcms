<?php
class SocialController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/social/views/sidebar'));
	}
	public function index() {
		//$this->documentation();
		//$this->display('social/views/settings', $settings);
		$this->display('social/views/settings');
	}
	public function settings(){
		$settings = Plugin::getAllSettings('social');
			if (!$settings) {
				Flash::set('error', 'Social - '.__('unable to retrieve plugin settings.'));
				return;
			}
			$this->display('social/views/settings', $settings);
	}
	public function save_settings(){
		$tablename = TABLE_PREFIX.'social';
		$display = $_POST['display'];
		$icon_set = $_POST['icon_set'];
		$appearance = $_POST['appearance'];
		$facebook_URL = $_POST['facebook_URL'];
		$twitter_URL = $_POST['twitter_URL'];
		$linkedin_URL = $_POST['linkedin_URL'];        
        $pinterest_URL = $_POST['pinterest_URL'];
		$youtube_URL = $_POST['youtube_URL'];
		$googleplus_URL = $_POST['googleplus_URL'];
		$vimeo_URL = $_POST['vimeo_URL'];
		$instagram_URL = $_POST['instagram_URL'];
		$yelp_URL = $_POST['yelp_URL'];
		$settings = array(	'display' => $display,
				  			'icon_set' => $icon_set,
				  			'appearance' => $appearance,
				  			'facebook_URL' => $facebook_URL,
				  			'twitter_URL' => $twitter_URL,
				  			'linkedin_URL' => $linkedin_URL,
				  			'pinterest_URL' => $pinterest_URL,
				  			'youtube_URL' => $youtube_URL,
				  			'googleplus_URL' => $googleplus_URL,
				  			'vimeo_URL' => $vimeo_URL,
				  			'instagram_URL' => $instagram_URL,
				  			'yelp_URL' => $yelp_URL);
		if (Plugin::setAllSettings($settings, 'social')) {
			Flash::set('success', 'Social - '.__('plugin settings saved.'));

			if(Plugin::isEnabled('_htaccess') == true){
	
				$htaccessfile = $_SERVER{'DOCUMENT_ROOT'}.'/.htaccess';
				ob_start();
				include($_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/_htaccess/lib/htaccess.php');
				$htaccesstemplate = ob_get_contents();
				ob_end_clean();
	
				//$htaccess = file_get_contents($htaccesstemplate);
				$htaccess = $htaccesstemplate;
				$htaccess = preg_replace("/(\s\s){1,}/","\n",trim($htaccess));
				
				$htaccessbackupfile = $_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/_htaccess/backups/.htaccess.bak';
				$htaccessbackup = file_get_contents($htaccessbackupfile);
				$htaccessbackup = preg_replace("/(\s\s){1,}/","\n",trim($htaccessbackup));
	
				saveServerConfig($htaccess,$htaccessbackup,$htaccessfile,$htaccessbackupfile);
			}

			redirect(get_url('plugin/social/settings'));
		} else {
			Flash::set('error', 'Social - '.__('plugin settings not saved!'));
			redirect(get_url('plugin/social/settings'));
		}

	}
}