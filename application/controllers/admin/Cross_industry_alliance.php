<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cross_industry_alliance extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('cross_industry_alliance_model');
    }

    public function index()
    {
        $this->data['page_title'] = '異業合作';

        $data = array();
        //total rows count
        $totalRec = count($this->cross_industry_alliance_model->getRows());
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/cross_industry_alliance/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //get the posts data
        $this->data['cross_industry_alliance'] = $this->cross_industry_alliance_model->getRows(array('limit'=>$this->perPage));

        $this->render('admin/cross_industry_alliance/index');
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
        $totalRec = count($this->cross_industry_alliance_model->getRows($conditions));
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/cross_industry_alliance/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $this->data['cross_industry_alliance'] = $this->cross_industry_alliance_model->getRows($conditions);
        //load the view
        $this->load->view('cross_industry_alliance/ajax-data', $this->data, false);
    }

    public function create()
    {
        $this->data['page_title'] = '新增異業合作';
        $this->render('admin/cross_industry_alliance/create');
    }

    public function insert()
    {
        $data = array(
            'cross_industry_alliance_name'         => $this->input->post('cross_industry_alliance_name'),
            'cross_industry_alliance_number'       => $this->input->post('cross_industry_alliance_number'),
            'cross_industry_alliance_contact_name' => $this->input->post('cross_industry_alliance_contact_name'),
            'cross_industry_alliance_email'        => $this->input->post('cross_industry_alliance_email'),
            'cross_industry_alliance_phone'        => $this->input->post('cross_industry_alliance_phone'),
            'cross_industry_alliance_content'      => $this->input->post('cross_industry_alliance_content'),
            'created_at'                           => date('Y-m-d H:i:s'),
        );

        $this->db->insert('cross_industry_alliance', $data);
        $this->session->set_flashdata('message', '異業合作建立成功！');
        redirect( base_url() . 'admin/cross_industry_alliance');
    }

    public function edit($id)
    {
        $this->data['page_title'] = '編輯異業合作';
        $this->data['cross_industry_alliance'] = $this->mysql_model->_select('cross_industry_alliance','cross_industry_alliance_id',$id,'row');
        $this->render('admin/cross_industry_alliance/edit');
    }

    public function update($id)
    {
        $data = array(
            'cross_industry_alliance_name'         => $this->input->post('cross_industry_alliance_name'),
            'cross_industry_alliance_number'       => $this->input->post('cross_industry_alliance_number'),
            'cross_industry_alliance_contact_name' => $this->input->post('cross_industry_alliance_contact_name'),
            'cross_industry_alliance_email'        => $this->input->post('cross_industry_alliance_email'),
            'cross_industry_alliance_phone'        => $this->input->post('cross_industry_alliance_phone'),
            'cross_industry_alliance_content'      => $this->input->post('cross_industry_alliance_content'),
            'updated_at'                           => date('Y-m-d H:i:s'),
        );

        $this->db->where('cross_industry_alliance_id', $id);
        $this->db->update('cross_industry_alliance', $data);
        $this->session->set_flashdata('message', '異業合作編輯成功！');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        $this->db->where('cross_industry_alliance_id', $id);
        $this->db->delete('cross_industry_alliance');
        $this->session->set_flashdata('message', '異業合作刪除成功！');
        redirect( base_url() . 'admin/cross_industry_alliance');
    }

}