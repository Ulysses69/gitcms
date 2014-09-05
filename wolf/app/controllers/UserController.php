<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008,2009,2010 Martijn van der Kleijn <martijn.niji@gmail.com>
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
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @copyright Martijn van der Kleijn, 2008,2009,2010
 * @copyright Philippe Archambault, 2008
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 *
 * @version $Id: UserController.php 187 2010-03-22 00:58:30Z martijn.niji@gmail.com $
 */

/**
 * Class UserController
 *
 * @package wolf
 * @subpackage controllers
 *
 * @since 0.1
 */
class UserController extends Controller {

	public function __construct() {
		AuthUser::load();
		if (!AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}

		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('user/sidebar'));
	}

	public function index() {
		if (!AuthUser::hasPermission('administrator')) {
			Flash::set('error', __('You do not have permission to access the requested page!'));

			if (Setting::get('default_tab') === 'user') {
				redirect(get_url('page'));
			}
			else {
				redirect(get_url());
			}
		}

		$this->display('user/index', array(
			'users' => User::findAll()
		));
	}

	public function add() {
		if (!AuthUser::hasPermission('administrator')) {
			Flash::set('error', __('You do not have permission to access the requested page!'));
			redirect(get_url());
		}

		// check if trying to save
		if (get_request_method() == 'POST') {
			return $this->_add();
		}

		// check if user have already enter something
		$user = Flash::get('post_data');

		if (empty($user)) {
			$user = new User;
			$user->language = Setting::get('language');
		}

		$this->display('user/edit', array(
			'action' => 'add',
			'csrf_token' => SecureToken::generateToken(BASE_URL.'user/add'),
			'user' => $user,
			'permissions' => Record::findAllFrom('Permission')
		));
	}

	private function _add() {
		use_helper('Validate');
		$data = $_POST['user'];

		// Add pre-save checks here
		$errors = false;

		// CSRF checks
		if (isset($_POST['csrf_token'])) {
			$csrf_token = $_POST['csrf_token'];
			if (!SecureToken::validateToken($csrf_token, BASE_URL.'user/add')) {
				Flash::set('error', __('Invalid CSRF token found!'));
				redirect(get_url('user/add'));
			}
		}
		else {
			Flash::set('error', __('No CSRF token found!'));
			redirect(get_url('user/add'));
		}

		// check if pass and confirm are equal and >= 5 chars
		if (strlen($data['password']) >= 5 && $data['password'] == $data['confirm']) {
			//$data['password'] = sha1($data['password']);
			unset($data['confirm']);
		}
		else {
			Flash::set('error', __('Password and Confirm are not the same or too small!'));
			redirect(get_url('user/add'));
		}

		// check if username >= 3 chars
		if (strlen($data['username']) < 3) {
			Flash::set('error', __('Username must contain a minimum of 3 characters!'));
			redirect(get_url('user/add'));
		}

		// check if username != password
		if ($data['username'] == $data['password']) {
			Flash::set('error', __('The password must not be the same as the username!'));
			redirect(get_url('user/add'));
		}

		// Check alphanumerical fields
		$fields = array('username', 'name');
		foreach ($fields as $field) {
			if (!empty($data[$field]) && !Validate::alphanum_space($data[$field])) {
				$errors[] = __('Illegal value for :fieldname field!', array(':fieldname' => $field));
				// Reset to prevent XSS
				$data[$field] = '';
			}
		}

		if (!empty($data['email']) && !Validate::email($data['email'])) {
			$errors[] = __('Illegal value for :fieldname field!', array(':fieldname' => 'email'));
			// Reset to prevent XSS
			$data['email'] = '';
		}

		if (!empty($data['avatar'])) {
			$errors[] = __('Illegal value for :fieldname field!', array(':fieldname' => 'avatar'));
			// Reset to prevent XSS
			$data['avatar'] = '';
		}

		if (!empty($data['language']) && !Validate::alpha($data['language'])) {
			$errors[] = __('Illegal value for :fieldname field!', array(':fieldname' => 'language'));
			// Reset to prevent XSS
			// @todo Remove hardcoded reset to 'en' language
			$data['language'] = 'en';
		}

		Flash::set('post_data', (object) $data);

		if ($errors !== false) {
			// Set the errors to be displayed.
			Flash::set('error', implode('<br/>', $errors));
			redirect(get_url('user/add'));
		}

		$user = new User($data);

		// Generate a salt and create encrypted password
		$user->salt = AuthUser::generateSalt();
		$user->password = sha1($user->password.$user->salt);
		//$user->password = AuthUser::generateHashedPassword($user->password, $user->salt);

		if ($user->save()) {
			// now we need to add permissions if needed
			if (!empty($_POST['user_permission']))
				UserPermission::setPermissionsFor($user->id, $_POST['user_permission']);

			Flash::set('success', __('User has been added!'));
			Observer::notify('user_after_add', $user->name);
		}
		else {
			Flash::set('error', __('User has not been added!'));
		}

		redirect(get_url('user'));
	}

	public function edit($id) {
		if (AuthUser::getId() != $id && ! AuthUser::hasPermission('administrator')) {
			Flash::set('error', __('You do not have permission to access the requested page!'));
			redirect(get_url());
		}

		// check if trying to save
		if (get_request_method() == 'POST') {
			return $this->_edit($id);
		}

		if ($user = User::findById($id)) {
			$this->display('user/edit', array(
				'action' => 'edit',
				'csrf_token' => SecureToken::generateToken(BASE_URL.'user/edit'),
				'user' => $user,
				'permissions' => Record::findAllFrom('Permission')
			));
		}
		else {
			Flash::set('error', __('User not found!'));
		}

		redirect(get_url('user'));

	} // edit

	private function _edit($id) {
		use_helper('Validate');
		$data = $_POST['user'];
		Flash::set('post_data', (object) $data);

		// Add pre-save checks here
		$errors = false;

		// CSRF checks
		if (isset($_POST['csrf_token'])) {
			$csrf_token = $_POST['csrf_token'];
			if (!SecureToken::validateToken($csrf_token, BASE_URL.'user/edit')) {
				Flash::set('error', __('Invalid CSRF token found!'));
				redirect(get_url('user/add'));
			}
		}
		else {
			Flash::set('error', __('No CSRF token found!'));
			redirect(get_url('user/edit'));
		}

		// check if user want to change the password
		if (strlen($data['password']) > 0) {
			// check if pass and confirm are egal and >= 5 chars
			if (strlen($data['password']) >= 5 && $data['password'] == $data['confirm']) {
				unset($data['confirm']);
			}
			else {
				Flash::set('error', __('Password and Confirm are not the same or too small!'));
				redirect(get_url('user/edit/'.$id));
			}
		}
		else {
			unset($data['password'], $data['confirm']);
		}

		// Check alphanumerical fields
		$fields = array('username', 'name');
		foreach ($fields as $field) {
			if (!empty($data[$field]) && !Validate::alphanum_space($data[$field])) {
				$errors[] = __('Illegal value for :fieldname field!', array(':fieldname' => $field));
			}
		}

		if (!empty($data['email']) && !Validate::email($data['email'])) {
			$errors[] = __('Illegal value for :fieldname field!', array(':fieldname' => 'email'));
		}

		if (!empty($data['language']) && !Validate::alpha($data['language'])) {
			$errors[] = __('Illegal value for :fieldname field!', array(':fieldname' => 'language'));
		}

		if ($errors !== false) {
			// Set the errors to be displayed.
			Flash::set('error', implode('<br/>', $errors));
			redirect(get_url('user/edit/'.$id));
		}

		$user = Record::findByIdFrom('User', $id);
		if (isset($data['password'])) {
			//if (empty($user->salt)) {
			//	$user->salt = AuthUser::generateSalt();
			//}
			
			$data['password'] = sha1($data['password'].$user->salt);
			//$data['password'] = AuthUser::generateHashedPassword($data['password'], $user->salt);
		}

		$user->setFromData($data);

		if ($user->save()) {
			if (AuthUser::hasPermission('administrator')) {
				// now we need to add permissions
				$data = isset($_POST['user_permission']) ? $_POST['user_permission']: array();
				UserPermission::setPermissionsFor($user->id, $data);
			}

			Flash::set('success', __('User has been saved!'));
			Observer::notify('user_after_edit', $user->name);
		}
		else {
			Flash::set('error', __('User has not been saved!'));
		}

		if (AuthUser::getId() == $id) {
			redirect(get_url('user/edit/'.$id));
		}
		else {
			redirect(get_url('user'));
		}

	}

	public function delete($id) {
		if (!AuthUser::hasPermission('administrator')) {
			Flash::set('error', __('You do not have permission to access the requested page!'));
			redirect(get_url());
		}

		// Sanity checks
		use_helper('Validate');
		if (!Validate::numeric($id)) {
			Flash::set('error', __('Invalid input found!'));
			redirect(get_url());
		}
		
		// CSRF checks
		if (isset($_GET['csrf_token'])) {
			$csrf_token = $_GET['csrf_token'];
			if (!SecureToken::validateToken($csrf_token, BASE_URL.'user/delete/'.$id)) {
				Flash::set('error', __('Invalid CSRF token found!'));
				redirect(get_url('user'));
			}
		}
		else {
			Flash::set('error', __('No CSRF token found!'));
			redirect(get_url('user'));
		}

		// security (dont delete the first admin)
		if ($id > 1) {
			// find the user to delete
			if ($user = Record::findByIdFrom('User', $id)) {
				if ($user->delete()) {
					Flash::set('success', __('User <strong>:name</strong> has been deleted!', array(':name' => $user->name)));
					Observer::notify('user_after_delete', $user->name);
				}
				else {
					Flash::set('error', __('User <strong>:name</strong> has not been deleted!', array(':name' => $user->name)));
				}
			}
			else {
				Flash::set('error', __('User not found!'));
			}
		}
		else {
			Flash::set('error', __('Action disabled!'));
		}

		redirect(get_url('user'));
	}

}