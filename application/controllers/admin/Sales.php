<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends Admin_Controller {

	function __construct() {
		parent::__construct();
        $this->load->model('order_model');
        $this->load->model('sales_model');
        $this->load->model('agent_model');
	}

    function page()
    {
        $this->data['page_title'] = '銷售頁面';
        $this->render('admin/sales/page/index');
    }

    function pageAjaxData() {
        $conditions = array();
        $page = $this->input->get('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $status = $this->input->get('status');
        if (!empty($status)) {
            $conditions['search']['status'] = $status;
        }
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $this->data['SingleSales'] = $this->sales_model->getRows($conditions);
        $this->data['SingleSalesAgent'] = $this->sales_model->getSingleSalesAgentList();
        $this->data['SingleStatus'] = $this->input->get('status');
        //load the view
        $this->load->view('admin/sales/page/ajax-data', $this->data, false);
    }

    function history()
    {
        $this->data['page_title'] = '銷售紀錄';
        $this->data['SingleSales'] = $this->sales_model->getSingleSalesList();
        $this->data['SingleSalesAgent'] = $this->sales_model->getSingleSalesAgentList();
        $this->render('admin/sales/history/index');
    }

    function ajaxData() {
        $conditions = array();
        $page = $this->input->get('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $keywords = $this->input->get('keywords');
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        if (!empty($keywords)) {
            $conditions['search']['keywords'] = $keywords;
        }
        if (!empty($start_date)) {
            $conditions['search']['start_date'] = $start_date;
        }
        if (!empty($end_date)) {
            $conditions['search']['end_date'] = $end_date;
        }
        //total rows count
        $conditions['returnType'] = 'count';
        $totalRec = $this->order_model->getSalesHistoryRows($conditions);
        //pagination configuration
        $config['target'] = '#datatable';
        $config['base_url'] = base_url() . 'admin/sales/ajaxData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $conditions['returnType'] = '';
        $this->data['orders'] = $this->order_model->getSalesHistoryRows($conditions);
        //load the view
        $this->load->view('admin/sales/history/ajax-data', $this->data, false);
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
        $this->data['product'] = $this->mysql_model->_select('product', 'product_id', $this->data['SingleSalesDetail']['product_id'], 'row');
        $this->data['product_unit'] = $this->mysql_model->_select('single_product_unit', 'product_id', $this->data['SingleSalesDetail']['product_id']);
        $this->data['product_specification'] = $this->mysql_model->_select('single_product_specification', 'product_id', $this->data['SingleSalesDetail']['product_id']);
        $this->data['product_combine'] = $this->mysql_model->_select('single_product_combine', 'product_id', $this->data['SingleSalesDetail']['product_id']);
        $this->data['page_title'] = '銷售頁面編輯';
        $this->render('admin/sales/page/edit');
    }

    function updateEditAllData() {
        $this->input->post('single_sales_agent_list');
        if (!empty($this->input->post('single_sales_agent_list'))) {
            foreach ($this->input->post('single_sales_agent_list') as $row) {
                $style = array(
                    'color_style' => strval($row['color_style']),
                    'font_size_style' => strval($row['font_size_style']),
                    'background_color_style' => strval($row['background_color_style']),
                );
                $update_data = array(
                    'name' => $row['agent_name'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->db->where('id',$row['agent_id']);
                $this->db->update('agent', $update_data);
                $update_data = array(
                    'name' => $row['single_sales_agent_name'],
                    'name_style' => json_encode($style),
                    'profit_percentage' => $row['profit_percentage'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->db->where('single_sales_id',$this->input->post('sales_id'));
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

    function updateSingleSalesStatus() {
        $update_data = array(
            'status' => $this->input->post('status'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id',$this->input->post('id'));
        $this->db->update('single_sales', $update_data);
    }

    function create_plan($id) {
        $this->data['product'] = $this->mysql_model->_select('product', 'product_id', $id, 'row');
        $this->data['product_specification'] = $this->mysql_model->_select('single_product_specification', 'product_id', $id);
        $this->load->view('admin/sales/page/product/product_create_plan', $this->data);
    }

    function insert_plan() {
        $data = array(
            'product_id' => $this->input->post('product_id'),
            'name' => $this->input->post('product_combine_name'),
            'price' => $this->input->post('product_combine_price'),
            'current_price' => $this->input->post('product_combine_current_price'),
            'picture' => $this->input->post('product_combine_image'),
            'description' => $this->input->post('product_combine_description'),
        );
        $id = $this->mysql_model->_insert('single_product_combine', $data);
        $qty = $this->input->post('plan_qty');
        $unit = $this->input->post('plan_unit');
        $specification = $this->input->post('plan_specification');
        $count = count($qty);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($qty)) {
                $insert_data = array(
                    'product_id' => $this->input->post('product_id'),
                    'product_combine_id' => $id,
                    'qty' => $qty[$i],
                    'product_unit' => get_empty($unit[$i]),
                    'product_specification' => get_empty($specification[$i]),
                );
                $this->db->insert('single_product_combine_item', $insert_data);
            }
        }
    }

    function edit_plan($id) {
        $this->data['product_combine'] = $this->mysql_model->_select('single_product_combine', 'id', $id, 'row');
        $product_id = $this->data['product_combine']['product_id'];
        $this->data['product'] = $this->mysql_model->_select('product', 'product_id', $product_id, 'row');
        $this->data['product_unit'] = $this->mysql_model->_select('single_product_unit', 'product_id', $product_id);
        $this->data['product_specification'] = $this->mysql_model->_select('single_product_specification', 'product_id', $product_id);
        $this->data['product_combine_item'] = $this->mysql_model->_select('single_product_combine_item', 'product_combine_id', $this->data['product_combine']['id']);

        $this->load->view('admin/sales/page/product/product_edit_plan', $this->data);
    }

    function update_plan($id) {
        $this->data['product_combine'] = $this->mysql_model->_select('single_product_combine', 'id', $id, 'row');

        $update_data = array(
            'product_id' => $this->input->post('product_id'),
            'name' => $this->input->post('product_combine_name'),
            'price' => $this->input->post('product_combine_price'),
            'current_price' => $this->input->post('product_combine_current_price'),
            'picture' => $this->input->post('product_combine_image'),
            'description' => $this->input->post('product_combine_description'),
            'type' => $this->input->post('any_specification'),
            'limit_enable' => $this->input->post('limit_enable'),
        );
        $this->db->where('id', $id);
        $this->db->update('single_product_combine', $update_data);

        $this->db->where('product_combine_id', $id);
        $this->db->delete('single_product_combine_item');

        $qty = $this->input->post('plan_qty');
        $unit = $this->input->post('plan_unit');
        $specification = $this->input->post('plan_specification');
        $count = count($qty);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($qty)) {
                $insert_data = array(
                    'product_id' => $this->input->post('product_id'),
                    'product_combine_id' => $id,
                    'qty' => $qty[$i],
                    'product_unit' => get_empty($unit[$i]),
                    'product_specification' => get_empty($specification[$i]),
                );
                $this->db->insert('single_product_combine_item', $insert_data);
            }
        }
        $this->session->set_flashdata('message', '商品更新成功！');
    }

    function delete_plan($id) {
        $this->db->where('id', $id);
        $this->db->delete('single_product_combine');

        $this->db->where('product_combine_id', $id);
        $this->db->delete('single_product_combine_item');

        redirect($_SERVER['HTTP_REFERER']);
    }


}