<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getBanner()
    {
        $this->db->where('banner_on_the_shelf <=', date('Y-m-d H:i:s'));
        $this->db->where('banner_off_the_shelf >=', date('Y-m-d H:i:s'));
        $this->db->where('banner_status', '1');
        $this->db->order_by('banner_sort','asc');
        $query = $this->db->get('banner');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function get_users_address($id)
    {
        $this->db->where('user_id', $id);
        $this->db->where('used', 1);
        $this->db->limit(1);
        // $this->db->order_by('id','desc');
        $query = $this->db->get('users_address');
        return ($query->num_rows() > 0)?$query->row_array():false;
    }

}