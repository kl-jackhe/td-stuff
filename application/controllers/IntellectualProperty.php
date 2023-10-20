<?php defined('BASEPATH') OR exit('No direct script access allowed');

class IntellectualProperty extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '知識產權';
		$this->load->view('pages/intellectual_property', $this->data);
	}

}