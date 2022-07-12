<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('home_model');
		$this->load->model('service_area_model');
		$this->load->model('product_model');
	}

	public function index() {
		$this->load->helper('cookie');
		$this->data['page_title'] = '首頁';
		$this->data['products'] = $this->product_model->getHomeProducts();
		$this->data['banner'] = $this->home_model->GetBanner();
		$this->data['hide_county'] = $this->service_area_model->get_hide_county();
		$this->data['hide_district'] = $this->service_area_model->get_hide_district();
		// 取得客戶地址
		if ($this->ion_auth->logged_in()) {
			$users_address = $this->home_model->get_users_address($this->ion_auth->user()->row()->id);
			$this->data['users_address']['county'] = $users_address['county'];
			$this->data['users_address']['district'] = $users_address['district'];
			$this->data['users_address']['address'] = $users_address['address'];
			$data = array(
				'delivery_place' => $users_address['county'] . $users_address['district'] . $users_address['address'],
			);
			$this->session->set_userdata($data);
		} else {
			$this->data['users_address']['county'] = get_cookie("user_county", true);
			$this->data['users_address']['district'] = get_cookie("user_district", true);
			$this->data['users_address']['address'] = get_cookie("user_address", true);
			$data = array(
				'delivery_place' => $this->data['users_address']['county'] . $this->data['users_address']['district'] . $this->data['users_address']['address'],
			);
			$this->session->set_userdata($data);
		}
		$this->render('home/index');
	}

	public function shop_alliance() {
		$data = array(
			'shop_alliance_name' => $this->input->post('shop_alliance_name'),
			'shop_alliance_county' => $this->input->post('county'),
			'shop_alliance_district' => $this->input->post('district'),
			'shop_alliance_address' => $this->input->post('shop_alliance_address'),
			'shop_alliance_contact_name' => $this->input->post('shop_alliance_contact_name'),
			'shop_alliance_email' => $this->input->post('shop_alliance_email'),
			'shop_alliance_phone' => $this->input->post('shop_alliance_phone'),
			'created_at' => date('Y-m-d H:i:s'),
		);

		$this->db->insert('shop_alliance', $data);
		$this->session->set_flashdata('message', '店家合作表單送出成功！');
		redirect('about/shop_alliance?send=yes');
	}

	public function cross_industry_alliance() {
		$data = array(
			'cross_industry_alliance_name' => $this->input->post('cross_industry_alliance_name'),
			'cross_industry_alliance_number' => $this->input->post('cross_industry_alliance_number'),
			'cross_industry_alliance_contact_name' => $this->input->post('cross_industry_alliance_contact_name'),
			'cross_industry_alliance_email' => $this->input->post('cross_industry_alliance_email'),
			'cross_industry_alliance_phone' => $this->input->post('cross_industry_alliance_phone'),
			'cross_industry_alliance_content' => $this->input->post('cross_industry_alliance_content'),
			'created_at' => date('Y-m-d H:i:s'),
		);

		$this->db->insert('cross_industry_alliance', $data);
		$this->session->set_flashdata('message', '異業合作表單送出成功！');
		redirect('about/cross_industry_alliance?send=yes');
	}

	function send_email() {
		$this->load->library('MY_phpmailer');
		if ($this->my_phpmailer->send('a0935756869@gmail.com', 'Subject', 'Content')) {
			echo '信件已發送。';
		} else {
			echo '無法發送通知信件。';
		}
	}

	function send_email2() {
		$this->load->library('email');
		$this->email->from('service1@bythewaytaiwan.com', get_setting_general('name'));
		$this->email->to('a093575669@gmail.com');
		$this->email->subject('TEST');
		$this->email->message('TEST!!!!!!!');
		if ($this->email->send()) {
			echo '信件已發送。';
		} else {
			echo '無法發送通知信件。';
		}
	}

	function test() {
		$this->data['hide_county'] = $this->service_area_model->get_hide_county();
		$this->data['hide_district'] = $this->service_area_model->get_hide_district();
		// header('Content-Type: application/json');
		// echo '<pre>';
		echo json_encode($this->data['hide_district'], JSON_UNESCAPED_UNICODE);
		// echo '</pre>';
	}

}