<?php defined('BASEPATH') or exit('No direct script access allowed');

class Coupon_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getRowsCount($params = array())
    {
        $this->db->select('coupon_id');
        $this->db->from('coupon');
        //filter data by searched keywords
        if (!empty($params['search']['keywords'])) {
            $this->db->group_start();
            $this->db->like('coupon_name', $params['search']['keywords']);
            $this->db->or_like('coupon_code', $params['search']['keywords']);
            $this->db->group_end();
        }
        if (!empty($params['search']['category'])) {
            $this->db->where('coupon_type', $params['search']['category']);
        }
        //sort data by ascending or desceding order
        // if(!empty($params['search']['sortBy'])){
        //     $this->db->where('coupon_off_day',$params['search']['sortBy']);
        // }
        // if(!empty($params['search']['status'])){
        //     $this->db->where('coupon_status',$params['search']['status']);
        // } else {
        //     $this->db->where('coupon_status', '1');
        // }
        if (!empty($params['search']['stare_date'])) {
            $this->db->where('coupon_on_date <=', $params['search']['stare_date']);
        }
        if (!empty($params['search']['end_date'])) {
            $this->db->where('coupon_off_date >=', $params['search']['end_date']);
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
        return ($query->num_rows() > 0) ? $query->result_array() : false;
    }

    function getRows($params = array())
    {
        $this->db->select('*');
        $this->db->from('coupon');
        //filter data by searched keywords
        if (!empty($params['search']['keywords'])) {
            $this->db->group_start();
            $this->db->like('coupon_name', $params['search']['keywords']);
            $this->db->or_like('coupon_code', $params['search']['keywords']);
            $this->db->group_end();
        }
        if (!empty($params['search']['category'])) {
            $this->db->where('coupon_type', $params['search']['category']);
        }
        //sort data by ascending or desceding order
        // if(!empty($params['search']['sortBy'])){
        //     $this->db->where('coupon_off_day',$params['search']['sortBy']);
        // }
        // if(!empty($params['search']['status'])){
        //     $this->db->where('coupon_status',$params['search']['status']);
        // } else {
        //     $this->db->where('coupon_status', '1');
        // }
        if (!empty($params['search']['stare_date'])) {
            $this->db->where('coupon_on_date <=', $params['search']['stare_date']);
        }
        if (!empty($params['search']['end_date'])) {
            $this->db->where('coupon_off_date >=', $params['search']['end_date']);
        }
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : false;
    }

    // function get_user_coupon($user_id) {
    //     $this->db->join('coupon', 'coupon.coupon_code = user_coupon.coupon_code');
    //     $this->db->where('coupon_is_uesd', 'n');
    //     $this->db->where('user_id', $user_id);
    //     $this->db->order_by('coupon_expiry_date', 'asc');
    //     $query = $this->db->get('user_coupon');
    //     return ($query->num_rows() > 0)?$query->result_array():false;
    // }

    // function get_user_all_coupon($user_id) {
    //     $this->db->join('coupon', 'coupon.coupon_code = user_coupon.coupon_code');
    //     $this->db->join('user_coupon', 'coupon.coupon_code = user_coupon.coupon_code');
    //     $this->db->where('user_id', $user_id);
    //     $this->db->order_by('coupon_off_date', 'asc');
    //     $query = $this->db->get('user_coupon');
    //     $query = $this->db->get('coupon');
    //     return ($query->num_rows() > 0)?$query->result_array():false;
    // }

    function getShareCoupon()
    {
        $this->db->select('*');
        $query = $this->db->get('coupon');
        return ($query->num_rows() > 0) ? $query->result_array() : false;
    }

    function getNewCoupon()
    {
        $this->db->select('*');
        $query = $this->db->get('new_coupon');
        return ($query->num_rows() > 0) ? $query->result_array() : false;
    }

    function getTotalCustom()
    {
        $this->db->select('id');
        $query = $this->db->get('users');
        return ($query->num_rows() > 0) ? $query->result_array() : false;
    }

    function getExistCouponProduct($id)
    {
        $this->db->select('use_product_id');
        $this->db->where('coupon_id', $id);
        $query = $this->db->get('new_coupon_product')->result_array();
        return (!empty($query) ? $query : false);
    }

    function isExistProductID($coupon_id, $product_id)
    {
        $this->db->where('coupon_id', $coupon_id);
        $this->db->where('use_product_id', $product_id);
        $query = $this->db->get('new_coupon_product')->result_array();
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    function getSelectedProductID($id)
    {
        $selected = array();
        $this->db->select('use_product_id');
        $this->db->where('coupon_id', $id);
        $query = $this->db->get('new_coupon_product')->result_array();
        if (!empty($query)) {
            foreach ($query as $row) {
                $selected[] = $row['use_product_id'];
            }
        }
        return $selected;
    }
}
