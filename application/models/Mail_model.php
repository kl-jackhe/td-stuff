<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mail_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getRows($params = array())
    {
        $this->db->select('*');
        $this->db->from('contact');
        $this->db->order_by("datetime DESC", "datetime2 DESC", "contid DESC");
        //filter data by searched keywords
        if (!empty($params['search']['keywords'])) {
            $this->db->group_start();
            $this->db->like('tel', $params['search']['keywords']);
            $this->db->or_like('email', $params['search']['keywords']);
            $this->db->or_like('cpname', $params['search']['keywords']);
            $this->db->or_like('custname', $params['search']['keywords']);
            $this->db->group_end();
        }
        if (!empty($params['search']['sortBy'])) {
            $this->db->order_by('contid', $params['search']['sortBy']);
        } else {
            $this->db->order_by('contid', 'desc');
        }
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
            $result = $this->db->count_all_results();
        } else {
            //get records
            $query = $this->db->get();
            //return fetched data
            $result = ($query->num_rows() > 0) ? $query->result_array() : false;
        }
        return $result;
    }
}
