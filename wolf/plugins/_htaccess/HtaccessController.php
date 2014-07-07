<?php

class HtaccessController extends PluginController {

	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/_htaccess/views/sidebar'));
	}
	public function index(){
		$this->documentation();
	}
    public function documentation() {
        //$this->display('_htaccess/views/documentation');
        redirect(get_url('plugin/_htaccess/settings'));
    }
     public function settings() {
        $this->display('_htaccess/views/settings');
    }
	public function save_settings(){
		$tablename = TABLE_PREFIX.'htaccess';
		$htaccess = $_POST['htaccess'];
		$htaccessbackup = $_POST['htaccessbackup'];

		$htaccessfile = $_SERVER{'DOCUMENT_ROOT'}.'/.htaccess';
		$htaccessbackupfile = $_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/_htaccess/backups/.htaccess.bak';

		if($htaccess != ''){

			saveServerConfig($htaccess,$htaccessbackup,$htaccessfile,$htaccessbackupfile);

			$settings = array('htaccess' => $htaccess, 'htaccessbackup' => $htaccessbackup);
			if (Plugin::setAllSettings($settings, 'htaccess'))
				Flash::set('success', '.htaccess - '.__('plugin settings saved.'));
			else
				Flash::set('error', '.htaccess - '.__('plugin settings not saved!'));
		}
		
		redirect(get_url('plugin/_htaccess/settings'));

	}

}