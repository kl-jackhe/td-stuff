<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function search_pos()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $start_time = $this->input->get('start_time');
        $end_time = $this->input->get('end_time');
        $user = $this->input->get('user');
        if (!empty($start_date)) {
            // if($start_date==$end_date){
            //     $this->db->like('created_at',$start_date);
            // } else {
                //$start_date=str_replace("-","",$start_date);
                //$end_date=str_replace("-","",$end_date);
                if(!empty($start_time)){
                    $start_date=$start_date.' '.$start_time;
                    $end_date=$end_date.' '.$end_time;
                } else {
                    $start_date=$start_date.' 00:00:00';
                    $end_date=$end_date.' 23:59:59';
                }
                $this->db->where('created_at >=', $start_date);
                $this->db->where('created_at <=', $end_date);
            // }
        }
        if (!empty($user)) {
            $this->db->where('creator_id', $user);
        }
        $this->db->where('order_status', '1');
        $this->db->order_by('order_id','desc');
        $query = $this->db->get('pos_order');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function search_void_result()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $user = $this->input->get('user');
        if (!empty($start_date)) {
            if($start_date==$end_date){
                $this->db->like('created_at',$start_date);
            } else {
                //$start_date=str_replace("-","",$start_date);
                //$end_date=str_replace("-","",$end_date);
                $start_date=$start_date.' 00:00:00';
                $end_date=$end_date.' 23:59:59';
                $this->db->where('created_at >=', $start_date);
                $this->db->where('created_at <=', $end_date);
            }
        }
        if (!empty($user)) {
            $this->db->where('creator_id', $user);
        }
        $this->db->where('order_status', '2');
        $this->db->order_by('order_id','desc');
        $query = $this->db->get('pos_order');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function search_fist_invoice()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $user = $this->input->get('user');
        if (!empty($start_date)) {
            if($start_date==$end_date){
                $this->db->like('created_at',$start_date);
            } else {
                //$start_date=str_replace("-","",$start_date);
                //$end_date=str_replace("-","",$end_date);
                $start_date=$start_date.' 00:00:00';
                $end_date=$end_date.' 23:59:59';
                $this->db->where('created_at >=', $start_date);
                $this->db->where('created_at <=', $end_date);
            }
        }
        if (!empty($user)) {
            $this->db->where('creator_id', $user);
        }
        //$this->db->like('order_id',$word);
        $this->db->order_by('order_id','asc');
        $query = $this->db->get('pos_order');
        if ($query->num_rows() > 0) {
            return $query->first_row('array');
        }
        return false;
    }

    public function search_last_invoice()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $user = $this->input->get('user');
        if (!empty($start_date)) {
            if($start_date==$end_date){
                $this->db->like('created_at',$start_date);
            } else {
                //$start_date=str_replace("-","",$start_date);
                //$end_date=str_replace("-","",$end_date);
                $start_date=$start_date.' 00:00:00';
                $end_date=$end_date.' 23:59:59';
                $this->db->where('created_at >=', $start_date);
                $this->db->where('created_at <=', $end_date);
            }
        }
        if (!empty($user)) {
            $this->db->where('creator_id', $user);
        }
        //$this->db->like('order_id',$word);
        $this->db->order_by('order_id','desc');
        $query = $this->db->get('pos_order');
        if ($query->num_rows() > 0) {
            return $query->first_row('array');
        }
        return false;
    }

    public function search_purchase()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $user = $this->input->get('user');
        $manufacturer = $this->input->get('purchase_manufacturer');
        if (!empty($start_date)) {
            if($start_date==$end_date){
                $this->db->like('created_at',$start_date);
            } else {
                //$start_date=str_replace("-","",$start_date);
                //$end_date=str_replace("-","",$end_date);
                $start_date=$start_date.' 00:00:00';
                $end_date=$end_date.' 23:59:59';
                $this->db->where('created_at >=', $start_date);
                $this->db->where('created_at <=', $end_date);
            }
        }
        if (!empty($manufacturer)) {
            $this->db->where('manufacturer_id', $manufacturer);
        }
        if (!empty($user)) {
            $this->db->where('creator_id', $user);
        }
        $this->db->where('purchase_status', '1');
        $query = $this->db->get('purchase_order');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function search_purchase_item()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        if (!empty($start_date)) {
            if($start_date==$end_date){
                $this->db->like('created_at',$start_date);
            } else {
                //$start_date=str_replace("-","",$start_date);
                //$end_date=str_replace("-","",$end_date);
                $start_date=$start_date.' 00:00:00';
                $end_date=$end_date.' 23:59:59';
                $this->db->where('created_at >=', $start_date);
                $this->db->where('created_at <=', $end_date);
            }
        }
        $this->db->where('purchase_item_status', '1');
        $this->db->order_by('purchase_id', 'desc');
        $query = $this->db->get('purchase_order_item');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function search_produce()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $user = $this->input->get('user');
        if (!empty($start_date)) {
            if($start_date==$end_date){
                $this->db->like('created_at',$start_date);
            } else {
                //$start_date=str_replace("-","",$start_date);
                //$end_date=str_replace("-","",$end_date);
                $start_date=$start_date.' 00:00:00';
                $end_date=$end_date.' 23:59:59';
                $this->db->where('created_at >=', $start_date);
                $this->db->where('created_at <=', $end_date);
            }
        }
        if (!empty($user)) {
            $this->db->where('creator_id', $user);
        }
        $this->db->where('produce_status', '1');
        $query = $this->db->get('produce');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function search_produce_item()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        if (!empty($start_date)) {
            if($start_date==$end_date){
                $this->db->like('created_at',$start_date);
            } else {
                //$start_date=str_replace("-","",$start_date);
                //$end_date=str_replace("-","",$end_date);
                $start_date=$start_date.' 00:00:00';
                $end_date=$end_date.' 23:59:59';
                $this->db->where('created_at >=', $start_date);
                $this->db->where('created_at <=', $end_date);
            }
        }
        $this->db->where('produce_status', '1');
        $this->db->order_by('produce_id', 'desc');
        $query = $this->db->get('produce');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function search_sales()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $user = $this->input->get('user');
        $manufacturer = $this->input->get('sales_manufacturer');
        if (!empty($start_date)) {
            if($start_date==$end_date){
                $this->db->like('created_at',$start_date);
            } else {
                //$start_date=str_replace("-","",$start_date);
                //$end_date=str_replace("-","",$end_date);
                $start_date=$start_date.' 00:00:00';
                $end_date=$end_date.' 23:59:59';
                $this->db->where('created_at >=', $start_date);
                $this->db->where('created_at <=', $end_date);
            }
        }
        if (!empty($manufacturer)) {
            $this->db->where('manufacturer_id', $manufacturer);
        }
        if (!empty($user)) {
            $this->db->where('creator_id', $user);
        }
        $this->db->where('sales_status', '1');
        $query = $this->db->get('sales_order');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function search_sales_item()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        if (!empty($start_date)) {
            if($start_date==$end_date){
                $this->db->like('created_at',$start_date);
            } else {
                //$start_date=str_replace("-","",$start_date);
                //$end_date=str_replace("-","",$end_date);
                $start_date=$start_date.' 00:00:00';
                $end_date=$end_date.' 23:59:59';
                $this->db->where('created_at >=', $start_date);
                $this->db->where('created_at <=', $end_date);
            }
        }
        $this->db->where('sales_item_status', '1');
        $this->db->order_by('sales_id', 'desc');
        $query = $this->db->get('sales_order_item');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function get_sales_manufacturer()
    {
        //$this->db->select('manufacturer_id');
        //$query = $this->db->get('sales_order');
        $query = $this->db->query('select distinct manufacturer_id from sales_order');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    public function get_purchase_manufacturer()
    {
        //$this->db->select('manufacturer_id');
        //$query = $this->db->get('purchase_order');
        $query = $this->db->query('select distinct manufacturer_id from purchase_order');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

}