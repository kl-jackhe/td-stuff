<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Menu extends Admin_Controller {
    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['page_title'] = '選單管理';
        $this->data['menu'] = $this->getMenuData();
        $this->render('admin/menu/index');
    }

    function insert() {
        $m_row = $this->getMenuData($this->input->post('menu_name'));
        $message = '新增失敗「名稱重複」';
        if (empty($m_row)) {
            $insertData = array(
                'name' => $this->input->post('menu_name'),
                'type' => $this->input->post('menu_type'),
                'sort' => $this->input->post('menu_sort'),
            );
            $this->db->insert('menu', $insertData);
            $message = '新增成功';
        }
        $this->session->set_flashdata('message', $message);
        redirect(base_url() . 'admin/menu');
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('menu');
        $this->session->set_flashdata('message', '刪除成功');
        redirect(base_url() . 'admin/menu');
    }

    function getMenuData($name = '') {
        $this->db->select('id,code,name,sort,type,status');
        if ($name != '') {
            $this->db->where('name', $name);
            $this->db->limit(1);
            $query = $this->db->get('menu')->row_array();
        } else {
            $query = $this->db->get('menu')->result_array();
        }
        return (!empty($query)?$query:false);
    }

}