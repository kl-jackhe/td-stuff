<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Disclaimer extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '免責聲明';
		$this->load->view('pages/disclaimer', $this->data);
	}

}