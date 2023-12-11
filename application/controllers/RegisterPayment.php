<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegisterPayment extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '方案付款';
		$this->load->view('pages/register_payment', $this->data);
	}

}