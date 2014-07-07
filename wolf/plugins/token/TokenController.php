<?php

/*
 * Token - Wolf CMS URL token plugin
 *
 * Copyright (c) 2012 Steven Henderson
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 *
 */

class TokenController extends PluginController {
    public function __construct(){
        /*
		AuthUser::load();
        if ( ! AuthUser::isLoggedIn()) {
            redirect(get_url('login'));
        }
        */
        $this->setLayout('backend');
        $this->assignToLayout('sidebar', new View('../../plugins/token/views/sidebar'));
    }

    public function index(){

		// load tokens
		$data['current_tokens'] = Record::findAllFrom('TokenTokens', 'true ORDER BY literal_main, literal_mobile, placeholder');
        if (!$data) {
            Flash::set('error', 'Tokens - '.__('unable to retrieve plugin data.'));
            return;
        }
		$this->display('token/views/index', $data);
		//$this->display('token/views/index');
    }


	public function save(){

        $data = $_POST['token'];

        if (empty($data['placeholder'])){
            Flash::set('error', __('You have to specify a name!'));
            redirect(get_url('plugin/token/'));
        }

        if (empty($data['literal_main']) || empty($data['literal_mobile'])){
			//if (empty($data['literal_main'])){
	            Flash::set('error', __('You have to specify a value!'));
	            redirect(get_url('plugin/token/'));
	        //}
	        //if (empty($data['literal_mobile'])){
	        //    Flash::set('error', __('You have to specify a value!'));
	        //    redirect(get_url('plugin/token/'));
	        //}
		}
		
		if ($existing_token = Record::findOneFrom('TokenTokens', 'placeholder = \''.($data['placeholder'].'\''))) {
			Record::update('TokenTokens', array('placeholder' => $data['placeholder'], 'literal_main' => $data['literal_main'], 'literal_mobile' => $data['literal_mobile']), 'placeholder = \''.($data['placeholder'].'\''));
		} else {
			$entry = new TokenTokens($data);
			
			if (!$entry->save()){
	            Flash::set('error', __('There was a problem adding your token.'));
	        } else {

	            Flash::set('success', __('Token has been added!'));
	        }
		}
		
        redirect(get_url('plugin/token/'));

	}

	public function remove($id) {
        // find the user to delete
        if ($token = Record::findByIdFrom('TokenTokens', $id)){
            if ($token->delete()) {
                Flash::set('success', __('Token has been deleted!'));
            } else {
                Flash::set('error', __('There was a problem deleting this token!'));
			}
        } else {
			Flash::set('error', __('Token not found!'));
		}

        redirect(get_url('plugin/token/'));	

	}

}