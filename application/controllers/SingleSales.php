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
			$agent_name = $this->sales_model->getAgentName($id,$this->input->get('aid'));
			if ($this->session->userdata('agent_id') != $this->input->get('aid')) {
				$this->cart->destroy();
				unset($_SESSION['agent_id']);
				unset($_SESSION['agent_name']);
			}
			if (empty($agent_name)) {
				$this->render('single_sales/error');
				return;
			}
			$session_data = array(
				'agent_id' => $this->input->get('aid'),
				'agent_name' => $agent_name['name'],
			);
			$this->session->set_userdata($session_data);
			$this->data['product'] = $this->product_model->getSingleProduct($row['product_id']);
			$this->data['specification'] = $this->mysql_model->_select('single_product_specification', 'product_id', $row['product_id']);
			$this->data['product_combine'] = $this->mysql_model->_select('single_product_combine', 'product_id', $row['product_id']);
			$this->render('single_sales/index');
		} else {
			$this->render('single_sales/error');
		}
	}

}