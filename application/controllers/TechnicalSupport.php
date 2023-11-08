<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TechnicalSupport extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '技術支援';
		$this->load->view('pages/technical_support', $this->data);
	}

}