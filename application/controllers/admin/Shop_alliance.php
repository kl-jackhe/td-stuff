<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_alliance extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('shop_alliance_model');
    }

    public function index()
    {
        $this->data['page_title'] = '店家合作';

        $data = array();
        //total rows count
        $totalRec = count($this->shop_alliance_model->getRows());
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/shop_alliance/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //get the posts data
        $this->data['shop_alliance'] = $this->shop_alliance_model->getRows(array('limit'=>$this->perPage));

        $this->render('admin/shop_alliance/index');
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
        $status = $this->input->get('status');
        $county = $this->input->get('county');
        $district = $this->input->get('district');
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($status)){
            $conditions['search']['status'] = $status;
        }
        if(!empty($county)){
            $conditions['search']['county'] = $county;
        }
        if(!empty($district)){
            $conditions['search']['district'] = $district;
        }
        //total rows count
        $totalRec = count($this->shop_alliance_model->getRows($conditions));
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/shop_alliance/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $this->data['shop_alliance'] = $this->shop_alliance_model->getRows($conditions);
        //load the view
        $this->load->view('admin/shop_alliance/ajax-data', $this->data, false);
    }

    public function create()
    {
        $this->data['page_title'] = '新增店家合作';
        $this->render('admin/shop_alliance/create');
    }

    public function insert()
    {
        $data = array(
            'shop_alliance_name'         => $this->input->post('shop_alliance_name'),
            'shop_alliance_county'       => $this->input->post('county'),
            'shop_alliance_district'     => $this->input->post('district'),
            'shop_alliance_address'      => $this->input->post('shop_alliance_address'),
            'shop_alliance_contact_name' => $this->input->post('shop_alliance_contact_name'),
            'shop_alliance_email'        => $this->input->post('shop_alliance_email'),
            'shop_alliance_phone'        => $this->input->post('shop_alliance_phone'),
            'created_at'                 => date('Y-m-d H:i:s'),
        );

        $this->db->insert('shop_alliance', $data);
        $this->session->set_flashdata('message', '店家合作建立成功！');
        redirect( base_url() . 'admin/shop_alliance');
    }

    public function edit($id)
    {
        $this->data['page_title'] = '編輯店家合作';
        $this->data['shop_alliance'] = $this->mysql_model->_select('shop_alliance','shop_alliance_id',$id,'row');
        $this->render('admin/shop_alliance/edit');
    }

    public function update($id)
    {
        $data = array(
            'shop_alliance_name'         => $this->input->post('shop_alliance_name'),
            'shop_alliance_county'       => $this->input->post('county'),
            'shop_alliance_district'     => $this->input->post('district'),
            'shop_alliance_address'      => $this->input->post('shop_alliance_address'),
            'shop_alliance_contact_name' => $this->input->post('shop_alliance_contact_name'),
            'shop_alliance_email'        => $this->input->post('shop_alliance_email'),
            'shop_alliance_phone'        => $this->input->post('shop_alliance_phone'),
            'updated_at'                 => date('Y-m-d H:i:s'),
        );

        $this->db->where('shop_alliance_id', $id);
        $this->db->update('shop_alliance', $data);
        $this->session->set_flashdata('message', '店家合作編輯成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        $this->db->where('shop_alliance_id', $id);
        $this->db->delete('shop_alliance');
        $this->session->set_flashdata('message', '店家合作刪除成功！');
        redirect( base_url() . 'admin/shop_alliance');
    }

}