<?php
class CleanerController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
	}
    public function index() {
        //$this->documentation();
        //$this->display('cleaner/views/settings', $settings);
        $this->display('cleaner/views/settings');
    }
	public function settings(){
		$settings = Plugin::getAllSettings('cleaner');
	        if (!$settings) {
	            Flash::set('error', 'Cleaner - '.__('unable to retrieve plugin settings.'));
	            return;
	        }
	        $this->display('cleaner/views/settings', $settings);
	}
	public function save_settings(){
		$tablename = TABLE_PREFIX.'cleaner';
		$cleanlist = $_POST['cleanlist'];
		$protectlist = $_POST['protectlist'];

		$cleanlist = str_replace("\\","/",$cleanlist);
		$protectlist = str_replace("\\","/",$protectlist);

		$settings = array('cleanlist' => $cleanlist, 'protectlist' => $protectlist);
		if (Plugin::setAllSettings($settings, 'cleaner')) {
			Flash::set('success', 'Cleaner - '.__('plugin settings saved.'));
			redirect(get_url('plugin/cleaner/settings'));
		} else {
			Flash::set('error', 'Cleaner - '.__('plugin settings not saved!'));
			redirect(get_url('plugin/cleaner/settings'));
		}

	}
}