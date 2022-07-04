<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Store_order_time extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('service_area_model');
        $this->load->model('store_order_time_model');
        $this->load->model('store_order_time_area_model');
    }

    public function index()
    {
        $this->data['page_title'] = '可訂購時段';

        $data = array();
        //total rows count
        $totalRec = count($this->store_order_time_model->getRows());
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/store_order_time/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //get the posts data
        $this->data['store'] = $this->mysql_model->_select('store');
        $this->data['store_order_time'] = $this->store_order_time_model->getRows(array('limit'=>$this->perPage));
        $this->data['store_order_time_area'] = $this->store_order_time_area_model->getRows(array('limit'=>$this->perPage));

        $this->render('admin/store_order_time/index');
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
        $totalRec = count($this->store_order_time_model->getRows($conditions));
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/store_order_time/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $this->data['store_order_time'] = $this->store_order_time_model->getRows($conditions);
        //load the view
        $this->load->view('admin/store_order_time/ajax-data', $this->data, false);
    }

    public function create_before()
    {
        $this->data['store'] = $this->mysql_model->_select('store');
        $this->load->view('admin/store_order_time/create-before', $this->data);
    }

    public function create($store_id)
    {
        $this->data['page_title'] = '新增可訂購時段';
        $this->data['store_id'] = $store_id;
        $this->data['store'] = $this->mysql_model->_select('store','store_id',$store_id,'row');
        $this->data['product'] = $this->mysql_model->_select('product','store_id',$store_id);
        $this->data['hide_county'] = $this->service_area_model->get_hide_county();
        $this->data['hide_district'] = $this->service_area_model->get_hide_district();
        $this->render('admin/store_order_time/create');
    }

    public function insert()
    {
        $count_no = 0;
        $count_yes = 0;
        $this_store = $this->mysql_model->_select('store', 'store_id', $this->input->post('store_id'),'row');

        if(!empty($this->input->post('delivery_time'))){
            $delivery_time = implode(',', $this->input->post('delivery_time'));
        } else {
            $delivery_time='';
        }
        $first_date = '';
        $last_date = '';
        $first_date .= substr($this->input->post('store_order_time'), 0, 10);
        $last_date .= substr($this->input->post('store_order_time'), -11, 10);
        $data = array(
            'store_id'              => $this->input->post('store_id'),
            'store_order_time_area' => $first_date.' - '.$last_date,
            'store_order_time'      => $this->input->post('store_order_time'),
            'store_close_time'      => $this->input->post('store_close_time'),
            'delivery_cost'         => $this->input->post('delivery_cost'),
            'delivery_county'       => $this->input->post('delivery_county'),
            'delivery_district'     => $this->input->post('delivery_district'),
            'delivery_time'         => $delivery_time,
            'creator_id'            => $this->ion_auth->user()->row()->id,
            'created_at'            => date('Y-m-d H:i:s'),
        );
        $store_order_time_area_id = $this->mysql_model->_insert('store_order_time_area',$data);

        foreach (explode(',',$this->input->post('store_order_time')) as $sot) {
            if(!empty($sot)){

                $this->db->where('store_id', $this->input->post('store_id'));
                $this->db->where('store_order_time', $sot);
                $this->db->where('delivery_county', $this->input->post('delivery_county'));
                $this->db->where('delivery_district', $this->input->post('delivery_district'));
                $query = $this->db->get('store_order_time');
                if($query->num_rows()>0){
                    $count_no++;
                    // $this->session->set_flashdata('message', '此可訂購時段縣市或是行政區已經存在！');
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
                            'store_id'          => $this->input->post('store_id'),
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

                        $count               = count($this->input->post('product_id'));
                        $product_id          = $this->input->post('product_id');
                        $product_daily_stock = $this->input->post('product_daily_stock');
                        $product_person_buy  = $this->input->post('product_person_buy');
                        for($i = 0; $i < $count; $i++){
                            $data = array(
                                'store_order_time_id' => $store_order_time_id,
                                'product_id'          => $product_id[$i],
                                'product_daily_stock' => $product_daily_stock[$i],
                                'product_person_buy'  => $product_person_buy[$i],
                            );
                            $this->db->insert('store_order_time_item', $data);
                            //
                            $data = array(
                                'store_order_time_area_id' => $store_order_time_area_id,
                                'product_id'               => $product_id[$i],
                                'product_daily_stock'      => $product_daily_stock[$i],
                                'product_person_buy'       => $product_person_buy[$i],
                            );
                            $this->db->insert('store_order_time_area_item', $data);
                        }
                        $count_yes++;
                    }

                }
            }
        }

        $this->session->set_flashdata('message', '建立'.$count_yes.'個可訂購時段，'.$count_no.'個已存在。');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function edit($id)
    {
        $this->data['page_title'] = '編輯可訂購時段';
        $this_store_order_time = $this->mysql_model->_select('store_order_time','store_order_time_id',$id,'row');
        $this_store = $this->mysql_model->_select('store','store_id',$this_store_order_time['store_id'],'row');
        $this->data['store_id'] = $this_store['store_id'];
        $this->data['store'] = $this->mysql_model->_select('store','store_id',$this_store['store_id'],'row');
        $this->data['id'] = $id;
        $this->data['product'] = $this->mysql_model->_select('product','store_id',$this_store['store_id']);
        $this->data['store_order_time'] = $this->mysql_model->_select('store_order_time','store_order_time_id',$id,'row');
        $this->data['store_order_time_item'] = $this->mysql_model->_select('store_order_time_item','store_order_time_id',$id);
        $this->data['hide_county'] = $this->service_area_model->get_hide_county();
        $this->data['hide_district'] = $this->service_area_model->get_hide_district();
        $this->render('admin/store_order_time/edit');
    }

    public function update($id)
    {
        $this->db->where('store_order_time_id !=', $id);
        $this->db->where('store_id', $this->input->post('store_id'));
        $this->db->where('store_order_time', $this->input->post('store_order_time'));
        $this->db->where('delivery_county', $this->input->post('delivery_county'));
        $this->db->where('delivery_district', $this->input->post('delivery_district'));
        $query = $this->db->get('store_order_time');
        if($query->num_rows()>0){
            $this->session->set_flashdata('message', '此可訂購時段縣市或是行政區已經存在！');
        } else {
            if(!empty($this->input->post('delivery_time'))){
                $delivery_time = implode(',', $this->input->post('delivery_time'));
            } else {
                $delivery_time='';
            }
            $data = array(
                'store_id'          => $this->input->post('store_id'),
                'store_order_time'  => $this->input->post('store_order_time'),
                'store_close_time'  => $this->input->post('store_close_time'),
                'delivery_cost'     => $this->input->post('delivery_cost'),
                'delivery_county'   => $this->input->post('delivery_county'),
                'delivery_district' => $this->input->post('delivery_district'),
                'delivery_time'     => $delivery_time,
                'updater_id'        => $this->ion_auth->user()->row()->id,
                'updated_at'        => date('Y-m-d H:i:s'),
            );

            $this->db->where('store_order_time_id', $id);
            $this->db->update('store_order_time', $data);

            $this->db->where('store_order_time_id', $id);
            $this->db->delete('store_order_time_item');

            $count               = count($this->input->post('use'));
            $use                 = $this->input->post('use');
            $product_id          = $this->input->post('product_id');
            $product_daily_stock = $this->input->post('product_daily_stock');
            $product_person_buy  = $this->input->post('product_person_buy');
            for($i = 0; $i < $count; $i++){
                if($use[$i]=='1'){
                    $data = array(
                        'store_order_time_id' => $id,
                        'product_id'          => $product_id[$i],
                        'product_daily_stock' => $product_daily_stock[$i],
                        'product_person_buy'  => $product_person_buy[$i],
                    );
                    $this->db->insert('store_order_time_item', $data);
                }
            }
            $this->session->set_flashdata('message', '可訂購時段修改成功！');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        //
        $this->db->where('store_order_time_id', $id);
        $this->db->delete('store_order_time');
        //
        $this->db->where('store_order_time_id', $id);
        $this->db->delete('store_order_time_item');
        $this->session->set_flashdata('message', '可訂購時段刪除成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

}