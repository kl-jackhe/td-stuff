<?php defined('BASEPATH') or exit('No direct script access allowed');

class Banner_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getRows($params = array())
    {
        $this->db->select('*');
        $this->db->from('banner');
        if (!empty($params['search']['keywords'])) {
            $this->db->like('banner_name', $params['search']['keywords']);
        }
        if (!empty($params['search']['sortBy'])) {
            $this->db->order_by('banner_sort', $params['search']['sortBy']);
        } else {
            $this->db->order_by('banner_sort', 'asc');
        }
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : false;
    }
}
