<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Auth extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');

		if ($this->is_partnertoys) :
			$this->load->model('auth_model');
		endif;
	}

	public function index()
	{
		if ($this->is_partnertoys) :
			$this->data['title'] = '會員專區';

			if (empty($this->session->userdata('user_id'))) :
				$this->data['auth_category'] = $this->auth_model->getAuthVisiterCategory();
			else :
				// 抓使用者資料
				$id = $this->session->userdata('user_id');
				$user = $this->ion_auth->user($id)->row();
				$this->data['user'] = $user;
				$this->data['order'] = $this->auth_model->getOrders($id);
				$this->data['order_item'] = $this->auth_model->getOrderItem($id);
				$this->data['auth_category'] = $this->auth_model->getAuthMemberCategory();
			endif;
			$this->render('auth/partnertoys_index');
		endif;
	}

	public function cancel_order($id)
	{
		$this->load->model('checkout_model');
		$sel = $this->checkout_model->getSelectedOrder($id);
		if (isset($sel)) :
			$this->db->select('order_id, order_step');
			$this->db->where('order_id', $id);
			$query = $this->db->get('orders');
			if ($query->num_rows() === 1) {
				$this->db->update('orders', ['order_step' => 'cancel'], ['order_id' => $id]);
			}
			echo 'successful';
		else :
			echo 'unsuccessful';
		endif;
	}

	/**
	 * FB_Log the user in
	 */
	public function FB_login()
	{
		$this->load->model('ion_auth_model');
		// 讀取 POST 資料
		$post_data = file_get_contents("php://input");

		// 解析 JSON 資料
		$user_data = json_decode($post_data, true);

		if ($user_data['accessToken'] != null && $user_data['email'] != null && $user_data['name'] != null && $user_data['userID'] != null) {
			// $user_data 包含從前端傳來的使用者資訊
			// echo json_encode($user_data);
			if ($this->ion_auth_model->FB_acesses($user_data)) :
				echo json_encode('successful');
			else :
				echo json_encode('unsuccessful');
			endif;
		} else {
			echo json_encode('unsuccessful');
		}
	}

	/**
	 * Log the user in
	 */
	public function login()
	{
		$this->data['title'] = $this->lang->line('login_heading');

		// validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() === TRUE) {
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				// echo '<script>alert("登入成功");</script>';
				redirect('/', 'refresh');
			} else {
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());

				if ($this->is_partnertoys) {
					$this->session->set_flashdata('loginMessage', $this->ion_auth->errors());
					$this->session->set_flashdata('identity', $this->input->post('identity'));
					redirect('auth/index?id=1', 'refresh');
				}
				redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		} else {
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = [
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			];

			$this->data['password'] = [
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
			];

			if ($this->is_partnertoys) {
				$this->session->set_flashdata('loginMessage', (validation_errors()) ? validation_errors() : $this->session->flashdata('loginMessage'));
				$this->session->set_flashdata('identity', $this->input->post('identity'));
				redirect('auth/index?id=1', 'refresh');
			}

			$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'login', $this->data);
		}
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		// log the user out
		$this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());

		// redirect home page
		redirect(base_url(), 'refresh');
	}

	/**
	 * Change password
	 */
	public function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in()) {
			if ($this->is_partnertoys) {
				$this->session->set_flashdata('changePasswordMessage', '<br>FB登入者無法使用此功能<br><br>');
				redirect('auth/index?id=6', 'refresh');
			}
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() === FALSE) {
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = [
				'name' => 'old',
				'id' => 'old',
				'type' => 'password',
			];
			$this->data['new_password'] = [
				'name' => 'new',
				'id' => 'new',
				'type' => 'password',
				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
			];
			$this->data['new_password_confirm'] = [
				'name' => 'new_confirm',
				'id' => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
			];
			$this->data['user_id'] = [
				'name' => 'user_id',
				'id' => 'user_id',
				'type' => 'hidden',
				'value' => $user->id,
			];

			// render
			// $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'change_password', $this->data);
			if ($this->is_partnertoys) {
				$this->session->set_flashdata('changePasswordMessage', (validation_errors()) ? validation_errors() : $this->session->flashdata('changePasswordMessage'));
				redirect('auth/index?id=6', 'refresh');
			}
			$this->render('auth/change_password', 'admin_master');
		} else {
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change) {
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				if ($this->is_partnertoys) {
					$this->session->set_flashdata('changePasswordMessage', $this->ion_auth->errors());
					redirect('auth/index?id=6', 'refresh');
				}
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	/**
	 * Forgot password
	 */
	public function forgot_password()
	{
		$this->data['page_title'] = '忘記密碼';

		// setting validation rules by checking whether identity is username or email
		if ($this->config->item('identity', 'ion_auth') != 'email') {
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		} else {
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}

		if ($this->form_validation->run() === FALSE) {
			$this->data['type'] = $this->config->item('identity', 'ion_auth');
			// setup the input
			$this->data['identity'] = [
				'name' => 'identity',
				'id' => 'identity',
			];

			if ($this->config->item('identity', 'ion_auth') != 'email') {
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			} else {
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			// $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'forgot_password', $this->data);
			if ($this->is_partnertoys) {
				$this->session->set_flashdata('forgotMessage', (validation_errors()) ? validation_errors() : $this->session->flashdata('forgotMessage'));
				redirect('auth/index?id=3', 'refresh');
			}
			$this->render('auth/forgot_password');
		} else {
			$identity_column = $this->config->item('identity', 'ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();
			$identity2 = $this->ion_auth->where('email', $this->input->post('identity'))->users()->row();

			if (empty($identity) && empty($identity2)) {

				if ($this->config->item('identity', 'ion_auth') != 'email') {
					$this->ion_auth->set_error('forgot_password_identity_not_found');
				} else {
					$this->ion_auth->set_error('forgot_password_email_not_found');
				}

				$this->session->set_flashdata('message', $this->ion_auth->errors());
				if ($this->is_partnertoys) {
					$this->session->set_flashdata('forgotMessage', $this->ion_auth->errors());
					redirect('auth/index?id=3', 'refresh');
				}
				redirect("forgot_password", 'refresh');
			}

			// run the forgotten password method to email an activation code to the user
			if (!empty($identity)) {
				$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
			}
			if (!empty($identity2)) {
				$forgotten = $this->ion_auth->forgotten_password($identity2->email);
			}

			if ($forgotten) {
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				if ($this->is_partnertoys) {
					echo '<script>alert("已發送認證信");</script>';
					redirect("auth", 'refresh');
				}
				redirect("login", 'refresh'); //we should display a confirmation page here instead of the login page
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				if ($this->is_partnertoys) {
					$this->session->set_flashdata('forgotMessage', $this->ion_auth->errors());
					redirect('auth/index?id=3', 'refresh');
				}
				redirect("forgot_password", 'refresh');
			}
		}
	}

	/**
	 * Reset password - final step for forgotten password
	 *
	 * @param string|null $code The reset code
	 */
	public function reset_password($code = NULL)
	{
		if (!$code) {
			show_404();
		}

		$this->data['title'] = $this->lang->line('reset_password_heading');

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user) {
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() === FALSE) {
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = [
					'name' => 'new',
					'id' => 'new',
					'type' => 'password',
					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
					'class' => 'form-control',
				];
				$this->data['new_password_confirm'] = [
					'name' => 'new_confirm',
					'id' => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
					'class' => 'form-control',
				];
				$this->data['user_id'] = [
					'name' => 'user_id',
					'id' => 'user_id',
					'type' => 'hidden',
					'value' => $user->id,
					'class' => 'form-control',
				];
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				// render
				// $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'reset_password', $this->data);
				$this->render('auth/reset_password');
			} else {
				$identity = $user->{$this->config->item('identity', 'ion_auth')};

				// do we have a valid request?
				// if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				// {

				// 	// something fishy might be up
				// 	$this->ion_auth->clear_forgotten_password_code($identity);

				// 	show_error($this->lang->line('error_csrf'));

				// }
				// else
				// {
				// finally change the password
				$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

				if ($change) {
					// if the password was successfully changed
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect("login", 'refresh');
				} else {
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect('auth/reset_password/' . $code, 'refresh');
				}
				// }
			}
		} else {
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("/forgot_password", 'refresh');
		}
	}

	/**
	 * Activate the user
	 *
	 * @param int         $id   The user ID
	 * @param string|bool $code The activation code
	 */
	public function activate($id, $code = FALSE)
	{
		$activation = FALSE;

		if ($code !== FALSE) {
			$activation = $this->ion_auth->activate($id, $code);
		} else if ($this->ion_auth->is_admin()) {
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation) {
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		} else {
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	/**
	 * Deactivate the user
	 *
	 * @param int|string|null $id The user ID
	 */
	public function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			// redirect them to the home page because they must be an administrator to view this
			show_error('You must be an administrator to view this page.');
		}

		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() === FALSE) {
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			// $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'deactivate_user', $this->data);
			$this->render('auth/deactivate_user', 'admin_master');
		} else {
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes') {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	// create a new user
	public function create_user()
	{
		$this->data['page_title'] = '會員註冊';

		// if ($this->ion_auth->logged_in())
		// {
		//     redirect($_SERVER['HTTP_REFERER']);
		// }

		// echo '<script>alert("' . $this->input->post('captcha') . '")</script>';
		// echo '<script>alert("' . $this->input->post('sex') . '")</script>';

		if ($this->is_partnertoys && empty($this->input->post('checkcode'))) {
			$this->session->set_flashdata('form_values', $this->input->post());
			$this->session->set_flashdata('registerMessage', '<br>【驗證碼】欄位為必填項目<br><br>');
			redirect('auth/index?id=2', 'refresh');
		} elseif (!empty($this->input->post('checkcode')) && !empty($this->input->post('captcha'))) {
			$checkcode = $this->input->post('checkcode');
			$captcha = $this->input->post('captcha');
			if ($checkcode != $captcha) {
				$this->session->set_flashdata('form_values', $this->input->post());
				$this->session->set_flashdata('registerMessage', '<br>【驗證碼錯誤】請重新填寫驗證碼<br><br>');
				redirect('auth/index?id=2', 'refresh');
			}
		}

		if ($this->is_partnertoys && empty($this->input->post('sex'))) {
			$this->session->set_flashdata('form_values', $this->input->post());
			$this->session->set_flashdata('registerMessage', '<br>【性別】欄位為必填項目<br><br>');
			redirect('auth/index?id=2', 'refresh');
		}

		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;

		// validate form input
		if ($identity_column !== 'email') {
			$this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
		} else {
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
		}
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->form_validation->run() == true) {
			$gender = ($this->input->post('sex') == '女' ? 'Female' : 'Male');
			$email = strtolower($this->input->post('email'));
			$identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
			$password = $this->input->post('password');
			$full_name = $this->input->post('name');
			$group = array('2');

			$additional_data = array(
				'gender'	   => $gender,
				'full_name'    => $full_name,
				'phone'        => $this->input->post('identity'),
				'creator_id'   => 0,
				'created_at'   => date('Y-m-d H:i:s'),
			);
		}
		if ($this->form_validation->run() == true && $id = $this->ion_auth->register($identity, $password, $email, $additional_data, $group)) {
			// 註冊成功時，登入
			$remember = true;
			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
				//if the login is successful
				$data = array(
					'ip_address' => $this->input->ip_address(),
					'user_id' => $this->ion_auth->user()->row()->id,
					'datetime' => date('Y-m-d H:i:s'),
				);
				$this->db->insert('login_log', $data);
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				echo '<script>alert("成功加入會員");</script>';
				redirect('/', 'refresh');
				// if ($this->input->post('now_url') != '') {
				// 	if ($this->input->post('now_url') == base_url() . '/register' || $this->input->post('now_url') == base_url() . '/register/') {
				// 		redirect(base_url(), 'refresh');
				// 	} else {
				// 		redirect($this->input->post('now_url') . '?ajax_register=yes');
				// 	}
				// } else {
				// 	redirect($_SERVER['HTTP_REFERER']);
				// }
			} else {
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				if ($this->is_partnertoys) {
					$this->session->set_flashdata('form_values', $this->input->post());
					$this->session->set_flashdata('registerMessage', $this->ion_auth->errors());
					redirect('auth/index?id=2', 'refresh');
				}
				redirect('register', 'refresh');
			}
		} else {
			// display the create user form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
				'class' => 'form-control',
			);
			$this->data['email'] = array(
				'name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email'),
				'class' => 'form-control',
			);
			$this->data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password'),
				'class' => 'form-control',
			);
			$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id' => 'password_confirm',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
				'class' => 'form-control',
			);

			//$this->_render_page('auth/create_user', $this->data);
			if ($this->is_partnertoys) {
				$this->session->set_flashdata('form_values', $this->input->post());
				$this->session->set_flashdata('registerMessage', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('registerMessage'))));
				redirect('auth/index?id=2', 'refresh');
			}
			$this->render('auth/register');
		}
	}

	// edit a user
	public function edit_user()
	{
		$this->data['page_title'] = '編輯個人資料';

		// $id = $this->ion_auth->user()->row()->id;
		$id = $this->session->userdata('user_id');
		// if (!$this->ion_auth->logged_in() && !$this->ion_auth->user()->row()->id == $id)
		if (!$this->ion_auth->logged_in()) {
			redirect('/login', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		if (isset($_POST) && !empty($_POST)) {
			// do we have a valid request?
			// if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			// if ($id != $this->input->post('id'))
			// {
			// 	show_error($this->lang->line('error_csrf'));
			// }

			// update the password if it was posted
			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			// if ($this->form_validation->run() === TRUE)
			// {
			$data = array(
				'full_name' => $this->input->post('full_name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'county' => $this->input->post('county'),
				'district' => $this->input->post('district'),
				'address' => $this->input->post('address'),
				'birthday' => $this->input->post('birthday'),
				'updater_id' => $this->ion_auth->user()->row()->id,
				'updated_at' => date('Y-m-d H:i:s'),
			);

			// update the password if it was posted
			if ($this->input->post('password')) {
				$data['password'] = $this->input->post('password');
			}

			// Only allow updating groups if user is admin
			if ($this->ion_auth->is_admin()) {
				// Update the groups user belongs to
				$groupData = $this->input->post('groups');

				if (isset($groupData) && !empty($groupData)) {

					$this->ion_auth->remove_from_group('', $id);

					foreach ($groupData as $grp) {
						$this->ion_auth->add_to_group($grp, $id);
					}
				}
			}

			// check to see if we are updating the user
			if ($this->ion_auth->update($user->id, $data)) {
				// redirect them back to the admin page if admin, or to the base url if non admin
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				if ($this->is_partnertoys) {
					echo '<script>alert("修改成功");</script>';
					redirect('auth/index?id=5', 'refresh');
				}
				if ($this->ion_auth->is_admin()) {
					// redirect('/auth', 'refresh');
					redirect($_SERVER['HTTP_REFERER']);
				} else {
					// redirect('/', 'refresh');
					redirect($_SERVER['HTTP_REFERER']);
				}
			} else {
				// redirect them back to the admin page if admin, or to the base url if non admin
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				if ($this->is_partnertoys) {
					$this->session->set_flashdata('editMessage', $this->ion_auth->errors());
					redirect('auth/index?id=5', 'refresh');
				}
				if ($this->ion_auth->is_admin()) {
					// redirect('/auth', 'refresh');
					redirect($_SERVER['HTTP_REFERER']);
				} else {
					// redirect('/', 'refresh');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
			// }
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['password'] = array(
			'name' => 'password',
			'id' => 'password',
			'type' => 'password',
			'class' => 'form-control',
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id' => 'password_confirm',
			'type' => 'password',
			'class' => 'form-control',
		);

		//$this->_render_page('auth/edit_user', $this->data);
		$this->render('auth/edit_user');
	}

	// join a user
	public function join_user()
	{
		$order_id = decode($this->input->post('order_id'));
		$this->db->select('customer_id,customer_name,customer_phone,customer_email');
		$this->db->where('order_id', $order_id);
		$this->db->limit(1);
		$o_row = $this->db->get('orders')->row_array();
		if (!empty($o_row)) {
			$user = $this->ion_auth->user($o_row['customer_id'])->row();
			if (isset($_POST) && !empty($_POST)) {
				$data = array(
					'join_status' => 'IsJoin',
					'full_name' => $o_row['customer_name'],
					'email' => $o_row['customer_email'],
					'phone' => $o_row['customer_phone'],
					'password' => $this->input->post('password'),
					'updated_at' => date('Y-m-d H:i:s'),
				);
				if ($this->ion_auth->update($user->id, $data)) {
					echo 'yes';
					return;
				} else {
					echo 'no';
					return;
				}
			}
			echo 'no';
			return;
		} else {
			echo 'error';
			return;
		}
	}

	/**
	 * Create a new group
	 */
	public function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			redirect('auth', 'refresh');
		}

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required|alpha_dash');

		if ($this->form_validation->run() === TRUE) {
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if ($new_group_id) {
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		} else {
			// display the create group form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = [
				'name' => 'group_name',
				'id' => 'group_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			];
			$this->data['description'] = [
				'name' => 'description',
				'id' => 'description',
				'type' => 'text',
				'value' => $this->form_validation->set_value('description'),
			];

			// $this->_render_page('auth/create_group', $this->data);
			$this->render('auth/create_group', 'admin_master');
		}
	}

	/**
	 * Edit a group
	 *
	 * @param int|string $id
	 */
	public function edit_group($id)
	{
		// bail if no group id given
		if (!$id || empty($id)) {
			redirect('auth', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if (isset($_POST) && !empty($_POST)) {
			if ($this->form_validation->run() === TRUE) {
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if ($group_update) {
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				} else {
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['group'] = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$this->data['group_name'] = [
			'name' => 'group_name',
			'id' => 'group_name',
			'type' => 'text',
			'value' => $this->form_validation->set_value('group_name', $group->name),
			$readonly => $readonly,
		];
		$this->data['group_description'] = [
			'name' => 'group_description',
			'id' => 'group_description',
			'type' => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		];

		// $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'edit_group', $this->data);
		$this->render('auth/edit_group', 'admin_master');
	}

	public function identity_check()
	{
		if ($this->ion_auth_model->identity_check($this->input->get('identity'))) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function email_check()
	{
		if ($this->ion_auth->email_check($this->input->get('email'))) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function identity_check_with_id()
	{
		echo $this->db->where('username', $this->input->get('identity'))
			->where('id !=', $this->input->get('id'))
			->limit(1)
			->count_all_results('users');
	}

	public function get_user_recommend_code_by_line_id()
	{
		$this->db->where('oauth_uid', $this->input->get('line_id'));
		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			$row = $query->result();
			echo json_encode($row);
		} else {
			echo 0;
		}
	}

	public function check_is_login()
	{
		if ($this->ion_auth->logged_in()) {
			echo '1';
		} else {
			echo '0';
		}
	}

	/**
	 * @return array A CSRF key-value pair
	 */
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return [$key => $value];
	}

	/**
	 * @return bool Whether the posted CSRF token matches
	 */
	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param string     $view
	 * @param array|null $data
	 * @param bool       $returnhtml
	 *
	 * @return mixed
	 */
	public function _render_page($view, $data = NULL, $returnhtml = FALSE) //I think this makes more sense
	{

		$viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml) {
			return $view_html;
		}
	}
}
