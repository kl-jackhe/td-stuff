<?php defined('BASEPATH') or exit('No direct script access allowed');
class Menu_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getMenuData($id = 0)
    {
        $this->db->select('id, code, name, sort, position_sort, type, status');
        if ($id == 0) {
            // 主選單
            $this->db->order_by('position_sort', 'ASC');
            $query = $this->db->get('menu')->result_array();
        } else {
            // 找parent(son找parent用)
            $this->db->where('id', $id);
            $this->db->limit(1);
            $query = $this->db->get('menu')->row_array();
        }
        return (!empty($query) ? $query : false);
    }

    function getSubMenuData($id = 0, $parent_id = 0)
    {
        $this->db->select('id, parent_id, code, name, sort, position_sort, type, status');
        if ($id == 0 && $parent_id != 0) {
            // 找son
            $this->db->where('parent_id', $parent_id);
            $this->db->order_by('position_sort', 'ASC');
            $query = $this->db->get('sub_menu')->result_array();
        } else if ($id != 0 && $parent_id == 0) {
            // 找parent(son找parent用)
            $this->db->where('id', $id);
            $this->db->limit(1);
            $query = $this->db->get('sub_menu')->row_array();
        } else {
            $this->db->order_by('position_sort', 'ASC');
            $query = $this->db->get('sub_menu')->result_array();
        }
        return (!empty($query) ? $query : false);
    }

    function getSubSonMenuData($id = 0, $parent_id = 0)
    {
        $this->db->select('id, parent_id, grandparent_id, code, description, name, sort, position_sort, type, status');
        if ($id == 0 && $parent_id != 0) {
            // 找son
            $this->db->where('parent_id', $parent_id);
            $this->db->order_by('position_sort', 'ASC');
            $query = $this->db->get('sub_son_menu')->result_array();
        } else if ($id != 0 && $parent_id == 0) {
            // 找parent(son找parent用)
            $this->db->where('id', $id);
            $this->db->limit(1);
            $query = $this->db->get('sub_son_menu')->row_array();
        } else {
            $this->db->order_by('position_sort', 'ASC');
            $query = $this->db->get('sub_son_menu')->result_array();
        }
        return (!empty($query) ? $query : false);
    }

    function getSubSubSonMenuData($id = 0, $parent_id = 0)
    {
        $this->db->select('id, parent_id, grandparent_id, grandparent_parent_id, code, description, name, sort, position_sort, type, status');
        if ($id == 0 && $parent_id != 0) {
            // 找son
            $this->db->where('parent_id', $parent_id);
            $this->db->order_by('position_sort', 'ASC');
            $query = $this->db->get('sub_sub_son_menu')->result_array();
        } else if ($id != 0 && $parent_id == 0) {
            // 找parent(son找parent用)
            $this->db->where('id', $id);
            $this->db->limit(1);
            $query = $this->db->get('sub_sub_son_menu')->row_array();
        } else {
            $this->db->order_by('position_sort', 'ASC');
            $query = $this->db->get('sub_sub_son_menu')->result_array();
        }
        return (!empty($query) ? $query : false);
    }
}
