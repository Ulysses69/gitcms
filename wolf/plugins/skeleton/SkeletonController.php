<?php
class SkeletonController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/'.SKELETON_ID.'/views/sidebar'));
	}
	public function index() {
		//$this->documentation();
		//$this->display('skeleton/views/settings', $settings);
		$this->display(SKELETON_ID.'/views/settings');
	}
	public function settings(){
		$settings = Plugin::getAllSettings(SKELETON_ID);
			if (!$settings) {
				Flash::set('error', SKELETON_TITLE.' - '.__('unable to retrieve plugin settings.'));
				return;
			}
			$this->display(SKELETON_ID.'/views/settings', $settings);
	}
	public function save_settings(){
		$version = $_POST['version'];
		$test1 = $_POST['test1'];
		$settings = array('version' => $version, 'test1' => $test1);

		//$tablename = TABLE_PREFIX.SKELETON_TABLE;
		if (Plugin::setAllSettings($settings, SKELETON_ID)) {
			Flash::set('success', SKELETON_TITLE.' - '.__('plugin settings saved.'));
			redirect(get_url('plugin/'.SKELETON_ID.'/settings'));
		} else {
			Flash::set('error', SKELETON_TITLE.' - '.__('plugin settings not saved!'));
			redirect(get_url('plugin/'.SKELETON_ID.'/settings'));
		}

	}
}