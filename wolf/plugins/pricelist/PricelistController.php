<?php

class PricelistController extends PluginController {
    function __construct() {
        AuthUser::load();
        if ( ! AuthUser::isLoggedIn()) {
            redirect(get_url('login'));
        }
 
        $this->setLayout('backend');
        $this->assignToLayout('sidebar', new View('../../plugins/pricelist/views/sidebar'));
    }
 
    function index() {
		$data['current_prices'] = Record::findAllFrom('PricelistPrices', 'true ORDER BY itemlabel, itemdesc, itemprice, itemprice2, itemkey');
        $this->display('pricelist/views/index', $data);
    }

	function save() {
        $data = $_POST['price'];
        
        // Check what form is being saved
		if(isset($_POST['save-sidebar'])){
			
			/* Sidebar */

			$itempricelabel = $_POST['itempricelabel'];
			$itemprice2label = $_POST['itemprice2label'];
			$settings = array('itempricelabel' => $itempricelabel,
		            		  'itemprice2label' => $itemprice2label);
	
			if (Plugin::setAllSettings($settings, 'pricelist')) {
				Flash::set('success', 'Pricelist settings - '.__('plugin settings saved.'));
				redirect(get_url('plugin/pricelist'));
			} else {
				Flash::set('error', 'Pricelist settings - '.__('plugin settings not saved!'));
				redirect(get_url('plugin/pricelist'));
			}

		} else {
			
			/* Add Price */

	        if (empty($data['itemprice'])){
	            Flash::set('error', __('You have to specify a itemprice itemlabel.'));
	            redirect(get_url('plugin/pricelist/'));
	        }
	
	        $dataLabel = $data['itemlabel'];
	        $dataDesc = $data['itemdesc'];
	        $dataPrice = $data['itemprice'];
	        $dataPrice2 = $data['itemprice2'];
	        $dataKey = $data['itemkey'];
	
		    // Pricelist plugin settings
			if (Plugin::setAllSettings($settings, 'pricelist')){
		        Flash::set('success', __('Pricelist settings saved.'));
		    } else {
		        Flash::set('error', __('Pricelist settings not saved.'));
			}
	
			// Pricelist prices
			if ($existing_price = Record::findOneFrom('PricelistPrices', 'itemlabel = \''.($dataLabel.'\''))) {
				Record::update('PricelistPrices', array('itemlabel' => $dataLabel, 'itemdesc' => $dataDesc, 'itemprice' => $dataPrice, 'itemprice2' => $dataPrice2, 'itemkey' => $dataKey));
			} else {
	
				$data = array("itemlabel" => $dataLabel, "itemdesc" => $dataDesc, "itemprice" => $dataPrice, "itemprice2" => $dataPrice2, "itemkey" => $dataKey);
	
				$entry = new PricelistPrices($data);
	
				if (! $entry->save()){
		            Flash::set('error', __('There was a problem adding your price.'));
		        } else {
		            Flash::set('success', __('Price has been added.'));
		        }
			}

		}


		redirect(get_url('plugin/pricelist/'));
	}

	function remove($id) {

        /* Delete user */

        if ($price = Record::findByIdFrom('PricelistPrices', $id)){
            if ($price->delete()){
                Flash::set('success', __('Price has been deleted.'));
            }
            else
                Flash::set('error', __('There was a problem deleting this price.'));
        }
        else Flash::set('error', __('Price not found.'));

        redirect(get_url('plugin/pricelist/'));
	}
	
	function update() {
		
		// Remove price
		
		if (isset($_POST['remove'])) {

			//remove($_POST['prices_id']);
			redirect(get_url('plugin/pricelist/remove/'.$_POST['prices_id']));
			
		}

		// Update price

		if (!isset($_POST['update'])) {

			Flash::set('error', __('Price not found.'));

		} else {

			$id = $_POST['prices_id'];
	        $data = $_POST[$id];

	        if($data['itemlabel'] != ''){

				$prices = new PricelistPrices();
	
		        $prices->id = $id;
				$prices->itemlabel = $data['itemlabel'];
		        $prices->itemdesc = $data['itemdesc'];
		        $prices->itemprice = $data['itemprice'];
		        $prices->itemprice2 = $data['itemprice2'];
	
		        $prices->save();
	
		        Flash::set('success', __('Price has been updated.'));
		        //redirect(get_url('plugin/pricelist'));

			} else {

				Flash::set('success', __('Price label is required.'));

			}

		}

        redirect(get_url('plugin/pricelist/'));
	}

}
