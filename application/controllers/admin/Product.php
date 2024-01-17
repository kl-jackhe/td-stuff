<?php defined('BASEPATH') or exit('No direct script access allowed');

class Product extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('product_model');
		if ($this->is_liqun_food) {
			$this->load->model('product_tag_model');
		}
	}

	public function index()
	{
		$this->data['page_title'] = '商品管理';
		if ($this->is_partnertoys) {
			$this->data['enable_status'] = $this->product_model->getProductContradiction(1);
		}
		$this->render('admin/product/index');
	}

	function contradiction()
	{
		$status = $this->input->post('status');
		$this->db->select('*');
		$this->db->where('id', 1);
		$query = $this->db->get('contradiction');
		if ($query->num_rows() === 1) {
			$self = $query->row();
			if ($status == '1') {
				$this->db->update('contradiction', ['contradiction_status' => 0], ['id' => $self->id]);
			} else if ($status == '0') {
				$this->db->update('contradiction', ['contradiction_status' => 1], ['id' => $self->id]);
			}
			echo 'successful';
			return;
		} else {
			echo 'unsuccessful';
			return;
		}
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
			// 'product_category_id' => $this->input->post('product_category'),
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

		$product_category_id_list = $this->input->post('product_category');
		if (isset($product_category_id_list) && !empty($product_category_id_list)) {
			for ($i = 0; $i < count($product_category_id_list); $i++) {
				$this->db->select('product_category_id');
				$this->db->where('product_id', $product_id);
				$this->db->where('product_category_id', $product_category_id_list[$i]);
				$pcl_row = $this->db->get('product_category_list')->row_array();
				if (empty($pcl_row)) {
					$this->db->insert('product_category_list', array('product_id' => $product_id, 'product_category_id' => $product_category_id_list[$i]));
				}
			}
		}

		$this->session->set_flashdata('message', '商品建立成功！');
		redirect('admin/product/edit/' . $product_id);
	}

	public function edit($id)
	{
		$this->data['page_title'] = '編輯商品';
		$this->data['product'] = $this->product_model->getSingleProduct($id);
		$this->data['product_unit'] = $this->mysql_model->_select('product_unit', 'product_id', $id);
		$this->data['product_specification'] = $this->product_model->getProduct_Specification($id);
		$this->data['product_combine'] = $this->product_model->getProduct_Combine($id);
		$this->data['product_category'] = $this->mysql_model->_select('product_category');
		$this->data['select_product_category'] = $this->product_model->getSelectProductCategory($id);
		$this->data['delivery'] = $this->mysql_model->_select('delivery', 'delivery_status', '1');
		if ($this->is_liqun_food) {
			$this->data['product_tag'] = $this->product_tag_model->getProductTag();
			$this->data['selected_product_tag'] = $this->product_tag_model->getSelectedProductTagID($id);
		}
		$this->db->select('delivery_id');
		$this->db->where('source', 'Product');
		$this->db->where('source_id', $id);
		$this->db->where('status', 1);
		$this->data['use_delivery_list'] = $this->db->get('delivery_range_list')->result_array();
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
			// 'product_weight' => $this->input->post('product_weight'),
			// 'volume_length' => $this->input->post('volume_length'),
			// 'volume_width' => $this->input->post('volume_width'),
			// 'volume_height' => $this->input->post('volume_height'),
			'product_price' => $this->input->post('product_price'),
			'product_add_on_price' => $this->input->post('product_add_on_price'),
			// 'product_category_id' => $this->input->post('product_category'),
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

		$product_category_id_list = $this->input->post('product_category');
		if (isset($product_category_id_list) && !empty($product_category_id_list)) {
			$this->db->where_not_in('product_category_id', $product_category_id_list);
			$this->db->where('product_id', $id);
			$this->db->delete('product_category_list');
			for ($i = 0; $i < count($product_category_id_list); $i++) {
				$this->db->select('product_category_id');
				$this->db->where('product_id', $id);
				$this->db->where('product_category_id', $product_category_id_list[$i]);
				$pcl_row = $this->db->get('product_category_list')->row_array();
				if (empty($pcl_row)) {
					$this->db->insert('product_category_list', array('product_id' => $id, 'product_category_id' => $product_category_id_list[$i]));
				} else {
				}
			}
		} else {
			$this->db->where('product_id', $id);
			$this->db->delete('product_category_list');
		}

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
		$weight = $this->input->post('weight');
		$volume_length = $this->input->post('volume_length');
		$volume_width = $this->input->post('volume_width');
		$volume_height = $this->input->post('volume_height');
		if (isset($unit) && !empty($unit)) {
			$this->db->where_not_in('unit', $unit);
			$this->db->where('product_id', $id);
			$this->db->delete('product_unit');
			for ($i = 0; $i < count($unit); $i++) {
				if ($unit[$i] != '') {
					$this->db->select('id');
					$this->db->where('product_id', $id);
					$this->db->where('unit', $unit[$i]);
					$this->db->limit(1);
					$pu_row = $this->db->get('product_unit')->row_array();
					$unit_data = array(
						'unit' => $unit[$i],
						'weight' => $weight[$i],
						'volume_length' => $volume_length[$i],
						'volume_width' => $volume_width[$i],
						'volume_height' => $volume_height[$i],
					);
					if (!empty($pu_row)) {
						$this->db->where('id', $pu_row['id']);
						$this->db->update('product_unit', $unit_data);
					} else {
						$unit_data['product_id'] = $id;
						$this->db->insert('product_unit', $unit_data);
					}
				}
			}
		} else {
			$this->db->where('product_id', $id);
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
		if (isset($delivery) && !empty($delivery)) {
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

		// 標籤處理
		$productTagArray = $this->input->post('product_tag');

		// 檢查是否沒被選標籤
		if (empty($productTagArray)) {
			$this->db->where('product_id', $id);
			$this->db->delete('product_tag_content');
			$this->session->set_flashdata('message', '更新成功');
			echo '<script>window.history.back();</script>';
		}

		if (!empty($productTagArray)) {
			$existingTags = $this->product_tag_model->getTagsProductTagID($id);
			if (!empty($existingTags)) {
				// 去名
				$existingTagIds = array_column($existingTags, 'product_tag_id');
				// 找出需要刪除的標籤
				$tagsToDelete = array_diff($existingTagIds, $productTagArray);

				// 循環遍歷需要刪除的標籤，並刪除對應的數據
				foreach ($tagsToDelete as $tag) {
					$this->db->where('product_tag_id', $tag);
					$this->db->where('product_id', $id);
					$this->db->delete('product_tag_content');
				}
			}

			// 插入未存在標籤
			foreach ($productTagArray as $tag) {
				if (!$this->product_tag_model->isExistProductID($tag, $id)) {
					$data = array(
						'product_tag_id' => $tag,
						'product_id' => $id,
					);
					$this->db->insert('product_tag_content', $data);
				}
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
		if ($this->is_liqun_food) {
			$this->data['cargo_id'] = $this->product_model->getProductCombineCargoId($id);
		}
		$this->load->view('admin/product/create_plan', $this->data);
	}

	function insert_plan()
	{
		$data = array(
			'product_id' => $this->input->post('product_id'),
			'cargo_id' => $this->input->post('product_combine_cargo_id'),
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
		if ($this->is_liqun_food) {
			$this->data['cargo_id'] = $this->product_model->getProductCombineCargoId($product_id);
		}
		$this->load->view('admin/product/edit_plan', $this->data);
	}

	function update_plan($id)
	{
		$this->data['product_combine'] = $this->mysql_model->_select('product_combine', 'id', $id, 'row');

		$update_data = array(
			'product_id' => $this->input->post('product_id'),
			'cargo_id' => $this->input->post('product_combine_cargo_id'),
			'name' => $this->input->post('product_combine_name'),
			'price' => $this->input->post('product_combine_price'),
			'current_price' => $this->input->post('product_combine_current_price'),
			'picture' => $this->input->post('product_combine_image'),
			'description' => $this->input->post('product_combine_description'),
			'type' => $this->input->post('any_specification'),
			'limit_enable' => $this->input->post('limit_enable'),
			'limit_qty' => $this->input->post('limit_qty'),
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

		$this->db->where('product_id', $id);
		$this->db->delete('product_category_list');

		$this->db->where('product_id', $id);
		$this->db->delete('product_unit');

		$this->db->where('product_id', $id);
		$this->db->delete('product_combine');

		$this->db->where('product_id', $id);
		$this->db->delete('product_combine_item');

		$this->db->where('product_id', $id);
		$this->db->delete('product_specification');

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
		redirect(base_url() . 'admin/product/edit/' . $id);
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
		if (!empty($this->product_model->checkProductCategoryNameIsExist($product_category_name))) {
			$this->session->set_flashdata('message', '新增失敗「名稱重複」');
		} else {
			$data = array(
				'product_category_parent' => $this->input->post('product_category_parent'),
				'product_category_name' => $product_category_name,
				'product_category_sort' => $this->input->post('product_category_sort'),
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
			'product_category_parent' => $this->input->post('product_category_parent'),
			'product_category_name' => $this->input->post('product_category_name'),
			'product_category_sort' => $this->input->post('product_category_sort'),
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
		if (isset($delivery) & !empty($delivery)) {
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

		$this->db->where('product_category_id', $id);
		$this->db->delete('product_category_list');

		$this->db->where('product_category_id', $id);
		$this->db->update('product', array('product_category_id' => 0));

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

	// 標籤功能 ---------------------------------------------------------------------------------
	public function product_tag()
	{
		$this->data['page_title'] = '商品標籤';
		$this->data['product_tag'] = $this->product_tag_model->getProductTag();
		$this->data['product_tag_content'] = $this->mysql_model->_select('product_tag_content');

		$this->render('admin/product/product_tag/index');
	}

	public function insert_tag()
	{
		$this->data['page_title'] = '新增商品標籤';
		$data = array(
			'name' => $this->input->post('product_tag_name'),
			'sort' => $this->input->post('product_tag_sort'),
		);
		$this->db->insert('product_tag', $data);
		$this->session->set_flashdata('message', '新增成功');

		echo '<script>window.history.back();</script>';
	}

	public function edit_tag($id)
	{
		$this->data['page_title'] = '編輯商品標籤';
		$this->data['total_product_tag'] = $this->mysql_model->_select('product_tag');
		$this->data['product_tag'] = $this->mysql_model->_select('product_tag', 'id', $id, 'row');
		$this->data['products'] = $this->product_model->getProducts();
		$this->data['selected_products'] = $this->product_tag_model->getSelectedProductID($id);

		$this->render('admin/product/product_tag/edit');
	}

	public function update_tag($id)
	{
		$data = array(
			'name' => $this->input->post('product_tag_name'),
			// 'code' => $this->input->post('product_tag_code'),
			'sort' => $this->input->post('product_tag_sort'),
			'status' => $this->input->post('product_tag_status'),
		);

		$this->db->where('id', $id);
		$this->db->update('product_tag', $data);



		$productTagArray = $this->input->post('product_tag');

		// 檢查資料庫是否沒對應標籤之商品
		if (!$this->product_tag_model->tagContentIsNull($id) && !empty($productTagArray)) {
			$this->session->set_flashdata('message', '更新成功');
			echo '<script>window.history.back();</script>';
		}

		// 檢查資料庫是否沒被選標籤
		if (empty($productTagArray)) {
			$this->db->where('product_tag_id', $id);
			$this->db->delete('product_tag_content');
			$this->session->set_flashdata('message', '更新成功');
			echo '<script>window.history.back();</script>';
		}

		if (!empty($productTagArray)) {
			$existingTags = $this->product_tag_model->getTagsProductID($id);
			if (!empty($existingTags)) {
				// 去名
				$existingTagIds = array_column($existingTags, 'product_id');

				// echo "<pre>";
				// print_r($productTagArray);
				// echo "</pre>";
				// echo "<pre>";
				// print_r($existingTags);
				// echo "</pre>";
				// echo "<pre>";
				// print_r($existingTagIds);
				// echo "</pre>";


				// 找出需要刪除的標籤
				$tagsToDelete = array_diff($existingTagIds, $productTagArray);

				// 循環遍歷需要刪除的標籤，並刪除對應的數據
				foreach ($tagsToDelete as $tag) {
					$this->db->where('product_tag_id', $id);
					$this->db->where('product_id', $tag);
					$this->db->delete('product_tag_content');
				}
			}

			// 插入未存在標籤
			foreach ($productTagArray as $tag) {
				if (!$this->product_tag_model->isExistProductID($id, $tag)) {
					$data = array(
						'product_tag_id' => $id,
						'product_id' => $tag,
					);
					$this->db->insert('product_tag_content', $data);
				}
			}
			$this->session->set_flashdata('message', '更新成功');
			echo '<script>window.history.back();</script>';
		}
	}

	public function delete_tag($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('product_tag');

		$this->db->where('product_tag_id', $id);
		$this->db->delete('product_tag_content');

		$this->session->set_flashdata('message', '刪除成功');
		echo '<script>window.history.back();</script>';
	}
}
