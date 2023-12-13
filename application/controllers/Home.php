<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends Public_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('home_model');
		$this->load->model('product_model');
	}

	function index($franchisee = '') {
		$this->load->helper('cookie');
		$this->data['page_title'] = '首頁';
		$this->data['products'] = $this->product_model->getHomeProducts();
		$this->data['banner'] = $this->home_model->getBanner();
		$this->data['franchisee'] = $franchisee;
		$this->data['uid'] = (isset($_GET['uid'])?$_GET['uid']:null);
		if ($this->is_partnertoys) {
			$this->render('home/partnertoys_index');
		} else {
			$this->render('home/index');
		}
	}

}