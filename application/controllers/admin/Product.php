<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('product_model');
	}

	public function index() {
		$this->data['page_title'] = '商品管理';

		$data = array();
		//total rows count
		$conditions['returnType'] = 'count';
		$totalRec = $this->product_model->getRows($conditions);
		//pagination configuration
		$config['target'] = '#datatable';
		$config['base_url'] = base_url() . 'product/ajaxData';
		$config['total_rows'] = $totalRec;
		$config['per_page'] = $this->perPage;
		$config['link_func'] = 'searchFilter';
		$this->ajax_pagination_admin->initialize($config);
		//get the posts data
		$this->data['product'] = $this->product_model->getRows(array('limit' => $this->perPage));

		$this->render('admin/product/index');
	}

	function ajaxData() {
		$conditions = array();
		//calc offset number
		$page = $this->input->get('page');
		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}
		//set conditions for search
		$keywords = $this->input->get('keywords');
		$sortBy = $this->input->get('sortBy');
		$category = $this->input->get('category');
		$status = $this->input->get('status');
		if (!empty($keywords)) {
			$conditions['search']['keywords'] = $keywords;
		}
		if (!empty($sortBy)) {
			$conditions['search']['sortBy'] = $sortBy;
		}
		if (!empty($category)) {
			$conditions['search']['category'] = $category;
		}
		if (!empty($status)) {
			$conditions['search']['status'] = $status;
		}
		//total rows count
		$conditions['returnType'] = 'count';
		$totalRec = $this->product_model->getRows($conditions);
		//pagination configuration
		$config['target'] = '#datatable';
		$config['base_url'] = base_url() . 'admin/product/ajaxData';
		$config['total_rows'] = $totalRec;
		$config['per_page'] = $this->perPage;
		$config['link_func'] = 'searchFilter';
		$this->ajax_pagination_admin->initialize($config);
		//set start and limit
		$conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		//get posts data
		$conditions['returnType'] = '';
		$this->data['product'] = $this->product_model->getRows($conditions);
		//load the view
		$this->load->view('admin/product/ajax-data', $this->data, false);
	}

	public function create() {
		$this->data['page_title'] = '新增商品';

		$this->render('admin/product/create');
	}

	public function insert() {
		$data = array(
			'product_name' => $this->input->post('product_name'),
			'product_price' => $this->input->post('product_price'),
			'product_description' => $this->input->post('product_description'),
			'product_image' => $this->input->post('product_image'),
			'creator_id' => $this->ion_auth->user()->row()->id,
			'created_at' => date('Y-m-d H:i:s'),
		);
		$product_id = $this->mysql_model->_insert('product', $data);

		$this->session->set_flashdata('message', '商品建立成功！');
		redirect('admin/product/edit/'.$product_id);
	}

	public function edit($id) {
		$this->data['page_title'] = '編輯商品';
		$this->data['product'] = $this->mysql_model->_select('product', 'product_id', $id, 'row');
		$this->data['product_unit'] = $this->mysql_model->_select('product_unit', 'product_id', $id);
		$this->data['product_specification'] = $this->mysql_model->_select('product_specification', 'product_id', $id);
		$this->data['product_combine'] = $this->mysql_model->_select('product_combine', 'product_id', $id);
		$this->data['change_log'] = get_change_log('product', $id);
		$this->render('admin/product/edit');
	}

	public function update($id) {
		// 紀錄欄位變動
		$updated_at = date('Y-m-d H:i:s');
		$product = $this->mysql_model->_select('product', 'product_id', $id, 'row');
		foreach ($product as $key => $value) {
			// echo "欄位: ".($key)." 的值: ".($value)."<br>";
			foreach ($_POST as $post_key => $post_value) {
				if (!is_array($post_value)) {
					// echo "欄位: ".($post_key)." 的值: ".($post_value)."<br>";
					if ($key == $post_key) {
						if ($value != $post_value) {
							// echo $post_key." [值] ".$post_value."<br>";
							$insert_data = array(
								'change_log_column' => 'product',
								'change_log_column_id' => $id,
								'change_log_key' => $post_key,
								'change_log_value' => $post_value,
								'change_log_creator_id' => $this->ion_auth->user()->row()->id,
								'change_log_created_at' => $updated_at,
							);
							$this->db->insert('change_log', $insert_data);
						}
					}
				}
			}
		}

		$data = array(
			'product_name' => $this->input->post('product_name'),
			'product_price' => $this->input->post('product_price'),
			'product_description' => $this->input->post('product_description'),
			'product_image' => $this->input->post('product_image'),
			'updater_id' => $this->ion_auth->user()->row()->id,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->db->where('product_id', $id);
		$this->db->update('product', $data);

		// 商品單位
		$this->db->where('product_id', $id);
		$this->db->delete('product_unit');

		$unit = $this->input->post('unit');
		$count = count($unit);
		for ($i = 0; $i < $count; $i++) {
			if (!empty($unit)) {
				$insert_data = array(
					'product_id' => $id,
					'unit' => $unit[$i],
				);
				$this->db->insert('product_unit', $insert_data);
			}
		}

		// 商品規格
		$this->db->where('product_id', $id);
		$this->db->delete('product_specification');

		$specification = $this->input->post('specification');
		$count = count($specification);
		for ($i = 0; $i < $count; $i++) {
			if (!empty($specification)) {
				$insert_data = array(
					'product_id' => $id,
					'specification' => $specification[$i],
				);
				$this->db->insert('product_specification', $insert_data);
			}
		}

		$this->session->set_flashdata('message', '商品更新成功！');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete($id) {
		// $this->db->where('product_id', $id);
		// $this->db->delete('product');

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function multiple_action() {
		if (!empty($this->input->post('product_id'))) {
			foreach ($this->input->post('product_id') as $product_id) {
				if ($this->input->post('action') == 'delete') {
					// $this->db->where('product_id', $product_id);
					// $this->db->delete('product');
					// $this->session->set_flashdata('message', '商品刪除成功！');
				} elseif ($this->input->post('action') == 'on_the_shelf') {
					$data = array(
						'product_status' => '1',
					);
					$this->db->where('product_id', $product_id);
					$this->db->update('product', $data);
					$this->session->set_flashdata('message', '商品上架成功！');
				} elseif ($this->input->post('action') == 'go_off_the_shelf') {
					$data = array(
						'product_status' => '2',
					);
					$this->db->where('product_id', $product_id);
					$this->db->update('product', $data);
					$this->session->set_flashdata('message', '商品下架成功！');
				}
			}
		}
		redirect(base_url() . 'product');
	}

	function create_plan($id) {
		$this->data['product'] = $this->mysql_model->_select('product', 'product_id', $id, 'row');
		$this->data['product_specification'] = $this->product_model->getProduct_Specification($id);

		$this->load->view('admin/product/create_plan', $this->data);
	}

	function insert_plan() {
		$data = array(
			'product_id' => $this->input->post('product_id'),
			'name' => $this->input->post('product_combine_name'),
			'price' => $this->input->post('product_combine_price'),
			'picture' => $this->input->post('product_combine_image'),
			'description' => $this->input->post('product_combine_description'),
		);
		$id = $this->mysql_model->_insert('product_combine', $data);

		$qty = $this->input->post('plan_qty');
		$unit = $this->input->post('plan_unit');
		$specification = $this->input->post('plan_specification');
		$count = count($qty);
		for ($i = 0; $i < $count; $i++) {
			if (!empty($qty)) {
				$insert_data = array(
					'product_id' => $this->input->post('product_id'),
					'product_combine_id' => $id,
					'qty' => $qty[$i],
					'product_unit' => $unit[$i],
					'product_specification' => $specification[$i],
				);
				$this->db->insert('product_combine_item', $insert_data);
			}
		}
	}

	function edit_plan($id) {
		$this->data['product_combine'] = $this->mysql_model->_select('product_combine', 'id', $id, 'row');
		$product_id = $this->data['product_combine']['product_id'];
		$this->data['product'] = $this->mysql_model->_select('product', 'product_id', $product_id, 'row');
		$this->data['product_unit'] = $this->mysql_model->_select('product_unit', 'product_id', $product_id);
		$this->data['product_specification'] = $this->mysql_model->_select('product_specification', 'product_id', $product_id);
		$this->data['product_combine_item'] = $this->mysql_model->_select('product_combine_item', 'product_combine_id', $this->data['product_combine']['id']);

		$this->load->view('admin/product/edit_plan', $this->data);
	}

	function update_plan($id) {
		$this->data['product_combine'] = $this->mysql_model->_select('product_combine', 'id', $id, 'row');

		$update_data = array(
			'product_id' => $this->input->post('product_id'),
			'name' => $this->input->post('product_combine_name'),
			'price' => $this->input->post('product_combine_price'),
			'picture' => $this->input->post('product_combine_image'),
			'description' => $this->input->post('product_combine_description'),
		);
		$this->db->where('id', $id);
		$this->db->update('product_combine', $update_data);

		$this->db->where('product_combine_id', $id);
		$this->db->delete('product_combine_item');

		$qty = $this->input->post('plan_qty');
		$unit = $this->input->post('plan_unit');
		$specification = $this->input->post('plan_specification');
		$count = count($qty);
		for ($i = 0; $i < $count; $i++) {
			if (!empty($qty)) {
				$insert_data = array(
					'product_id' => $this->input->post('product_id'),
					'product_combine_id' => $id,
					'qty' => $qty[$i],
					'product_unit' => $unit[$i],
					'product_specification' => $specification[$i],
				);
				$this->db->insert('product_combine_item', $insert_data);
			}
		}
	}

	function delete_plan($id) {
		$this->db->where('id', $id);
		$this->db->delete('product_combine');

		$this->db->where('product_combine_id', $id);
		$this->db->delete('product_combine_item');

		redirect($_SERVER['HTTP_REFERER']);
	}

	// 其他功能
	public function get_product_info() {
		$data = $this->input->post('product_id');
		$this->db->where('product_id', $data);
		$this->db->limit(1);
		$query = $this->db->get('product');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			echo json_encode($row, JSON_UNESCAPED_UNICODE);
			//echo 0;
		} else {
			echo 0;
		}
	}
}