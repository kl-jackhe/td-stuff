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

    function getPaymentName()
    {
        $this->db->select('id, payment_code, payment_name');
        $query = $this->db->get('payment');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function getCouponName($id)
    {
        $this->db->select('name');
        $this->db->where('id', $id);
        $query = $this->db->get('new_coupon');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function getCoupons($id)
    {
        $this->db->select('*');
        $this->db->where('custom_id', $id);
        $this->db->order_by('discontinued_at', 'desc');
        $query = $this->db->get('new_coupon_custom');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function getAllCoupons()
    {
        $this->db->select('*');
        $query = $this->db->get('new_coupon');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function getOrders($id)
    {
        $this->db->select('*');
        $this->db->where('main_order_number', '');
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

    function getMails()
    {
        $this->db->select('*');
        $this->db->where('tel', $this->session->userdata('identity'));
        $this->db->order_by('datetime', 'desc');
        $query = $this->db->get('contact');
        if (empty($query)) {
            $this->db->select('*');
            $this->db->where('email', $this->session->userdata('identity'));
            $this->db->order_by('datetime', 'desc');
            $query = $this->db->get('contact');
        }
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

    function getLanguageData($lang)
    {
        $this->db->where('page_lang', $lang);
        $this->db->like('page_name', 'TermsOfService', 'both');
        $query = $this->db->get('standard_page_list');
        return (!empty($query) ? $query->row_array() : false);
    }

    function getOrderMessage($order_id)
    {
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('guestbook')->result_array();
        return !empty($query) ? $query : false;
    }
}
