<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Freeshipping extends Public_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('cart');
        $this->load->model('home_model');
        $this->load->model('store_model');
        $this->load->model('coupon_model');
        $this->load->model('service_area_model');
    }

    public function index()
    {
        $this->data['page_title'] = '免運跨區美食';
        $this->data['banner'] = $this->home_model->GetBanner();
        $this->data['hide_county'] = $this->service_area_model->get_hide_county();
        $this->data['hide_district'] = $this->service_area_model->get_hide_district();
        if(isset($_GET['county']) && isset($_GET['district']) && isset($_GET['address'])) {
            // 清空購物車
            $this->cart->destroy();
            $data = array(
                // 清空配送日期
                'delivery_date' => '',
                // 清空配送時間
                'delivery_time' => '',
                // 清空配送地點
                'delivery_place' => '',
                // 清空優惠券
                'coupon_id'     => '0',
                'coupon_code'   => '0',
                'coupon_method' => '',
                'coupon_price'  => '0',
                // 儲存城市
                'county' => $this->input->get('county'),
                // 儲存區域
                'district' => $this->input->get('district'),
                // 儲存地址
                'address' => $this->input->get('address'),
            );
            $this->session->set_userdata($data);
            // 儲存配送地址
            $this->session->unset_userdata('custom_address');
            $data = array(
               'custom_address' => $this->input->get('county').$this->input->get('district').$this->input->get('address'),
            );
            $this->session->set_userdata($data);
            // 儲存查詢的地址
            if ($this->ion_auth->logged_in()){
                $users_address = $this->home_model->get_users_address($this->ion_auth->user()->row()->id);
                if($users_address){
                    $this->data['users_address']['county'] = $users_address['county'];
                    $this->data['users_address']['district'] = $users_address['district'];
                    $this->data['users_address']['address'] = $users_address['address'];
                    $data = array(
                       'delivery_place' => $users_address['county'].$users_address['district'].$users_address['address']
                    );
                    $this->session->set_userdata($data);
                } else {
                    $this->data['users_address']['county'] = '';
                    $this->data['users_address']['district'] = '';
                    $this->data['users_address']['address'] = '';
                    $data = array(
                       'delivery_place' => ''
                    );
                    $this->session->set_userdata($data);
                }
            } else {
                set_cookie("user_county", $this->input->get('county'), 30*86400);
                set_cookie("user_district", $this->input->get('district'), 30*86400);
                set_cookie("user_address", $this->input->get('address'), 30*86400);
            }
            //
            $coordinates = get_coordinates($this->input->get('county').$this->input->get('district').$this->input->get('address'));
            if(!empty($coordinates['district']) && !empty($coordinates['route'])){
                // 儲存郵遞區號
                $this->session->unset_userdata('zipcode');
                $zipcode_data = array(
                   'zipcode' => $coordinates['zipcode'],
                );
                $this->session->set_userdata($zipcode_data);
                // echo $this->input->get('county').$this->input->get('district').$this->input->get('address');
                if($this->input->get('district')==$coordinates['district']){
                    if(strpos($this->input->get('address'), $coordinates['route']) !== false || strpos($this->input->get('address'), get_road_turn($coordinates['route'])) !== false){
                        $this->data['store_order_time_date'] = $this->store_model->getSearchStoreDate();
                        $this->data['store_order_time'] = $this->store_model->getSearchStore();
                    } else {
                        $this->data['store_order_time_date'] = array();
                        $this->data['store_order_time'] = array();
                    }
                } else {
                    $this->data['store_order_time_date'] = array();
                    $this->data['store_order_time'] = array();
                }
            } else {
                $this->data['store_order_time_date'] = array();
                $this->data['store_order_time'] = array();
            }
            // $this->data['store_0'] = $this->store_model->getSearchStore_0();
            // $this->data['store_1'] = $this->store_model->getSearchStore_1();
            // 查詢配送點
            // $this->data['delivery_place'] = $this->store_model->getSearchDeliveryPlace($this->session->userdata('county'),$this->session->userdata('district'),$this->session->userdata('address'));
            $data = array(
               'delivery_place' => $this->input->get('county').$this->input->get('district').$this->input->get('address'),
            );
            $this->session->set_userdata($data);
        } else {
            $this->cart->destroy();
            $this->session->unset_userdata('delivery_place');
            $this->session->unset_userdata('coupon_id');
            $this->session->unset_userdata('coupon_code');
            $this->session->unset_userdata('coupon_method');
            $this->session->unset_userdata('coupon_price');
            $this->session->unset_userdata('county');
            $this->session->unset_userdata('district');
            $this->session->unset_userdata('address');
            // 取得客戶地址
            if ($this->ion_auth->logged_in()) {
                $users_address = $this->home_model->get_users_address($this->ion_auth->user()->row()->id);
                $this->data['users_address']['county'] = $users_address['county'];
                $this->data['users_address']['district'] = $users_address['district'];
                $this->data['users_address']['address'] = $users_address['address'];
                $data = array(
                   'delivery_place' => $users_address['county'].$users_address['district'].$users_address['address'],
                );
                $this->session->set_userdata($data);
            } else {
                $this->data['users_address']['county'] = get_cookie("user_county", true);
                $this->data['users_address']['district'] = get_cookie("user_district", true);
                $this->data['users_address']['address'] = get_cookie("user_address", true);
                $data = array(
                   'delivery_place' => $this->data['users_address']['county'].$this->data['users_address']['district'].$this->data['users_address']['address'],
                );
                $this->session->set_userdata($data);
            }
        }
        // header('Content-Type: application/json');
        // echo json_encode($this->data['delivery_place'], JSON_PRETTY_PRINT);
        $this->render('freeshipping/index');
    }

}