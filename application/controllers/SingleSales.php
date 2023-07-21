<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SingleSales extends Public_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('product_model');
		$this->load->model('sales_model');
	}

	function index($id = '') {
		$row = $this->sales_model->getSingleSalesProductID(trim($id));
		if (!empty($row) && $this->input->get('aid') != '') {
			$session_data = array(
				'agent_id' => $this->input->get('aid'),
			);
			$this->session->set_userdata($session_data);
			$this->data['product'] = $this->product_model->getSingleProduct($row['product_id']);
			$this->data['specification'] = $this->product_model->getProduct_Specification($row['product_id']);
			$this->data['product_combine'] = $this->mysql_model->_select('product_combine', 'product_id', $row['product_id']);
			$this->data['page_title'] = $this->data['product']['product_name'];
			$this->render('single_sales/index');
		} else {
			redirect(base_url() . 'product/');
		}
	}
}