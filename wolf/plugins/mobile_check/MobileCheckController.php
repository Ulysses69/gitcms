<?php
class MobileCheckController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/mobile_check/views/sidebar'));
	}
	public function index() {
		//$settings = array('enable' => $enable);
		$settings = array();
		$this->display('mobile_check/views/settings', $settings);
	}
	public function settings(){
		$settings = Plugin::getAllSettings('mobile_check');
			if (!$settings) {
				Flash::set('error', 'MobileCheck - '.__('unable to retrieve plugin settings.'));
				return;
			}
			$this->display('mobile_check/views/settings', $settings);
	}
	public function save_settings(){
		/* Temporarily store current enable value */
		$get_enable = Plugin::getSetting('enable', 'mobile_check');

		/* Set variables */
		$tablename = TABLE_PREFIX.'mobile_check';

		$newcss = '';
		//$settings = '';
		
		// TO DO: Move these tasks to new single function after the settings are saved to the database. This function can call values directly from database, so these tasks can be called from external scripts */
		$settings = updateMobileCSS();


		if (Plugin::setAllSettings($settings, 'mobile_check')) {


			//if($enable != $get_enable){
				if(function_exists('funky_cache_delete_all')){
					funky_cache_delete_all();
				}
			//}

			Flash::set('success', 'Mobile Check - '.__('plugin settings saved.'));
			redirect(get_url('plugin/mobile_check/settings'));
		} else {
			Flash::set('error', 'Mobile Check - '.__('plugin settings not saved!').$enable);
			redirect(get_url('plugin/mobile_check/settings'));
		}

	}
}