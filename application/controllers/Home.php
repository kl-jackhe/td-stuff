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
		$this->data['product_combine'] = $this->product_model->getHomeProductCombineList();
		$this->data['limited_time_products'] = $this->product_model->getHomeLimitedTimeProductsList();
		$this->data['product_category'] = $this->product_model->get_product_category();
		$this->data['main_product_category'] = $this->product_model->getMainProductCategory();
		$this->data['banner'] = $this->home_model->getBanner();
		$this->data['franchisee'] = $franchisee;
		$this->data['uid'] = (isset($_GET['uid'])?$_GET['uid']:null);
		if ($this->is_partnertoys) {
			$this->render('home/partnertoys_index');
		} else if ($this->is_liqun_food) {
			$this->render('home/liqun_index');
		} else {
			$this->render('home/index');
		}
	}

	function searchAllProduct() {
		$keywords = $this->input->post('keywords');
		$this->data['products'] = $this->product_model->getSearchProductResults($keywords);
		if (!empty($this->data['products']) && $keywords != '') {
			$this->load->view('home/search_product_results', $this->data);
			return;
		} else {
			echo 'noProductData';
			return;
		}
	}

}