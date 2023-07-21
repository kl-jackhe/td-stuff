<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends Admin_Controller {

	function __construct() {
		parent::__construct();
        $this->load->model('sales_model');
        $this->load->model('agent_model');
	}

    function index()
    {
        $this->data['page_title'] = '銷售管理';
        $this->data['SingleSales'] = $this->sales_model->getSingleSalesList();
        $this->data['SingleSalesAgent'] = $this->sales_model->getSingleSalesAgentList();
        $this->render('admin/sales/index');
    }

    function createSingleSales() {
        //status -> Closure OnSale OutSale ForSale Test
        if ($this->input->post('product_id') != '') {
            $repeatedAttempts = 0;
            $ssID = '';
            do {
                $ssID = 'SS' .  date('ymd') . get_random_string(3);
                $this->db->select('id');
                $this->db->where('id',$ssID);
                $this->db->limit(1);
                $ss_row =$this->db->get('single_sales')->row_array();
                if (!empty($ss_row)) {
                    $repeatedAttempts++;
                    if ($repeatedAttempts >= 5) {
                        break;
                    }
                } else {
                    break;
                }
            } while (true);
            if ($ssID != '') {
                $url = base_url() . 'SingleSales/' . $ssID;
                $insertData = array(
                    'id' => $ssID,
                    'product_id' => $this->input->post('product_id'),
                    'url' => $url,
                    'status' => 'Test',
                );
                $this->db->insert('single_sales',$insertData);
                if ($this->db->affected_rows() > 0) {
                    echo '/admin/sales/editSingleSales/' . $ssID;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function editSingleSales($id) {
        $this->data['SingleSalesDetail'] = $this->sales_model->getSingleSalesDetail($id);
        $this->data['SingleSalesAgentDetail'] = $this->sales_model->getSingleSalesAgentDetail($id);
        $this->data['AgentList'] = $this->agent_model->getAgentList();
        $this->data['page_title'] = '銷售頁面編輯';
        $this->render('admin/sales/edit');
    }

    function updateEditAllData() {
        $this->input->post('single_sales_agent_list');
        if (!empty($this->input->post('single_sales_agent_list'))) {
            foreach ($this->input->post('single_sales_agent_list') as $row) {
                $update_data = array(
                    'name' => $row['agent_name'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->db->where('id',$row['agent_id']);
                $this->db->update('agent', $update_data);
                $update_data = array(
                    'name' => $row['single_sales_agent_name'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->db->where('id',$row['single_sales_agent_id']);
                $this->db->update('single_sales_agent', $update_data);
            }
        }
        $update_data = array(
            'pre_date' => $this->input->post('pre_date'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id',$this->input->post('sales_id'));
        $this->db->update('single_sales', $update_data);
    }


}