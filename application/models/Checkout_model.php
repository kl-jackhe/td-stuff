<?php defined('BASEPATH') or exit('No direct script access allowed');
class Checkout_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getECPay($id = 3)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('payment');
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
}
