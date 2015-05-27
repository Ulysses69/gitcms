<?php
class SimpleBannersController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/simple_banners/views/sidebar'));
	}
	public function index() {
		//$this->documentation();
		//$this->display('simple_banners/views/settings', $settings);
		$this->display('simple_banners/views/settings');
	}
	public function settings(){
		$settings = Plugin::getAllSettings('simple_banners');
			if (!$settings) {
				Flash::set('error', 'SimpleBanners - '.__('unable to retrieve plugin settings.'));
				return;
			}
			$this->display('simple_banners/views/settings', $settings);
	}
	public function save_settings(){
		$tablename = TABLE_PREFIX.'simple_banners';
		$display = $_POST['display'];
		$bannercontainer = $_POST['bannercontainer'];
		$bannerduration = $_POST['bannerduration'];
		$images_home_FOLDER = $_POST['images_home_FOLDER'];
		$images_main_FOLDER = $_POST['images_main_FOLDER'];
		$settings = array(	'display' => $display,
				  			'bannercontainer' => $bannercontainer,
				  			'bannerduration' => $bannerduration,
				  			'images_home_FOLDER' => $images_home_FOLDER,
				  			'images_main_FOLDER' => $images_main_FOLDER);
		if (Plugin::setAllSettings($settings, 'simple_banners')) {
			/* Update mobile CSS */
			if(function_exists('updateMobileCSS')){
				updateMobileCSS();
			}
			Flash::set('success', 'SimpleBanners - '.__('plugin settings saved.'));
			redirect(get_url('plugin/simple_banners/settings'));
		} else {
			Flash::set('error', 'SimpleBanners - '.__('plugin settings not saved!'));
			redirect(get_url('plugin/simple_banners/settings'));
		}

	}
}