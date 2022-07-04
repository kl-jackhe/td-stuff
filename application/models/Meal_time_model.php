<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Meal_time_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('meal_time');
        //filter data by searched keywords
        // if(!empty($params['search']['keywords'])){
        //     $this->db->like('meal_time_name',$params['search']['keywords']);
        //     $this->db->or_like('meal_time_team',$params['search']['keywords']);
        // }
        // if(!empty($params['search']['category'])){
        //     $this->db->where('meal_time_category',$params['search']['category']);
        // }
        //sort data by ascending or desceding order
        // if(!empty($params['search']['sortBy'])){
        //     $this->db->order_by('meal_time_id',$params['search']['sortBy']);
        // }else{
        //     $this->db->order_by('meal_time_id','desc');
        // }
        if(!empty($params['search']['status'])){
            $this->db->where('meal_time_status',$params['search']['status']);
        } else {
            $this->db->where('meal_time_status', '1');
        }
        $this->db->order_by('meal_time_content_start','asc');
        //set start and limit
        // if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
        //     $this->db->limit($params['limit'],$params['start']);
        // }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
        //     $this->db->limit($params['limit']);
        // }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

}