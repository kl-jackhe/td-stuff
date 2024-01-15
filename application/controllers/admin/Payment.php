<?php defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['page_title'] = '支付管理';
		$this->data['payment'] = $this->mysql_model->_select('payment');
		$this->data['features_pay'] = $this->mysql_model->_select('features_pay');

		$this->render('admin/payment/index');
	}

	public function insert_payment()
	{
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

	public function edit_KEY($id)
	{
		$this->data['page_title'] = '編輯金鑰';
		$this->data['features_pay'] = $this->mysql_model->_select('features_pay', 'pay_id', $id, 'row');

		$this->render('admin/payment/edit_KEY');
	}

	public function edit_payment($id)
	{
		$this->data['page_title'] = '編輯支付方式';
		$this->data['payment'] = $this->mysql_model->_select('payment', 'id', $id, 'row');

		$this->render('admin/payment/edit');
	}

	public function update_KEY($id)
	{
		$data = array(
			'pay_name' => $this->input->post('pay_name'),
			'MerchantID' => $this->input->post('MerchantID'),
			'HashKey' => $this->input->post('HashKey'),
			'HashIV' => $this->input->post('HashIV'),
			'payment_status' => $this->input->post('payment_status'),
		);
		$this->db->where('pay_id', $id);
		$this->db->update('features_pay', $data);

		redirect(base_url() . 'admin/payment');
	}

	public function update_payment($id)
	{
		$data = array(
			'payment_name' => $this->input->post('payment_name'),
			'payment_info' => $this->input->post('payment_info'),
			'payment_status' => $this->input->post('payment_status'),
			'sort' => $this->input->post('sort'),
			// 'updater_id' => $this->current_user->id,
			// 'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->db->where('id', $id);
		$this->db->update('payment', $data);

		redirect(base_url() . 'admin/payment');
	}

	public function update_KEY_status($id)
	{
		$tmp = $this->mysql_model->_select('features_pay', 'pay_id', $id, 'row');
		$data = array(
			'payment_status' => !$tmp['payment_status'],
		);
		$this->db->where('pay_id', $id);
		$this->db->update('features_pay', $data);

		echo '<script>window.history.back();</script>';
	}

	public function update_payment_status($id)
	{
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

	public function delete_payment($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('payment');
		redirect(base_url() . 'admin/payment');
	}
}
