<?php
//if (!defined('IN_CMS')) { exit(); }
class ElementsController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		//$this->assignToLayout('sidebar', new View('../../plugins/elements/views/sidebar'));
	}
	public function index(){
		$this->documentation();
		//$this->display('elements/views/pages/documentation');
	}
	public function documentation() {
		jselements();
  		     $this->display('elements/views/settings');
	}
	public function save_settings(){
	}

}