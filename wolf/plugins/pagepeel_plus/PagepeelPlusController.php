<?php
//if (!defined('IN_CMS')) { exit(); }
class PagepeelPlusController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/pagepeel_plus/views/sidebar'));
	}
	public function index(){
		$this->display('pagepeel_plus/views/settings');
	}
	public function generate(){
		$this->display('pagepeel_plus/views/settings');
	}
	public function settings(){
		$settings = Plugin::getAllSettings('pagepeel_plus');
	        if (!$settings) {
	            Flash::set('error', 'Pagepeel Plus - '.__('unable to retrieve plugin settings.'));
	            return;
	        }
	        $this->display('pagepeel_plus/views/settings', $settings);
	}
	public function save_settings(){
		$tablename = TABLE_PREFIX.'pagepeel_plus';
		$pagelink = $_POST['pagelink'];
		$pagelist = $_POST['pagelist'];

		if (empty($pagelist)) {
			$pagelist = 'all';
	        } else {
	        	$settings = array('pagelink' => $pagelink,'pagelist' => $pagelist);

			if (Plugin::setAllSettings($settings, 'pagepeel_plus'))
				Flash::set('success', 'Pagepeel Plus - '.__('plugin settings saved.'));
			else
				Flash::set('error', 'Pagepeel Plus - '.__('plugin settings not saved!'));
				redirect(get_url('plugin/pagepeel_plus/settings'));
		}

	}
}