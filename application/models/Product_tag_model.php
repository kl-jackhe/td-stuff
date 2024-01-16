<?php defined('BASEPATH') or exit('No direct script access allowed');

class Product_tag_model extends CI_Model
{

    function __construct()
    {
        $this->table = 'Product_tag';
        $this->primary_key = 'id';
        $this->return_as = 'array';
        parent::__construct();
    }

    function getRowsCount($params = array())
    {
        $this->db->select('id');
        $this->db->where('status', $params['search']['status']);
        $this->db->order_by('sort', $params['search']['sortBy']);
        $query = $this->db->get('Product_tag');
        return $query->num_rows();
    }

    function getRows($params = array())
    {
        $this->db->select('id,code,sort,status');
        $this->db->where('status', $params['search']['status']);
        $this->db->order_by('sort', $params['search']['sortBy']);
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get('Product_tag');
        return ($query->num_rows() > 0) ? $query->result_array() : false;
    }

    function getProductTagContentList($product_tag_id)
    {
        $this->db->select('id,product_tag_id,product_id');
        $this->db->where('product_tag_id', $product_tag_id);
        $this->db->order_by('product_tag_id', 'asc');
        $query = $this->db->get('product_tag_content')->result_array();
        return (!empty($query)) ? $query : false;
    }

    function getProductTagContentSelectList($product_tag_id, $product_id)
    {
        $this->db->select('product_id');
        $this->db->where('product_tag_id', $product_tag_id);
        $this->db->where('product_id', $product_id);
        $this->db->limit(1);
        $row = $this->db->get('product_tag_content')->row_array();
        return (!empty($row)) ? $row : false;
    }

    function getProductTagList()
    {
        $this->db->select('id');
        $query = $this->db->get('product_tag')->result_array();
        return (!empty($query)) ? $query : false;
    }

    function getSelectProductTag($product_tag_id, $product_id)
    {
        $this->db->select('product_tag_id,product_id');
        $this->db->where('product_tag_id', $product_tag_id);
        $this->db->where('product_id', $product_id);
        $this->db->limit(1);
        $row = $this->db->get('product_tag_content')->row_array();
        return (!empty($row)) ? 'selected' : '';
    }

    function checkProductTagNameIsExist($name)
    {
        $this->db->select('id');
        $this->db->where('name', $name);
        $this->db->limit(1);
        $row = $this->db->get('product_tag')->row_array();
        return (!empty($row) ? $row : false);
    }

    function getProductTag()
    {
        $this->db->select('id, name, code, sort, status');
        $this->db->order_by('sort');
        $query = $this->db->get('product_tag')->result_array();
        return (!empty($query)) ? $query : false;
    }

    function getSelectedProductID($id)
    {
        $selected = array();
        $this->db->select('product_tag_id, product_id');
        $this->db->where('product_tag_id', $id);
        $query = $this->db->get('product_tag_content')->result_array();
        if (!empty($query)) {
            foreach ($query as $row) {
                $selected[] = $row['product_id'];
            }
        }
        return $selected;
    }

    function getSelectedProductTagID($id)
    {
        $selected = array();
        $this->db->select('product_tag_id, product_id');
        $this->db->where('product_id', $id);
        $query = $this->db->get('product_tag_content')->result_array();
        if (!empty($query)) {
            foreach ($query as $row) {
                $selected[] = $row['product_tag_id'];
            }
        }
        return $selected;
    }

    function tagContentIsNull($id)
    {
        $this->db->where('product_tag_id', $id);
        $query = $this->db->get('product_tag_content')->result_array();
        if (!empty($query)) {
            return false;
        } else {
            return true;
        }
    }

    function isExistProductID($product_tag_id, $product_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->where('product_tag_id', $product_tag_id);
        $query = $this->db->get('product_tag_content')->result_array();
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    function getTagsProductID($id)
    {
        $this->db->select('product_id');
        $this->db->where('product_tag_id', $id);
        $query = $this->db->get('product_tag_content')->result_array();
        return (!empty($query) ? $query : false);
    }

    function getTagsProductTagID($id)
    {
        $this->db->select('product_tag_id');
        $this->db->where('product_id', $id);
        $query = $this->db->get('product_tag_content')->result_array();
        return (!empty($query) ? $query : false);
    }

    function getSelectedProductTag($id)
    {
        $this->db->select('id, name, code, sort, status');
        $this->db->where('id', $id);
        $query = $this->db->get('product_tag')->row_array();
        return (!empty($query) ? $query : false);
    }
}
