<?php
class TinymceStylesController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/tinymce_styles/views/sidebar'));
	}
	public function index(){
		$this->generate();
	}
	public function generate(){
		$this->display('tinymce_styles/views/settings');
	}
	public function settings(){
		$settings = Plugin::getAllSettings('tinymce_styles');
			if (!$settings) {
				Flash::set('error', 'TinyMCE Styles - '.__('unable to retrieve plugin settings.'));
				return;
			}
			$this->display('tinymce_styles/views/settings', $settings);
	}
	public function save_settings(){
		$tablename = TABLE_PREFIX.'tinymce_styles';
		$tinymce_styles_list = str_replace(",",'',$_POST['tinymce_styles_list']);
		$settings = array('tinymce_styles_list' => $tinymce_styles_list);

		if (Plugin::setAllSettings($settings, 'tinymce_styles')) {
			Flash::set('success', 'TinyMCE Styles - '.__('plugin settings saved.'));
			redirect(get_url('plugin/tinymce_styles'));
		} else {
			Flash::set('error', 'TinyMCE Styles - '.__('plugin settings not saved!'));
			redirect(get_url('plugin/tinymce_styles/settings'));
		}

	}
}