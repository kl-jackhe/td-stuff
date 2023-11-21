<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Lottery_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function getRows($params = array()){
        $this->db->select('id,name,email_subject,email_content,sms_subject,sms_content,product_id,number_limit,number_remain,number_alternate,star_time,end_time,draw_date,fill_up_date,draw_over,fill_up_over,filter_black,state,lottery_end,create_time');
        // if(!empty($params['search']['keywords'])){
        //     $this->db->like('banner_name',$params['search']['keywords']);
        // }
        $this->db->order_by('id', 'desc');
        if (array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        } elseif (!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get('lottery')->result_array();
        return (!empty($query)?$query:false);
    }

}