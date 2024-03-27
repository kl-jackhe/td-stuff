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
			$this->load->model('menu_model');
			$this->load->model('auth_model');
		elseif ($this->is_liqun_food) :
			$this->load->library('verification_code');
			$this->load->library('call_api');
			$this->load->model('auth_model');
		endif;
	}

	public function index()
	{
		$this->data['title'] = '會員專區';
		if ($this->is_partnertoys) {
			if (empty($this->session->userdata('user_id'))) {
				$this->data['membership'] = $this->auth_model->getStandardPageList('TermsOfService_tw');
				// 分類
				$this->data['auth_category'] = $this->menu_model->getSubMenuData(0, 6);
				// 類別分類
				$this->data['category'] = '';

				// 获取当前 URL
				$current_url = $_SERVER['REQUEST_URI'];

				// 使用 parse_url() 解析 URL 获取查询字符串部分
				$query_string = parse_url($current_url, PHP_URL_QUERY);

				// 对参数进行解码以获取您想要的内容
				// $decoded_data = $this->security_url->decryptData($query_string);
				$decoded_data = $this->security_url->fixedDecryptData($query_string);

				// 如果查询字符串不为空
				if (!empty($query_string)) {
					if (!empty($decoded_data) && !empty($decoded_data['category'])) {
						$this->data['category'] = $decoded_data['category'];
					}
				}
			} else {
				// 抓使用者資料
				$id = $this->session->userdata('user_id');
				$user = $this->ion_auth->user($id)->row();
				$this->data['user'] = $user;

				// 個人訂單
				$this->data['order'] = $this->auth_model->getOrders($id);
				$this->data['order_item'] = $this->auth_model->getOrderItem($id);

				// 訂單留言
				$msg_buf = array();
				if (!empty($this->data['order'])) {
					foreach ($this->data['order'] as $self) {
						$tmp_buf = $this->auth_model->getOrderMessage($self['order_id']);
						if (!empty($tmp_buf)) {
							foreach ($tmp_buf as $self) {
								$msg_buf[] = $self;
							}
						}
					}
				}
				$this->data['order_message'] = $msg_buf;

				// echo '<pre>';
				// print_r($this->data['order']);
				// echo '</pre>';
				// echo '<pre>';
				// print_r($this->data['order_message']);
				// echo '</pre>';
				// return;

				// 抓payname
				$this->data['payment_name'] = $this->auth_model->getPaymentName();

				// 抽選資料
				$self_lottery = array();
				$this->data['lottery_pool'] = $this->mysql_model->_select('lottery_pool', 'users_id', $id);
				if (!empty($this->data['lottery_pool'])) {
					foreach ($this->data['lottery_pool'] as $self) {
						$tmp = $this->mysql_model->_select('lottery', 'id', $self['lottery_id'], 'row');
						if (!empty($tmp)) {
							$product_name = $this->mysql_model->_select('product', 'product_id', $tmp['product_id'], 'row');
							// $this->data['lotteryProductCombine'] = $this->mysql_model->_select('product_combine', 'product_id', $tmp['product_id']);
						}
						if (!empty($product_name)) {
							$tmp['product_name'] = $product_name['product_name'];
						}
						$self_lottery[] = $tmp;
					}
				}
				$this->data['lottery'] = $self_lottery;

				// 類別分類
				$this->data['category'] = '';
				// 获取当前 URL
				$current_url = $_SERVER['REQUEST_URI'];
				// 使用 parse_url() 解析 URL 获取查询字符串部分
				$query_string = parse_url($current_url, PHP_URL_QUERY);
				// 对参数进行解码以获取您想要的内容
				// $decoded_data = $this->security_url->decryptData($query_string);
				$decoded_data = $this->security_url->fixedDecryptData($query_string);
				// 如果查询字符串不为空
				if (!empty($query_string)) {
					if (!empty($decoded_data) && !empty($decoded_data['order'])) {
						$this->data['postOrder'] = $decoded_data['order'];
					}
					if (!empty($decoded_data) && !empty($decoded_data['category'])) {
						$this->data['category'] = $decoded_data['category'];
					}
				}

				// 郵件
				$this->data['mail'] = $this->auth_model->getMails();

				// 分類
				$this->data['auth_category'] = $this->menu_model->getSubMenuData(0, 17);
			}
			$this->render('auth/partnertoys/partnertoys_index');
		} elseif ($this->is_liqun_food) {
			if (empty($this->session->userdata('user_id'))) {
				$this->data['membership'] = $this->auth_model->getStandardPageList('TermsOfService');

				// 分類
				$this->data['auth_category'] = $this->auth_model->getAuthVisiterCategory();

				// 類別分類
				$this->data['category'] = '';
				// 获取当前 URL
				$current_url = $_SERVER['REQUEST_URI'];
				// 使用 parse_url() 解析 URL 获取查询字符串部分
				$query_string = parse_url($current_url, PHP_URL_QUERY);
				// 对参数进行解码以获取您想要的内容
				// $decoded_data = $this->security_url->decryptData($query_string);
				$decoded_data = $this->security_url->fixedDecryptData($query_string);
				// 如果查询字符串不为空
				if (!empty($query_string)) {
					if (!empty($decoded_data) && !empty($decoded_data['order'])) {
						$this->data['postOrder'] = $decoded_data['order'];
					}
					if (!empty($decoded_data) && !empty($decoded_data['category'])) {
						$this->data['category'] = $decoded_data['category'];
					}
				}
			} else {
				// 抓使用者資料
				$id = $this->session->userdata('user_id');
				$user = $this->ion_auth->user($id)->row();
				$this->data['user'] = $user;

				// 優惠券
				$coupon_arr = $this->auth_model->getCoupons($id);
				if (!empty($coupon_arr)) {
					foreach ($coupon_arr as &$self) {
						$save_arr = $this->auth_model->getCouponName($self['coupon_id']);
						$self['name'] = $save_arr['name'];
					}
					unset($self);  // 解除引用，以防止后续代码中意外修改 $self 导致原数组变动
				}
				$this->data['coupon'] = $coupon_arr;

				// 個人訂單
				$this->data['order'] = $this->auth_model->getOrders($id);
				$this->data['order_item'] = $this->auth_model->getOrderItem($id);

				// 抓payname
				$this->data['payment_name'] = $this->auth_model->getPaymentName();

				// 分類
				$this->data['auth_category'] = $this->auth_model->getAuthMemberCategory();

				// 類別分類
				$this->data['category'] = '';
				// 获取当前 URL
				$current_url = $_SERVER['REQUEST_URI'];
				// 使用 parse_url() 解析 URL 获取查询字符串部分
				$query_string = parse_url($current_url, PHP_URL_QUERY);
				// 对参数进行解码以获取您想要的内容
				// $decoded_data = $this->security_url->decryptData($query_string);
				$decoded_data = $this->security_url->fixedDecryptData($query_string);
				// 如果查询字符串不为空
				if (!empty($query_string)) {
					if (!empty($decoded_data) && !empty($decoded_data['order'])) {
						$this->data['postOrder'] = $decoded_data['order'];
					}
					if (!empty($decoded_data) && !empty($decoded_data['category'])) {
						$this->data['category'] = $decoded_data['category'];
					}
				}
			}
			$this->render('auth/liqun/liqun_index');
		}
	}

	function sms_mitake_point()
	{
		// url
		$url = 'https://smsapi.mitake.com.tw/api/mtk/SmQuery';
		// parameters
		$data = 'username=' . get_setting_general('mitake_username');
		$data .= '&password=' . get_setting_general('mitake_password');

		// 准备请求头
		$header = array(
			'Content-Type: application/x-www-form-urlencoded',
		);

		// 设置请求选项
		$options = array(
			'http' => array(
				'method' => 'POST', // 使用 POST 方法发送数据
				'header' => implode("\r\n", $header),
				'content' => $data, // 将 JSON 数据放在请求主体中
			),
		);

		$context = stream_context_create($options);

		$res = @file_get_contents($url, false, $context);

		// 從 API 回傳的文字中提取數字部分
		preg_match('/\d+/', $res, $matches);

		// 檢查是否有匹配到數字
		if (!empty($matches)) {
			// 提取到的數字存儲在 $matches[0] 中
			$number = $matches[0];
			// 存入 $data 陣列中
			$data = array(
				'setting_general_value' => $number,
			);
			$this->db->where('setting_general_name', 'mitake_point');
			$this->db->update('setting_general', $data);
		}
	}

	function sms_mitake_send($number, $code)
	{
		// url
		$url = 'https://smsapi.mitake.com.tw/api/mtk/SmSend?';
		$url .= 'CharsetURL=UTF-8';
		// parameters
		$data = 'username=' . get_setting_general('mitake_username');
		$data .= '&password=' . get_setting_general('mitake_password');
		$data .= '&dstaddr=' . $number;
		$data .= '&smbody=【阿凱的冰箱】您於官網申請帳號的手機驗證碼為[' . $code . ']，5分鐘內有效，請勿將驗證碼提供他人以防詐騙';

		// 准备请求头
		$header = array(
			'Content-Type: application/x-www-form-urlencoded',
		);

		// 设置请求选项
		$options = array(
			'http' => array(
				'method' => 'POST', // 使用 POST 方法发送数据
				'header' => implode("\r\n", $header),
				'content' => $data, // 将 JSON 数据放在请求主体中
			),
		);

		$context = stream_context_create($options);

		// 傳送要求
		$res = @file_get_contents($url, false, $context);

		// 更新剩餘餘額
		$this->sms_mitake_point();
	}

	function get_checkcode()
	{
		$checkcode = $this->verification_code->generateVerificationCode();
		$this->session->set_userdata('phone_number', $this->input->post('custom_number')); // 記錄手機號
		$this->session->set_userdata('phone_code', $checkcode['code']); // 記錄驗證碼
		$this->session->set_userdata('phone_expire', $checkcode['life']); // 記錄壽命
		$this->session->set_userdata('last_request_time', time()); // 記錄請求時間

		$number = $this->input->post('custom_number');
		$code = $this->session->userdata('phone_code');
		$this->sms_mitake_send($number, $code);

		echo 'success';
	}

	function check_member()
	{
		$number = $this->input->post('number');
		$self = $this->mysql_model->_select('users', 'username', $number, 'row');
		echo !empty($self) ? 'exist' : 'inexist';
	}

	function compare_checkcode($checkcode)
	{
		if (!empty($this->session->userdata('phone_code')) && !empty($this->session->userdata('phone_expire'))) {
			if ($this->session->userdata('phone_expire') > time()) {
				if ($checkcode == $this->session->userdata('phone_code')) {
					echo 'success';
				} else {
					echo 'fault';
				}
			} else {
				echo 'overtime';
			}
		} else {
			echo 'error';
		}
	}

	function language_switch()
	{
		$lang = $this->input->post('lang');
		$data = $this->auth_model->getLanguageData($lang);
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		return;
	}

	public function mail_total_reading()
	{
		$this->db->where('tel', $this->session->userdata('identity'));
		$this->db->update('contact', ['state_member' => 1]);
		$this->db->where('email', $this->session->userdata('identity'));
		$this->db->update('contact', ['state_member' => 1]);
	}

	public function mail_is_reading()
	{
		$id = $this->input->post('id');
		$this->db->where('contid', $id);
		$this->db->update('contact', ['state_member' => 1]);
	}

	public function uploadOrderMessage()
	{
		$order_id = $this->input->post('id');
		$message = $this->input->post('message');
		$data = array(
			'order_id' => $order_id,
			'user_id' => $this->session->userdata('user_id'),
			'content' => $message,
			'response_status' => 0,
			'created_at' => date('Y-m-d H:i:s'),
		);
		$this->db->insert('guestbook', $data);
		echo 'success';
		return;
	}

	public function cantact_us()
	{
		$freetime = $this->input->post('freetime');
		$company = $this->input->post('company');
		$name = $this->input->post('name');
		$number = $this->input->post('number');
		$email = $this->input->post('email');
		$content = $this->input->post('content');

		$data = array(
			'gtime' => $freetime,
			'cpname' => $company,
			'custname' => $name,
			'tel' => $number,
			'email' => $email,
			'desc1' => $content,
			'datetime' => date('Y-m-d H:i:s'),
		);

		$this->db->insert('contact', $data);
		echo '
		<script>
			alert("發送成功，請留意信箱訊息以接收回復通知");
			window.history.back();
		</script>';
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
				$this->db->update('orders', ['order_step' => 'order_cancel'], ['order_id' => $id]);
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
				echo 'successful';
			else :
				echo 'unsuccessful';
			endif;
		} else {
			echo 'unsuccessful';
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

				if ($this->is_partnertoys || $this->is_liqun_food) {
					$this->session->set_flashdata('loginMessage', $this->ion_auth->errors());
					$this->session->set_flashdata('identity', $this->input->post('identity'));
					echo '<script>window.history.back();</script>';
					return;
					// redirect('auth/index?id=1', 'refresh');
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

			if ($this->is_partnertoys || $this->is_liqun_food) {
				$this->session->set_flashdata('loginMessage', (validation_errors()) ? validation_errors() : $this->session->flashdata('loginMessage'));
				$this->session->set_flashdata('identity', $this->input->post('identity'));
				echo '<script>window.history.back();</script>';
				return;
				// redirect('auth/index?id=1', 'refresh');
			}

			$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'login', $this->data);
		}
	}

	/**
	 * Log the user out
	 */
	public function logout($locationHref = '')
	{
		// log the user out
		$this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());

		// redirect home page
		if (!empty($locationHref)) {
			echo "<script>alert('密碼更改成功')</script>";
			redirect($locationHref, 'refresh');
		} else {
			redirect(base_url(), 'refresh');
		}
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
			if ($this->is_partnertoys || $this->is_liqun_food) {
				if (!empty($this->session->userdata('fb_id'))) {
					$this->session->set_flashdata('changePasswordMessage', '<br>FB登入者無法使用此功能<br><br>');
				} else {
					$this->session->set_flashdata('changePasswordMessage', '<br>輸入錯誤請重新嘗試<br><br>');
				}
				echo '<script>window.history.back();</script>';
				return;
				// redirect('auth/index?id=6', 'refresh');
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
			if ($this->is_partnertoys || $this->is_liqun_food) {
				$this->session->set_flashdata('changePasswordMessage', (validation_errors()) ? validation_errors() : $this->session->flashdata('changePasswordMessage'));
				echo '<script>window.history.back();</script>';
				return;
				// redirect('auth/index?id=6', 'refresh');
			}
			$this->render('auth/change_password', 'admin_master');
		} else {
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change) {
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout('auth/index');
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				if ($this->is_partnertoys || $this->is_liqun_food) {
					$this->session->set_flashdata('changePasswordMessage', $this->ion_auth->errors());
					echo '<script>window.history.back();</script>';
					return;
					// redirect('auth/index?id=6', 'refresh');
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
			if ($this->is_partnertoys || $this->is_liqun_food) {
				$this->session->set_flashdata('forgotMessage', (validation_errors()) ? validation_errors() : $this->session->flashdata('forgotMessage'));
				echo '<script>window.history.back();</script>';
				return;
				// redirect('auth/index?id=3', 'refresh');
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
				if ($this->is_partnertoys || $this->is_liqun_food) {
					$this->session->set_flashdata('forgotMessage', $this->ion_auth->errors());
					echo '<script>window.history.back();</script>';
					return;
					// redirect('auth/index?id=3', 'refresh');
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
				if ($this->is_partnertoys || $this->is_liqun_food) {
					echo '<script>alert("已發送認證信");</script>';
					redirect("auth", 'refresh');
				}
				redirect("login", 'refresh'); //we should display a confirmation page here instead of the login page
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				if ($this->is_partnertoys || $this->is_liqun_food) {
					$this->session->set_flashdata('forgotMessage', $this->ion_auth->errors());
					echo '<script>window.history.back();</script>';
					return;
					// redirect('auth/index?id=3', 'refresh');
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

		// 阿凱的冰箱手機驗證碼
		if ($this->is_liqun_food) {
			if (empty($this->input->post('checkcode'))) {
				$this->session->set_flashdata('form_values', $this->input->post());
				$this->session->set_flashdata('registerMessage', '<br>【驗證碼】欄位為必填項目<br><br>');
				echo '<script>window.history.back();</script>';
				return;
			} elseif (!empty($this->input->post('checkcode')) && !empty($this->session->userdata('phone_number')) && !empty($this->session->userdata('phone_code')) && !empty($this->session->userdata('phone_expire'))) {
				$checkcode = $this->input->post('checkcode');
				$number = $this->session->userdata('phone_number');
				$captcha = $this->session->userdata('phone_code');
				$life = $this->session->userdata('phone_expire');
				if ($number != $this->input->post('identity')) {
					$this->session->set_flashdata('form_values', $this->input->post());
					$this->session->set_flashdata('registerMessage', '<br>【門號錯誤】註冊帳號需與傳送簡訊之門號相符<br><br>');
					echo '<script>window.history.back();</script>';
					return;
				}
				if ($life < time()) {
					$this->session->set_flashdata('form_values', $this->input->post());
					$this->session->set_flashdata('registerMessage', '<br>【驗證碼過期】請重新獲取驗證碼<br><br>');
					echo '<script>window.history.back();</script>';
					return;
				}
				if ($checkcode != $captcha) {
					$this->session->set_flashdata('form_values', $this->input->post());
					$this->session->set_flashdata('registerMessage', '<br>【驗證碼錯誤】請重新填寫驗證碼<br><br>');
					echo '<script>window.history.back();</script>';
					return;
				}
			}
		}

		// 夥伴玩具驗證碼
		if ($this->is_partnertoys) {
			if (empty($this->input->post('checkcode'))) {
				$this->session->set_flashdata('form_values', $this->input->post());
				$this->session->set_flashdata('registerMessage', '<br>【驗證碼】欄位為必填項目<br><br>');
				echo '<script>window.history.back();</script>';
				return;
			} elseif (!empty($this->input->post('checkcode')) && !empty($this->input->post('captcha'))) {
				$checkcode = $this->input->post('checkcode');
				$captcha = $this->input->post('captcha');
				if ($checkcode != $captcha) {
					$this->session->set_flashdata('form_values', $this->input->post());
					$this->session->set_flashdata('registerMessage', '<br>【驗證碼錯誤】請重新填寫驗證碼<br><br>');
					echo '<script>window.history.back();</script>';
					return;
				}
			}
		}

		// 夥伴玩具性別
		if ($this->is_partnertoys && empty($this->input->post('sex'))) {
			$this->session->set_flashdata('form_values', $this->input->post());
			$this->session->set_flashdata('registerMessage', '<br>【性別】欄位為必填項目<br><br>');
			echo '<script>window.history.back();</script>';
			return;
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
				// if the login is successful
				$data = array(
					'ip_address' => $this->input->ip_address(),
					'user_id' => $this->ion_auth->user()->row()->id,
					'datetime' => date('Y-m-d H:i:s'),
				);
				$this->db->insert('login_log', $data);

				// coupon given

				$coupon = $this->auth_model->getAllCoupons();
				if (!empty($coupon)) {
					foreach ($coupon as $self) {
						if ($self['use_member_enable'] == 1 && ($self['use_member_type'] == 'new_member' || $self['use_member_type'] == 'all_member')) {
							$data = array(
								'coupon_id' => $self['id'],
								'custom_id' => $this->ion_auth->user()->row()->id,
								'type' => $self['type'],
								'discount_amount' => $self['discount_amount'],
								'use_limit_enable' => $self['use_limit_enable'],
								'use_type_enable' => $self['use_type_enable'],
								'use_product_enable' => $self['use_product_enable'],
								'distribute_at' => $self['distribute_at'],
								'discontinued_at' => $self['discontinued_at'],
							);
							if ($self['use_limit_enable'] == '1') {
								$data['use_limit_number'] = $self['use_limit_number'];
							} else {
								$data['use_limit_number'] = '';
							}
							if ($self['use_type_enable'] == '1') {
								$data['use_type_name'] = $self['use_type_name'];
								$data['use_type_number'] = $self['use_type_number'];
							} else {
								$data['use_type_name'] = '';
								$data['use_type_number'] = '';
							}
							$this->db->insert('new_coupon_custom', $data);
						}
					}
				}

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
				if ($this->is_partnertoys || $this->is_liqun_food) {
					$this->session->set_flashdata('form_values', $this->input->post());
					$this->session->set_flashdata('registerMessage', $this->ion_auth->errors());
					echo '<script>window.history.back();</script>';
					return;
					// redirect('auth/index?id=2', 'refresh');
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
			if ($this->is_partnertoys || $this->is_liqun_food) {
				$this->session->set_flashdata('form_values', $this->input->post());
				$this->session->set_flashdata('registerMessage', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('registerMessage'))));
				echo '<script>window.history.back();</script>';
				return;
				// redirect('auth/index?id=2', 'refresh');
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

			$this_province = '';
			$this_county = '';
			$this_district = '';
			$this_zipcode = '';

			if ($this->input->post('Country') == '臺灣') {
				$this_province = '';
				$this_county = $this->input->post('tw_county');
				$this_district = $this->input->post('tw_district');
				$this_zipcode = $this->input->post('tw_zipcode');
			} else if ($this->input->post('Country') == '中國') {
				$this_province = $this->input->post('cn_province');
				$this_county = $this->input->post('cn_county');
				$this_district = $this->input->post('cn_district');
				$this_zipcode = $this->input->post('cn_zipcode');
			}
			$data = array(
				'full_name' => $this->input->post('full_name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'Country' => $this->input->post('Country'),
				'province' => $this_province,
				'county' => $this_county,
				'district' => $this_district,
				'zipcode' => $this_zipcode,
				'address' => $this->input->post('address'),
				'birthday' => $this->input->post('birthday'),
				'updater_id' => $this->ion_auth->user()->row()->id,
				'updated_at' => date('Y-m-d H:i:s'),
			);

			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';

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
				if ($this->is_partnertoys || $this->is_liqun_food) {
					echo '<script>alert("修改成功");</script>';
					echo '<script>window.history.back();</script>';
					return;
					// redirect('auth/index?id=5', 'refresh');
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
				if ($this->is_partnertoys || $this->is_liqun_food) {
					$this->session->set_flashdata('editMessage', $this->ion_auth->errors());
					echo '<script>window.history.back();</script>';
					return;
					// redirect('auth/index?id=5', 'refresh');
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

	// public function get_captcha()
	// {
	// 	// 生成一個包含數字和英文字母的隨機四位數字驗證碼
	// 	$randomCode = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4);

	// 	// 將驗證碼存入 Session 中
	// 	$this->session->set_flashdata('captcha', $randomCode);

	// 	// 創建一個圖片
	// 	$imageWidth = 150;
	// 	$imageHeight = 70;
	// 	$image = imagecreate($imageWidth, $imageHeight);

	// 	// 主要色彩設定
	// 	// 圖片底色 - 深紫
	// 	$bgColor = imagecolorallocate($image, 189, 41, 163);

	// 	// 文字顏色 - 白
	// 	$textColor = imagecolorallocate($image, 255, 255, 255);

	// 	// 干擾線條顏色 - 深藍
	// 	$gray1 = imagecolorallocate($image, 21, 41, 164);

	// 	// 干擾像素顏色 - 淺紫
	// 	$gray2 = imagecolorallocate($image, 232, 64, 185);

	// 	// 設定圖片底色
	// 	imagefill($image, 0, 0, $bgColor);

	// 	//底色干擾線條
	// 	for ($i = 0; $i < 10; $i++) {
	// 		imageline(
	// 			$image,
	// 			rand(0, $imageWidth),
	// 			rand(0, $imageHeight),
	// 			rand($imageHeight, $imageWidth),
	// 			rand(0, $imageHeight),
	// 			$gray1
	// 		);
	// 	}

	// 	// 干擾像素
	// 	for ($i = 0; $i < 90; $i++) {
	// 		imagesetpixel(
	// 			$image,
	// 			rand() % $imageWidth,
	// 			rand() % $imageHeight,
	// 			$gray2
	// 		);
	// 	}

	// 	// 設定字型和文字大小
	// 	$font = './assets/font_ttf/GHOSTWRITER.TTF';  // 替換成你的字型文件的路徑
	// 	$fontSize = 32;

	// 	// 設定文字位置，使文字剛好在圖片中間
	// 	$textBox = imagettfbbox($fontSize, 0, $font, $randomCode);
	// 	$textWidth = $textBox[2] - $textBox[0];
	// 	$textHeight = $textBox[3] - $textBox[5];
	// 	$textX = ($imageWidth - $textWidth) / 2;
	// 	$textY = ($imageHeight - $textHeight) / 2 + $textHeight; // 增加文字的高度，使文字垂直居中

	// 	// 在圖片上寫入文字
	// 	imagettftext($image, $fontSize, 0, $textX, $textY, $textColor, $font, $randomCode);

	// 	// 將圖片轉換為 base64 編碼的數據 URI
	// 	ob_start();
	// 	imagepng($image);
	// 	$imageData = ob_get_contents();
	// 	ob_end_clean();
	// 	$imageBase64 = 'data:image/png;base64,' . base64_encode($imageData);

	// 	// 返回所有數據
	// 	$this->output
	// 		->set_content_type('application/json')
	// 		->set_output(json_encode($imageBase64));
	// }
}
