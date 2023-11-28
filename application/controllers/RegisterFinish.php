<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegisterFinish extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '註冊完成';
		$this->load->view('pages/register_finish', $this->data);
	}

}