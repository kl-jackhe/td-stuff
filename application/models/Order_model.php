<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('orders');
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('order_number',$params['search']['keywords']);
            $this->db->or_like('customer_name',$params['search']['keywords']);
            $this->db->or_like('customer_phone',$params['search']['keywords']);
        }
        if(!empty($params['search']['category'])){
            $this->db->where('order_pay_status',$params['search']['category']);
            // $this->db->where('order_delivery_place',$params['search']['category']);
        }
        if(!empty($params['search']['category2'])){
            $this->db->where('order_step',$params['search']['category2']);
            // $this->db->where('order_delivery_place',$params['search']['category']);
        }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('order_date', $params['search']['sortBy']);
        } else {
            $this->db->order_by('order_date', 'desc');
            $this->db->order_by('order_id', 'desc');
        }
        // if(!empty($params['search']['status'])){
        //     $this->db->where('order_status',$params['search']['status']);
        // } else {
        //     $this->db->where('order_status', '1');
        // }
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

    function find_all_order($params = array()){
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->like('created_at', date('Y-m-d'));
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('order_id',$params['search']['keywords']);
            //$this->db->or_like('order_eat_type',$params['search']['keywords']);
            //$this->db->or_like('invoice_randcode',$params['search']['keywords']);
            //$this->db->like('created_at',$params['search']['keywords'], 'after');
        }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('order_id',$params['search']['sortBy']);
        }else{
            $this->db->order_by('order_id','desc');
        }
        if(!empty($params['search']['category'])){
            $this->db->where('order_eat_type',$params['search']['category']);
        }
        if(!empty($params['search']['status'])){
            $this->db->where('order_status',$params['search']['status']);
        } else {
            $this->db->where('order_status', '1');
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

    public function find_other_order($type)
    {
        //$this->db->join('purchase_item', 'purchase_item.purchase_id = purchase.purchase_id');
        $this->db->where('order_status', '1');
        $this->db->where('order_eat_type', $type);
        $this->db->order_by('order_id','desc');
        $query = $this->db->get('pos_other_order');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function get_customer_order($id)
    {
        // $this->db->where('customer_id', $id);
        $this->db->order_by('order_id','desc');
        $query = $this->db->get('orders');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function get_order_item_with_product($id)
    {
        $this->db->join('product', 'product.product_id = order_item.product_id');
        $this->db->where('order_id', $id);
        // $this->db->order_by('order_id','desc');
        $query = $this->db->get('order_item');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

}