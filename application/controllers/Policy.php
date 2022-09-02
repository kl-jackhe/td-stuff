<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Policy extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->load->helper('cookie');
		$this->data['page_title'] = '服務條款';
		$this->render('policy/index');
	}
}