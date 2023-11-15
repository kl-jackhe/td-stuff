<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegisterPlan extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '註冊我的專屬商店';
		$this->load->view('pages/register_plan', $this->data);
	}

}