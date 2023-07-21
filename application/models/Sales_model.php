<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getSingleSalesList() {
        $this->db->select('id,product_id,url,pre_date,start_date,end_date,stock_qty,cost,status,created_at,updated_at');
        $query = $this->db->get('single_sales')->result_array();
        return (!empty($query)? $query : false);
    }

    function getSingleSalesDetail($id) {
        $this->db->select('id,product_id,url,pre_date,start_date,end_date,stock_qty,cost,status,created_at,updated_at');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $row = $this->db->get('single_sales')->row_array();
        return (!empty($row)? $row : false);
    }

    function getSingleSalesAgentList() {
        $this->db->select('id,single_sales_id,agent_id,name,cost,created_at,updated_at');
        $query = $this->db->get('single_sales_agent')->result_array();
        return (!empty($query)? $query : false);
    }

    function getSingleSalesAgentDetail($id) {
        $this->db->select('single_sales_agent.id AS single_sales_agent_id,single_sales_id,agent_id,single_sales_agent.name AS single_sales_agent_name,single_sales_agent.cost,single_sales_agent.created_at,single_sales_agent.updated_at');
        $this->db->select('agent.id AS agent_id,agent.name AS agent_name,agent.users_id,agent.status');
        $this->db->join('agent', 'agent.id = single_sales_agent.agent_id');
        $this->db->where('single_sales_id', $id);
        $query = $this->db->get('single_sales_agent')->result_array();
        return (!empty($query)? $query : false);
    }

    function getSingleSalesProductID($id) {
        $this->db->select('product_id');
        $this->db->where('id',$id);
        $this->db->limit(1);
        $row = $this->db->get('single_sales')->row_array();
        return (!empty($row)? $row : false);
    }

    function checkSingleSalesAgentIsDuplicate($single_sales_id,$agent_id) {
        $this->db->select('id,single_sales_id,agent_id');
        $this->db->where('single_sales_id',$single_sales_id);
        $this->db->where('agent_id', $agent_id);
        $this->db->limit(1);
        $row = $this->db->get('single_sales_agent')->row_array();
        return (!empty($row)? $row : false);
    }

}