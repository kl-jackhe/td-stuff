<?php defined('BASEPATH') or exit('No direct script access allowed');

class Product extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('product_model');
	}

	public function index()
	{
		$this->data['page_title'] = '商品管理';
		$this->render('admin/product/index');
	}

	function ajaxData()
	{
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
		$this->data['product_category'] = $this->mysql_model->_select('product_category');
		//load the view
		$this->load->view('admin/product/ajax-data', $this->data);
	}

	public function create()
	{
		$this->data['page_title'] = '新增商品';
		$this->data['product_category'] = $this->mysql_model->_select('product_category');
		$this->render('admin/product/create');
	}

	public function insert()
	{
		if ($this->checkSKUIsDuplicated(0, $this->input->post('product_sku')) == 'No') {
			$this->session->set_flashdata('message', '品號重複');
			redirect($_SERVER['HTTP_REFERER']);
			exit;
		}
		$data = array(
			'product_name' => $this->input->post('product_name'),
			'product_price' => $this->input->post('product_price'),
			'product_category_id' => $this->input->post('product_category'),
			'product_sku' => $this->input->post('product_sku'),
			'product_description' => $this->input->post('product_description'),
			'product_note' => $this->input->post('product_note'),
			'product_image' => $this->input->post('product_image'),
			'creator_id' => $this->current_user->id,
			'distribute_at' => $this->input->post('distribute_at'),
			// 'discontinued_at' => $this->input->post('discontinued_at'),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$product_id = $this->mysql_model->_insert('product', $data);

		$this->session->set_flashdata('message', '商品建立成功！');
		redirect('admin/product/edit/' . $product_id);
	}

	public function edit($id)
	{
		$this->data['page_title'] = '編輯商品';
		$this->data['product'] = $this->mysql_model->_select('product', 'product_id', $id, 'row');
		$this->data['product_unit'] = $this->mysql_model->_select('product_unit', 'product_id', $id);
		$this->data['product_specification'] = $this->mysql_model->_select('product_specification', 'product_id', $id);
		$this->data['product_combine'] = $this->mysql_model->_select('product_combine', 'product_id', $id);
		$this->data['product_category'] = $this->mysql_model->_select('product_category');
		$this->data['delivery'] = $this->mysql_model->_select('delivery', 'delivery_status', '1');
		$this->db->select('delivery_id');
		$this->db->where('source', 'Product');
		$this->db->where('source_id', $id);
		$this->db->where('status', 1);
		$this->data['use_delivery_list'] = $this->db->get('delivery_range_list')->result_array();
		// $this->data['change_log'] = get_change_log('product', $id);
		$this->render('admin/product/edit');
	}

	public function update($id)
	{
		if ($this->checkSKUIsDuplicated($id, $this->input->post('product_sku')) == 'No') {
			$this->session->set_flashdata('message', '品號重複');
			redirect($_SERVER['HTTP_REFERER']);
			exit;
		}
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
								'change_log_creator_id' => $this->current_user->id,
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
			'distribute_at' => $this->input->post('distribute_at'), //tmp
			'discontinued_at' => $this->input->post('discontinued_at'), //tmp
			'product_sku' => $this->input->post('product_sku'),
			'product_weight' => $this->input->post('product_weight'),
			'volume_length' => $this->input->post('volume_length'),
			'volume_width' => $this->input->post('volume_width'),
			'volume_height' => $this->input->post('volume_height'),
			'product_price' => $this->input->post('product_price'),
			'product_add_on_price' => $this->input->post('product_add_on_price'),
			'product_category_id' => $this->input->post('product_category'),
			'product_description' => $this->input->post('product_description'),
			'product_note' => $this->input->post('product_note'),
			'product_image' => $this->input->post('product_image'),
			'inventory' => $this->input->post('inventory'),
			'excluding_inventory' => $this->input->post('excluding_inventory'),
			'stock_overbought' => $this->input->post('stock_overbought'),
			'updater_id' => $this->current_user->id,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->db->where('product_id', $id);
		$this->db->update('product', $data);

		$inventory_log = array(
			'product_id' => $id,
			'source' => 'ProductEdit',
			'change_history' => $this->input->post('inventory'),
			'change_notes' => 'Adjustment',
		);
		$this->db->insert('inventory_log', $inventory_log);

		// 商品單位
		$unitStr = array();
		$unit = $this->input->post('unit');
		if (is_array($unit)) {
			for ($i = 0; $i < count($unit); $i++) {
				if (!empty($unit)) {
					$unitStr[] = $unit[$i];
					$unit_data = array('unit' => $unit[$i]);
					$this->db->select('id');
					$this->db->where('product_id', $id);
					$this->db->where('unit', $unit[$i]);
					$this->db->limit(1);
					$pu_row = $this->db->get('product_unit')->row_array();
					if (!empty($pu_row)) {
						$this->db->where('id', $pu_row['id']);
						$this->db->update('product_unit', $unit_data);
					} else {
						$unit_data['product_id'] = $id;
						$this->db->insert('product_unit', $unit_data);
					}
				}
			}
			//刪除不要的單位
			$this->db->where('product_id', $id);
			$this->db->where_not_in('unit', $unitStr);
			$this->db->delete('product_unit');
		}

		// 商品規格
		$specificationStr = array();
		$specification = $this->input->post('specification');
		$picture = $this->input->post('picture');
		$status = $this->input->post('status');
		$limit_enable = $this->input->post('limit_enable');
		$limit_qty = $this->input->post('limit_qty');
		if (is_array($specification)) {
			for ($i = 0; $i < count($specification); $i++) {
				if (empty($picture[$i])) {
					$picture[$i] = '';
				}
				if (empty($status[$i])) {
					$status[$i] = 0;
				}
				if (empty($limit_enable[$i])) {
					$limit_enable[$i] = '';
				}
				if (empty($limit_qty[$i])) {
					$limit_qty[$i] = 0;
				}
				if (!empty($specification)) {
					$specificationStr[] = $specification[$i];
					$specification_data = array(
						'picture' => $picture[$i],
						'status' => $status[$i],
						'limit_enable' => $limit_enable[$i],
						'limit_qty' => $limit_qty[$i],
					);
					$this->db->select('id');
					$this->db->where('product_id', $id);
					$this->db->where('specification', $specification[$i]);
					$this->db->limit(1);
					$ps_row = $this->db->get('product_specification')->row_array();
					if (!empty($ps_row)) {
						$this->db->where('id', $ps_row['id']);
						$this->db->update('product_specification', $specification_data);
					} else {
						$specification_data['product_id'] = $id;
						$specification_data['specification'] = $specification[$i];
						$this->db->insert('product_specification', $specification_data);
					}
				}
			}
			//刪除不要的規格
			$this->db->where('product_id', $id);
			$this->db->where_not_in('specification', $specificationStr);
			$this->db->delete('product_specification');
		}

		// 刪除配送方式
		$this->db->where('source', 'Product');
		$this->db->where('source_id', $id);
		$this->db->delete('delivery_range_list');
		$delivery = $this->input->post('delivery');
		if (count($delivery) > 0) {
			// 新增配送方式
			for ($i = 0; $i < count($delivery); $i++) {
				$insertData = array(
					'delivery_id' => $delivery[$i],
					'source' => 'Product',
					'source_id' => $id,
				);
				$this->db->insert('delivery_range_list', $insertData);
			}
		}

		$this->session->set_flashdata('message', '商品更新成功！');
		redirect($_SERVER['HTTP_REFERER']);
	}

	function checkSKUIsDuplicated($product_id = 0, $product_sku)
	{
		$this->db->select('product_id');
		if ($product_id > 0) {
			$this->db->where('product_id !=', $product_id);
		}
		$this->db->where('product_sku', $product_sku);
		$this->db->limit(1);
		$row = $this->db->get('product')->row_array();
		return (!empty($row) ? 'No' : 'Yes');
	}

	public function multiple_action()
	{
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
		redirect(base_url() . 'admin/product');
	}

	function create_plan($id)
	{
		$this->data['product'] = $this->mysql_model->_select('product', 'product_id', $id, 'row');
		$this->data['product_specification'] = $this->product_model->getProduct_Specification($id);
		$this->load->view('admin/product/create_plan', $this->data);
	}

	function insert_plan()
	{
		$data = array(
			'product_id' => $this->input->post('product_id'),
			'name' => $this->input->post('product_combine_name'),
			'price' => $this->input->post('product_combine_price'),
			'current_price' => $this->input->post('product_combine_current_price'),
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
					'product_unit' => get_empty($unit[$i]),
					'product_specification' => get_empty($specification[$i]),
				);
				$this->db->insert('product_combine_item', $insert_data);
			}
		}
	}

	function edit_plan($id)
	{
		$this->data['product_combine'] = $this->mysql_model->_select('product_combine', 'id', $id, 'row');
		$product_id = $this->data['product_combine']['product_id'];
		$this->data['product'] = $this->mysql_model->_select('product', 'product_id', $product_id, 'row');
		$this->data['product_unit'] = $this->mysql_model->_select('product_unit', 'product_id', $product_id);
		$this->data['product_specification'] = $this->mysql_model->_select('product_specification', 'product_id', $product_id);
		$this->data['product_combine_item'] = $this->mysql_model->_select('product_combine_item', 'product_combine_id', $this->data['product_combine']['id']);

		$this->load->view('admin/product/edit_plan', $this->data);
	}

	function update_plan($id)
	{
		$this->data['product_combine'] = $this->mysql_model->_select('product_combine', 'id', $id, 'row');

		$update_data = array(
			'product_id' => $this->input->post('product_id'),
			'name' => $this->input->post('product_combine_name'),
			'price' => $this->input->post('product_combine_price'),
			'current_price' => $this->input->post('product_combine_current_price'),
			'picture' => $this->input->post('product_combine_image'),
			'description' => $this->input->post('product_combine_description'),
			'type' => $this->input->post('any_specification'),
			'limit_enable' => $this->input->post('limit_enable'),
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
					'product_unit' => get_empty($unit[$i]),
					'product_specification' => get_empty($specification[$i]),
				);
				$this->db->insert('product_combine_item', $insert_data);
			}
		}
		$this->session->set_flashdata('message', '商品更新成功！');
	}

	public function delete($id)
	{
		$this->db->where('product_id', $id);
		$this->db->delete('product');
		redirect(base_url() . 'admin/product');
	}

	function delete_plan($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('product_combine');

		$this->db->where('product_combine_id', $id);
		$this->db->delete('product_combine_item');

		redirect($_SERVER['HTTP_REFERER']);
	}

	// 商品銷售狀態 ------------------------------------------------------------------------------
	public function update_sales_status($id)
	{
		if (!empty($id)) {
			$data = array(
				'sales_status' => $this->input->post('sales_status'),
			);
			$this->db->where('product_id', $id);
			$this->db->update('product', $data);
		}
		redirect(base_url() . 'admin/product');
	}

	// 商品上下架 --------------------------------------------------------------------------------
	public function update_product_status($id)
	{
		$this->data['product'] = $this->mysql_model->_select('product', 'product_id', $id);
		foreach ($this->data['product'] as $row) {
			if ($row['product_status'] == 1) {
				$product_status = 2;
			} else {
				$product_status = 1;
			}
		}
		$data = array(
			'product_status' => $product_status,
		);
		$this->db->where('product_id', $id);
		$this->db->update('product', $data);
		redirect(base_url() . 'admin/product');
	}

	// 其他功能 ---------------------------------------------------------------------------------
	public function get_product_info()
	{
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

	// 商品分類 ---------------------------------------------------------------------------------
	public function category()
	{
		$this->data['page_title'] = '商品分類';
		$this->data['category'] = $this->mysql_model->_select('product_category');

		$this->render('admin/product/category/index');
	}

	public function insert_category()
	{
		$this->data['page_title'] = '新增商品分類';
		$product_category_name = $this->input->post('product_category_name');
		$this->data['product_category'] = $this->mysql_model->_select('product_category', 'product_category_name', $product_category_name);
		if ($this->data['product_category'] > 0) {
			$this->session->set_flashdata('message', '新增失敗「名稱重複」');
		} else {
			$data = array(
				'product_category_name' => $product_category_name,
				'creator_id' => $this->current_user->id,
			);
			$this->db->insert('product_category', $data);
			$this->session->set_flashdata('message', '新增成功');
		}
		redirect(base_url() . 'admin/product/category');
	}

	public function edit_category($id)
	{
		$this->data['page_title'] = '編輯商品分類';
		$this->data['category'] = $this->mysql_model->_select('product_category', 'product_category_id', $id, 'row');

		$this->data['delivery'] = $this->mysql_model->_select('delivery', 'delivery_status', '1');
		$this->db->select('delivery_id');
		$this->db->where('source', 'ProductCategory');
		$this->db->where('source_id', $id);
		$this->db->where('status', 1);
		$this->data['use_delivery_list'] = $this->db->get('delivery_range_list')->result_array();

		$this->render('admin/product/category/edit');
	}

	public function update_category($id)
	{
		$data = array(
			'product_category_name' => $this->input->post('product_category_name'),
			'updater_id' => $this->current_user->id,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->db->where('product_category_id', $id);
		$this->db->update('product_category', $data);

		// 刪除配送方式
		$this->db->where('source', 'ProductCategory');
		$this->db->where('source_id', $id);
		$this->db->delete('delivery_range_list');
		$delivery = $this->input->post('delivery');
		if (count($delivery) > 0) {
			// 新增配送方式
			for ($i = 0; $i < count($delivery); $i++) {
				$insertData = array(
					'delivery_id' => $delivery[$i],
					'source' => 'ProductCategory',
					'source_id' => $id,
				);
				$this->db->insert('delivery_range_list', $insertData);
			}
		}

		redirect(base_url() . 'admin/product/category');
	}

	public function delete_category($id)
	{
		$this->db->where('product_category_id', $id);
		$this->db->delete('product_category');

		redirect(base_url() . 'admin/product/category');
	}

	// 加購功能 ---------------------------------------------------------------------------------
	public function add_on_group()
	{
		$this->data['page_title'] = '加購項目';
		$this->data['add_on_group'] = $this->mysql_model->_select('product_add_on_group');
		$this->render('admin/product/add_on_group/index');
	}

	public function insert_add_on_group()
	{
		$this->data['page_title'] = '新增加購項目';
		$product_group_name = $this->input->post('product_group_name');
		$this->data['product_add_on_group'] = $this->mysql_model->_select('product_add_on_group', 'product_group_name', $product_group_name);
		if ($this->data['product_add_on_group'] > 0) {
			$this->session->set_flashdata('message', '新增失敗「名稱重複」');
		} else {
			$data = array(
				'product_group_name' => $this->input->post('product_group_name'),
			);
			$this->db->insert('product_add_on_group', $data);
			$this->session->set_flashdata('message', '新增成功');
		}
		redirect(base_url() . 'admin/product/add_on_group');
	}

	public function edit_add_on_group($id)
	{
		$this->data['page_title'] = '編輯加購項目';
		if (!empty($id)) {
			$this->data['add_on_group'] = $this->mysql_model->_select('product_add_on_group', 'id', $id, 'row');
		}
		$this->render('admin/product/add_on_group/edit');
	}

	public function update_add_on_group($id)
	{
		$data = array(
			'product_group_name' => $this->input->post('product_group_name'),
			// 'updater_id' => $this->current_user->id,
			// 'updated_at' => date('Y-m-d H:i:s'),
		);
		$this->db->where('product_group_id', $id);
		$this->db->update('product_add_on_group', $data);

		redirect(base_url() . 'admin/product/add_on_group');
	}

	public function delete_add_on_group($id)
	{
		$this->db->where('product_group_id', $id);
		$this->db->delete('product_add_on_group');

		redirect(base_url() . 'admin/product/add_on_group');
	}
}
