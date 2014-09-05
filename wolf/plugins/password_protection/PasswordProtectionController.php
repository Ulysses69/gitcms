<?php
class PasswordProtectionController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/password_protection/views/sidebar'));
	}
	public function index(){
		$this->generate();
	}
	public function generate(){
		$this->display('password_protection/views/settings');
	}
	public function settings(){
		$settings = Plugin::getAllSettings('password_protection');
			if (!$settings) {
				Flash::set('error', 'Password Protection - '.__('unable to retrieve plugin settings.'));
				return;
			}
			$this->display('password_protection/views/settings', $settings);
	}
	public function save_settings(){
		$tablename = TABLE_PREFIX.'password_protection';
		$password_protection_list = str_replace(",",'',$_POST['password_protection_list']);
		$settings = array('password_protection_list' => $password_protection_list);

		if (Plugin::setAllSettings($settings, 'password_protection')) {
			Flash::set('success', 'Password Protection - '.__('plugin settings saved.'));
			redirect(get_url('plugin/password_protection'));
		} else {
			Flash::set('error', 'Password Protection - '.__('plugin settings not saved!'));
			redirect(get_url('plugin/password_protection/settings'));
		}

	}
}