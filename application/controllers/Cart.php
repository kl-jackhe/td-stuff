<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends Public_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('cart');
        //$this->load->model('cart_model');
    }

    public function index() { }

    public function add()
    {
        $data = array(
           'coupon_id'     => '0',
           'coupon_code'   => '0',
           'coupon_method' => '',
           'coupon_price'  => '0',
        );
        $this->session->set_userdata($data);
        //
        $price=0;
        if(get_setting_general('is_food_discount')=='1' && !empty(get_setting_general('food_discount_number') && get_setting_general('food_discount_number')!='0')){
            $price=(get_setting_general('food_discount_number')/10)*get_product_price($this->input->post('id'));
        } else {
            $price=get_product_price($this->input->post('id'));
        }

        // 判斷這個商品是否有在購物車了
        if(!empty($this->cart->contents())){
            // $do=0;
            $rowid='';
            $product_id='';
            foreach($this->cart->contents() as $items) {
                // 有的話，更新數量
                if($items["id"]==$this->input->post('id')){
                    // $update_data = array(
                    //     'rowid' => $items["rowid"],
                    //     'qty'   => $this->input->post('qty')
                    // );
                    // $rowid = $this->cart->update($update_data);
                    // $do++;
                    $rowid = $items["rowid"];
                    $product_id = $items["id"];
                // 沒有的話，新增到購物車
                } else {
                    // if($do==0){
                    //     $insert_data = array(
                    //         'id'    => $this->input->post('id'),
                    //         'name'  => get_product_name($this->input->post('id')),
                    //         'price' => $price,
                    //         'qty'   => $this->input->post('qty'),
                    //         'store_order_time' => $this->input->post('store_order_time'),
                    //     );
                    //     $rowid = $this->cart->insert($insert_data);
                    // }
                }
            }

            if($rowid!=''){
                $update_data = array(
                    'rowid' => $rowid,
                    'qty'   => $this->input->post('qty')
                );
                $rowid = $this->cart->update($update_data);
            } else {
                $insert_data = array(
                    'id'    => $this->input->post('id'),
                    'name'  => get_product_name($this->input->post('id')),
                    'price' => $price,
                    'qty'   => $this->input->post('qty'),
                    'store_order_time' => $this->input->post('store_order_time'),
                );
                $rowid = $this->cart->insert($insert_data);
            }
        } else {
            $insert_data = array(
                'id'    => $this->input->post('id'),
                'name'  => get_product_name($this->input->post('id')),
                'price' => $price,
                'qty'   => $this->input->post('qty'),
                'store_order_time' => $this->input->post('store_order_time'),
            );
            $rowid = $this->cart->insert($insert_data);
        }

        // $insert_data = array(
        //     'id'    => $this->input->post('id'),
        //     'name'  => get_product_name($this->input->post('id')),
        //     'price' => $price,
        //     'qty'   => $this->input->post('qty'),
        //     'store_order_time' => $this->input->post('store_order_time'),
        // );
        // $rowid = $this->cart->insert($insert_data);

        // 判斷是否有超過每人限購數量
        $aaa=0;
        foreach($this->cart->contents() as $items) {
            if($items["id"]==$this->input->post('id')){
                $product_person_buy = get_product_person_buy($this->input->post('store_order_time_id'), $items["id"]);
                if($items["qty"]>$product_person_buy){
                    $data = array(
                       'rowid' => $items["rowid"],
                       'qty'   => $product_person_buy
                    );
                    $this->cart->update($data);
                    $aaa+=$product_person_buy;
                } else {
                    //
                    $aaa+=$this->input->post('qty');
                }
            }
        }
        echo $aaa;
    }

    public function add_coupon()
    {
        if($this->input->post('coupon_code')!='0' && !empty($this->input->post('coupon_code'))){
            $data = array(
               'coupon_id'     => '0',
               'coupon_code'   => '0',
               'coupon_method' => '',
               'coupon_price'  => '0',
            );
            $this->session->set_userdata($data);
            $active = 0;
            $fail = 0;
            $fail_reason = '';
            $this_user =  $this->mysql_model->_select('users','id',$this->ion_auth->user()->row()->id,'row');
            $this->db->join('coupon', 'coupon.coupon_code = user_coupon.coupon_code');
            $this->db->where('coupon.coupon_off_date >=', date('Y-m-d H:i:s'));
            $this->db->where('user_id', $this_user['id']);
            $this->db->where('user_coupon.coupon_code', $this->input->post('coupon_code'));
            // $this->db->order_by('coupon_id', 'desc');
            $query = $this->db->get('user_coupon');
            if($query->num_rows()>0){
                foreach($query->result_array() as $row) {
                // $row = $query->row_array();

                    // 判斷是否使用過
                    if($row['coupon_use_limit']=='once' && $row['coupon_is_uesd']=='n'){
                        $active++;
                    } elseif ($row['coupon_use_limit']=='once' && $row['coupon_is_uesd']=='y') {
                        $active--;
                        $fail++;
                        $fail_reason .= '此優惠券已使用過。';
                    } elseif ($row['coupon_use_limit']=='repeat') {
                        $active++;
                    } else {
                        $active++;
                    }

                    // 判斷是否滿額
                    if($row['coupon_amount_limit']==1){
                        if($this->cart->total()>=$row['coupon_amount_limit_number']){
                            $active++;
                        } else {
                            $active--;
                            $fail++;
                            $fail_reason .= '尚未滿足購物車金額, 需滿'.$row['coupon_amount_limit_number'].'元。';
                        }
                    }

                    // 判斷店家是否符合
                    if($row['coupon_store_limit']!=0){
                        if($this->session->userdata('store')==$row['coupon_store_limit']){
                            $active++;
                        } else {
                            $active--;
                            $fail++;
                            $fail_reason .= '此優惠券不適用此店家。';
                        }
                    }

                    // 判斷地區是否符合
                    if($row['coupon_localtion_limit']==1){
                        if($this->session->userdata('county')==$row['coupon_localtion_county'] && $this->session->userdata('district')==$row['coupon_localtion_district']){
                            $active++;
                        } else {
                            $active--;
                            $fail++;
                            $fail_reason .= '地區不符合。';
                        }
                    }

                    // 判斷是否符合商品
                    if($row['coupon_product_limit']==1){
                        if($row['coupon_product_limit_product']==0){
                            $active--;
                            $fail++;
                            $fail_reason .= '商品不符合。';
                        } else {
                            if ($cart = $this->cart->contents()){
                                foreach ($cart as $item){
                                    if($item['id']==$row['coupon_product_limit_product']){
                                        if($row['coupon_product_limit_type']=='qty'){
                                            if($item['qty']>=$row['coupon_product_limit_number']){
                                                $active++;
                                            } else {
                                                $active--;
                                                $fail++;
                                                $fail_reason .= '不符合商品數量需求。至少需要'.$row['coupon_product_limit_number'].'個';
                                            }
                                        }
                                        if($row['coupon_product_limit_type']=='price'){
                                            if(($item['qty']*$item['price'])>=$row['coupon_product_limit_number']){
                                                $active++;
                                            } else {
                                                $active--;
                                                $fail++;
                                                $fail_reason .= '不符合商品金額需求。至少需要'.$row['coupon_product_limit_number'].'元';
                                            }
                                        }
                                    } else {
                                        $active--;
                                        $fail++;
                                        $fail_reason .= '商品不符合。';
                                    }
                                }
                            }
                        }
                    }

                    // 壽星限定
                    if($row['coupon_birthday_only']==1){
                        foreach (explode(',', $row['coupon_birthday_month']) as $value) {
                            if ($value == substr($this_user['birthday'], 5, 2)) {
                                $active++;
                                break;
                            } else {
                                $active--;
                                $fail++;
                            }
                        }
                        // if(date('m-d')==substr($this_user['birthday'], 5, 5)){
                        //     $active++;
                        // } else {
                        //     $active--;
                        //     $fail_reason .= '不符合壽星條件';
                        // }
                        if($active>0){
                            //
                        } else {
                            $fail_reason .= '不符合壽星條件';
                        }
                    }

                }

                //  如果符合條件，套用優惠券
                if($fail<=0){
                    // $this->session->unset_userdata('coupon_id');
                    // $this->session->unset_userdata('coupon_code');
                    // $this->session->unset_userdata('coupon_method');
                    // $this->session->unset_userdata('coupon_price');
                    $data = array(
                       'coupon_id'     => get_coupon_id_by_code($row['coupon_code']),
                       'coupon_code'   => $row['coupon_code'],
                       'coupon_method' => $row['coupon_method'],
                       'coupon_price'  => get_coupon_number_by_code($row['coupon_code'])
                    );
                    $this->session->set_userdata($data);
                    // echo '1';
                    $array = array(
                        'result' => '1',
                        'reason' => $fail_reason
                    );
                    // return $array;
                    header('Content-Type: application/json');
                    echo json_encode($array,JSON_PRETTY_PRINT);
                } else {
                    $data = array(
                       'coupon_id'     => '0',
                       'coupon_code'   => '0',
                       'coupon_method' => '',
                       'coupon_price'  => '0',
                    );
                    $this->session->set_userdata($data);
                    $array = array(
                        'result' => '3',
                        'reason' => $fail_reason
                    );
                    // echo '3';
                    // return $array;
                    header('Content-Type: application/json');
                    echo json_encode($array,JSON_PRETTY_PRINT);
                }

            } else {
                $data = array(
                   'coupon_id'     => '0',
                   'coupon_code'   => '0',
                   'coupon_method' => '',
                   'coupon_price'  => '0',
                );
                $this->session->set_userdata($data);
                // echo '0';
                $array = array(
                    'result' => '0',
                    'reason' => '此優惠券不存在。'
                );
                // return $array;
                header('Content-Type: application/json');
                echo json_encode($array,JSON_PRETTY_PRINT);
            }
        } elseif($this->input->post('coupon_code')=='0' || empty($this->input->post('coupon_code'))){
            $data = array(
               'coupon_id'     => '0',
               'coupon_code'   => '0',
               'coupon_method' => '',
               'coupon_price'  => '0',
            );
            $this->session->set_userdata($data);
            // echo '2';
            $array = array(
                'result' => '2',
                'reason' => ''
            );
            // return $array;
            header('Content-Type: application/json');
            echo json_encode($array,JSON_PRETTY_PRINT);
        } else {
            // echo '4';
            $array = array(
                'result' => '4',
                'reason' => ''
            );
            // return $array;
            header('Content-Type: application/json');
            echo json_encode($array,JSON_PRETTY_PRINT);
        }
    }

    public function check_coupon()
    {
        if($this->session->userdata('coupon_code')!='0' && !empty($this->session->userdata('coupon_code'))){
            $data = array(
               'coupon_id'     => '0',
               'coupon_code'   => '0',
               'coupon_method' => '',
               'coupon_price'  => '0',
            );
            $this->session->set_userdata($data);
            $active=0;
            $this_user =  $this->mysql_model->_select('users','id',$this->ion_auth->user()->row()->id,'row');
            $this->db->join('coupon', 'coupon.coupon_code = user_coupon.coupon_code');
            $this->db->where('coupon_off_date >=', date('Y-m-d H:i:s'));
            $this->db->where('user_id', $this_user['id']);
            $this->db->where('user_coupon.coupon_code', $this->session->userdata('coupon_code'));
            // $this->db->order_by('coupon_id', 'desc');
            $query = $this->db->get('user_coupon');
            if($query->num_rows()>0){
                foreach($query->result_array() as $row) {
                // $row = $query->row_array();

                    // 判斷是否使用過
                    if($row['coupon_use_limit']=='once' && $row['coupon_is_uesd']=='n'){
                        $active++;
                    } elseif ($row['coupon_use_limit']=='once' && $row['coupon_is_uesd']=='y') {
                        $active=0;
                    } elseif ($row['coupon_use_limit']=='repeat') {
                        $active++;
                    } else {
                        $active++;
                    }

                    // 判斷是否滿額
                    if($row['coupon_amount_limit']==1){
                        if($this->cart->total()>=$row['coupon_amount_limit_number']){
                            $active++;
                        } else {
                            $active=0;
                        }
                    }

                    // 判斷地區是否符合
                    if($row['coupon_localtion_limit']==1){
                        if($this->session->userdata('county')==$row['coupon_localtion_county'] && $this->session->userdata('district')==$row['coupon_localtion_district']){
                            $active++;
                        } else {
                            $active=0;
                        }
                    }

                    // 判斷是否符合商品
                    if($row['coupon_product_limit']==1){
                        if($row['coupon_product_limit_product']==0){
                            $active=0;
                        } else {
                            if ($cart = $this->cart->contents()){
                                foreach ($cart as $item){
                                    if($item['id']==$row['coupon_product_limit_product']){
                                        if($row['coupon_product_limit_type']=='qty'){
                                            if($item['qty']>=$row['coupon_product_limit_number']){
                                                $active++;
                                            } else {
                                                $active=0;
                                            }
                                        }
                                        if($row['coupon_product_limit_type']=='price'){
                                            if(($item['qty']*$item['price'])>=$row['coupon_product_limit_number']){
                                                $active++;
                                            } else {
                                                $active=0;
                                            }
                                        }
                                    } else {
                                        $active=0;
                                    }
                                }
                            }
                        }
                    }

                    // 壽星限定
                    if($row['coupon_birthday_only']==1){
                        if(date('m-d')==substr($this_user['birthday'], 5, 5)){
                            $active++;
                        } else {
                            $active=0;
                        }
                    }

                }

                //  如果符合條件，套用優惠券
                if($active>0){
                    // $this->session->unset_userdata('coupon_id');
                    // $this->session->unset_userdata('coupon_code');
                    // $this->session->unset_userdata('coupon_method');
                    // $this->session->unset_userdata('coupon_price');
                    $data = array(
                       'coupon_id'     => get_coupon_id_by_code($row['coupon_code']),
                       'coupon_code'   => $row['coupon_code'],
                       'coupon_method' => $row['coupon_method'],
                       'coupon_price'  => get_coupon_number_by_code($row['coupon_code'])
                    );
                    $this->session->set_userdata($data);
                    echo '1';
                } else {
                    $data = array(
                       'coupon_id'     => '0',
                       'coupon_code'   => '0',
                       'coupon_method' => '',
                       'coupon_price'  => '0',
                    );
                    $this->session->set_userdata($data);
                    echo '3';
                }

            } else {
                $data = array(
                   'coupon_id'     => '0',
                   'coupon_code'   => '0',
                   'coupon_method' => '',
                   'coupon_price'  => '0',
                );
                $this->session->set_userdata($data);
                echo '0';
            }
        } elseif($this->session->userdata('coupon_code')=='0' || empty($this->session->userdata('coupon_code'))){
            $data = array(
               'coupon_id'     => '0',
               'coupon_code'   => '0',
               'coupon_method' => '',
               'coupon_price'  => '0',
            );
            $this->session->set_userdata($data);
            echo '2';
        } else {
            echo '4';
        }
    }

    public function add_delivery_place()
    {
        $this->session->unset_userdata('delivery_place');
        $data = array(
           'delivery_place' => $this->input->post('delivery_place'),
        );
        $this->session->set_userdata($data);
    }

    public function add_delivery_date()
    {
        $this->session->unset_userdata('delivery_date');
        $data = array(
           'delivery_date' => $this->input->post('delivery_date'),
        );
        $this->session->set_userdata($data);
    }

    public function add_delivery_time()
    {
        $this->session->unset_userdata('delivery_time');
        $data = array(
           'delivery_time' => $this->input->post('delivery_time'),
        );
        $this->session->set_userdata($data);
    }

    public function add_custom_address()
    {
        $this->session->unset_userdata('custom_address');
        $data = array(
           'custom_address' => $this->input->post('custom_address'),
        );
        $this->session->set_userdata($data);
        $this->check_coupon();
    }

    public function update_price()
    {
        $data = array(
           'rowid' => $this->input->post('rowid'),
           'price' => $this->input->post('price')
        );
        $this->cart->update($data);
        //redirect($_SERVER['HTTP_REFERER']);
    }

    public function update_qty()
    {
        $data = array(
           'rowid' => $this->input->post('rowid'),
           'qty' => $this->input->post('qty')
        );
        $this->cart->update($data);
        $this->check_coupon();
    }

    public function update_remark()
    {
        $data = array(
           'rowid' => $this->input->post('rowid'),
           'remark' => $this->input->post('remark')
        );
        $this->cart->update($data);
    }

    public function update_warehouse()
    {
        $data = array(
           'rowid' => $this->input->post('rowid'),
           'warehouse' => $this->input->post('warehouse')
        );
        $this->cart->update($data);
    }

    public function remove()
    {
        $data = array(
            'rowid' => $this->input->post('rowid'),
            'qty' => 0
        );
        $this->cart->update($data);
        $data = array(
           'coupon_id'     => '0',
           'coupon_code'   => '0',
           'coupon_method' => '',
           'coupon_price'  => '0',
        );
        $this->session->set_userdata($data);
        //redirect($_SERVER['HTTP_REFERER']);
    }

    public function remove_all()
    {
        $this->cart->destroy();
        // 清空配送日期
        $data = array(
            'delivery_date' => '',
        );
        $this->session->set_userdata($data);
        // 清空配送時間
        $data = array(
            'delivery_time' => '',
        );
        $this->session->set_userdata($data);
        // 清空配送地點
        $data = array(
           'delivery_place' => '',
        );
        $this->session->set_userdata($data);
        // 清空優惠券
        $data = array(
           'coupon_id'     => '0',
           'coupon_code'   => '0',
           'coupon_method' => '',
           'coupon_price'  => '0',
        );
        $this->session->set_userdata($data);
    }

    public function check_cart_is_empty()
    {
        $count=0;
        if(!empty($this->cart->contents())){
            foreach($this->cart->contents() as $items) {
                $count++;
            }
        }
        echo $count;
    }

}