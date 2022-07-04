<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Store_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getRowsCount($params = array()){
        $this->db->select('store_id');
        $this->db->from('store');
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('store_name',$params['search']['keywords']);
        }
        // if(!empty($params['search']['category'])){
        //     $this->db->where('store_category',$params['search']['category']);
        // }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->where('store_off_day',$params['search']['sortBy']);
        }
        // if(!empty($params['search']['status'])){
        //     $this->db->where('store_status',$params['search']['status']);
        // } else {
        //     $this->db->where('store_status', '1');
        // }
        if(!empty($params['search']['county'])){
            $this->db->where('store_county',$params['search']['county']);
        }
        if(!empty($params['search']['district'])){
            $this->db->where('store_district',$params['search']['district']);
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

    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('store');
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('store_name',$params['search']['keywords']);
        }
        // if(!empty($params['search']['category'])){
        //     $this->db->where('store_category',$params['search']['category']);
        // }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->where('store_off_day',$params['search']['sortBy']);
        }
        // if(!empty($params['search']['status'])){
        //     $this->db->where('store_status',$params['search']['status']);
        // } else {
        //     $this->db->where('store_status', '1');
        // }
        if(!empty($params['search']['county'])){
            $this->db->where('store_county',$params['search']['county']);
        }
        if(!empty($params['search']['district'])){
            $this->db->where('store_district',$params['search']['district']);
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

    function getSearchStoreDate(){
        $this->db->select('store_order_time,store_close_time');
        $this->db->where('store_order_time >=', date('Y-m-d'));
        $this->db->where('delivery_county', $this->session->userdata('county'));
        $this->db->where('delivery_district', $this->session->userdata('district'));
        $this->db->order_by('store_order_time', 'asc');
        $this->db->group_by('store_order_time');
        $this->db->limit(14);

        // $this->db->where('store_order_time.store_close_time >=', date('Y-m-d H:i:s'));
        $query = $this->db->get('store_order_time');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    function getSearchStoreDateFree(){
        $this->db->select('store_order_time,store_close_time');
        $this->db->where('store_order_time >=', date('Y-m-d'));
        $this->db->where('delivery_county', $this->session->userdata('county'));
        $this->db->where('delivery_district', $this->session->userdata('district'));
        $this->db->where('delivery_cost', 0);
        $this->db->order_by('store_order_time', 'asc');
        $this->db->group_by('store_order_time');
        $this->db->limit(14);

        // $this->db->where('store_order_time.store_close_time >=', date('Y-m-d H:i:s'));
        $query = $this->db->get('store_order_time');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    function getSearchStore(){
        // if(date('H:i:s')>'10:00:00'){
            // return false;
        // } else {
            $this->db->join('store', 'store.store_id = store_order_time.store_id');
            $this->db->where('delivery_county', $this->session->userdata('county'));
            $this->db->where('delivery_district', $this->session->userdata('district'));
            $this->db->where('store_order_time.store_order_time >=', date('Y-m-d'));
            // $this->db->where('store_order_time.store_order_time <=', date('Y-m-d',strtotime(date('Y-m-d') . "+7 days")));

            $this->db->where('store_status', 1);
            $this->db->order_by('store_order_time', 'asc');

            // $this->db->where('store_order_time.store_close_time >=', date('Y-m-d H:i:s'));
            $query = $this->db->get('store_order_time');
            return ($query->num_rows() > 0)?$query->result_array():false;
        // }
    }

    function getSearchStoreFree(){
        // if(date('H:i:s')>'10:00:00'){
            // return false;
        // } else {
            $this->db->join('store', 'store.store_id = store_order_time.store_id');
            $this->db->where('delivery_cost', 0);
            $this->db->where('delivery_county', $this->input->get('county'));
            $this->db->where('delivery_district', $this->input->get('district'));
            $this->db->where('store_order_time.store_order_time >=', date('Y-m-d'));
            // $this->db->where('store_order_time.store_close_time <=', date('Y-m-d',strtotime(date('Y-m-d') . "+7 days")));

            $this->db->where('store_status', 1);
            $this->db->order_by('store_order_time', 'asc');

            // $this->db->where('store_order_time.store_close_time >=', date('Y-m-d H:i:s'));
            $query = $this->db->get('store_order_time');
            return ($query->num_rows() > 0)?$query->result_array():false;
        // }
    }

    function getSearchStore_0(){
        if(date('H:i:s')>'10:00:00'){
            return false;
        } else {
            $this->db->join('store', 'store.store_id = store_order_time.store_id');
            $this->db->where('delivery_county', $this->input->get('county'));
            $this->db->where('delivery_district', $this->input->get('district'));
            $this->db->where('store_status', 1);
            // $this->db->where('store_order_time.store_order_time', date('Y-m-d'));
            $this->db->where('store_order_time.store_close_time >=', date('Y-m-d H:i:s'));
            $query = $this->db->get('store_order_time');
            return ($query->num_rows() > 0)?$query->result_array():false;
        }
    }

    function getSearchStore_1(){
        $this->db->join('store', 'store.store_id = store_order_time.store_id');
        $this->db->where('delivery_county', $this->input->get('county'));
        $this->db->where('delivery_district', $this->input->get('district'));
        $this->db->where('store_status', 1);
        // $this->db->where('store_order_time.store_order_time <=', date('Y-m-d',strtotime(date('Y-m-d') . "+1 days")));
        $this->db->where('store_order_time.store_close_time >=', date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s') . "+1 days")));
        // $this->db->or_where('store_order_time.store_close_time <=', date('Y-m-d',strtotime(date('Y-m-d'))).' 20:00:00');
        $query = $this->db->get('store_order_time');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    function get_store_order_time_with_store($id){
        // $this->db->join('store', 'store.store_id = store_order_time.store_id');
        $this->db->where('store_order_time_id', $id);
        // $this->db->where('store_status', 1);
        $query = $this->db->get('store_order_time');
        return ($query->num_rows() > 0)?$query->row_array():false;
    }

    function get_store_order_time_item_with_product($id){
        $this->db->select('*');
        $this->db->select('store_order_time_item.product_daily_stock as product_daily_stock');
        $this->db->select('store_order_time_item.product_person_buy as product_person_buy');
        $this->db->join('product', 'product.product_id = store_order_time_item.product_id');
        $this->db->where('store_order_time_id', $id);
        // $this->db->where('store_status', 1);
        $query = $this->db->get('store_order_time_item');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

    function getSearchDeliveryPlace($county,$district,$address){
        $array_data = array();
        $array = array();

        $county = trim($county);
        $district = trim($district);
        $address = trim($address);

        // 地址取得經緯度
        $address = $county.$district.$address;
        if(get_coordinates($address)!=false){
            $latlng = get_coordinates($address);
            $geo_lat = $latlng['lat'];
            $geo_lng = $latlng['lng'];
        } else {
            $geo_lat = 0;
            $geo_lng = 0;
        }
        // End 地址取得經緯度

        $this->db->where('delivery_place_county', $county);
        $this->db->where('delivery_place_district', $district);
        $this->db->where('delivery_place_status', 1);
        $query = $this->db->get('delivery_place');
        if ($query->num_rows() > 0) {
            foreach($query->result_array() as $result){

                $distance = GetWalkingDistance($geo_lat,$geo_lng,$result['delivery_place_lat'],$result['delivery_place_lng']);

                $array = array(
                    'delivery_place_id'       => $result['delivery_place_id'],
                    'delivery_place_name'     => $result['delivery_place_name'],
                    'delivery_place_county'   => $result['delivery_place_county'],
                    'delivery_place_district' => $result['delivery_place_district'],
                    'delivery_place_address'  => $result['delivery_place_address'],
                    'delivery_place_lat'      => $result['delivery_place_lat'],
                    'delivery_place_lng'      => $result['delivery_place_lng'],
                    'distance'                => $distance['distance'],
                    'time'                    => $distance['time'],
                );
                array_push($array_data, $array);
            }
        }
        // 依照 distance 升冪排序
        usort($array_data, function ($item1, $item2) {
            return $item1['distance'] <=> $item2['distance'];
        });
        return $array_data;
    }

    function get_users_delivery_time($id) {
        $this->db->join('delivery_time', 'delivery_time.delivery_time_id = users_delivery_time.delivery_time_id');
        $this->db->where('user_id', $id);
        $query = $this->db->get('users_delivery_time');
        return ($query->num_rows() > 0)?$query->result_array():false;
    }

}