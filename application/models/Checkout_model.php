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
}
