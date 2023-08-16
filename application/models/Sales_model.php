<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getRows($params = array()) {
        $this->db->select('id,product_id,url,pre_date,start_date,end_date,stock_qty,cost,qty,unit,default_profit_percentage,status,created_at,updated_at');
        if (!empty($params['search']['status'])) {
            if ($params['search']['status'] == 'History') {
                $this->db->where('status', 'Closure');
                $this->db->or_where('status', 'OutSale');
            } else {
                $this->db->where('status', $params['search']['status']);
            }
        }
        // if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
        //     $this->db->limit($params['limit'], $params['start']);
        // } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
        //     $this->db->limit($params['limit']);
        // }
        $query = $this->db->get('single_sales')->result_array();
        return (!empty($query)? $query : false);
    }

    function getSingleSalesList() {
        $this->db->select('id,product_id,url,pre_date,start_date,end_date,stock_qty,cost,qty,unit,default_profit_percentage,status,created_at,updated_at');
        $query = $this->db->get('single_sales')->result_array();
        return (!empty($query)? $query : false);
    }

    function getSingleSalesDetail($id) {
        $this->db->select('id,product_id,url,pre_date,start_date,end_date,stock_qty,cost,qty,unit,default_profit_percentage,status,created_at,updated_at');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $row = $this->db->get('single_sales')->row_array();
        return (!empty($row)? $row : false);
    }

    function getSingleSalesAgentList() {
        $this->db->select('id,single_sales_id,agent_id,name,name_style,time_description,cost,pre_hits,start_hits,profit_percentage,created_at,updated_at');
        $query = $this->db->get('single_sales_agent')->result_array();
        return (!empty($query)? $query : false);
    }

    function getSingleSalesAgentDetail($single_sales_id) {
        $this->db->select('
            single_sales_agent.id AS single_sales_agent_id,
            single_sales_id,
            single_sales_agent.name AS single_sales_agent_name,
            single_sales_agent.name_style AS single_sales_agent_name_style,
            single_sales_agent.time_description,
            single_sales_agent.cost,
            single_sales_agent.profit_percentage,
            single_sales_agent.order_qty,
            single_sales_agent.finish_qty,
            single_sales_agent.cancel_qty,
            single_sales_agent.turnover_rate,
            single_sales_agent.turnover_amount,
            single_sales_agent.income,
            single_sales_agent.created_at,
            single_sales_agent.updated_at
            ');
        $this->db->select('
            agent.id AS agent_id,
            agent.name AS agent_name,
            agent.users_id,
            agent.status
            ');
        $this->db->join('agent', 'agent.id = single_sales_agent.agent_id');
        $this->db->where('single_sales_id', $single_sales_id);
        $query = $this->db->get('single_sales_agent')->result_array();
        return (!empty($query)? $query : false);
    }

    function checkSingleSalesAgentIsDuplicate($single_sales_id,$agent_id) {
        $this->db->select('id,single_sales_id,agent_id');
        $this->db->where('single_sales_id',$single_sales_id);
        $this->db->where('agent_id', $agent_id);
        $this->db->limit(1);
        $row = $this->db->get('single_sales_agent')->row_array();
        return (!empty($row)? $row : false);
    }

    function getAgentName($single_sales_id,$agent_id) {
        $this->db->select('id,name,name_style,time_description');
        $this->db->where('single_sales_id',$single_sales_id);
        $this->db->where('agent_id', $agent_id);
        $this->db->limit(1);
        $row = $this->db->get('single_sales_agent')->row_array();
        return (!empty($row)? $row : false);
    }

    function updateSingleSalesStatus($id,$status) {
        $update_data = array(
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id',$id);
        $this->db->update('single_sales', $update_data);
    }

    function getSingleSalesListIsCanChange() {
        $this->db->select('id,pre_date,start_date,end_date,status');
        $this->db->where('status','ForSale');
        $this->db->or_where('status','OnSale');
        $this->db->or_where('status','Test');
        $query = $this->db->get('single_sales')->result_array();
        return (!empty($query)? $query : false);
    }

}