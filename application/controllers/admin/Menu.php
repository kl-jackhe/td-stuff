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
        $this->data['menu'] = $this->menu_model->getMenuData();
        $this->render('admin/menu/index');
    }

    function sub_index($parent_id = 0)
    {
        $parentName = $this->menu_model->getMenuData($parent_id);
        $this->data['page_title'] = $parentName['name'] . '-選單管理';
        $this->data['parent_id'] = $parent_id;
        $this->data['menu'] = $this->menu_model->getSubMenuData(0, $parent_id);
        $this->render('admin/menu/sub_index');
    }

    function sub_son_index($parent_id = 0)
    {
        $parentName = $this->menu_model->getSubMenuData($parent_id, 0);
        $grandParentName = $this->menu_model->getMenuData($parentName['parent_id']);
        $this->data['page_title'] = $grandParentName['name'] . '-' . $parentName['name'] . '-選單管理';
        $this->data['parent_id'] = $parent_id;
        $this->data['grandparent_id'] = $grandParentName['id'];
        $this->data['menu'] = $this->menu_model->getSubSonMenuData(0, $parent_id);
        $this->render('admin/menu/sub_son_index');
    }

    function sub_sub_son_index($parent_id = 0)
    {
        $parentName = $this->menu_model->getSubSonMenuData($parent_id, 0);
        $grandParentName = $this->menu_model->getSubMenuData($parentName['parent_id']);
        $grandParentParentName = $this->menu_model->getMenuData($grandParentName['parent_id']);
        $this->data['page_title'] = $grandParentParentName['name'] . '-' . $grandParentName['name'] . '-' . $parentName['name'] . '-選單管理';
        $this->data['parent_id'] = $parent_id;
        $this->data['grandparent_id'] = $grandParentName['id'];
        $this->data['grandparent_parent_id'] = $grandParentParentName['id'];
        $this->data['menu'] = $this->menu_model->getSubSubSonMenuData(0, $parent_id);
        $this->render('admin/menu/sub_sub_son_index');
    }

    function insert()
    {
        $message = '新增失敗';

        $insertData = array(
            'name' => $this->input->post('menu_name'),
            'type' => $this->input->post('menu_type'),
            'sort' => $this->input->post('menu_sort'),
        );
        $this->db->insert('menu', $insertData);
        $message = '新增成功';

        $this->session->set_flashdata('message', $message);
        echo '<script>window.history.back();</script>';
    }

    function sub_insert()
    {
        $message = '新增失敗';

        $insertData = array(
            'parent_id' => $this->input->post('parent_id'),
            'name' => $this->input->post('menu_name'),
            'type' => $this->input->post('menu_type'),
            'sort' => $this->input->post('menu_sort'),
        );

        $this->db->insert('sub_menu', $insertData);
        $message = '新增成功';

        $this->session->set_flashdata('message', $message);
        echo '<script>window.history.back();</script>';
    }

    function sub_son_insert()
    {
        $message = '新增失敗';

        $insertData = array(
            'parent_id' => $this->input->post('parent_id'),
            'grandparent_id' => $this->input->post('grandparent_id'),
            'name' => $this->input->post('menu_name'),
            'type' => $this->input->post('menu_type'),
            'sort' => $this->input->post('menu_sort'),
        );

        $this->db->insert('sub_son_menu', $insertData);
        $message = '新增成功';

        $this->session->set_flashdata('message', $message);
        echo '<script>window.history.back();</script>';
    }

    function sub_sub_son_insert()
    {
        $message = '新增失敗';

        $insertData = array(
            'parent_id' => $this->input->post('parent_id'),
            'grandparent_id' => $this->input->post('grandparent_id'),
            'grandparent_parent_id' => $this->input->post('grandparent_parent_id'),
            'name' => $this->input->post('menu_name'),
            'type' => $this->input->post('menu_type'),
            'sort' => $this->input->post('menu_sort'),
        );

        $this->db->insert('sub_sub_son_menu', $insertData);
        $message = '新增成功';

        $this->session->set_flashdata('message', $message);
        echo '<script>window.history.back();</script>';
    }

    function edit($databaseName = '', $id = 0)
    {
        $this->data['databaseName'] = $databaseName;
        if ($databaseName == 'menu') {
            $this->data['returnIndex'] = 'index';
            $this->data['menu'] = $this->menu_model->getMenuData($id);
            $this->data['same_level_menu'] = $this->menu_model->getMenuData();
        } elseif ($databaseName == 'sub_menu') {
            $this->data['returnIndex'] = 'sub_index';
            $this->data['menu'] = $this->menu_model->getSubMenuData($id, 0);
            $this->data['same_level_menu'] = $this->menu_model->getSubMenuData(0, $this->data['menu']['parent_id']);
        } elseif ($databaseName == 'sub_son_menu') {
            $this->data['returnIndex'] = 'sub_son_index';
            $this->data['menu'] = $this->menu_model->getSubSonMenuData($id, 0);
            $this->data['same_level_menu'] = $this->menu_model->getSubSonMenuData(0, $this->data['menu']['parent_id']);
        } elseif ($databaseName == 'sub_sub_son_menu') {
            $this->data['returnIndex'] = 'sub_sub_son_index';
            $this->data['menu'] = $this->menu_model->getSubSubSonMenuData($id, 0);
            $this->data['same_level_menu'] = $this->menu_model->getSubSubSonMenuData(0, $this->data['menu']['parent_id']);
        }
        $this->render('admin/menu/edit');
    }

    function update($databaseName = '')
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $sort = $this->input->post('sort');
        $status = $this->input->post('status');
        $code = $this->input->post('code');
        if ($databaseName != 'menu' && $databaseName != 'sub_menu') {
            $code = $this->input->post('menu_image');
        }
        $description = $this->input->post('editor');

        $message = '更新失敗';

        if (!empty($id) && !empty($name) && !empty($sort) && ((!empty($status == 0) || !empty($status == 1)))) {
            try {
                $updateData = array(
                    'name' => $name,
                    'sort' => $sort,
                    'status' => $status,
                );
                if (!empty($code)) {
                    $updateData['code'] = $code;
                }
                if (!empty($description)) {
                    $updateData['description'] = $description;
                }
                $this->db->where('id', $id);
                $this->db->update($databaseName, $updateData);
                $message = '更新成功';
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }
        $this->session->set_flashdata('message', $message);
        echo '<script>window.history.back();</script>';
    }

    function delete($databaseName, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete($databaseName);
        $this->session->set_flashdata('message', '刪除成功');
        echo '<script>window.history.back();</script>';
    }
}
