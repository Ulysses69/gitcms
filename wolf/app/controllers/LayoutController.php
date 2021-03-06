<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2009 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */

/**
 * @package wolf
 * @subpackage controllers
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */

/**
 * Class LayoutController
 *
 * @package wolf
 * @subpackage controllers
 *
 * @version 0.1
 * @since 0.1
 */

class LayoutController extends Controller {

	function __construct() {
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}
		else {
			if ( ! AuthUser::hasPermission('administrator') && ! AuthUser::hasPermission('developer')) {
				Flash::set('error', __('You do not have permission to access the requested page!'));

				if (Setting::get('default_tab') === 'layout')
					redirect(get_url('page'));
				else
					redirect(get_url());
			}
		}

		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('layout/sidebar'));
	}

	function index() {
		$this->display('layout/index', array(
			'layouts' => Record::findAllFrom('Layout', '1=1 ORDER BY position')
		));
	}

	function add() {
	// check if trying to save
		if (get_request_method() == 'POST')
			return $this->_add();

		// check if user have already enter something
		$layout = Flash::get('post_data');

		if (empty($layout))
			$layout = new Layout;

		$this->display('layout/edit', array(
			'action'  => 'add',
			'csrf_token' => SecureToken::generateToken(BASE_URL.'layout/add'),
			'layout' => $layout
		));
	}

	function _add() {
		$data = $_POST['layout'];
		Flash::set('post_data', (object) $data);

		if (empty($data['name'])) {
			Flash::set('error', __('You have to specify a name!'));
			redirect(get_url('layout/add'));
		}

		if (empty($data['content_type'])) {
			Flash::set('error', __('You have to specify a content-type!'));
			redirect(get_url('layout/add'));
		}

		$layout = new Layout($data);

		if ( ! $layout->save()) {
			Flash::set('error', __('Layout has not been added. Name must be unique!'));
			redirect(get_url('layout/add'));
		}
		else {
			Flash::set('success', __('Layout has been added!'));
			Observer::notify('layout_after_add', $layout);
		}

		// save and quit or save and continue editing?
		if (isset($_POST['commit']))
			redirect(get_url('layout'));
		else
			redirect(get_url('layout/edit/'.$layout->id));
	}

	function edit($id) {
		if ( ! $layout = Layout::findById($id)) {
			Flash::set('error', __('Layout not found!'));
			redirect(get_url('layout'));
		}

		// check if trying to save
		if (get_request_method() == 'POST')
			return $this->_edit($id);

		// display things...
		$this->display('layout/edit', array(
			'action'  => 'edit',
			'csrf_token' => SecureToken::generateToken(BASE_URL.'layout/edit/'.$layout->id),
			'layout' => $layout
		));
	}

	function _edit($id) {
		$layout = Record::findByIdFrom('Layout', $id);
		$layout->setFromData($_POST['layout']);

		if ( ! $layout->save()) {
			Flash::set('error', __('Layout has not been saved. Name must be unique!'));
			redirect(get_url('layout/edit/'.$id));
		}
		else {
			Flash::set('success', __('Layout has been saved!'));
			Observer::notify('layout_after_edit', $layout);
		}

		// save and quit or save and continue editing?
		if (isset($_POST['commit']))
			redirect(get_url('layout'));
		else
			redirect(get_url('layout/edit/'.$id));
	}

	function delete($id) {

		// CSRF checks
		/*
		if (isset($_GET['csrf_token'])) {
			$csrf_token = $_GET['csrf_token'];
			if (!SecureToken::validateToken($csrf_token, BASE_URL.'layout/delete/'.$id)) {
				Flash::set('error', __('Invalid CSRF token found!'));
				redirect(get_url('layout'));
			}
		}
		else {
			Flash::set('error', __('No CSRF token found!'));
			redirect(get_url('layout'));
		}
		*/


	// find the layout to delete
		if ($layout = Record::findByIdFrom('Layout', $id)) {
			if ($layout->isUsed())
				Flash::set('error', __('Layout <b>:name</b> is in use! It CAN NOT be deleted!', array(':name'=>$layout->name)));
			else if ($layout->delete()) {
					Flash::set('success', __('Layout <b>:name</b> has been deleted!', array(':name'=>$layout->name)));
					Observer::notify('layout_after_edit', $layout);
				}
				else
					Flash::set('error', __('Layout <b>:name</b> has not been deleted!', array(':name'=>$layout->name)));
		}
		else Flash::set('error', __('Layout not found!'));

		redirect(get_url('layout'));
	}

	function reorder() {
		parse_str($_POST['data']);

		foreach ($layouts as $position => $layout_id) {
			$layout = Record::findByIdFrom('Layout', $layout_id);
			$layout->position = (int) $position + 1;
			$layout->save();
		}
	}

} // end LayoutController class
