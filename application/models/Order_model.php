<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

	function getRows($params = array()) {
		$this->db->select('orders.*');
		$this->db->from('orders');
		$this->db->order_by("order_id", "desc");
		//filter data by searched keywords
		if (!empty($params['search']['keywords'])) {
			$this->db->group_start();
			$this->db->like('order_number', $params['search']['keywords']);
			$this->db->or_like('customer_name', $params['search']['keywords']);
			$this->db->or_like('customer_phone', $params['search']['keywords']);
			$this->db->group_end();
		}
		if (!empty($params['search']['product'])) {
			$this->db->select('order_item.product_id');
			$this->db->join('order_item', 'order_item.order_id = orders.order_id');
			$this->db->where('order_item.product_id',$params['search']['product']);
			$this->db->group_by('orders.order_id');
		}
		if (!empty($params['search']['step'])) {
			$this->db->where('order_step', $params['search']['step']);
		}
		if (!empty($params['search']['delivery'])) {
			$this->db->where('order_delivery',$params['search']['delivery']);
		}
		if (!empty($params['search']['payment'])) {
			$this->db->where('order_payment',$params['search']['payment']);
		}
		if (!empty($params['search']['start_date'])) {
			$this->db->where('order_date >=', $params['search']['start_date']);
		}
		if (!empty($params['search']['end_date'])) {
			$this->db->where('order_date <=', $params['search']['end_date']);
		}
		if (!empty($params['search']['sales'])) {
			$this->db->where('single_sales_id', $params['search']['sales']);
		}
		if (!empty($params['search']['agent'])) {
			$this->db->where('agent_id', $params['search']['agent']);
		}
		//sort data by ascending or desceding order
		if (!empty($params['search']['sortBy'])) {
			$this->db->order_by('order_date', $params['search']['sortBy']);
		} else {
			$this->db->order_by('order_date', 'desc');
		}
		// if(!empty($params['search']['status'])){
		//     $this->db->where('order_status',$params['search']['status']);
		// } else {
		//     $this->db->where('order_status', '1');
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

	function find_all_order($params = array()) {
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->like('created_at', date('Y-m-d'));
		//filter data by searched keywords
		if (!empty($params['search']['keywords'])) {
			$this->db->like('order_id', $params['search']['keywords']);
			//$this->db->or_like('order_eat_type',$params['search']['keywords']);
			//$this->db->or_like('invoice_randcode',$params['search']['keywords']);
			//$this->db->like('created_at',$params['search']['keywords'], 'after');
		}
		//sort data by ascending or desceding order
		if (!empty($params['search']['sortBy'])) {
			$this->db->order_by('order_id', $params['search']['sortBy']);
		} else {
			$this->db->order_by('order_id', 'desc');
		}
		if (!empty($params['search']['category'])) {
			$this->db->where('order_eat_type', $params['search']['category']);
		}
		if (!empty($params['search']['status'])) {
			$this->db->where('order_status', $params['search']['status']);
		} else {
			$this->db->where('order_status', '1');
		}
		//set start and limit
		// if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
		//     $this->db->limit($params['limit'],$params['start']);
		// }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
		//     $this->db->limit($params['limit']);
		// }
		//get records
		$query = $this->db->get();
		//return fetched data
		return ($query->num_rows() > 0) ? $query->result_array() : false;
	}

	public function find_other_order($type) {
		//$this->db->join('purchase_item', 'purchase_item.purchase_id = purchase.purchase_id');
		$this->db->where('order_status', '1');
		$this->db->where('order_eat_type', $type);
		$this->db->order_by('order_id', 'desc');
		$query = $this->db->get('pos_other_order');
		return ($query->num_rows() > 0) ? $query->result_array() : false;
	}

	public function get_customer_order($id = 0) {
		if ($id == 0) {
			return false;
		}
		$this->db->where('customer_id', $id);
		$this->db->order_by('order_id', 'desc');
		$query = $this->db->get('orders');
		return ($query->num_rows() > 0) ? $query->result_array() : false;
	}

	public function get_customer_phone_order($id) {
		$this->db->where('customer_phone', $id);
		$this->db->order_by('order_id', 'desc');
		$query = $this->db->get('orders');
		return ($query->num_rows() > 0) ? $query->result_array() : false;
	}

	public function get_order_item_with_product($id) {
		$this->db->join('product', 'product.product_id = order_item.product_id');
		$this->db->where('order_id', $id);
		// $this->db->order_by('order_id','desc');
		$query = $this->db->get('order_item');
		return ($query->num_rows() > 0) ? $query->result_array() : false;
	}

	function getOrderProductQTY($single_sales_id, $agent_id='') {
		$this->db->select_sum('order_item_qty');
		$this->db->join('order_item','order_item.order_id = orders.order_id');
		$this->db->where('order_step != ','order_cancel');
		$this->db->where('order_item_price', 0);
		$this->db->where('single_sales_id', $single_sales_id);
		if ($agent_id != '') {
			$this->db->where('agent_id', $agent_id);
		}
		$row = $this->db->get('orders')->row_array();
		return (!empty($row)? ($row['order_item_qty'] > 0 ? $row['order_item_qty'] : 0 ) : 0);
	}

	function getOrderTotalAmount($single_sales_id, $agent_id='') {
		$this->db->select_sum('order_discount_total');
		$this->db->where('order_step != ','order_cancel');
		$this->db->where('single_sales_id', $single_sales_id);
		if ($agent_id != '') {
			$this->db->where('agent_id', $agent_id);
		}
		$row = $this->db->get('orders')->row_array();
		return (!empty($row)? ($row['order_discount_total'] > 0 ? $row['order_discount_total'] : 0 ) : 0);
	}

	function getSalesHistoryRows($params = array()) {
		$this->db->select('orders.*');
		$this->db->from('orders');
		$this->db->order_by("order_id", "desc");
		if (!empty($params['search']['keywords'])) {
			$this->db->group_start();
			$this->db->like('order_number', $params['search']['keywords']);
			$this->db->or_like('customer_name', $params['search']['keywords']);
			$this->db->or_like('customer_phone', $params['search']['keywords']);
			$this->db->group_end();
		}
		if (!empty($params['search']['product'])) {
			$this->db->select('order_item.product_id');
			$this->db->join('order_item', 'order_item.order_id = orders.order_id');
			$this->db->where('order_item.product_id',$params['search']['product']);
			$this->db->group_by('orders.order_id');
		}
		if (!empty($params['search']['step'])) {
			$this->db->where('order_step', $params['search']['step']);
		}
		if (!empty($params['search']['delivery'])) {
			$this->db->where('order_delivery',$params['search']['delivery']);
		}
		if (!empty($params['search']['payment'])) {
			$this->db->where('order_payment',$params['search']['payment']);
		}
		if (!empty($params['search']['start_date'])) {
			$this->db->where('order_date >=', $params['search']['start_date']);
		}
		if (!empty($params['search']['end_date'])) {
			$this->db->where('order_date <=', $params['search']['end_date']);
		}
		if (!empty($params['search']['sales'])) {
			$this->db->where('single_sales_id', $params['search']['sales']);
		}
		if (!empty($params['search']['agent'])) {
			$this->db->where('agent_id', $params['search']['agent']);
		}
		$this->db->where('single_sales_id !=', '');
		if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
			$this->db->limit($params['limit'], $params['start']);
		} elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
			$this->db->limit($params['limit']);
		}
		if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
			$result = $this->db->count_all_results();
		} else {
			$query = $this->db->get();
			$result = ($query->num_rows() > 0) ? $query->result_array() : false;
		}
		return $result;
	}

	function getPaymentList() {
		$this->db->select('id,payment_code,payment_name');
		$this->db->where('payment_status','1');
		$this->db->order_by('sort','asc');
		$query = $this->db->get('payment')->result_array();
		return (!empty($query)?$query:false);
	}

	function getDeliveryList() {
		$this->db->select('id,delivery_name_code,delivery_name');
		$this->db->where('delivery_status','1');
		$query = $this->db->get('delivery')->result_array();
		return (!empty($query)?$query:false);
	}
}