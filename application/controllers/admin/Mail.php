<?php defined('BASEPATH') or exit('No direct script access allowed');
class Mail extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->data['page_title'] = '郵件管理';
        //total rows count
        $conditions['returnType'] = 'count';
        $totalRec = $this->posts_model->getRows($conditions);
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url() . 'admin/mail/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        $this->data['mail'] = $this->mysql_model->_select('contact');
        $this->render('admin/mail/index');
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
        $sortBy = $this->input->get('sortBy');
        $status = $this->input->get('status');
        if (!empty($keywords)) {
            $conditions['search']['keywords'] = $keywords;
        }
        if (!empty($sortBy)) {
            $conditions['search']['sortBy'] = $sortBy;
        }
        if (!empty($status)) {
            $conditions['search']['status'] = $status;
        }
        //total rows count
        $conditions['returnType'] = 'count';
        $totalRec = $this->product_model->getRows($conditions);
        //pagination configuration
        $config['target'] = '#datatable';
        $config['base_url'] = base_url() . 'admin/mail/ajaxData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $conditions['returnType'] = '';
    }
}
