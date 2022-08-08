<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '付款方式';
		$this->data['payment'] = $this->mysql_model->_select('payment');

		$this->render('admin/payment/index');
	}

	public function insert_payment() {
		$this->data['page_title'] = '新增付款方式';

		$data = array(
			'payment_name' => $this->input->post('payment_name'),
			// 'creator_id' => $this->current_user->id,
			// 'created_at' => date('Y-m-d H:i:s'),
		);

		$this->db->insert('payment', $data);
		redirect(base_url() . 'admin/payment');
	}

	public function edit_payment($id) {
		$this->data['page_title'] = '編輯付款方式';
		$this->data['payment'] = $this->mysql_model->_select('payment', 'id', $id, 'row');

		$this->render('admin/payment/edit');
	}

	public function update_payment($id) {
		$data = array(
			'payment_name' => $this->input->post('payment_name'),
			// 'updater_id' => $this->current_user->id,
			// 'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->db->where('id', $id);
		$this->db->update('payment', $data);

		redirect(base_url() . 'admin/payment');
	}

	public function delete_payment($id) {
		$this->db->where('id', $id);
		$this->db->delete('payment');
		redirect(base_url() . 'admin/payment');
	}

}