<?php defined('BASEPATH') or exit('No direct script access allowed');
class Checkout_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getECPay($id = 1)
    {
        $this->db->select('*');
        $this->db->where('pay_id', $id);
        $query = $this->db->get('features_pay');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function getSelectedOrder($id)
    {
        $this->db->select('*');
        $this->db->where('order_id', $id);
        $query = $this->db->get('orders');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function getDelivery($name_code)
    {
        $this->db->select('*');
        $this->db->where('delivery_name_code', $name_code);
        $query = $this->db->get('delivery');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function getCoustomCoupons($id)
    {
        $this->db->select('*');
        $this->db->where('custom_id', $id);
        $this->db->order_by('LENGTH(type), type');
        $query = $this->db->get('new_coupon_custom');
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
}
