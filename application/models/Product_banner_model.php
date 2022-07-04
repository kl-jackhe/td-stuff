<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_banner_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('product_banner');
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('product_banner_name',$params['search']['keywords']);
        }
        // if(!empty($params['search']['category'])){
        //     $this->db->where('product_banner_category',$params['search']['category']);
        // }
        if(!empty($params['search']['status'])){
            $this->db->where('product_banner_status',$params['search']['status']);
        } else {
            $this->db->where('product_banner_status', '1');
        }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('product_banner_id',$params['search']['sortBy']);
        }else{
            $this->db->order_by('product_banner_id','desc');
        }
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

}