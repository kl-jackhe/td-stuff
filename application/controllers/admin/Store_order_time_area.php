<?php defined('BASEPATH') OR exit('No direct script access allowed');

class store_order_time_area extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('store_order_time_area_model');
        $this->load->model('service_area_model');
    }

    public function index()
    {
        $this->data['page_title'] = '可訂購時段範圍';

        $data = array();
        //total rows count
        $totalRec = count($this->store_order_time_area_model->getRowsCount());
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/store_order_time_area/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //get the posts data
        $this->data['store'] = $this->mysql_model->_select('store');
        $this->data['store_order_time_area'] = $this->store_order_time_area_model->getRows(array('limit'=>$this->perPage));

        $this->render('admin/store_order_time_area/index');
    }

    function ajaxData()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        //set conditions for search
        // $keywords = $this->input->get('keywords');
        // $sortBy = $this->input->get('sortBy');
        $category = $this->input->get('category');
        // $status = $this->input->get('status');
        $county = $this->input->get('county');
        $district = $this->input->get('district');
        // if(!empty($keywords)){
        //     $conditions['search']['keywords'] = $keywords;
        // }
        // if(!empty($sortBy)){
        //     $conditions['search']['sortBy'] = $sortBy;
        // }
        if(!empty($category)){
            $conditions['search']['category'] = $category;
        }
        // if(!empty($status)){
        //     $conditions['search']['status'] = $status;
        // }
        if(!empty($county)){
            $conditions['search']['county'] = $county;
        }
        if(!empty($district)){
            $conditions['search']['district'] = $district;
        }
        //total rows count
        $totalRec = count($this->store_order_time_area_model->getRowsCount($conditions));
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/store_order_time_area/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $this->data['store_order_time_area'] = $this->store_order_time_area_model->getRows($conditions);
        //load the view
        $this->load->view('admin/store_order_time_area/ajax-data', $this->data, false);
    }

    public function create_before()
    {
        $this->data['store'] = $this->mysql_model->_select('store');
        $this->load->view('admin/store_order_time_area/create-before', $this->data);
    }

    public function create()
    {
        $this->data['page_title'] = '新增可訂購時段範圍';
        // $this->data['store_id'] = $store_id;
        // $this->data['store'] = $this->mysql_model->_select('store','store_id',$store_id,'row');
        // $this->data['product'] = $this->mysql_model->_select('product','store_id',$store_id);
        $this->data['meal_time'] = $this->service_area_model->get_meal_time();
        $this->data['hide_county'] = $this->service_area_model->get_hide_county();
        $this->data['hide_district'] = $this->service_area_model->get_hide_district();
        // $this->render('admin/store_order_time_area/create');
        $this->render('admin/store_order_time_area/create-new');
    }

    public function insert()
    {
        $count_no = 0;
        $count_yes = 0;

        // 1,2,3,4 客戶ID
        foreach (explode(',',$this->input->post('store')) as $store) {

            $this_store = $this->mysql_model->_select('store', 'store_id', $store,'row');

            if(!empty($this->input->post('delivery_time'))){
                $delivery_time = implode(',', $this->input->post('delivery_time'));
            } else {
                $delivery_time='';
            }
            $first_date = '';
            $last_date = '';
            $first_date .= substr($this->input->post('store_order_time_area'), 0, 10);
            $last_date .= substr($this->input->post('store_order_time_area'), -11, 10);
            $data = array(
                'store_id'              => $store,
                'store_order_time_area' => $first_date.' - '.$last_date,
                'store_order_time'      => $this->input->post('store_order_time_area'),
                'store_close_time'      => $this->input->post('store_close_time'),
                'delivery_cost'         => $this->input->post('delivery_cost'),
                'delivery_county'       => $this->input->post('delivery_county'),
                'delivery_district'     => $this->input->post('delivery_district'),
                'delivery_time'         => $delivery_time,
                'creator_id'            => $this->ion_auth->user()->row()->id,
                'created_at'            => date('Y-m-d H:i:s'),
            );
            $store_order_time_area_id = $this->mysql_model->_insert('store_order_time_area',$data);

            $count               = count($this->input->post('use'));
            $store_id            = $this->input->post('store_id');
            $use                 = $this->input->post('use');
            $product_id          = $this->input->post('product_id');
            $product_daily_stock = $this->input->post('product_daily_stock');
            $product_person_buy  = $this->input->post('product_person_buy');
            for($i = 0; $i < $count; $i++){
                if($store_id[$i]==$store){
                    if($use[$i]=='1'){
                        $data = array(
                            'store_order_time_area_id' => $store_order_time_area_id,
                            'product_id'               => $product_id[$i],
                            'product_daily_stock'      => $product_daily_stock[$i],
                            'product_person_buy'       => $product_person_buy[$i],
                        );
                        $this->db->insert('store_order_time_area_item', $data);
                    }
                }
            }

            foreach (explode(',',$this->input->post('store_order_time_area')) as $sot) {
                if(!empty($sot)){

                    $this->db->where('store_id', $store);
                    $this->db->where('store_order_time_area', $sot);
                    $this->db->where('delivery_county', $this->input->post('delivery_county'));
                    $this->db->where('delivery_district', $this->input->post('delivery_district'));
                    $query = $this->db->get('store_order_time_area');
                    if($query->num_rows()>0){
                        $count_no++;
                        // $this->session->set_flashdata('message', '此可訂購時段範圍縣市或是行政區已經存在！');
                    } else {

                        $weekday = get_chinese_weekday($sot);
                        $this->db->like('store_off_day', $weekday);
                        $this->db->where('store_id', $this_store['store_id']);
                        $query = $this->db->get('store');
                        if ($query->num_rows() > 0) {
                            // 如果是公休日
                        } else {
                            // 如果不是公休日
                            if(!empty($this->input->post('delivery_time'))){
                                $delivery_time = implode(',', $this->input->post('delivery_time'));
                            } else {
                                $delivery_time='';
                            }
                            $data = array(
                                'store_id'                 => $store,
                                'store_order_time_area_id' => $store_order_time_area_id,
                                'store_order_time'         => $sot,
                                'store_close_time'         => $this->input->post('store_close_time'),
                                'delivery_cost'            => $this->input->post('delivery_cost'),
                                'delivery_county'          => $this->input->post('delivery_county'),
                                'delivery_district'        => $this->input->post('delivery_district'),
                                'delivery_time'            => $delivery_time,
                                'creator_id'               => $this->ion_auth->user()->row()->id,
                                'created_at'               => date('Y-m-d H:i:s'),
                            );

                            $store_order_time_id = $this->mysql_model->_insert('store_order_time',$data);

                            $count               = count($this->input->post('use'));
                            $store_id            = $this->input->post('store_id');
                            $use                 = $this->input->post('use');
                            $product_id          = $this->input->post('product_id');
                            $product_daily_stock = $this->input->post('product_daily_stock');
                            $product_person_buy  = $this->input->post('product_person_buy');
                            for($i = 0; $i < $count; $i++){
                                if($store_id[$i]==$store){
                                    if($use[$i]=='1'){
                                        $data = array(
                                            'store_order_time_id'      => $store_order_time_id,
                                            'store_order_time_area_id' => $store_order_time_area_id,
                                            'product_id'               => $product_id[$i],
                                            'product_daily_stock'      => $product_daily_stock[$i],
                                            'product_person_buy'       => $product_person_buy[$i],
                                        );
                                        $this->db->insert('store_order_time_item', $data);
                                    }
                                }
                            }
                            $count_yes++;
                        }

                    }
                }
            }

        }

        $this->session->set_flashdata('message', '建立'.$count_yes.'個可訂購時段，'.$count_no.'個已存在。');
        redirect( base_url() . 'admin/store_order_time_area');
        // redirect($_SERVER['HTTP_REFERER']);
    }

    public function insert_2020_01_16()
    {
        $count_no = 0;
        $count_yes = 0;
        $this_store = $this->mysql_model->_select('store', 'store_id', $this->input->post('store_id'),'row');

        // 配送時段
        if(!empty($this->input->post('delivery_time'))){
            $delivery_time = implode(',', $this->input->post('delivery_time'));
        } else {
            $delivery_time='';
        }
        // 可訂購日
        $first_date = '';
        $last_date = '';
        $first_date .= substr($this->input->post('store_order_time_area'), 0, 10);
        $last_date .= substr($this->input->post('store_order_time_area'), -11, 10);

        // 儲存可訂購時段範圍
        $data = array(
            'store_id'              => $this->input->post('store_id'),
            'store_order_time_area' => $first_date.' - '.$last_date,
            'store_order_time'      => $this->input->post('store_order_time_area'),
            'store_close_time'      => $this->input->post('store_close_time'),
            'delivery_cost'         => $this->input->post('delivery_cost'),
            'delivery_county'       => $this->input->post('delivery_county'),
            'delivery_district'     => $this->input->post('delivery_district'),
            'delivery_time'         => $delivery_time,
            'creator_id'            => $this->ion_auth->user()->row()->id,
            'created_at'            => date('Y-m-d H:i:s'),
        );
        $store_order_time_area_id = $this->mysql_model->_insert('store_order_time_area',$data);

        $count               = count($this->input->post('use'));
        $use                 = $this->input->post('use');
        $product_id          = $this->input->post('product_id');
        $product_daily_stock = $this->input->post('product_daily_stock');
        $product_person_buy  = $this->input->post('product_person_buy');
        for($i = 0; $i < $count; $i++){
            if($use[$i]=='1'){
                $data = array(
                    'store_order_time_area_id' => $store_order_time_area_id,
                    'product_id'               => $product_id[$i],
                    'product_daily_stock'      => $product_daily_stock[$i],
                    'product_person_buy'       => $product_person_buy[$i],
                );
                $this->db->insert('store_order_time_area_item', $data);
            }
        }

        // 儲存每個可訂購時段
        foreach (explode(',',$this->input->post('store_order_time_area')) as $sot) {
            if(!empty($sot)){

                $this->db->where('store_id', $this->input->post('store_id'));
                $this->db->where('store_order_time_area', $sot);
                $this->db->where('delivery_county', $this->input->post('delivery_county'));
                $this->db->where('delivery_district', $this->input->post('delivery_district'));
                $query = $this->db->get('store_order_time_area');
                if($query->num_rows()>0){
                    $count_no++;
                    // $this->session->set_flashdata('message', '此可訂購時段範圍縣市或是行政區已經存在！');
                } else {

                    $weekday = get_chinese_weekday($sot);
                    $this->db->like('store_off_day', $weekday);
                    $this->db->where('store_id', $this_store['store_id']);
                    $this->db->limit(1);
                    $query = $this->db->get('store');
                    if ($query->num_rows() > 0) {
                        // 如果是公休日
                    } else {
                        // 如果不是公休日
                        if(!empty($this->input->post('delivery_time'))){
                            $delivery_time = implode(',', $this->input->post('delivery_time'));
                        } else {
                            $delivery_time='';
                        }
                        $data = array(
                            'store_id'                 => $this->input->post('store_id'),
                            'store_order_time_area_id' => $store_order_time_area_id,
                            'store_order_time'         => $sot,
                            'store_close_time'         => $this->input->post('store_close_time'),
                            'delivery_cost'            => $this->input->post('delivery_cost'),
                            'delivery_county'          => $this->input->post('delivery_county'),
                            'delivery_district'        => $this->input->post('delivery_district'),
                            'delivery_time'            => $delivery_time,
                            'creator_id'               => $this->ion_auth->user()->row()->id,
                            'created_at'               => date('Y-m-d H:i:s'),
                        );

                        $store_order_time_id = $this->mysql_model->_insert('store_order_time',$data);

                        $count               = count($this->input->post('use'));
                        $use                 = $this->input->post('use');
                        $product_id          = $this->input->post('product_id');
                        $product_daily_stock = $this->input->post('product_daily_stock');
                        $product_person_buy  = $this->input->post('product_person_buy');
                        for($i = 0; $i < $count; $i++){
                            if($use[$i]=='1'){
                                $data = array(
                                    'store_order_time_id'      => $store_order_time_id,
                                    'store_order_time_area_id' => $store_order_time_area_id,
                                    'product_id'               => $product_id[$i],
                                    'product_daily_stock'      => $product_daily_stock[$i],
                                    'product_person_buy'       => $product_person_buy[$i],
                                );
                                $this->db->insert('store_order_time_item', $data);
                            }
                        }
                        $count_yes++;
                    }

                }
            }
        }

        $this->session->set_flashdata('message', '建立'.$count_yes.'個可訂購時段，'.$count_no.'個已存在。');
        redirect( base_url() . 'admin/store_order_time_area');
        // redirect($_SERVER['HTTP_REFERER']);
    }

    public function edit($id)
    {
        $this->data['page_title'] = '編輯可訂購時段範圍';
        $this_store_order_time_area = $this->mysql_model->_select('store_order_time_area','store_order_time_area_id',$id,'row');
        $this_store = $this->mysql_model->_select('store','store_id',$this_store_order_time_area['store_id'],'row');
        $this->data['store_id'] = $this_store['store_id'];
        $this->data['store'] = $this->mysql_model->_select('store','store_id',$this_store['store_id'],'row');
        $this->data['id'] = $id;
        $this->data['product'] = $this->mysql_model->_select('product','store_id',$this_store['store_id']);
        $this->data['store_order_time_area'] = $this->mysql_model->_select('store_order_time_area','store_order_time_area_id',$id,'row');
        $this->data['store_order_time_area_item'] = $this->mysql_model->_select('store_order_time_area_item','store_order_time_area_id',$id);
        $this->data['meal_time'] = $this->service_area_model->get_meal_time();
        $this->data['hide_county'] = $this->service_area_model->get_hide_county();
        $this->data['hide_district'] = $this->service_area_model->get_hide_district();
        $this->data['change_log'] = get_change_log('store_order_time_area',$id);
        // $this->render('admin/store_order_time_area/edit');
        $this->load->view('admin/store_order_time_area/edit', $this->data);
    }

    public function update($id)
    {
        // 紀錄欄位變動
        $updated_at = date('Y-m-d H:i:s');
        $store_order_time_area = $this->mysql_model->_select('store_order_time_area','store_order_time_area_id',$id,'row');
        foreach($store_order_time_area as $key => $value){
            // echo "欄位: ".($key)." 的值: ".($value)."<br>";
            foreach ($_POST as $post_key => $post_value) {
                if( !is_array( $post_value ) ){
                    // echo "欄位: ".($post_key)." 的值: ".($post_value)."<br>";
                    if($key==$post_key){
                        if($key=='delivery_cost'){
                            if($value!=$post_value){
                                // echo $post_key." [值] ".$post_value."<br>";
                                $insert_data = array(
                                    'change_log_column'     => 'store_order_time_area',
                                    'change_log_column_id'  => $id,
                                    'change_log_key'        => $post_key,
                                    'change_log_value'      => $post_value,
                                    'change_log_creator_id' => $this->ion_auth->user()->row()->id,
                                    'change_log_created_at' => $updated_at,
                                );
                                $this->db->insert('change_log', $insert_data);
                            }
                        }
                    }
                }
            }
        }

        $this_store = $this->mysql_model->_select('store', 'store_id', $this->input->post('store_id'),'row');
        if(!empty($this->input->post('delivery_time'))){
            $delivery_time = implode(',', $this->input->post('delivery_time'));
        } else {
            $delivery_time='';
        }
        $first_date = '';
        $last_date = '';
        $first_date .= substr($this->input->post('store_order_time_area'), 0, 10);
        $last_date .= substr($this->input->post('store_order_time_area'), -11, 10);
        $data = array(
            'store_id'              => $this->input->post('store_id'),
            'store_order_time_area' => $first_date.' - '.$last_date,
            'store_order_time'      => $this->input->post('store_order_time_area'),
            'store_close_time'      => $this->input->post('store_close_time'),
            'delivery_cost'         => $this->input->post('delivery_cost'),
            'delivery_county'       => $this->input->post('delivery_county'),
            'delivery_district'     => $this->input->post('delivery_district'),
            'delivery_time'         => $delivery_time,
            'updater_id'            => $this->ion_auth->user()->row()->id,
            'updated_at'            => date('Y-m-d H:i:s'),
        );

        $this->db->where('store_order_time_area_id', $id);
        $this->db->update('store_order_time_area', $data);

        $this->db->where('store_order_time_area_id', $id);
        $this->db->delete('store_order_time_area_item');

        $count               = count($this->input->post('use'));
        $use                 = $this->input->post('use');
        $product_id          = $this->input->post('product_id');
        $product_daily_stock = $this->input->post('product_daily_stock');
        $product_person_buy  = $this->input->post('product_person_buy');
        for($i = 0; $i < $count; $i++){
            if($use[$i]=='1'){
                $data = array(
                    'store_order_time_area_id' => $id,
                    'product_id'               => $product_id[$i],
                    'product_daily_stock'      => $product_daily_stock[$i],
                    'product_person_buy'       => $product_person_buy[$i],
                );
                $this->db->insert('store_order_time_area_item', $data);
            }
        }

        $this->db->where('store_order_time_area_id', $id);
        $this->db->delete('store_order_time');

        $this->db->where('store_order_time_area_id', $id);
        $this->db->delete('store_order_time_item');

        foreach (explode(',',$this->input->post('store_order_time_area')) as $sot) {
            if(!empty($sot)){
                // 刪除原有的可訂購時段
                // $this->db->where('store_id', $this->input->post('store_id'));
                // $this->db->where('store_order_time', $sot);
                // $this->db->where('delivery_county', $this->input->post('delivery_county'));
                // $this->db->where('delivery_district', $this->input->post('delivery_district'));
                // $query = $this->db->get('store_order_time');
                // if($query->num_rows()>0){
                //     foreach ($query->result_array() as $data) {
                //         $this->db->where('store_order_time_id', $data['store_order_time_id']);
                //         $this->db->delete('store_order_time');
                //         //
                //         $this->db->where('store_order_time_id', $data['store_order_time_id']);
                //         $this->db->delete('store_order_time_item');
                //     }
                // }
                // End 刪除原有的可訂購時段

                $weekday = get_chinese_weekday($sot);
                $this->db->like('store_off_day', $weekday);
                $this->db->where('store_id', $this_store['store_id']);
                $query = $this->db->get('store');
                if ($query->num_rows() > 0) {
                    // 如果是公休日
                } else {
                    // 如果不是公休日
                    if(!empty($this->input->post('delivery_time'))){
                        $delivery_time = implode(',', $this->input->post('delivery_time'));
                    } else {
                        $delivery_time='';
                    }
                    $data = array(
                        'store_id'          => $this->input->post('store_id'),
                        'store_order_time_area_id' => $id,
                        'store_order_time'  => $sot,
                        'store_close_time'  => $this->input->post('store_close_time'),
                        'delivery_cost'     => $this->input->post('delivery_cost'),
                        'delivery_county'   => $this->input->post('delivery_county'),
                        'delivery_district' => $this->input->post('delivery_district'),
                        'delivery_time'     => $delivery_time,
                        'creator_id'        => $this->ion_auth->user()->row()->id,
                        'created_at'        => date('Y-m-d H:i:s'),
                    );

                    $store_order_time_id = $this->mysql_model->_insert('store_order_time',$data);

                    $count               = count($this->input->post('use'));
                    $use                 = $this->input->post('use');
                    $product_id          = $this->input->post('product_id');
                    $product_daily_stock = $this->input->post('product_daily_stock');
                    $product_person_buy  = $this->input->post('product_person_buy');
                    for($i = 0; $i < $count; $i++){
                        if($use[$i]=='1'){
                            $data = array(
                                'store_order_time_id' => $store_order_time_id,
                                'store_order_time_area_id' => $id,
                                'product_id'          => $product_id[$i],
                                'product_daily_stock' => $product_daily_stock[$i],
                                'product_person_buy'  => $product_person_buy[$i],
                            );
                            $this->db->insert('store_order_time_item', $data);
                        }
                    }
                }

            }
        }

        $this->session->set_flashdata('message', '可訂購時段範圍修改成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        //
        $this->db->where('store_order_time_area_id', $id);
        $this->db->delete('store_order_time_area');
        //
        $this->db->where('store_order_time_area_id', $id);
        $this->db->delete('store_order_time_area_item');
        //
        $this->db->where('store_order_time_area_id', $id);
        $this->db->delete('store_order_time');
        //
        $this->db->where('store_order_time_area_id', $id);
        $this->db->delete('store_order_time_item');

        $this->session->set_flashdata('message', '可訂購時段範圍刪除成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function ajax_delete($id)
    {
        $count=0;
        //
        $this->db->where('store_order_time_area_id', $id);
        if($this->db->delete('store_order_time_area')){
            $count++;
        }
        //
        $this->db->where('store_order_time_area_id', $id);
        if($this->db->delete('store_order_time_area_item')){
            $count++;
        }
        //
        $this->db->where('store_order_time_area_id', $id);
        if($this->db->delete('store_order_time')){
            $count++;
        }
        //
        $this->db->where('store_order_time_area_id', $id);
        if($this->db->delete('store_order_time_item')){
            $count++;
        }

        if($count>0){
            echo 'ok';
        } else {
            echo 'no';
        }
    }

    public function multiple_action()
    {
        if (!empty($this->input->post('store_order_time_area_id'))) {
            foreach ($this->input->post('store_order_time_area_id') as $id) {
                if($this->input->post('action')=='delete'){
                    //
                    $this->db->where('store_order_time_area_id', $id);
                    $this->db->delete('store_order_time_area');
                    //
                    $this->db->where('store_order_time_area_id', $id);
                    $this->db->delete('store_order_time_area_item');
                    //
                    $this->db->where('store_order_time_area_id', $id);
                    $this->db->delete('store_order_time');
                    //
                    $this->db->where('store_order_time_area_id', $id);
                    $this->db->delete('store_order_time_item');
                }
            }
            $this->session->set_flashdata('message', '可訂購時段範圍刪除成功！');
        } else {
            $this->session->set_flashdata('message', '請選擇可訂購時段範圍！');
        }
        
        redirect($_SERVER['HTTP_REFERER']);
    }

}