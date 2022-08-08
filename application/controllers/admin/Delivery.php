<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '運送方式';
		$this->data['delivery'] = $this->mysql_model->_select('delivery');

		$this->render('admin/delivery/index');
	}

	public function insert_delivery() {
		$this->data['page_title'] = '新增運送方式';

		$data = array(
			'delivery_name' => $this->input->post('delivery_name'),
			'creator_id' => $this->current_user->id,
			'created_at' => date('Y-m-d H:i:s'),
		);

		$this->db->insert('delivery', $data);
		redirect(base_url() . 'setting/delivery');
	}

	public function edit_delivery($id) {
		$this->data['page_title'] = '編輯運送方式';
		$this->data['delivery'] = $this->mysql_model->_select('delivery', 'delivery_id', $id, 'row');

		$this->render('setting/delivery/edit');
	}

	public function update_delivery($id) {
		$data = array(
			'delivery_name' => $this->input->post('delivery_name'),
			'updater_id' => $this->current_user->id,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->db->where('delivery_id', $id);
		$this->db->update('delivery', $data);

		redirect(base_url() . 'setting/delivery');
	}

	public function delete_delivery($id) {
		$this->db->where('delivery_id', $id);
		$this->db->delete('delivery');
		redirect(base_url() . 'setting/delivery');
	}
}