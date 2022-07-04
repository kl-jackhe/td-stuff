<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Service_area_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('service_area');
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('service_area_name',$params['search']['keywords']);
        }
        // if(!empty($params['search']['category'])){
        //     $this->db->where('service_area_category',$params['search']['category']);
        // }
        //sort data by ascending or desceding order
        // if(!empty($params['search']['sortBy'])){
        //     $this->db->where('service_area_off_day',$params['search']['sortBy']);
        // }
        // if(!empty($params['search']['status'])){
        //     $this->db->where('service_area_status',$params['search']['status']);
        // } else {
        //     $this->db->where('service_area_status', '1');
        // }
        if(!empty($params['search']['county'])){
            $this->db->where('service_area_county',$params['search']['county']);
        }
        // if(!empty($params['search']['district'])){
        //     $this->db->where('store_district',$params['search']['district']);
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

    function get_user_service_area($user_id) {
        $this->db->join('service_area', 'service_area.service_area_code = user_service_area.service_area_code');
        $this->db->where('service_area_is_uesd', 'n');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('service_area_expiry_date', 'asc');
        $query = $this->db->get('user_service_area');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    function get_user_all_service_area($user_id) {
        $this->db->join('service_area', 'service_area.service_area_code = user_service_area.service_area_code');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('service_area_expiry_date', 'asc');
        $query = $this->db->get('user_service_area');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function get_hide_county()
    {
        $array_data = array();

        $this->db->group_by('service_area_county');
        $query0 = $this->db->get('service_area');

        $this->db->where('service_area_status', 1);
        $this->db->group_by('service_area_county');
        $query1 = $this->db->get('service_area');

        if($query0->num_rows()>0){
                foreach ($query0->result_array() as $value0) {
                    // if($value0['service_area_county']!=$value1['service_area_county']){
                        array_push($array_data, $value0['service_area_county']);
                    // }
                }
        }
        if($query1->num_rows()>0){
            foreach ($query1->result_array() as $value1) {
                if (($key = array_search($value1['service_area_county'], $array_data)) !== false) {
                    unset($array_data[$key]);
                }
            }
        }
        return $array_data;
        // return ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function get_hide_district()
    {
        $array_data = array();

        $this->db->group_by('service_area_district');
        $query0 = $this->db->get('service_area');

        $this->db->where('service_area_status', 1);
        $this->db->group_by('service_area_district');
        $query1 = $this->db->get('service_area');

        if($query0->num_rows()>0){
                foreach ($query0->result_array() as $value0) {
                    // if($value0['service_area_district']!=$value1['service_area_district']){
                        array_push($array_data, $value0['service_area_district']);
                    // }
                }
        }
        if($query1->num_rows()>0){
            foreach ($query1->result_array() as $value1) {
                if (($key = array_search($value1['service_area_district'], $array_data)) !== false) {
                    unset($array_data[$key]);
                }
            }
        }
        return $array_data;
        // return ($query->num_rows() > 0)?$query->result_array():false;
    }

    function get_meal_time() {
        $this->db->where('meal_time_status', 1);
        $this->db->order_by('meal_time_content_start', 'asc');
        $query = $this->db->get('meal_time');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

}