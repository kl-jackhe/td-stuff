<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cross_industry_alliance_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('cross_industry_alliance');
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('cross_industry_alliance_name',$params['search']['keywords']);
            $this->db->or_like('cross_industry_alliance_email',$params['search']['keywords']);
        }
        // if(!empty($params['search']['category'])){
        //     $this->db->where('cross_industry_alliance_category',$params['search']['category']);
        // }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('cross_industry_alliance_id',$params['search']['sortBy']);
        }else{
            $this->db->order_by('cross_industry_alliance_id','desc');
        }
        // if(!empty($params['search']['status'])){
        //     $this->db->where('cross_industry_alliance_status',$params['search']['status']);
        // } else {
        //     $this->db->where('cross_industry_alliance_status', '1');
        // }
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