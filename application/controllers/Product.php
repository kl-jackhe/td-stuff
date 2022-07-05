<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Public_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('home_model');
		$this->load->model('service_area_model');
	}

	public function index() {
		$this->load->helper('cookie');
		$this->data['page_title'] = '產品';
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
		$this->render('product/index');
	}
}