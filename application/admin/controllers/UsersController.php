<?php
/**
 * ZRECommerce e-commerce web application.
 *
 * @author ZRECommerce
 *
 * @package Admin
 * @subpackage Admin_Users
 * @category Controllers
 *
 * @version $Id$
 * @copyright Copyrights 2008 ZRECommerce. See README file.
 * @license GPL v3 or higher. See README file.
 */

/**
 * UsersController - User administration controller
 *
 */
class Admin_UsersController extends Zend_Controller_Action {
	public function preDispatch() {
		$zend_auth = Zend_Auth::getInstance();
		$zend_auth->setStorage( new Zend_Auth_Storage_Session() );
		$settings = Zre_Config::getSettingsCached();

		if (!Zre_Template::isHttps() && $settings->site->enable_ssl == 'yes') {
			$this->_redirect('https://' . $settings->site->url . '/admin/', array('exit' => true));
		}

		// All pages here require a valid login. Kick out if invalid.
		if ( $zend_auth->hasIdentity() &&
			(Zre_Acl::isAllowed('users', 'view') ||
				Zre_Acl::isAllowed('administration', 'ALL')) ) {
//			Zend_Session::rememberUntil( (int)$settings->site->session_timeout );
		} else {
			$this->_redirect('/admin/login', array('exit'=>'true'));
		}

		$this->view->assign('enable_admin_menu', 1);

		Zre_Registry_Session::set('selectedMenuItem', 'Users');
		Zre_Registry_Session::save();
		$this->_helper->layout->disableLayout();
	}
	/**
	 * Default User administration page.
	 */
	public function indexAction() {
		// TODO Auto-generated UsersController::indexAction() default action
		$settings = Zre_Config::getSettingsCached();
		$pre = $settings->db->table_name_prepend;

		$t = Zend_Registry::get('Zend_Translate');
		$this->view->title = $t->_('User Profile');

		$users = new Zre_Dataset_UsersEx();
		$records = $users->getProfiles(null, null, $pre);

		$this->view->assign('records', $records);
	}
//	/**
//	 * Update user action.
//	 *
//	 */
//	public function updateAction() {
//		if (Zre_Acl::isAllowed('users', 'update')) {
//			$settings = Zre_Config::getSettingsCached();
//
//
//			$t = Zend_Registry::get('Zend_Translate');
//
//			$this->view->assign('enable_dojo', 1);
//			$this->view->title = $t->_('User Profile');
//
////			$right_column_entries = new Zre_Ui_Sidebar_Menu();
//			$user_form = new Zre_Ui_Form_Register(null, $this->getRequest());
//
//			$params = '';
//			$params_array = array(
//				'id' => $this->getRequest()->getParam('id'),
//				'start_index' => $this->getRequest()->getParam('start_index'),
//				'max_per_page' => $this->getRequest()->getParam('max_per_page')
//			);
//
//			// Grab our key/value POST vars, for use with our datagrid links.
//			foreach($params_array as $key => $value) {
//				$params .= '/'.$key . '/' . $value;
//			}
//			$url_params = $params;
//
//			$user_form->setAction('/admin/users/update'.$params);
//			$user_form->removeElement('captcha_field');
//			$user_form->removeElement('submit');
//
//			$select_role = new Zend_Dojo_Form_Element_RadioButton('role');
//			$select_role->setLabel('Select role');
//			$select_role->addMultiOptions(array(
//				'guest' => 'Guest',
//				'staff' => 'Staff',
//				'editor' => 'Editor',
//				'administrator' => 'Administrator'
//			));
//
//			$submit = new Zend_Dojo_Form_Element_SubmitButton('submit');
//			$submit->setLabel('Update');
//			$user_id_element = new Zend_Form_Element_Hidden('user_id');
//
//			$user_form->addElements(array($select_role, $user_id_element, $submit));
//			$user_form->getElement('password')->setRequired(false);
//			$user_form->getElement('retype_password')->setRequired(false);
//
//			$is_submitted = $this->getRequest()->getParam('is_submitted');
//			$params = $this->getRequest()->getParams();
//
//			if ($is_submitted) {
//				$updateResult = Zre_Dataset_Users::update( $params['user_id'], $params );
//
//				if ($updateResult === true) {
//					$data = Zre_Dataset_Users::read( $params['user_id'] );
//					$user_form->setDefaults( $data );
//
//					$this->_redirect('/admin/users/index/start_index/'.$params_array['start_index'].'/max_per_page/'.$params_array['max_per_page'].'');
//
//				} else {
//					// Display an error
//					$user_form->setDefaults( $params );
//					$this->view->assign('content', '<div class="errors">'.$t->_('Error:').' '.$t->_('Invalid user name. Please try a different one.').'</div>');
//
//				}
//			} else {
//				// Grab the selected user's profile info. Display it.
//				$user_id = $this->getRequest()->getParam('id');
//
//				$data = Zre_Dataset_users::read( $user_id );
//				unset($data['password']);
//				$user_form->setDefaults( $data );
//
//			}
//			$this->view->form = $user_form;
////			$this->view->assign('right_column', $right_column_entries->get());
//		} else {
//			$this->_redirect('/admin/', array('exit'=>'true'));
//		}
//	}
//	/**
//	 * Remove user action.
//	 *
//	 */
//	public function removeAction() {
//		if (Zre_Acl::isAllowed('users', 'remove')) {
//			$settings = Zre_Config::getSettingsCached();
//
//
//			$t = Zend_Registry::get('Zend_Translate');
//
//			$this->view->title = $t->_('User Profile');
//
//			$params = '';
//			$params_array = array(
//				'id' => $this->getRequest()->getParam('id'),
//				'start_index' => $this->getRequest()->getParam('start_index'),
//				'max_per_page' => $this->getRequest()->getParam('max_per_page')
//			);
//
//			foreach($params_array as $key => $value) {
//				$params .= '/'.$key . '/' . $value;
//			}
//
//			if ($this->getRequest()->getParam('is_submitted')) {
//				$id = $this->getRequest()->getParam('id');
//
//				switch($this->getRequest()->getParam('yes_no_abort')) {
//					case 'yes':
//						$usersDataset = new Zre_Dataset_Users();
//						$usersDataset->delete( $id );
//
//						$this->view->assign('content', '<div><b>'.$t->_('Ok:').'</b>Deleted user. <a href="/admin/users/index/start_index/'.$params_array['start_index'].'/max_per_page/'.$params_array['max_per_page'].'">Back to user listing.</a></div>');
//						break;
//					case 'no':
//						$this->view->assign('content', '<div><b>'.$t->_('Cancelled:').'</b> '.$t->_('No update was performed.').' <a href="/admin/users/index/start_index/'.$params_array['start_index'].'/max_per_page/'.$params_array['max_per_page'].'">'.$t->_('Continue').'</a></div>');
//						break;
//					default:
//						$this->_redirect('/admin/users/index/start_index/'.$params_array['start_index'].'/max_per_page/'.$params_array['max_per_page'].'');
//						break;
//				}
//
//			} else {
//				// Need to confirm action to avoid accidental deletes.
//				$form = new Zre_Ui_Form_Dialog_YesNoAbort();
//				$this->view->form = $form;
//			}
//		} else {
//			$this->_redirect('/admin/', array('exit'=>'true'));
//		}
//	}

	public function jsonListAction() {

		$request = $this->getRequest();
		$data = null;

		try {
			$t = Zend_Registry::get('Zend_Translate');
			$settings = Zre_Config::getSettingsCached();
			$pre = $settings->db->table_name_prepend;

			$dataset = new Zre_Dataset_UsersEx();

			$sort = $request->getParam('sort', 'name');
			$order = $request->getParam('order', 'ASC');
			$page = $request->getParam('pageIndex', 1);
			$rowCount = $request->getParam('rowCount', 5);

			$options = array(
				'order' => $sort . ' ' . $order,
				'limit' => array(
					'page' => $page,
					'rowCount' => $rowCount
				)
			);

			$totalRecords = $dataset->listAll(null, array(
				'from' => array(
					'name' => array('u' => $dataset->getModel()->info('name')),
					'cols' => array(new Zend_Db_Expr('COUNT(*)'))
				)
				), false)->current()->offsetGet('COUNT(*)');

			$records = $dataset->getProfiles(null, $options, $pre);

			$data = array(
				'result' => 'ok',
				'totalRows' => $totalRecords,
				'data' => $records
			);

		} catch (Exception $e) {
			$data = array(
				'result' => 'error',
				'data' => (string) $e
			);
			Debug::log((string) $e);
		}
		$this->_helper->json($data);
	}

	public function jsonCreateAction() {
		$request = $this->getRequest();
		$data = null;
		$reply = null;
		try {
			$users = new Zre_Dataset_UsersEx();
			$data = $users->createProfile($request->getParams());

			$reply = array(
				'result' => 'ok',
				'data' => $data
			);
		} catch (Exception $e) {
			Debug::log( var_export($request->getParams(), true) . "\n\n" . (string)$e);
			$reply = array(
				'result' => 'error',
				'data' => (string)$e
			);
		}

		$this->_helper->json($reply);
	}

	public function jsonUpdateAction() {
		$t = Zend_Registry::get('Zend_Translate');

		$request = $this->getRequest();
		$reply = null;

		try {
			$db = Zend_Db_Table::getDefaultAdapter();
			$dataset = new Zre_Dataset_UsersEx();

			$user_id	= $request->getParam('user_id', null);
			$first_name	= $request->getParam('first_name', null);
			$last_name	= $request->getParam('last_name', null);
			$date_of_birth	= $request->getParam('date_of_birth', null);

			$role		= $request->getParam('role', null);
			$email		= $request->getParam('email', null);
			
			$password	= $request->getParam('password', null);
			$password_match = $request->getParam('password_match', null);

			if (isset($password) && !empty($password)) {
				if ($password == $password_match) {

					$updateData = array(
						'password' => new Zend_Db_Expr('MD5(' . $db->quote($password)  . ')')
					);

					$result = $dataset->update(
						$updateData,
						$user_id
					);

					$reply = array(
						'result' => 'ok',
						'product_id' => $user_id,
						'data' => $result
					);

				} else {
					throw new Exception( $t->_('Passwords do not match') );
				}
			} else {
				if (!isset($user_id)) throw new Zend_Exception( $t->_('No user ID specified.') );

				$updateData = array(
					'first_name' => $first_name,
					'last_name' => $last_name,
					'date_of_birth' => $date_of_birth,
					'role' => $role,
					'email' => $email,
					'city' => $city,
					'state_province' => $state,
					'zipcode' => $zipcode
				);

				$result = $dataset->updateProfile(
					$updateData,
					$user_id
				);

				$reply = array(
					'result' => 'ok',
					'user_id' => $user_id,
					'data' => $result
				);
			}
		} catch (Exception $e) {
			Debug::log((string) $e);
			
			$reply = array(
				'result' => 'error',
				'user_id' => $user_id,
				'data' => (string) $e->getMessage()
			);
		}

		$this->_helper->json($reply);
	}
}