<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Service_area extends Admin_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('service_area_model');
    }

    public function index()
    {
        $this->data['page_title'] = '服務區域';

        $data = array();
        //total rows count
        $totalRec = count($this->service_area_model->getRows());
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/service_area/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //get the posts data
        $this->data['service_area'] = $this->service_area_model->getRows(array('limit'=>$this->perPage));

        $this->render('admin/service_area/index');
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
        // $status = $this->input->get('status');
        $county = $this->input->get('county');
        $district = $this->input->get('district');
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
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
        $totalRec = count($this->service_area_model->getRows($conditions));
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/service_area/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $this->data['service_area'] = $this->service_area_model->getRows($conditions);
        //load the view
        $this->load->view('admin/service_area/ajax-data', $this->data, false);
    }

    public function create()
    {
        $this->data['page_title'] = '新增服務區域';
        $this->render('admin/service_area/create');
    }

    public function insert()
    {
        $data = array(
            'service_area_county'   => $this->input->post('service_area_county'),
            'service_area_district' => $this->input->post('service_area_district'),
            'service_area_status'   => $this->input->post('service_area_status'),
        );

        $this->db->insert('service_area', $data);
        $this->session->set_flashdata('message', '服務區域建立成功。');
        redirect( base_url() . 'admin/service_area');
    }

    public function edit($id)
    {
        $this->data['page_title'] = '編輯服務區域';
        $this->data['service_area'] = $this->mysql_model->_select('service_area','service_area_id',$id,'row');
        $this->render('admin/service_area/edit');
    }

    public function update($id)
    {
        $data = array(
            'service_area_county'   => $this->input->post('service_area_county'),
            'service_area_district' => $this->input->post('service_area_district'),
            'service_area_status'   => $this->input->post('service_area_status'),
        );
        $this->db->where('service_area_id', $id);
        $this->db->update('service_area', $data);
        $this->session->set_flashdata('message', '服務區域編輯成功。');
        redirect( base_url() . 'admin/service_area');

    }

    public function delete($id)
    {
        $this->db->where('service_area_id', $id);
        $this->db->delete('service_area');
        $this->session->set_flashdata('message', '服務區域刪除成功。');
        redirect( base_url() . 'admin/service_area');
    }

    public function multiple_action()
    {
        if (!empty($this->input->post('service_area_id'))) {
            foreach ($this->input->post('service_area_id') as $service_area_id) {
                if($this->input->post('action')=='open'){
                    $data = array(
                        'service_area_status' => 1
                    );
                    $this->db->where('service_area_id', $service_area_id);
                    $this->db->update('service_area', $data);
                } elseif ($this->input->post('action')=='close') {
                    $data = array(
                        'service_area_status' => 0
                    );
                    $this->db->where('service_area_id', $service_area_id);
                    $this->db->update('service_area', $data);
                }
            }
            $this->session->set_flashdata('message', '服務區域更新成功！');
        } else {
            $this->session->set_flashdata('error_message', '請勾選服務區域！');
        }
        redirect( base_url() . 'admin/service_area');
    }

}