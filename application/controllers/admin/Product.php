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
		$totalRec = 0;
		if ($this->product_model->getRows() != false) {
			$totalRec = count($this->product_model->getRows());
		}
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
		$totalRec = count($this->product_model->getRows($conditions));
		//pagination configuration
		$config['target'] = '#datatable';
		$config['base_url'] = base_url() . 'product/ajaxData';
		$config['total_rows'] = $totalRec;
		$config['per_page'] = $this->perPage;
		$config['link_func'] = 'searchFilter';
		$this->ajax_pagination_admin->initialize($config);
		//set start and limit
		$conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		//get posts data
		$this->data['product'] = $this->product_model->getRows($conditions);
		//load the view
		$this->load->view('product/ajax-data', $this->data, false);
	}

	public function create($id) {
		$this->data['page_title'] = '新增商品';
		$this->data['store_id'] = $id;

		// $this->load->view('admin/product/create', $this->data);
		$this->render('admin/product/create');
	}

	public function insert() {
		$data = array(
			// 'store_id' => $this->input->post('store_id'),
			'product_name' => $this->input->post('product_name'),
			'product_price' => $this->input->post('product_price'),
			'product_daily_stock' => $this->input->post('product_daily_stock'),
			'product_person_buy' => $this->input->post('product_person_buy'),
			'product_description' => $this->input->post('product_description'),
			'product_image' => $this->input->post('product_image'),
			'creator_id' => $this->ion_auth->user()->row()->id,
			'created_at' => date('Y-m-d H:i:s'),
		);
		$this->mysql_model->_insert('product', $data);

		$this->session->set_flashdata('message', '商品建立成功！');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function edit($id) {
		$this->data['page_title'] = '編輯商品';
		$this->data['product'] = $this->mysql_model->_select('product', 'product_id', $id, 'row');
		$this->data['change_log'] = get_change_log('product', $id);
		// $this->load->view('admin/product/edit', $this->data);
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
			'product_daily_stock' => $this->input->post('product_daily_stock'),
			'product_person_buy' => $this->input->post('product_person_buy'),
			'product_description' => $this->input->post('product_description'),
			'product_image' => $this->input->post('product_image'),
			'updater_id' => $this->ion_auth->user()->row()->id,
			'updated_at' => date('Y-m-d H:i:s'),
		);

		$this->db->where('product_id', $id);
		$this->db->update('product', $data);

		$this->session->set_flashdata('message', '商品更新成功！');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete($id) {
		$this->db->where('product_id', $id);
		$this->db->delete('product');

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function multiple_action() {
		if (!empty($this->input->post('product_id'))) {
			foreach ($this->input->post('product_id') as $product_id) {
				if ($this->input->post('action') == 'delete') {
					$this->db->where('product_id', $product_id);
					$this->db->delete('product');
					$this->session->set_flashdata('message', '商品刪除成功！');
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

	// 其他功能

	public function get_product_price() {
		$data = $this->input->post('product_id');
		$this->db->like('product_name', $data);
		$query = $this->db->get('product');
		//$query = $this->db->get_where('manufacturer', array('manufacturer_name' => $data));
		if ($query->num_rows() > 0) {
			$row = $query->row();
			echo json_encode($row, JSON_UNESCAPED_UNICODE);
			//echo 0;
		} else {
			echo 0;
		}
	}
}