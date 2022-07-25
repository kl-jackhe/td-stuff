<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Public_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('cookie');
		$this->load->library('cart');
		$this->load->model('product_model');
	}

	public function index() {
		$this->data['page_title'] = '商品';
		$this->data['products'] = $this->product_model->getHomeProducts();
		$this->render('product/index');
	}

	public function view($id = 0) {
		if ($id==0) {
			redirect(base_url() . 'product');
		}
		$this->data['product'] = $this->product_model->getSingleProduct($id);
		$this->data['specification'] = $this->product_model->getProduct_Specification($id);
		$this->data['product_combine'] = $this->mysql_model->_select('product_combine', 'product_id', $id);
		$this->data['page_title'] = $this->data['product']['product_name'];
		$this->render('product/view');
	}
}