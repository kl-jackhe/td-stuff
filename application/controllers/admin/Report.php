<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('report_model');
        //$this->output->enable_profiler(TRUE);
    }

    public function index()
    {
        $this->data['page_title'] = '報表查詢';
        $this->data['user'] = $this->mysql_model->_select('users');
        $this->data['sales_manufacturer'] = $this->report_model->get_sales_manufacturer();
        $this->data['purchase_manufacturer'] = $this->report_model->get_purchase_manufacturer();
        $this->render('report/index');
    }

    public function search()
    {
        $this->data['page_title'] = '查詢結果';
        if($this->input->get('type')=='pos'){
            $this->data['result'] = $this->report_model->search_pos();
            $this->data['void_result'] = $this->report_model->search_void_result();
            $this->data['fist_invoice'] = $this->report_model->search_fist_invoice();
            $this->data['last_invoice'] = $this->report_model->search_last_invoice();
            $this->render('report/pos');
        }
        elseif ($this->input->get('type')=='purchase') {
            $this->data['result'] = $this->report_model->search_purchase();
            $this->data['result_item'] = $this->report_model->search_purchase_item();
            $this->render('report/purchase');
        }
        elseif ($this->input->get('type')=='produce') {
            $this->data['result'] = $this->report_model->search_produce();
            $this->data['result_item'] = $this->report_model->search_produce_item();
            $this->render('report/produce');
        }
        elseif ($this->input->get('type')=='sales') {
            $this->data['result'] = $this->report_model->search_sales();
            $this->data['result_item'] = $this->report_model->search_sales_item();
            $this->render('report/sales');
        }
    }

}