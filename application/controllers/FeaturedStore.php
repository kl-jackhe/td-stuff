<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FeaturedStore extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '商店精選';
		$this->load->view('pages/featured_store', $this->data);
	}

}