<?php defined('BASEPATH') or exit('No direct script access allowed');

class Coupon extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('coupon_model');
        // $this->load->model('service_area_model');
    }

    public function index()
    {
        $this->data['page_title'] = '優惠券';

        $data = array();
        //total rows count
        if (!empty($this->coupon_model->getRowsCount())) {
            $totalRec = count($this->coupon_model->getRowsCount());
            $config['total_rows']  = $totalRec;
        }
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url() . 'admin/coupon/ajaxData';
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //get the posts data

        if ($this->is_liqun_food) {
            $this->data['coupon'] = $this->coupon_model->getNewCoupon();
            $this->render('admin/coupon/liqun/liqun_index');
        } else {
            $this->data['coupon'] = $this->coupon_model->getRows(array('limit' => $this->perPage));
            $this->render('admin/coupon/index');
        }
    }

    function ajaxData()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->get('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        //set conditions for search
        $keywords = $this->input->get('keywords');
        $category = $this->input->get('category');
        // $sortBy = $this->input->get('sortBy');
        // $status = $this->input->get('status');
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        if (!empty($keywords)) {
            $conditions['search']['keywords'] = $keywords;
        }
        if (!empty($category)) {
            $conditions['search']['category'] = $category;
        }
        // if(!empty($status)){
        //     $conditions['search']['status'] = $status;
        // }
        if (!empty($start_date)) {
            $conditions['search']['start_date'] = $start_date;
        }
        if (!empty($end_date)) {
            $conditions['search']['end_date'] = $end_date;
        }
        //total rows count
        $totalRec = count($this->coupon_model->getRowsCount($conditions));
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url() . 'admin/coupon/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $this->data['coupon'] = $this->coupon_model->getRows($conditions);
        //load the view
        $this->load->view('admin/coupon/ajax-data', $this->data, false);
    }

    public function create()
    {
        $this->data['page_title'] = '新增優惠券';
        $this->data['store'] = $this->mysql_model->_select('store');
        // $this->data['hide_county'] = $this->service_area_model->get_hide_county();
        // $this->data['hide_district'] = $this->service_area_model->get_hide_district();
        if ($this->is_liqun_food) {
            $this->data['products'] = $this->mysql_model->_select('product');
            $this->render('admin/coupon/liqun/coupon_create');
        } else {
            $this->data['product'] = $this->mysql_model->_select('product');
            $this->render('admin/coupon/create');
        }
    }

    public function insert()
    {
        if ($this->is_liqun_food) {
            $this->db->where('name', $this->input->post('coupon_name'));
            $query = $this->db->get('new_coupon');
            if ($query->num_rows() > 0) {
                $this->session->set_flashdata('message', '此優惠券已存在。');
                redirect(base_url() . 'admin/coupon/create');
            } else {
                // create new coupon
                $data = array(
                    'name' => $this->input->post('name'),
                    'type' => $this->input->post('type'),
                    'discount_amount' => $this->input->post('discount_amount'),
                    'use_limit_enable' => $this->input->post('use_limit_enable'),
                    'use_type_enable' => $this->input->post('use_type_enable'),
                    'use_member_enable' => $this->input->post('use_member_enable'),
                    'use_product_enable' => $this->input->post('use_product_enable'),
                    'distribute_at' => $this->input->post('distribute_at'),
                    'discontinued_at' => $this->input->post('discontinued_at'),
                );
                if ($this->input->post('use_limit_enable') == '1') {
                    $data['use_limit_number'] = $this->input->post('use_limit_number');
                }
                if ($this->input->post('use_type_enable') == '1') {
                    $data['use_type_name'] = $this->input->post('use_type_name');
                    $data['use_type_number'] = $this->input->post('use_type_number');
                }
                if ($this->input->post('use_member_enable') == '1') {
                    $data['use_member_type'] = $this->input->post('use_member_type');
                }
                $this->db->insert('new_coupon', $data);
                $id = $this->db->insert_id();

                // linkage the custom and the coupon
                if ($this->input->post('use_member_enable') == '1') {
                    $memberType = $this->input->post('use_member_type');
                    if ($memberType != 'new_member') {
                        $members = $this->coupon_model->getTotalCustom();
                        foreach ($members as $self) {
                            $data = array(
                                'coupon_id' => $id,
                                'custom_id' => $self['id'],
                                'type' => $this->input->post('type'),
                                'discount_amount' => $this->input->post('discount_amount'),
                                'use_limit_enable' => $this->input->post('use_limit_enable'),
                                'use_type_enable' => $this->input->post('use_type_enable'),
                                'use_product_enable' => $this->input->post('use_product_enable'),
                                'distribute_at' => $this->input->post('distribute_at'),
                                'discontinued_at' => $this->input->post('discontinued_at'),
                            );
                            if ($this->input->post('use_limit_enable') == '1') {
                                $data['use_limit_number'] = $this->input->post('use_limit_number');
                            } else {
                                $data['use_limit_number'] = '';
                            }
                            if ($this->input->post('use_type_enable') == '1') {
                                $data['use_type_name'] = $this->input->post('use_type_name');
                                $data['use_type_number'] = $this->input->post('use_type_number');
                            } else {
                                $data['use_type_name'] = '';
                                $data['use_type_number'] = '';
                            }
                            $this->db->insert('new_coupon_custom', $data);
                        }
                    }
                }

                $productsArray = $this->input->post('checkboxList');
                if ($this->input->post('use_product_enable') == '1' && !empty($productsArray)) {
                    $existingProducts = $this->coupon_model->getExistCouponProduct($id);
                    if (!empty($existingProducts)) {
                        // 去名
                        $existingProductIds = array_column($existingProducts, 'use_product_id');

                        // 找出需要刪除的標籤
                        $ProductsToDelete = array_diff($existingProductIds, $productsArray);

                        // echo '<pre>';
                        // print_r($ProductsToDelete);
                        // echo '</pre>';

                        // 循環遍歷需要刪除的標籤，並刪除對應的數據
                        foreach ($ProductsToDelete as $self) {
                            $this->db->where('coupon_id', $id);
                            $this->db->where('use_product_id', $self);
                            $this->db->delete('new_coupon_product');
                        }
                    }


                    // 插入未存在標籤
                    foreach ($productsArray as $self) {
                        if (!$this->coupon_model->isExistProductID($id, $self)) {
                            $data = array(
                                'coupon_id' => $id,
                                'use_product_id' => $self,
                            );
                            $this->db->insert('new_coupon_product', $data);
                        }
                    }
                }
            }
        } else {
            $this->db->where('coupon_code', $this->input->post('coupon_code'));
            $query = $this->db->get('coupon');
            if ($query->num_rows() > 0) {
                $this->session->set_flashdata('message', '此優惠券代碼已存在。');
                redirect(base_url() . 'admin/coupon/create');
            } else {

                if (!empty($this->input->post('coupon_birthday_month'))) {
                    $coupon_birthday_month = implode(',', $this->input->post('coupon_birthday_month'));
                } else {
                    $coupon_birthday_month = '';
                }
                $data = array(
                    'coupon_type'                  => 'general',
                    'coupon_method'                => $this->input->post('coupon_method'),
                    'coupon_name'                  => $this->input->post('coupon_name'),
                    'coupon_code'                  => $this->input->post('coupon_code'),
                    'coupon_number'                => $this->input->post('coupon_number'),
                    'coupon_use_limit'             => $this->input->post('coupon_use_limit'),
                    'coupon_store_limit'           => $this->input->post('coupon_store_limit'),
                    'coupon_amount_limit'          => $this->input->post('coupon_amount_limit'),
                    'coupon_amount_limit_number'   => $this->input->post('coupon_amount_limit_number'),
                    'coupon_localtion_limit'       => $this->input->post('coupon_localtion_limit'),
                    'coupon_localtion_county'      => $this->input->post('coupon_localtion_county'),
                    'coupon_localtion_district'    => $this->input->post('coupon_localtion_district'),
                    'coupon_product_limit'         => $this->input->post('coupon_product_limit'),
                    'coupon_product_limit_product' => $this->input->post('coupon_product_limit_product'),
                    'coupon_product_limit_type'    => $this->input->post('coupon_product_limit_type'),
                    'coupon_product_limit_number'  => $this->input->post('coupon_product_limit_number'),
                    'coupon_birthday_only'         => $this->input->post('coupon_birthday_only'),
                    'coupon_birthday_month'        => $coupon_birthday_month,
                    'coupon_on_date'               => $this->input->post('coupon_on_date'),
                    'coupon_off_date'              => $this->input->post('coupon_off_date'),
                    'creator_id'                   => $this->current_user->id,
                    'created_at'                   => date('Y-m-d H:i:s'),
                );
                $this->db->insert('coupon', $data);
            }
        }

        $this->session->set_flashdata('message', '優惠券建立成功。');
        redirect(base_url() . 'admin/coupon');
    }

    public function edit($id)
    {
        $this->data['page_title'] = '編輯優惠券';
        $this->data['store'] = $this->mysql_model->_select('store');
        // $this->data['hide_county'] = $this->service_area_model->get_hide_county();
        // $this->data['hide_district'] = $this->service_area_model->get_hide_district();
        $this->data['change_log'] = get_change_log('coupon', $id);
        if ($this->is_liqun_food) {
            $this->data['products'] = $this->mysql_model->_select('product');
            $this->data['selected_products'] = $this->coupon_model->getSelectedProductID($id);
            $this->data['coupon'] = $this->mysql_model->_select('new_coupon', 'id', $id, 'row');
            $this->render('admin/coupon/liqun/coupon_edit');
        } else {
            $this->data['product'] = $this->mysql_model->_select('product');
            $this->data['coupon'] = $this->mysql_model->_select('coupon', 'coupon_id', $id, 'row');
            $this->render('admin/coupon/edit');
        }
    }

    public function update($id)
    {
        if ($this->is_liqun_food) {
            $data = array(
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'discount_amount' => $this->input->post('discount_amount'),
                'use_limit_enable' => $this->input->post('use_limit_enable'),
                'use_type_enable' => $this->input->post('use_type_enable'),
                'use_member_enable' => $this->input->post('use_member_enable'),
                'use_product_enable' => $this->input->post('use_product_enable'),
                'distribute_at' => $this->input->post('distribute_at'),
                'discontinued_at' => $this->input->post('discontinued_at'),
            );
            if ($this->input->post('use_limit_enable') == '1') {
                $data['use_limit_number'] = $this->input->post('use_limit_number');
            } else {
                $data['use_limit_number'] = '';
            }
            if ($this->input->post('use_type_enable') == '1') {
                $data['use_type_name'] = $this->input->post('use_type_name');
                $data['use_type_number'] = $this->input->post('use_type_number');
            } else {
                $data['use_type_name'] = '';
                $data['use_type_number'] = '';
            }
            if ($this->input->post('use_member_enable') == '1') {
                $data['use_member_type'] = $this->input->post('use_member_type');
            } else {
                $data['use_member_type'] = '';
            }
            $this->db->where('id', $id);
            $this->db->update('new_coupon', $data);

            if ($this->input->post('use_member_enable') == '0') {
                $members = $this->coupon_model->getTotalCustom();
                foreach ($members as $self) {
                    $this->db->where('coupon_id', $id);
                    $this->db->where('custom_id', $self['id']);
                    $this->db->delete('new_coupon_custom');
                }
            } else {
                $memberType = $this->input->post('use_member_type');
                if ($memberType != 'new_member') {
                    $members = $this->coupon_model->getTotalCustom();
                    foreach ($members as $self) {
                        $this->db->where('coupon_id', $id);
                        $this->db->where('custom_id', $self['id']);
                        $query = $this->db->get('new_coupon_custom');
                        if (!($query->num_rows() > 0)) {
                            $data = array(
                                'coupon_id' => $id,
                                'custom_id' => $self['id'],
                                'type' => $this->input->post('type'),
                                'discount_amount' => $this->input->post('discount_amount'),
                                'use_limit_enable' => $this->input->post('use_limit_enable'),
                                'use_type_enable' => $this->input->post('use_type_enable'),
                                'use_product_enable' => $this->input->post('use_product_enable'),
                                'distribute_at' => $this->input->post('distribute_at'),
                                'discontinued_at' => $this->input->post('discontinued_at'),
                            );
                            if ($this->input->post('use_limit_enable') == '1') {
                                $data['use_limit_number'] = $this->input->post('use_limit_number');
                            } else {
                                $data['use_limit_number'] = '';
                            }
                            if ($this->input->post('use_type_enable') == '1') {
                                $data['use_type_name'] = $this->input->post('use_type_name');
                                $data['use_type_number'] = $this->input->post('use_type_number');
                            } else {
                                $data['use_type_name'] = '';
                                $data['use_type_number'] = '';
                            }
                            $this->db->insert('new_coupon_custom', $data);
                        }
                    }
                }
            }

            $productsArray = $this->input->post('checkboxList');
            if ($this->input->post('use_product_enable') == '0' || empty($productsArray)) {
                // 檢查是否沒被選或是關閉功能
                $this->db->where('coupon_id', $id);
                $this->db->delete('new_coupon_product');
            } else {
                $existingProducts = $this->coupon_model->getExistCouponProduct($id);
                if (!empty($existingProducts)) {
                    // 去名
                    $existingProductIds = array_column($existingProducts, 'use_product_id');

                    // 找出需要刪除的標籤
                    $ProductsToDelete = array_diff($existingProductIds, $productsArray);

                    // echo '<pre>';
                    // print_r($ProductsToDelete);
                    // echo '</pre>';

                    // 循環遍歷需要刪除的標籤，並刪除對應的數據
                    foreach ($ProductsToDelete as $self) {
                        $this->db->where('coupon_id', $id);
                        $this->db->where('use_product_id', $self);
                        $this->db->delete('new_coupon_product');
                    }
                }


                // 插入未存在標籤
                foreach ($productsArray as $self) {
                    if (!$this->coupon_model->isExistProductID($id, $self)) {
                        $data = array(
                            'coupon_id' => $id,
                            'use_product_id' => $self,
                        );
                        $this->db->insert('new_coupon_product', $data);
                    }
                }
            }

            // 限定商品使用
            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';
            $this->session->set_flashdata('message', '優惠券編輯成功。');
            echo '<script>window.history.back();</script>';
        } else {
            // 紀錄欄位變動
            $updated_at = date('Y-m-d H:i:s');
            $coupon = $this->mysql_model->_select('coupon', 'coupon_id', $id, 'row');
            foreach ($coupon as $key => $value) {
                // echo "欄位: ".($key)." 的值: ".($value)."<br>";
                foreach ($_POST as $post_key => $post_value) {
                    if (!is_array($post_value)) {
                        // echo "欄位: ".($post_key)." 的值: ".($post_value)."<br>";
                        if ($key == $post_key) {
                            if ($value != $post_value) {
                                // echo $post_key." [值] ".$post_value."<br>";
                                $insert_data = array(
                                    'change_log_column'     => 'coupon',
                                    'change_log_column_id'  => $id,
                                    'change_log_key'        => $post_key,
                                    'change_log_value'      => $post_value,
                                    'change_log_creator_id' => $this->current_user->id,
                                    'change_log_created_at' => $updated_at,
                                );
                                $this->db->insert('change_log', $insert_data);
                            }
                        }
                    }
                }
            }

            $this->db->where('coupon_id !=', $this->input->post('coupon_id'));
            $this->db->where('coupon_code', $this->input->post('coupon_code'));
            $query = $this->db->get('coupon');
            if ($query->num_rows() > 0) {

                $this->session->set_flashdata('message', '此優惠券代碼已存在。');
                redirect(base_url() . 'admin/coupon/create');
            } else {

                if (!empty($this->input->post('coupon_birthday_month'))) {
                    $coupon_birthday_month = implode(',', $this->input->post('coupon_birthday_month'));
                } else {
                    $coupon_birthday_month = '';
                }
                $data = array(
                    'coupon_method'                => $this->input->post('coupon_method'),
                    'coupon_name'                  => $this->input->post('coupon_name'),
                    'coupon_code'                  => $this->input->post('coupon_code'),
                    'coupon_number'                => $this->input->post('coupon_number'),
                    'coupon_use_limit'             => $this->input->post('coupon_use_limit'),
                    'coupon_store_limit'           => $this->input->post('coupon_store_limit'),
                    'coupon_amount_limit'          => $this->input->post('coupon_amount_limit'),
                    'coupon_amount_limit_number'   => $this->input->post('coupon_amount_limit_number'),
                    'coupon_localtion_limit'       => $this->input->post('coupon_localtion_limit'),
                    'coupon_localtion_county'      => $this->input->post('coupon_localtion_county'),
                    'coupon_localtion_district'    => $this->input->post('coupon_localtion_district'),
                    'coupon_product_limit'         => $this->input->post('coupon_product_limit'),
                    'coupon_product_limit_product' => $this->input->post('coupon_product_limit_product'),
                    'coupon_product_limit_type'    => $this->input->post('coupon_product_limit_type'),
                    'coupon_product_limit_number'  => $this->input->post('coupon_product_limit_number'),
                    'coupon_birthday_only'         => $this->input->post('coupon_birthday_only'),
                    'coupon_birthday_month'        => $coupon_birthday_month,
                    'coupon_on_date'               => $this->input->post('coupon_on_date'),
                    'coupon_off_date'              => $this->input->post('coupon_off_date'),
                    'updater_id'                   => $this->current_user->id,
                    'updated_at'                   => date('Y-m-d H:i:s'),
                );
                $this->db->where('coupon_id', $id);
                $this->db->update('coupon', $data);
                $this->session->set_flashdata('message', '優惠券編輯成功。');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function delete($id)
    {
        if ($this->is_liqun_food) {
            $this->db->where('id', $id);
            $this->db->delete('new_coupon');
            $this->db->where('coupon_id', $id);
            $this->db->delete('new_coupon_custom');
            $this->db->where('coupon_id', $id);
            $this->db->delete('new_coupon_product');
        } else {
            $this->db->where('coupon_id', $id);
            $this->db->delete('coupon');
        }

        $this->session->set_flashdata('message', '優惠券刪除成功。');
        redirect(base_url() . 'admin/coupon');
    }

    public function multiple_action()
    {
        if (!empty($this->input->post('coupon_code'))) {
            foreach ($this->input->post('coupon_code') as $coupon_code) {
                if ($this->input->post('action') == 'delete') {

                    $this->db->where('coupon_code', $coupon_code);
                    $this->db->delete('coupon');

                    $this->db->where('coupon_code', $coupon_code);
                    $this->db->delete('user_coupon');
                }
            }
            $this->session->set_flashdata('message', '優惠券刪除成功。！');
        }
        redirect(base_url() . 'admin/coupon');
    }

    public function check_coupon()
    {
        $code = $this->input->post('coupon');
        $query = $this->db->get_where('coupon', array('coupon_code' => $code));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            echo json_encode($row, JSON_UNESCAPED_UNICODE);
            //echo $row->coupon_code;
        } else {
            //echo '優惠代碼錯誤。';
            echo 0;
        }
    }

    public function all_coupon()
    {
        $this->data['page_title'] = '全站優惠設定';
        $this->data['product'] = $this->mysql_model->_select('product');
        $this->load->model('service_area_model');
        $this->data['hide_county'] = $this->service_area_model->get_hide_county();
        $this->data['hide_district'] = $this->service_area_model->get_hide_district();
        $this->data['change_log'] = get_change_log('all_coupon', 0);
        $this->render('admin/coupon/all_coupon_setting');
    }

    public function recommend_coupon()
    {
        $this->data['page_title'] = '推薦碼優惠券設定';
        $this->data['product'] = $this->mysql_model->_select('product');
        $this->load->model('service_area_model');
        $this->data['hide_county'] = $this->service_area_model->get_hide_county();
        $this->data['hide_district'] = $this->service_area_model->get_hide_district();
        $this->data['change_log'] = get_change_log('recommend_coupon', 0);
        $this->render('admin/coupon/recommend_coupon_setting');
    }
}
