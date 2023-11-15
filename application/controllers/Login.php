<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Public_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	/**
	 * Log the user in
	 */
	public function index()
	{
		$this->data['page_title'] = '登入';

		if ($this->ion_auth->logged_in())
		{
			// redirect('/', 'refresh');
			redirect($_SERVER['HTTP_REFERER']);
		}

		// validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() == true)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = true;

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				$data = array(
					'ip_address' => $this->input->ip_address(),
					'user_id'    => $this->ion_auth->user()->row()->id,
					'datetime'   => date('Y-m-d H:i:s'),
	            );
	            $this->db->insert('login_log', $data);
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				if($this->ion_auth->in_group('admin'))
				{
					redirect('admin', 'refresh');
				}
				//
				if($this->input->post('now_url')!=''){
					redirect($this->input->post('now_url'));
				} else {
					redirect('/');
				}

				// if(!empty($this->input->post('page')) && $this->input->post('page')=='home'){
				// 	redirect( base_url() . $this->input->post('page'), 'refresh');
				// } else {
				// 	// redirect('/', 'refresh');
				// 	redirect($_SERVER['HTTP_REFERER']);
				// }
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				// $this->session->set_flashdata('message', '使用者名稱或是密碼錯誤 , 請重新輸入。');
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id'   => 'password',
				'type' => 'password',
			);

			$this->session->set_flashdata('message', (validation_errors()) ? validation_errors() : $this->session->flashdata('message'));
			$this->render('auth/login');
		}
	}

	public function index_v2()
	{
		$this->data['page_title'] = '登入';

		if ($this->ion_auth->logged_in())
		{
			// redirect('/', 'refresh');
			redirect($_SERVER['HTTP_REFERER']);
		}

		// validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() == true)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = true;

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				$data = array(
					'ip_address' => $this->input->ip_address(),
					'user_id'    => $this->ion_auth->user()->row()->id,
					'datetime'   => date('Y-m-d H:i:s'),
	            );
	            $this->db->insert('login_log', $data);
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				if($this->ion_auth->in_group('admin'))
				{
					redirect('admin', 'refresh');
				}
				//
				if($this->input->post('now_url')!=''){
					redirect($this->input->post('now_url'));
				} else {
					redirect('/');
				}

				// if(!empty($this->input->post('page')) && $this->input->post('page')=='home'){
				// 	redirect( base_url() . $this->input->post('page'), 'refresh');
				// } else {
				// 	// redirect('/', 'refresh');
				// 	redirect($_SERVER['HTTP_REFERER']);
				// }
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				// $this->session->set_flashdata('message', '使用者名稱或是密碼錯誤 , 請重新輸入。');
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				$this->load->view('auth/login_v2',$this->data);
				// redirect('login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id'   => 'password',
				'type' => 'password',
			);

			$this->session->set_flashdata('message', (validation_errors()) ? validation_errors() : $this->session->flashdata('message'));
			$this->load->view('auth/login_v2',$this->data);
		}
	}

	/**
	 * Forgot password
	 */
	public function forgot_password()
	{
		$this->data['page_title'] = '忘記密碼';

		// setting validation rules by checking whether identity is username or email
		if ($this->config->item('identity', 'ion_auth') != 'email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		}
		else
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() === FALSE)
		{
			$this->data['type'] = $this->config->item('identity', 'ion_auth');
			// setup the input
			$this->data['identity'] = [
				'name' => 'identity',
				'id' => 'identity',
				'class' => 'form-control'
			];

			if ($this->config->item('identity', 'ion_auth') != 'email')
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			// $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'forgot_password', $this->data);
			$this->render('auth/forgot_password');
		}
		else
		{
			$identity_column = $this->config->item('identity', 'ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if (empty($identity))
			{

				if ($this->config->item('identity', 'ion_auth') != 'email')
				{
					$this->ion_auth->set_error('forgot_password_identity_not_found');
				}
				else
				{
					$this->ion_auth->set_error('forgot_password_email_not_found');
				}

				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("forgot_password", 'refresh');
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("forgot_password", 'refresh');
			}
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
		redirect('/', 'refresh');
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
	public function _valid_csrf_nonce(){
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue'))
		{
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
	public function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
	{

		$viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml)
		{
			return $view_html;
		}
	}

}
