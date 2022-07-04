<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_banner extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_banner_model');
    }

    public function index()
    {
        $this->data['page_title'] = '商品Banner';

        $data = array();
        //total rows count
        $totalRec = count($this->product_banner_model->getRows());
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/product_banner/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //get the posts data
        $this->data['product_banner'] = $this->product_banner_model->getRows(array('limit'=>$this->perPage));

        $this->render('admin/product_banner/index');
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
        $category = $this->input->get('category');
        $status = $this->input->get('status');
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($category)){
            $conditions['search']['category'] = $category;
        }
        if(!empty($status)){
            $conditions['search']['status'] = $status;
        }
        //total rows count
        $totalRec = count($this->product_banner_model->getRows($conditions));
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/product_banner/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $this->data['product_banner'] = $this->product_banner_model->getRows($conditions);
        //load the view
        $this->load->view('admin/product_banner/ajax-data', $this->data, false);
    }

    public function create()
    {
        $this->data['page_title'] = '新增商品Banner';
        $this->data['store'] = $this->mysql_model->_select('store');
        $this->render('admin/product_banner/create');
    }

    public function insert()
    {
        $data = array(
            'product_banner_name'          => $this->input->post('product_banner_name'),
            'product_banner_store'         => $this->input->post('product_banner_store'),
            'product_banner_on_the_shelf'  => $this->input->post('product_banner_on_the_shelf'),
            'product_banner_off_the_shelf' => $this->input->post('product_banner_off_the_shelf'),
            'product_banner_image'         => $this->input->post('product_banner_image'),
            'product_banner_link'          => $this->input->post('product_banner_link'),
            'product_banner_sort'          => $this->input->post('product_banner_sort'),
            'product_banner_status'        => $this->input->post('product_banner_status'),
            'creator_id'                   => $this->ion_auth->user()->row()->id,
            'created_at'                   => date('Y-m-d H:i:s'),
        );

        $this->db->insert('product_banner', $data);
        $this->session->set_flashdata('message', 'product_banner建立成功！');
        redirect( base_url() . 'admin/product_banner');
    }

    public function edit($id)
    {
        $this->data['page_title'] = '編輯商品Banner';
        $this->data['store'] = $this->mysql_model->_select('store');
        $this->data['product_banner'] = $this->mysql_model->_select('product_banner','product_banner_id',$id,'row');
        $this->render('admin/product_banner/edit');
    }

    public function update($id)
    {
        $data = array(
            'product_banner_name'          => $this->input->post('product_banner_name'),
            'product_banner_store'         => $this->input->post('product_banner_store'),
            'product_banner_on_the_shelf'  => $this->input->post('product_banner_on_the_shelf'),
            'product_banner_off_the_shelf' => $this->input->post('product_banner_off_the_shelf'),
            'product_banner_image'         => $this->input->post('product_banner_image'),
            'product_banner_link'          => $this->input->post('product_banner_link'),
            'product_banner_sort'          => $this->input->post('product_banner_sort'),
            'product_banner_status'        => $this->input->post('product_banner_status'),
            'updater_id'                   => $this->ion_auth->user()->row()->id,
            'updated_at'                   => date('Y-m-d H:i:s'),
        );

        $this->db->where('product_banner_id', $id);
        $this->db->update('product_banner', $data);
        $this->session->set_flashdata('message', '商品Banner編輯成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        $this->db->where('product_banner_id', $id);
        $this->db->delete('product_banner');
        $this->session->set_flashdata('message', '商品Banner刪除成功！');
        redirect( base_url() . 'admin/product_banner');
    }

    public function multiple_action()
    {
        if (!empty($this->input->post('product_banner_id'))) {
            foreach ($this->input->post('product_banner_id') as $product_banner_id) {
                if($this->input->post('action')=='delete'){
                    $this->db->where('product_banner_id', $product_banner_id);
                    $this->db->delete('product_banner');
                    $this->session->set_flashdata('message', '商品Banner刪除成功！');
                } elseif ($this->input->post('action')=='on_the_shelf') {
                    $data = array(
                        'product_banner_status' => '1',
                    );
                    $this->db->where('product_banner_id', $product_banner_id);
                    $this->db->update('product_banner', $data);
                    $this->session->set_flashdata('message', '商品Banner上架成功！');
                } elseif ($this->input->post('action')=='go_off_the_shelf') {
                    $data = array(
                        'product_banner_status' => '2',
                    );
                    $this->db->where('product_banner_id', $product_banner_id);
                    $this->db->update('product_banner', $data);
                    $this->session->set_flashdata('message', '商品Banner下架成功！');
                }
            }
        }
        redirect( base_url() . 'admin/product_banner');
    }

}