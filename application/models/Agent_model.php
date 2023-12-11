<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Agent_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getRows($params = array()) {
        $this->db->select('id,name,users_id,status,created_at,updated_at');
        if (!empty($params['search']['status'])) {
            $this->db->where('status', ($params['search']['status'] == 'Enabled' ? true : false));
        }
        $query = $this->db->get('agent')->result_array();
        return (!empty($query)? $query : false);
    }

    function getAgentList() {
        $this->db->select('id,name,users_id,status,created_at,updated_at');
        $this->db->where('status',1);
        $query = $this->db->get('agent')->result_array();
        return (!empty($query)? $query : false);
    }

    function getUsersList() {
        $this->db->select('users.id,users.username,users.email,users.full_name,users.phone,users.birthday');
        $this->db->join('users_groups','users_groups.user_id = users.id');
        $this->db->where('users_groups.group_id', 2);
        $this->db->where('users.active', 1);
        $query = $this->db->get('users')->result_array();
        return (!empty($query)? $query : false);
    }

    function getAgentName($agent_id) {
        $this->db->select('id,name');
        $this->db->where('id', $agent_id);
        $this->db->limit(1);
        $row = $this->db->get('agent')->row_array();
        return (!empty($row)? $row['name'] : '');
    }

    function getAgentDetail($id) {
        $this->db->select('agent.id,agent.name,agent.full_name,agent.phone,agent.address,agent.remark,agent.users_id,agent.status,agent.created_at,agent.updated_at');
        // $this->db->select('users.username,users.gender,users.email AS users_email,users.full_name AS users_full_name,users.phone AS users_phone,users.county,users.district,users.address AS users_address,users.birthday,users.company,users.status AS users_status');
        // $this->db->join('users','users.id = agent.users_id');
        $this->db->where('agent.id', $id);
        $this->db->limit(1);
        $row = $this->db->get('agent')->row_array();
        return (!empty($row)? $row : false);
    }

    function getAgentSalesPage($id) {
        $this->db->select('
            single_sales_agent.id as single_sales_agent_id,
            single_sales_agent.agent_id as agent_id,
            single_sales_agent.name AS single_sales_agent_name,
            single_sales_agent.name_style AS single_sales_agent_name_style,
            single_sales_agent.time_description,
            single_sales_agent.cost,
            single_sales_agent.profit_percentage,
            single_sales_agent.pre_hits,
            single_sales_agent.start_hits,
            single_sales_agent.order_qty,
            single_sales_agent.finish_qty,
            single_sales_agent.cancel_qty,
            single_sales_agent.turnover_rate,
            single_sales_agent.turnover_amount,
            single_sales_agent.income');
        $this->db->select('
            single_sales.id as single_sales_id,
            single_sales.product_id,
            single_sales.url,
            single_sales.pre_date,
            single_sales.start_date,
            single_sales.end_date,
            single_sales.stock_qty,
            single_sales.cost,
            single_sales.qty,
            single_sales.unit,
            single_sales.default_profit_percentage,
            single_sales.status');
        $this->db->join('single_sales', 'single_sales.id = single_sales_agent.single_sales_id');
        $this->db->where('agent_id', $id);
        $query = $this->db->get('single_sales_agent')->result_array();
        return (!empty($query) ? $query : false);
    }

    function getAgentSalesOrderList($id) {
        $this->db->select('order_id,order_number,order_date,store_id,customer_id,customer_name,customer_phone,customer_email,order_total,order_discount_total,order_discount_price,order_delivery_cost,order_delivery_place,order_delivery_address,order_delivery_time,order_store_name,order_store_address,order_delivery,order_payment,remittance_account,order_coupon,order_step,order_pay_status,order_pay_feedback,order_remark,order_void,order_void_reason,order_status,single_sales_id,agent_id,agent_profit_amount,creator_id,updater_id,created_at,updated_at');
        $this->db->where('agent_id', $id);
        $query = $this->db->get('orders')->result_array();
        return (!empty($query) ? $query : false);
    }

}