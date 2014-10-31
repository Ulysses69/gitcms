<?php
class CleanerController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/cleaner/views/sidebar'));
	}
	public function index() {
		$this->display('cleaner/views/index');
	}
	public function clean() {
		$this->display('cleaner/views/clean');
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
		$cleanlist = htmlspecialchars($_POST['cleanlist']);
		$protectlist = htmlspecialchars($_POST['protectlist']);
		//$debugmode = $_POST['debugmode'];
		
		$debug = htmlspecialchars($_GET['test']);
		if(isset($debug)){
			if($debug == true){
				$debugmode = true;
			} else {
				$debugmode = false;
			}
		} else {
			$debugmode = true;
		}

		//$customconditions = $_POST['customconditions'];

		// Handle platform slashes cross-platform style
		$cleanlist = str_replace("\\","/",$cleanlist);
		$protectlist = str_replace("\\","/",$protectlist);

		// Clean white spaces
		$cleanlist = str_replace(" ", '', $cleanlist);
		$protectlist = str_replace(" ", '', $protectlist);

		// Ensure custom admin dir is supported
		$cleanlist = str_replace('/admin/error_log', '/'.ADMIN_DIR.'/error_log', $cleanlist);
		$protectlist = str_replace('/admin/', '/'.ADMIN_DIR.'/', $protectlist);
		$protectlist = str_replace("/admin\r", "/".ADMIN_DIR."\r", $protectlist);

		$settings = array('cleanlist' => $cleanlist, 'protectlist' => $protectlist, 'debugmode' => $debugmode);
		if (Plugin::setAllSettings($settings, 'cleaner')) {
			Flash::set('success', 'Cleaner - '.__('plugin settings saved.'));
			redirect(get_url('plugin/cleaner/settings'));
		} else {
			Flash::set('error', 'Cleaner - '.__('plugin settings not saved!'));
			redirect(get_url('plugin/cleaner/settings'));
		}

	}

	function save() {

		$debug = htmlspecialchars($_GET['test']);
		if(isset($_GET['test'])){
			if($debug == 'DISABLED'){
				$debugmode = true;
			} else {
				$debugmode = false;
			}
		} else {
			$debugmode = true;
		}

		$settings = array('debugmode' => $debugmode);
		if (Plugin::setAllSettings($settings, 'cleaner')) {
			Flash::set('success', 'Cleaner - '.__('plugin settings saved.'));
			redirect(get_url('plugin/cleaner/settings'));
		} else {
			Flash::set('error', 'Cleaner - '.__('plugin settings not saved!'));
			redirect(get_url('plugin/cleaner/settings'));
		}


	}

}