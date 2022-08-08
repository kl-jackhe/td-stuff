<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Public_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('product_model');
	}

	public function index() {
		$this->data['page_title'] = '商品';
		// $this->data['products'] = $this->product_model->getHomeProducts();

		$data = array();
		//total rows count
		$conditions['returnType'] = 'count';
		$totalRec = $this->product_model->getRows($conditions);
		//pagination configuration
		$config['target'] = '#data';
		$config['base_url'] = base_url() . 'product/ajaxData';
		// $config['total_rows'] = $totalRec;
		// $config['per_page'] = $this->perPage;
		$config['link_func'] = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		//get the posts data
		// $this->data['products'] = $this->product_model->getRows(array('limit' => $this->perPage));
		$this->data['products'] = $this->product_model->getRows(array());

		$this->data['product_category'] = $this->product_model->get_product_category();
		$this->render('product/index');
	}

	public function view($id = 0) {
		if ($id == 0) {
			redirect(base_url() . 'product');
		}
		$this->data['product'] = $this->product_model->getSingleProduct($id);
		$this->data['specification'] = $this->product_model->getProduct_Specification($id);
		$this->data['product_combine'] = $this->mysql_model->_select('product_combine', 'product_id', $id);
		$this->data['page_title'] = $this->data['product']['product_name'];
		$this->render('product/view');
	}

	function ajaxData() {
		$conditions = array();
		//calc offset number
		$page = $this->input->get('page');
		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}
		//set conditions for search
		$keywords = $this->input->get('keywords');
		$product_category = $this->input->get('product_category');
		if (!empty($keywords)) {
			$conditions['search']['keywords'] = $keywords;
		}
		if (!empty($product_category)) {
			$conditions['search']['product_category_id'] = $product_category;
		}
		//total rows count
		$conditions['returnType'] = 'count';
		$totalRec = $this->product_model->getRows($conditions);
		//pagination configuration
		$config['target'] = '#data';
		$config['base_url'] = base_url() . 'product/ajaxData';
		// $config['total_rows'] = $totalRec;
		// $config['per_page'] = $this->perPage;
		$config['link_func'] = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		//set start and limit
		$conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		//get posts data
		$conditions['returnType'] = '';
		$this->data['products'] = $this->product_model->getRows($conditions);
		//load the view
		$this->load->view('product/ajax-data', $this->data, false);
	}
}