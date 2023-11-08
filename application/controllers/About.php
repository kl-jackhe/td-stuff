<?php defined('BASEPATH') OR exit('No direct script access allowed');

class About extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '關於' . get_setting_general('name');
		$this->load->view('pages/about', $this->data);
	}

}