<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function getRows($params = array()) {
		$this->db->select('*');
		$this->db->from('product');
		//filter data by searched keywords
		// if (!empty($params['search']['keywords'])) {
		// 	$this->db->like('product_name', $params['search']['keywords']);
		// }
		// if (!empty($params['search']['category'])) {
		// 	$this->db->join('product_category_list', 'product_category_list.product_id = product.product_id');
		// 	$this->db->where('product_category_list.product_category_id', $params['search']['category']);
		// }
		// if (!empty($params['search']['status'])) {
		// 	$this->db->where('product_status', $params['search']['status']);
		// } else {
		// 	$this->db->where('product_status', '1');
		// }
		// if (!empty($params['search']['sortBy'])) {
		// 	$this->db->order_by('product.product_id', $params['search']['sortBy']);
		// } else {
		// 	$this->db->order_by('product.product_id', 'desc');
		// }
		//set start and limit
		// if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
		// 	$this->db->limit($params['limit'], $params['start']);
		// } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
		// 	$this->db->limit($params['limit']);
		// }
		//get records
		$query = $this->db->get();
		//return fetched data
		return ($query->num_rows() > 0) ? $query->result_array() : false;
	}

	function getTopCategory() {
		$this->db->where('product_category_parent', '0');
		$query = $this->db->get('product_category');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		//return ($query->num_rows() > 0)?$query->result_array():false;
	}

	function getSubCategory() {
		$this->db->where('product_category_parent !=', '0');
		$query = $this->db->get('product_category');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
	}

	function getRows_list($params = array()) {
		$this->db->select('*');
		$this->db->from('product');
		//filter data by searched keywords
		// if (!empty($params['search']['keywords'])) {
		// 	$this->db->like('product_name', $params['search']['keywords']);
		// }
		// if (!empty($params['search']['category'])) {
		// 	$this->db->join('product_category_list', 'product_category_list.product_id = product.product_id');
		// 	$this->db->where('product_category_list.product_category_id', $params['search']['category']);
		// }
		// if (!empty($params['search']['status'])) {
		// 	$this->db->where('product_status', $params['search']['status']);
		// } else {
		// 	$this->db->where('product_status', '1');
		// }
		// if (!empty($params['search']['sortBy'])) {
		// 	$this->db->order_by('product.product_id', $params['search']['sortBy']);
		// } else {
		// 	$this->db->order_by('product.product_id', 'desc');
		// }
		// $this->db->where('product_type', 'p');
		// //set start and limit
		// if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
		// 	$this->db->limit($params['limit'], $params['start']);
		// } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
		// 	$this->db->limit($params['limit']);
		// }
		//get records
		$query = $this->db->get();
		//return fetched data
		return ($query->num_rows() > 0) ? $query->result_array() : false;
	}

	function get_sub_category_product($id) {
		$this->db->join('product', 'product.product_id = product_category_list.product_id');
		$this->db->where('product_category_id', $id);
		//set start and limit
		$query = $this->db->get('product_category_list');
		//return fetched data
		return ($query->num_rows() > 0) ? $query->result_array() : false;
	}

	function getManufacturer() {
		$this->db->where('manufacturer_status', '1');
		$this->db->like('manufacturer_type', 's');
		$query = $this->db->get('manufacturer');
		return ($query->num_rows() > 0) ? $query->result_array() : false;
	}

}