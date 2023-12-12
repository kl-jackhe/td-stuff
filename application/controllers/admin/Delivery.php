<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '配送管理';
		$this->data['delivery'] = $this->mysql_model->_select('delivery');

		$this->render('admin/delivery/index');
	}

	// public function insert_delivery() {
	// 	$this->data['page_title'] = '新增配送方式';

	// 	$data = array(
	// 		'delivery_name' => $this->input->post('delivery_name'),
	// 		'shipping_cost' => $this->input->post('shipping_cost'),
	// 		'limit_weight' => $this->input->post('limit_weight'),
	// 		'limit_weight_unit' => $this->input->post('limit_weight_unit'),
	// 		'limit_volume_length' => $this->input->post('limit_volume_length'),
	// 		'limit_volume_width' => $this->input->post('limit_volume_width'),
	// 		'limit_volume_height' => $this->input->post('limit_volume_height'),
	// 		'delivery_info' => $this->input->post('delivery_info'),
	// 		'delivery_status' => $this->input->post('delivery_status'),
	// 		'created_at' => date('Y-m-d H:i:s'),
	// 	);

	// 	$this->db->insert('delivery', $data);
	// 	redirect(base_url() . 'admin/delivery');
	// }

	public function edit_delivery($id) {
		$this->data['page_title'] = '編輯配送方式';
		$this->data['delivery'] = $this->mysql_model->_select('delivery', 'id', $id, 'row');

		$this->render('admin/delivery/edit');
	}

	public function update_delivery($id) {
		$data = array(
			'delivery_name' => $this->input->post('delivery_name'),
			'shipping_cost' => $this->input->post('shipping_cost'),
			'limit_weight' => $this->input->post('limit_weight'),
			'limit_weight_unit' => $this->input->post('limit_weight_unit'),
			'limit_volume_length' => $this->input->post('limit_volume_length'),
			'limit_volume_width' => $this->input->post('limit_volume_width'),
			'limit_volume_height' => $this->input->post('limit_volume_height'),
			'delivery_info' => $this->input->post('delivery_info'),
			'delivery_status' => $this->input->post('delivery_status'),
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->db->where('id', $id);
		$this->db->update('delivery', $data);

		redirect(base_url() . 'admin/delivery');
	}

	public function update_delivery_status($id) {
		$this->db->select('id,delivery_status');
		$this->db->where('id',$id);
		$this->db->limit(1);
		$d_row = $this->db->get('delivery')->row_array();
		$delivery_status = ($d_row['delivery_status'] == 1 ? 0 : 1);
		$data = array(
			'delivery_status' => $delivery_status,
			// 'updater_id' => $this->current_user->id,
			// 'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->db->where('id', $id);
		$this->db->update('delivery', $data);

		if ($delivery_status == 0) {
			$this->db->where('delivery_id', $id);
			$this->db->delete('delivery_range_list');
		}

		redirect(base_url() . 'admin/delivery');
	}

	public function delete_delivery($id) {
		$this->db->where('id', $id);
		$this->db->delete('delivery');
		redirect(base_url() . 'admin/delivery');
	}
}