<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegisterStore extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '註冊我的商店';
		$this->load->view('pages/register_store', $this->data);
	}

}