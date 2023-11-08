<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SampleStore extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '網購商店示範';
		$this->load->view('pages/sample_store', $this->data);
	}

}