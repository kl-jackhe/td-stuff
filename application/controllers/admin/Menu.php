<?php defined('BASEPATH') or exit('No direct script access allowed');
class Menu extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->data['page_title'] = '選單管理';
        $this->data['menu'] = $this->getMenuData();
        $this->render('admin/menu/index');
    }

    function sub_index($id = 0)
    {
        $this->data['page_title'] = '子選單管理';
        $this->data['parent_id'] = $id;
        $this->data['menu'] = $this->getSubMenuData($id);
        $this->render('admin/menu/sub_index');
    }

    function insert()
    {
        $m_row = $this->getMenuData($this->input->post('menu_name'));
        $message = '新增失敗';
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

    function sub_insert()
    {
        $parent_id = $this->input->post('parent_id');
        $m_row = $this->getSubMenuData($this->input->post('menu_name'));
        $message = '新增失敗';
        if (empty($m_row)) {
            $insertData = array(
                'parent_id' => $parent_id,
                'name' => $this->input->post('menu_name'),
                'type' => $this->input->post('menu_type'),
                'sort' => $this->input->post('menu_sort'),
            );
            $this->db->insert('sub_menu', $insertData);
            $message = '新增成功';
        }
        $this->session->set_flashdata('message', $message);
        redirect(base_url() . 'admin/menu/sub_index/' . $parent_id);
    }

    function update()
    {
        $this->data['menu'] = $this->getMenuData();
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $sort = $this->input->post('sort');
        $status = $this->input->post('status');
        $message = '更新失敗';

        if (!empty($this->data['menu'])) {
            foreach ($this->data['menu'] as $self) {
                if ($sort == $self['sort']) {
                    if ($id != $self['id']) {
                        echo $message;
                        return;
                    }
                }
            }
        }

        if (!empty($id) && !empty($name) && !empty($sort) && !empty($status)) {
            try {
                $updateData = array(
                    'id' => $id,
                    'name' => $name,
                    'sort' => $sort,
                    'status' => $status,
                );
                $this->db->where('id', $id);
                $this->db->update('menu', $updateData);
                $message = '更新成功';
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }
        $this->session->set_flashdata('message', $message);
        echo $message;
        return;
    }

    function sub_update()
    {
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('menu');
        $this->session->set_flashdata('message', '刪除成功');
        redirect(base_url() . 'admin/menu');
    }

    function sub_delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('sub_menu');
        $this->session->set_flashdata('message', '刪除成功');
        // 回上一頁
        echo '<script>window.history.back();</script>';
    }

    function getMenuData($name = '')
    {
        $this->db->select('id,code,name,sort,type,status');
        if ($name != '') {
            $this->db->where('name', $name);
            $this->db->limit(1);
            $query = $this->db->get('menu')->row_array();
        } else {
            $this->db->order_by('sort', 'ASC');
            $query = $this->db->get('menu')->result_array();
        }
        return (!empty($query) ? $query : false);
    }

    function getSubMenuData($id = null)
    {
        $this->db->select('id, parent_id, code, name, sort, type, status');
        $this->db->where('parent_id', $id);
        $query = $this->db->get('sub_menu')->result_array();
        return (!empty($query) ? $query : false);
    }
}
