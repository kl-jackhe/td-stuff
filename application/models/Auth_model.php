<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getAuthVisiterCategory()
    {
        $this->db->select('*');
        $query = $this->db->get('auth_visiter_category')->result_array();
        return (!empty($query) ? $query : false);
    }

    function getAuthMemberCategory()
    {
        $this->db->select('*');
        $query = $this->db->get('auth_member_category')->result_array();
        return (!empty($query) ? $query : false);
    }

    function getOrders($id)
    {
        $this->db->select('*');
        $this->db->where('customer_id', $id);
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get('orders');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function getOrderItem($id)
    {
        $this->db->select('*');
        $this->db->where('customer_id', $id);
        $query = $this->db->get('order_item');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function getStandardPageList($name = null)
    {
        $this->db->select('*');
        if (!empty($name)) {
            $this->db->where('page_name', $name);
            $query = $this->db->get('standard_page_list');
        } else {
            $query = $this->db->get('standard_page_list');
        }

        if (!empty($name) && $query->num_rows() > 0) {
            return $query->row_array();
        } elseif (empty($name) && $query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}
