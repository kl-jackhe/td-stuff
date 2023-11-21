<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Lottery extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('lottery_model');
    }

    public function index()
    {
        $this->data['page_title'] = '抽選管理';
        $this->render('admin/lottery/index');
    }

    function ajaxData()
    {
        $conditions = array();
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        $keywords = $this->input->get('keywords');
        // $sortBy = $this->input->get('sortBy');
        // $category = $this->input->get('category');
        // $status = $this->input->get('status');
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        // if(!empty($sortBy)){
        //     $conditions['search']['sortBy'] = $sortBy;
        // }
        // if(!empty($category)){
        //     $conditions['search']['category'] = $category;
        // }
        // if(!empty($status)){
        //     $conditions['search']['status'] = $status;
        // }
        $totalRec = (!empty($this->lottery_model->getRows($conditions)) ? count($this->lottery_model->getRows($conditions)) : 0 );
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/lottery/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $this->data['lottery'] = $this->lottery_model->getRows($conditions);
        $this->load->view('admin/lottery/ajax-data', $this->data, false);
    }

}