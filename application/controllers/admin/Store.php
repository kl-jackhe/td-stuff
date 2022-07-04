<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('store_model');
        $this->load->model('service_area_model');
    }

    public function index()
    {
        $this->data['page_title'] = '店家';

        $data = array();
        //total rows count
        $totalRec = count($this->store_model->getRowsCount());
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/store/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //get the posts data
        $this->data['store'] = $this->store_model->getRows(array('limit'=>$this->perPage));

        $this->render('admin/store/index');
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
        $keywords = $this->input->get('keywords');
        $sortBy = $this->input->get('sortBy');
        // $category = $this->input->get('category');
        // $status = $this->input->get('status');
        $county = $this->input->get('county');
        $district = $this->input->get('district');
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        // if(!empty($category)){
        //     $conditions['search']['category'] = $category;
        // }
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
        $totalRec = count($this->store_model->getRowsCount($conditions));
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/store/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $this->data['store'] = $this->store_model->getRows($conditions);
        //load the view
        $this->load->view('admin/store/ajax-data', $this->data, false);
    }

    public function create()
    {
        $this->data['page_title'] = '新增店家';
        $this->data['hide_county'] = $this->service_area_model->get_hide_county();
        $this->data['hide_district'] = $this->service_area_model->get_hide_district();
        $this->render('admin/store/create');
    }

    public function insert()
    {
        if(!empty($this->input->post('store_support_time'))){
            $store_support_time = implode(',', $this->input->post('store_support_time'));
        } else {
            $store_support_time='';
        }

        if(!empty($this->input->post('store_off_day'))){
            $store_off_day = implode(',', $this->input->post('store_off_day'));
        } else {
            $store_off_day='';
        }

        $data = array(
            'store_name'          => $this->input->post('store_name'),
            'store_county'        => $this->input->post('store_county'),
            'store_district'      => $this->input->post('store_district'),
            'store_address'       => $this->input->post('address'),
            'store_image'         => $this->input->post('store_image'),
            'store_banner'        => $this->input->post('store_banner'),
            'store_link'          => $this->input->post('store_link'),
            'store_open_time'     => $this->input->post('store_open_time'),
            'store_closing_time'  => $this->input->post('store_closing_time'),
            'store_support_time'  => $store_support_time,
            'store_off_day'       => $store_off_day,
            // 'store_delivery_cost' => $this->input->post('store_delivery_cost'),
            'creator_id'          => $this->ion_auth->user()->row()->id,
            'created_at'          => date('Y-m-d H:i:s'),
        );

        $this->db->insert('store', $data);
        $this->session->set_flashdata('message', '店家建立成功！');
        redirect( base_url() . 'admin/store');
    }

    public function edit($id)
    {
        $this->data['page_title'] = '編輯店家';
        $this->data['store'] = $this->mysql_model->_select('store','store_id',$id,'row');
        $this->data['store_order_time'] = $this->mysql_model->_select('store_order_time','store_id',$id,'result',0,'store_order_time',1);
        $this->data['product'] = $this->mysql_model->_select('product','store_id',$id);
        $this->data['hide_county'] = $this->service_area_model->get_hide_county();
        $this->data['hide_district'] = $this->service_area_model->get_hide_district();
        $this->render('admin/store/edit');
    }

    public function update($id)
    {
        if(!empty($this->input->post('store_support_time'))){
            $store_support_time = implode(',', $this->input->post('store_support_time'));
        } else {
            $store_support_time='';
        }

        if(!empty($this->input->post('store_off_day'))){
            $store_off_day = implode(',', $this->input->post('store_off_day'));
        } else {
            $store_off_day='';
        }

        $data = array(
            'store_name'              => $this->input->post('store_name'),
            'store_county'            => $this->input->post('store_county'),
            'store_district'          => $this->input->post('store_district'),
            'store_address'           => $this->input->post('address'),
            'store_image'             => $this->input->post('store_image'),
            'store_banner'            => $this->input->post('store_banner'),
            'store_link'              => $this->input->post('store_link'),
            'store_open_time'         => $this->input->post('store_open_time'),
            'store_closing_time'      => $this->input->post('store_closing_time'),
            'store_support_time'      => $store_support_time,
            'store_off_day'           => $store_off_day,
            'store_can_order_day'     => $this->input->post('store_can_order_day'),
            'store_close_order_day'   => $this->input->post('store_close_order_day'),
            'store_delivery_county'   => $this->input->post('store_delivery_county'),
            'store_delivery_district' => $this->input->post('store_delivery_district'),
            // 'store_delivery_cost'     => $this->input->post('store_delivery_cost'),
            // 'store_status'            => $this->input->post('store_status'),
            'updater_id'              => $this->ion_auth->user()->row()->id,
            'updated_at'              => date('Y-m-d H:i:s'),
        );

        $this->db->where('store_id', $id);
        $this->db->update('store', $data);
        $this->session->set_flashdata('message', '店家編輯成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        //
        $this->db->where('store_id', $id);
        $this->db->delete('store');
        //
        $this->db->where('store_id', $id);
        $this->db->delete('product');
        //
        $this->db->where('store_id', $id);
        $this->db->delete('store_order_time');
        $this->session->set_flashdata('message', '店家刪除成功！');
        redirect( base_url() . 'admin/store');
    }

    public function order_time_create($store_id)
    {
        $this->data['page_title'] = '新增可訂購時段';
        $this->data['store_id'] = $store_id;
        $this->data['store'] = $this->mysql_model->_select('store','store_id',$store_id,'row');
        $this->data['product'] = $this->mysql_model->_select('product','store_id',$store_id);
        $this->data['hide_county'] = $this->service_area_model->get_hide_county();
        $this->data['hide_district'] = $this->service_area_model->get_hide_district();
        $this->load->view('admin/store/order_time/create', $this->data);
    }

    public function order_time_insert()
    {
        // $this->db->where('store_id', $this->input->post('store_id'));
        // $this->db->where('store_order_time', $this->input->post('store_order_time'));
        // $this->db->where('delivery_county', $this->input->post('delivery_county'));
        // $this->db->where('delivery_district', $this->input->post('delivery_district'));
        // $query = $this->db->get('store_order_time');
        // if($query->num_rows()>0){
        //     $this->session->set_flashdata('message', '此可訂購時段縣市或是行政區已經存在！');
        // } else {
        $this_store = $this->mysql_model->_select('store', 'store_id', $this->input->post('store_id'),'row');
        foreach (explode(',',$this->input->post('store_order_time')) as $sot) {

            $weekday = get_chinese_weekday($sot);
            $this->db->like('store_off_day', $weekday);
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
                }

            }
        }
        // }
        $this->session->set_flashdata('message', '可訂購時段建立成功！');
        // redirect($_SERVER['HTTP_REFERER']);
        redirect( base_url() . 'admin/store_order_time');
    }

    public function order_time_edit($store_id,$id)
    {
        $this->data['page_title'] = '編輯可訂購時段';
        $this->data['store_id'] = $store_id;
        $this->data['store'] = $this->mysql_model->_select('store','store_id',$store_id,'row');
        $this->data['id'] = $id;
        $this->data['product'] = $this->mysql_model->_select('product','store_id',$store_id);
        $this->data['store_order_time'] = $this->mysql_model->_select('store_order_time','store_order_time_id',$id,'row');
        $this->data['store_order_time_item'] = $this->mysql_model->_select('store_order_time_item','store_order_time_id',$id);
        $this->data['hide_county'] = $this->service_area_model->get_hide_county();
        $this->data['hide_district'] = $this->service_area_model->get_hide_district();
        $this->load->view('admin/store/order_time/edit', $this->data);
    }

    public function order_time_update($id)
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

    public function order_time_delete($id)
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