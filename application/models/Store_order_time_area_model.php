<?php defined('BASEPATH') OR exit('No direct script access allowed');

class store_order_time_area_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getRowsCount($params = array()){
        $this->db->select('store_order_time_area_id');
        $this->db->from('store_order_time_area');
        //filter data by searched keywords
        // if(!empty($params['search']['keywords'])){
        //     $this->db->like('store_name',$params['search']['keywords']);
        // }
        if(!empty($params['search']['category'])){
            $this->db->where('store_id',$params['search']['category']);
        }
        //sort data by ascending or desceding order
        // if(!empty($params['search']['sortBy'])){
        //     $this->db->order_by('store_order_time_area',$params['search']['sortBy']);
        // }else{
        //     $this->db->order_by('store_order_time_area','desc');
        // }
        // if(!empty($params['search']['status'])){
        //     $this->db->where('store_status',$params['search']['status']);
        // } else {
        //     $this->db->where('store_status', '1');
        // }
        if(!empty($params['search']['county'])){
            $this->db->where('delivery_county',$params['search']['county']);
        }
        if(!empty($params['search']['district']) && $params['search']['district']!='全區'){
            $this->db->where('delivery_district',$params['search']['district']);
        }
        // $this->db->where('store_order_time_area >=', date('Y-m-d'));
        // $this->db->order_by('store_order_time_area','desc');
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

    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('store_order_time_area');
        //filter data by searched keywords
        // if(!empty($params['search']['keywords'])){
        //     $this->db->like('store_name',$params['search']['keywords']);
        // }
        if(!empty($params['search']['category'])){
            $this->db->where('store_id',$params['search']['category']);
        }
        //sort data by ascending or desceding order
        // if(!empty($params['search']['sortBy'])){
        //     $this->db->order_by('store_order_time_area',$params['search']['sortBy']);
        // }else{
        //     $this->db->order_by('store_order_time_area','desc');
        // }
        // if(!empty($params['search']['status'])){
        //     $this->db->where('store_status',$params['search']['status']);
        // } else {
        //     $this->db->where('store_status', '1');
        // }
        if(!empty($params['search']['county'])){
            $this->db->where('delivery_county',$params['search']['county']);
        }
        if(!empty($params['search']['district']) && $params['search']['district']!='全區'){
            $this->db->where('delivery_district',$params['search']['district']);
        }
        // $this->db->where('store_order_time_area >=', date('Y-m-d'));
        $this->db->order_by('store_order_time_area','desc');
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