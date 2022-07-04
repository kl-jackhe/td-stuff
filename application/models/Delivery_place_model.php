<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_place_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('delivery_place');
        //filter data by searched keywords
        // if(!empty($params['search']['keywords'])){
        //     $this->db->like('delivery_place_name',$params['search']['keywords']);
        //     $this->db->or_like('delivery_place_team',$params['search']['keywords']);
        // }
        // if(!empty($params['search']['category'])){
        //     $this->db->where('delivery_place_category',$params['search']['category']);
        // }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('delivery_place_id',$params['search']['sortBy']);
        }else{
            $this->db->order_by('delivery_place_id','desc');
        }
        if(!empty($params['search']['status'])){
            $this->db->where('delivery_place_status',$params['search']['status']);
        } else {
            $this->db->where('delivery_place_status', '1');
        }
        if(!empty($params['search']['county'])){
            $this->db->where('delivery_place_county',$params['search']['county']);
        }
        if(!empty($params['search']['district'])){
            $this->db->where('delivery_place_district',$params['search']['district']);
        }
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