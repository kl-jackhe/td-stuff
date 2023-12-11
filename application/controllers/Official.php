<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Official extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '官方網站';
		$this->load->view('official/index', $this->data);
	}

}