<?php defined('BASEPATH') or exit('No direct script access allowed');

class Delivery_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getSortDesc()
    {
        $this->db->select('*');
        $this->db->order_by('delivery_sort', 'asc');
        $result = $this->db->get('delivery')->result_array();
        return !empty($result) ? $result : false;
    }

    function getSortOpenDesc()
    {
        $this->db->select('*');
        $this->db->where('delivery_status', '1');
        $this->db->order_by('delivery_sort', 'asc');
        $result = $this->db->get('delivery')->result_array();
        return !empty($result) ? $result : false;
    }
}
