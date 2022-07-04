<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Car_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('car');
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('car_name',$params['search']['keywords']);
        }
        if(!empty($params['search']['category'])){
            $this->db->where('car_category',$params['search']['category']);
        }
        if(!empty($params['search']['status'])){
            $this->db->where('car_status',$params['search']['status']);
        } else {
            $this->db->where('car_status', '1');
        }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('car_id',$params['search']['sortBy']);
        }else{
            $this->db->order_by('car_id','desc');
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

    function get_fuel_consumption($params = array()){
        $this->db->select('*');
        $this->db->from('fuel_consumption');
        //filter data by searched keywords
        if(!empty($params['search']['status'])){
            $this->db->where('fuel_consumption_status',$params['search']['status']);
        } else {
            $this->db->where('fuel_consumption_status', '1');
        }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('fuel_consumption_id',$params['search']['sortBy']);
        }else{
            $this->db->order_by('fuel_consumption_id','desc');
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