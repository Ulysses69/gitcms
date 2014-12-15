<?php

class AdsController extends PluginController {
	function __construct() {
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}

		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/ads/views/sidebar'));
	}
 
	function index() {
		$data['current_boxes'] = Record::findAllFrom('AdsBoxes', 'true ORDER BY boxlabel, boxcontent, boxlinkurl, boxstatus, itemkey');
		$this->display('ads/views/index', $data);
	}

	function save() {
		$data = $_POST['box'];

		/* Add box */

		if (empty($data['boxlabel'])){
			Flash::set('error', __('You have to specify a name.'));
			redirect(get_url('plugin/ads/'));
		}

		$dataLabel = $data['boxlabel'];
		$dataContent = $data['boxcontent'];
		$dataURL = $data['boxlinkurl'];
		if(isset($data['boxstatus'])){
			$dataStatus = $data['boxstatus'];
		} else {
			$dataStatus = '';
		}
		$dataKey = $data['itemkey'];

		// Ads plugin settings
		if (Plugin::setAllSettings($settings, 'ads')){
			Flash::set('success', __('Ads settings saved.'));
		} else {
			Flash::set('error', __('Ads settings not saved.'));
		}

		// Ads boxes
		if ($existing_box = Record::findOneFrom('AdsBoxes', 'boxlabel = \''.($dataLabel.'\''))) {
			Record::update('AdsBoxes', array('boxlabel' => $dataLabel, 'boxcontent' => $dataContent, 'boxlinkurl' => $dataURL, 'boxstatus' => $dataStatus, 'itemkey' => $dataKey));
		} else {

			$data = array("boxlabel" => $dataLabel, "boxcontent" => $dataContent, "boxlinkurl" => $dataURL, "boxstatus" => $dataStatus, "itemkey" => $dataKey);

			$entry = new AdsBoxes($data);

			if (! $entry->save()){
				Flash::set('error', __('There was a problem adding your ad.'));
			} else {
				Flash::set('success', __('Ad has been added.'));
			}
		}
		redirect(get_url('plugin/ads/'));

	}

	function remove($id) {

		/* Delete box */

		if ($box = Record::findByIdFrom('AdsBoxes', $id)){
			if ($box->delete()){
				Flash::set('success', __('Ad has been deleted.'));
			}
			else
				Flash::set('error', __('There was a problem deleting this ad.'));
		}
		else Flash::set('error', __('Ad not found.'));

		redirect(get_url('plugin/ads/'));
	}
	
	function update() {
		
		// Remove box
		
		if (isset($_POST['remove'])) {

			//remove($_POST['boxes_id']);
			redirect(get_url('plugin/ads/remove/'.$_POST['boxes_id']));
			
		}

		// Update box

		if (!isset($_POST['update'])) {

			Flash::set('error', __('Ad not found.'));

		} else {

			$id = $_POST['boxes_id'];
			$data = $_POST[$id];

			if($data['boxlabel'] != ''){

				$boxes = new AdsBoxes();
	
				$boxes->id = $id;
				$boxes->boxlabel = $data['boxlabel'];
				$boxes->boxcontent = $data['boxcontent'];
				$boxes->boxlinkurl = $data['boxlinkurl'];
				if(isset($data['boxstatus'])){
					$boxes->boxstatus = $data['boxstatus'];
				} else {
					$boxes->boxstatus = '';
				}
	
				$boxes->save();
	
				Flash::set('success', __('Ad has been updated.'));
				//redirect(get_url('plugin/ads'));

			} else {

				Flash::set('success', __('Ad label is required.'));

			}

		}

		redirect(get_url('plugin/ads/'));
	}

}
