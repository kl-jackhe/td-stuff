<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function getRows($params = array()) {
		$this->db->select('*');
		$this->db->from('product');
		$this->db->order_by("distribute_at DESC", "product_id ASC");
		//filter data by searched keywords
		if (!empty($params['search']['keywords'])) {
			$this->db->like('product_name', $params['search']['keywords']);
		}
		if (!empty($params['search']['product_category_id'])) {
			$this->db->where('product_category_id', $params['search']['product_category_id']);
			// $this->db->like('product_category_id', $params['search']['product_category_id']);
		}
		// if (!empty($params['search']['category'])) {
		// 	$this->db->join('product_category_list', 'product_category_list.product_id = product.product_id');
		// 	$this->db->where('product_category_list.product_category_id', $params['search']['category']);
		// }
		if (!empty($params['search']['status'])) {
			$this->db->where('product_status', $params['search']['status']);
		} else {
			$this->db->where('product_status', '1');
		}
		// if (!empty($params['search']['sortBy'])) {
		// 	$this->db->order_by('product.product_id', $params['search']['sortBy']);
		// } else {
		// 	$this->db->order_by('product.product_id', 'desc');
		// }
		//set start and limit
		if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
			$this->db->limit($params['limit'], $params['start']);
		} elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
			$this->db->limit($params['limit']);
		}
		if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
			$result = $this->db->count_all_results();
		} else {
			//get records
			$query = $this->db->get();
			//return fetched data
			$result = ($query->num_rows() > 0) ? $query->result_array() : false;
		}
		return $result;
	}

	function getProducts($params = array()) {
		$this->db->select('*');
		$this->db->from('product');
		if (!empty($params['search']['product_category_id'])) {
			$this->db->where('product_category_id', $params['search']['product_category_id']);
		}
		$this->db->where('product_status', '1');
		if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
			$result = $this->db->count_all_results();
		} else {
			//get records
			$query = $this->db->get();
			//return fetched data
			$result = ($query->num_rows() > 0) ? $query->result_array() : false;
		}
		return $result;
	}

	function getProductList() {
		$this->db->select('*');
		$query = $this->db->get('product')->result_array();
		return (!empty($query)?$query:false);
	}

	function getHomeProducts() {
		$this->db->select('*');
		$this->db->where('product_status', 1);
		$query = $this->db->get('product');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	function get_product_category() {
		$this->db->select('*');
		$query = $this->db->get('product_category');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	function getProductCombine() {
		$this->db->select('*');
		$query = $this->db->get('product_combine');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	function getProductCombineItem() {
		$this->db->select('*');
		$query = $this->db->get('product_combine_item');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	function get_product_category_name($id) {
		$this->db->select('product_category_name');
		$this->db->limit(1);
		$this->db->where('product_category_id', $id);
		$query = $this->db->get('product_category');
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}

	function get_product_combine_item($id) {
		$this->db->select('*');
		$this->db->where('product_combine_id', $id);
		$query = $this->db->get('product_combine_item');
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}

	function getSingleProduct($id) {
		$this->db->select('*');
		$this->db->where('product_id', $id);
		$this->db->limit(1);
		$row = $this->db->get('product')->row_array();
		return (!empty($row)?$row:false);
	}

	function getProduct_Specification($id) {
		$this->db->select('*');
		$this->db->where('product_id', $id);
		$query = $this->db->get('product_specification');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	function getProduct_Combine($id) {
		$this->db->select('*');
		$this->db->where('product_id', $id);
		$query = $this->db->get('product_combine');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
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
		$query = $this->db->get();
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

	function getSpecificationStr($id) {
		$this->db->select('specification');
		$this->db->where('id',$id);
		$this->db->limit(1);
		$row = $this->db->get('product_specification')->row_array();
		return (!empty($row)?$row['specification']:'');
	}

	function getSelectProductCategory($productID) {
		$select_product_category = array();
		$this->db->select('product_category_id');
		$this->db->where('product_id', $productID);
		$pcl_query = $this->db->get('product_category_list')->result_array();
		if (!empty($pcl_query)) {
			foreach ($pcl_query as $pcl_row) {
				$select_product_category[] = $pcl_row['product_category_id'];
			}
		}
		return $select_product_category;
	}

}