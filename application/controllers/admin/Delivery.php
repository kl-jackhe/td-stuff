<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '配送方式';
		$this->data['delivery'] = $this->mysql_model->_select('delivery');

		$this->render('admin/delivery/index');
	}

	public function insert_delivery() {
		$this->data['page_title'] = '新增配送方式';

		$data = array(
			'delivery_name' => $this->input->post('delivery_name'),
			'shipping_cost' => $this->input->post('shipping_cost'),
			'delivery_info' => $this->input->post('delivery_info'),
			'delivery_status' => $this->input->post('delivery_status'),
			// 'creator_id' => $this->current_user->id,
			// 'created_at' => date('Y-m-d H:i:s'),
		);

		$this->db->insert('delivery', $data);
		redirect(base_url() . 'admin/delivery');
	}

	public function edit_delivery($id) {
		$this->data['page_title'] = '編輯配送方式';
		$this->data['delivery'] = $this->mysql_model->_select('delivery', 'id', $id, 'row');

		$this->render('admin/delivery/edit');
	}

	public function update_delivery($id) {
		$data = array(
			'delivery_name' => $this->input->post('delivery_name'),
			'shipping_cost' => $this->input->post('shipping_cost'),
			'delivery_info' => $this->input->post('delivery_info'),
			'delivery_status' => $this->input->post('delivery_status'),
			// 'updater_id' => $this->current_user->id,
			// 'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->db->where('id', $id);
		$this->db->update('delivery', $data);

		redirect(base_url() . 'admin/delivery');
	}

	public function update_delivery_status($id) {
		$this->data['delivery'] = $this->mysql_model->_select('delivery', 'id', $id);
		foreach ($this->data['delivery'] as $row) {
			if ($row['delivery_status'] == 1) {
				$delivery_status = 0;
			} else {
				$delivery_status = 1;
			}
		}
		$data = array(
			'delivery_status' => $delivery_status,
			// 'updater_id' => $this->current_user->id,
			// 'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->db->where('id', $id);
		$this->db->update('delivery', $data);

		redirect(base_url() . 'admin/delivery');
	}

	public function delete_delivery($id) {
		$this->db->where('id', $id);
		$this->db->delete('delivery');
		redirect(base_url() . 'admin/delivery');
	}
}