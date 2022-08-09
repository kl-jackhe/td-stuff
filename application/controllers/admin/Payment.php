<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_title'] = '支付管理';
		$this->data['payment'] = $this->mysql_model->_select('payment');

		$this->render('admin/payment/index');
	}

	public function insert_payment() {
		$this->data['page_title'] = '新增支付方式';

		$data = array(
			'payment_name' => $this->input->post('payment_name'),
			'payment_info' => $this->input->post('payment_info'),
			'payment_status' => $this->input->post('payment_status'),
			// 'creator_id' => $this->current_user->id,
			// 'created_at' => date('Y-m-d H:i:s'),
		);

		$this->db->insert('payment', $data);
		redirect(base_url() . 'admin/payment');
	}

	public function edit_payment($id) {
		$this->data['page_title'] = '編輯支付方式';
		$this->data['payment'] = $this->mysql_model->_select('payment', 'id', $id, 'row');

		$this->render('admin/payment/edit');
	}

	public function update_payment($id) {
		$data = array(
			'payment_name' => $this->input->post('payment_name'),
			'payment_info' => $this->input->post('payment_info'),
			'payment_status' => $this->input->post('payment_status'),
			// 'updater_id' => $this->current_user->id,
			// 'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->db->where('id', $id);
		$this->db->update('payment', $data);

		redirect(base_url() . 'admin/payment');
	}

	public function update_payment_status($id) {
		$this->data['payment'] = $this->mysql_model->_select('payment', 'id', $id);
		foreach ($this->data['payment'] as $row) {
			if ($row['payment_status'] == 1) {
				$payment_status = 0;
			} else {
				$payment_status = 1;
			}
		}
		$data = array(
			'payment_status' => $payment_status,
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