<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends Admin_Controller {

	function __construct() {
		parent::__construct();
        $this->load->model('order_model');
        $this->load->model('sales_model');
        $this->load->model('agent_model');
        $this->load->model('product_model');
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
        $this->data['payment'] = $this->order_model->getPaymentList();
        $this->data['delivery'] = $this->order_model->getDeliveryList();
        $this->data['agent'] = $this->agent_model->getAgentList();
        $this->data['product'] = $this->product_model->getProductList();
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
        //set conditions for search
        $keywords = $this->input->get('keywords');
        $product = $this->input->get('product');
        $category = $this->input->get('category');
        $category1 = $this->input->get('category1');
        $category2 = $this->input->get('category2');
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $sales = $this->input->get('sales');
        $agent = $this->input->get('agent');
        if (!empty($keywords)) {
            $conditions['search']['keywords'] = $keywords;
        }
        if (!empty($product)) {
            $conditions['search']['product'] = $product;
        }
        if (!empty($category)) {
            $conditions['search']['step'] = $category;
        }
        if (!empty($category1)) {
            $conditions['search']['delivery'] = $category1;
        }
        if (!empty($category2)) {
            $conditions['search']['payment'] = $category2;
        }
        if (!empty($start_date)) {
            $conditions['search']['start_date'] = $start_date;
        }
        if (!empty($end_date)) {
            $conditions['search']['end_date'] = $end_date;
        }
        if (!empty($sales)) {
            $conditions['search']['sales'] = $sales;
        }
        if (!empty($agent)) {
            $conditions['search']['agent'] = $agent;
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

        $this->data['orders'] = $this->order_model->getSalesPageHistoryList($id);

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
                    'time_description' => $row['time_description'],
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
            'default_profit_percentage' => $this->input->post('default_profit_percentage'),
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

    function calculationReport() {
        $ssd_row = $this->sales_model->getSingleSalesDetail($this->input->post('id'));
        if (!empty($ssd_row)) {
            $ssad_query = $this->sales_model->getSingleSalesAgentDetail($ssd_row['id']);
            if ($ssd_row['default_profit_percentage'] > 0) {
                if (!empty($ssad_query)) {
                    foreach ($ssad_query as $ssad_row) {
                        $turnoverAmount = $this->calculationTurnoverAmount($ssad_row['single_sales_id'],$ssad_row['agent_id']);
                        $income = $this->calculationIncome($turnoverAmount,$ssd_row['default_profit_percentage'],$ssad_row['agent_id'],$ssad_row['profit_percentage']);
                        $orderQtyList = $this->calculationOrderQTY($ssad_row['single_sales_id'],$ssad_row['agent_id']);
                        $turnoverRate = $this->calculationTurnoverRate($orderQtyList);
                        $this->updateCalculationResults($turnoverAmount,$income,$orderQtyList,$turnoverRate,$ssad_row['single_sales_agent_id'],$ssd_row['id']);
                    }
                    $this->data['SingleSalesDetail'] = $ssd_row;
                    $this->data['SingleSalesAgentList'] = $this->sales_model->getSingleSalesAgentDetail($ssd_row['id']);
                    $this->load->view('/admin/report/single_sales_agent_report', $this->data);
                    echo 'yes';
                } else {
                    echo 'no';
                }
            } else {
                echo 'no_default_profit_percentage';
            }
        } else {
            echo 'no';
        }
    }

    function calculationTurnoverAmount($single_sales_id,$agent_id) {
        $this->db->select_sum('order_discount_total');
        $this->db->where('single_sales_id',$single_sales_id);
        $this->db->where('agent_id',$agent_id);
        $this->db->where('order_step','complete');
        $this->db->where('order_status','1');
        $row = $this->db->get('orders')->row_array();
        return (!empty($row) ? $row['order_discount_total'] : 0);
    }

    function calculationIncome($turnoverAmount,$default_profit_percentage,$agent_id,$profit_percentage) {
        $income = 0;
        if ($turnoverAmount > 0) {
            $income = round($turnoverAmount * (($profit_percentage > 0 ? $profit_percentage : $default_profit_percentage)/100));
        }
        return $income;
    }

    function calculationOrderQTY($single_sales_id,$agent_id) {
        $total_qty = 0;
        $complete_qty = 0;
        $cancel_qty = 0;
        $other_qty = 0;
        $this->db->select('order_id,order_step');
        $this->db->where('single_sales_id',$single_sales_id);
        $this->db->where('agent_id',$agent_id);
        $this->db->where('order_status','1');
        $query = $this->db->get('orders')->result_array();
        if (!empty($query)) {
            foreach ($query as $row) {
                $total_qty++;
                if ($row['order_step'] == 'complete') {
                    $complete_qty++;
                } elseif ($row['order_step'] == 'order_cancel') {
                    $cancel_qty++;
                } else {
                    $other_qty++;
                }
            }
        }
        $orderQtyArray = array(
            'total_qty' => $total_qty,
            'complete' => $complete_qty,
            'cancel' => $cancel_qty,
            'other' => $other_qty,
        );
        return $orderQtyArray;
    }

    function calculationTurnoverRate($orderQtyList) {
        $turnoverRate = 0;
        if ($orderQtyList['total_qty'] > 0) {
            $turnoverRate = floor(($orderQtyList['complete'] / $orderQtyList['total_qty']) * 100);
        }
        return $turnoverRate;
    }

    function updateCalculationResults($turnoverAmount,$income,$orderQtyList,$turnoverRate,$single_sales_agent_id,$id) {
        $updateData = array(
            'turnover_amount' => $turnoverAmount,
            'income' => $income,
            'order_qty' => $orderQtyList['total_qty'],
            'finish_qty' => $orderQtyList['complete'],
            'cancel_qty' => $orderQtyList['cancel'],
            'other_qty' => $orderQtyList['other'],
            'turnover_rate' => $turnoverRate,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id',$single_sales_agent_id);
        $this->db->update('single_sales_agent',$updateData);

        $update_data = array(
            'status' => 'Closure',
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id',$id);
        $this->db->update('single_sales', $update_data);
    }

    function viewCalculationReport() {
        $this->data['SingleSalesDetail'] = $this->sales_model->getSingleSalesDetail($this->input->post('id'));
        $this->data['SingleSalesAgentList'] = $this->sales_model->getSingleSalesAgentDetail($this->input->post('id'));
        $this->load->view('/admin/report/single_sales_agent_report', $this->data);
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