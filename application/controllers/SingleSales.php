<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SingleSales extends Public_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('product_model');
		$this->load->model('sales_model');
	}

	function index($id = '') {
		$row = $this->sales_model->getSingleSalesDetail(trim($id));
		if (!empty($row) && $this->input->get('aid') != '') {
			$agent_name = $this->sales_model->getAgentName($id,$this->input->get('aid'));
			if ($this->session->userdata('agent_id') != $this->input->get('aid')) {
				$this->cart->destroy();
				unset($_SESSION['single_sales_id']);
				unset($_SESSION['agent_id']);
				unset($_SESSION['agent_name']);
			}
			if (empty($agent_name) || ($row['status'] == 'Closure' || $row['status'] == 'OutSale')) {
				$this->render('single_sales/error');
				return;
			}
			$session_data = array(
				'single_sales_id' => $id,
				'agent_id' => $this->input->get('aid'),
				'agent_name' => $agent_name['name'],
				'single_sales_status' => $row['status'],
			);
			$this->session->set_userdata($session_data);
			$this->data['name_style'] = $agent_name['name_style'];
			$this->data['single_sales'] = $row;
			$this->data['product'] = $this->product_model->getSingleProduct($row['product_id']);
			$this->data['specification'] = $this->mysql_model->_select('product_specification', 'product_id', $row['product_id']);
			$this->data['product_combine'] = $this->mysql_model->_select('product_combine', 'product_id', $row['product_id']);
			// $this->data['specification'] = $this->mysql_model->_select('single_product_specification', 'product_id', $row['product_id']);
			// $this->data['product_combine'] = $this->mysql_model->_select('single_product_combine', 'product_id', $row['product_id']);
			if ($row['status'] == 'OnSale' || $row['status'] == 'ForSale') {
				$this->updateHits($id,$this->input->get('aid'),$row['status']);
			}
			$this->render('single_sales/index');
		} else {
			$this->render('single_sales/error');
		}
	}

	function checkSingleSalesDate() {
		$sslicc_query = $this->sales_model->getSingleSalesListIsCanChange();
		if (!empty($sslicc_query)) {
			foreach ($sslicc_query as $sslicc_row) {
				if ($sslicc_row['status'] == 'OnSale' && ($sslicc_row['end_date'] < date('Y-m-d H:i:s') && $sslicc_row['end_date'] != '0000-00-00 00:00:00')) {
					echo $sslicc_row['id'] . ' - OnSale To OutSale.<br>';
					$this->sales_model->updateSingleSalesStatus($sslicc_row['id'],'OutSale');
				}
				if ($sslicc_row['status'] == 'ForSale' && ($sslicc_row['start_date'] < date('Y-m-d H:i:s') && $sslicc_row['start_date'] != '0000-00-00 00:00:00')) {
					echo $sslicc_row['id'] . ' - ForSale To OnSale.<br>';
					$this->sales_model->updateSingleSalesStatus($sslicc_row['id'],'OnSale');
				}
				if ($sslicc_row['status'] == 'Test' && ($sslicc_row['pre_date'] < date('Y-m-d H:i:s') && $sslicc_row['pre_date'] != '0000-00-00 00:00:00')) {
					echo $sslicc_row['id'] . ' - Test To ForSale.<br>';
					$this->sales_model->updateSingleSalesStatus($sslicc_row['id'],'ForSale');
				}
			}
		}
	}

	function updateHits($single_sales_id,$agent_id,$status) {
		$deviceIP = $_SERVER['REMOTE_ADDR'];
		if (empty($_COOKIE['visited_' . $single_sales_id . '_' . $agent_id])) {
			setcookie('visited_' . $single_sales_id . '_' . $agent_id, '1', time() + 3600);
			$this->db->select('id');
			$this->db->where('single_sales_id',$single_sales_id);
			$this->db->where('agent_id',$agent_id);
			$this->db->limit(1);
			$row = $this->db->get('single_sales_agent')->row_array();
			if (!empty($row)) {
				if ($status == 'ForSale') {
					$sql = "UPDATE single_sales_agent SET pre_hits = (pre_hits + 1) WHERE id = ?";
				}
				if ($status == 'OnSale') {
					$sql = "UPDATE single_sales_agent SET start_hits = (start_hits + 1) WHERE id = ?";
				}
				$this->db->query($sql, array($row['id']));
			}
		}
	}

}