<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Users_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    // function getRows($params = array()) {
    //     $this->db->select('*');
    //     $this->db->order_by('id', 'desc');
    //     if (array_key_exists("start",$params) && array_key_exists("limit",$params)){
    //         $this->db->limit($params['limit'],$params['start']);
    //     } elseif (!array_key_exists("start",$params) && array_key_exists("limit",$params)){
    //         $this->db->limit($params['limit']);
    //     }
    //     $query = $this->db->get('users')->result_array();
    //     return (!empty($query)?$query:false);
    // }

    function getUserDetail($userID) {
        $this->db->select('id,join_status,oauth_provider,oauth_uid,ip_address,username,gender,password,salt,email,activation_selector,activation_code,forgotten_password_selector,forgotten_password_code,forgotten_password_time,remember_selector,remember_code,created_on,last_login,active,full_name,phone,county,district,address,birthday,company,status,creator_id,updater_id,created_at,updated_at');
        $this->db->where('id', $userID);
        $this->db->limit(1);
        $row = $this->db->get('users')->row_array();
        return (!empty($row)?$row:false);
    }

}