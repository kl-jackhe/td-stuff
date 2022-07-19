<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Public_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('product_model');
		$this->load->model('home_model');
		$this->load->model('store_model');
		$this->load->model('coupon_model');
		$this->load->model('service_area_model');
	}

	public function index() {
		$this->load->helper('cookie');
		$this->data['product'] = $this->product_model->getProductPage();
		$this->data['page_title'] = '商品';
		$this->render('product/index');
	}

	public function view($id) {
		if (!empty($id)) {
			$this->load->helper('cookie');
			$this->data['product'] = $this->product_model->getSingleProduct($id);
			$this->data['specification'] = $this->product_model->getProduct_Specification($id);
			$this->data['page_title'] = $this->product_model->getProductName($id);
			$this->render('product/view');
		}
	}
}