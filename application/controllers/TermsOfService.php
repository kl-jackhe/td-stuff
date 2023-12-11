<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TermsOfService extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '服務條款';
		$this->load->view('pages/terms_of_service', $this->data);
	}

}