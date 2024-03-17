<?php defined('BASEPATH') or exit('No direct script access allowed');
class StandardPage extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->data['page_title'] = '制式頁面管理';
        $this->data['total_page'] = $this->mysql_model->_select('standard_page_list');
        $this->render('admin/standard_page/index');
    }

    function openStandardPage()
    {
        $this->data['pageData'] = $this->getStandardPageData($this->input->post('source'), $this->input->post('lang'));
        $this->load->view('admin/standard_page/page', $this->data);
    }

    function changeStandardPage()
    {
        $data = array(
            'page_title' => $this->input->post('title'),
            'page_info' => $this->input->post('content'),
            'page_img' => '',
            'page_lang' => $this->input->post('lang'),
        );
        $row = $this->getStandardPageData($this->input->post('source'), $this->input->post('lang'));
        if (!empty($row)) {
            $this->db->where('id', $row['id']);
            $this->db->update('standard_page_list', $data);
        } else {
            $data['page_name'] = $this->input->post('source');
            $this->db->insert('standard_page_list', $data);
        }
    }

    function getStandardPageData($source, $lang)
    {
        $this->db->select('id,page_name,page_title,page_info,page_img,page_lang');
        $this->db->where('page_name', $source);
        $this->db->where('page_lang', $lang);
        $this->db->limit(1);
        $row = $this->db->get('standard_page_list')->row_array();
        return (!empty($row) ? $row : false);
    }
}
