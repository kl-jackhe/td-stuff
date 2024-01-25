<?php defined('BASEPATH') or exit('No direct script access allowed');

class Product extends Public_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index($id = 1)
	{

		$data = array();
		//total rows count
		$conditions['returnType'] = 'count';
		$totalRec = $this->product_model->getProducts($conditions);
		//pagination configuration
		$config['target'] = '#data';
		$config['base_url'] = base_url() . 'product/ajaxData';
		// $config['total_rows'] = $totalRec;
		// $config['per_page'] = $this->perPage;
		$config['link_func'] = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		//get the posts data
		$this->data['products'] = $this->product_model->getProducts();
		// $this->data['product_category'] = $this->product_model->get_product_category();

		if ($this->is_td_stuff) {
			$this->data['page_title'] = '商品頁面';
			$this->render('product/index');
		}
		if ($this->is_liqun_food) {
			$this->data['page_title'] = '商品頁面';
			$this->data['product_category'] = $this->product_model->get_product_category();
			$this->render('product/liqun/index');
		}
		if ($this->is_partnertoys) {
			$this->data['page_title'] = '夥伴商城';
			$this->data['current_page'] = $id;

			// 處理上下架時間
			$this->data['products'] = $this->product_model->getInTimeProducts();
			foreach ($this->data['products'] as $key => &$product) {
				// 現在的時間
				$now = new DateTime();
				$now = $now->format('Y-m-d H:i:s');

				// none setting
				$noneSetting = "0000-00-00 00:00:00";

				// 將字串轉換為 DateTime 物件
				$distributeAt = $product['distribute_at'];
				$discontinuedAt = $product['discontinued_at'];

				// 檢查是否在時間範圍內
				if (
					($distributeAt <= $now && $discontinuedAt > $now) ||
					($distributeAt == $noneSetting && $discontinuedAt == $noneSetting) ||
					($distributeAt == $noneSetting && $discontinuedAt > $now) ||
					($distributeAt <= $now && $discontinuedAt == $noneSetting)
				) {
					// 在時間範圍內，可以保留該項目
					// echo "<pre>";
					// print_r($product['product_name'] . ' pass ' . $discontinuedAt . '->' . $now . '=>' . ($distributeAt <= $now));
					// echo "</pre>";
				} else {
					// 不在時間範圍內，移除該項目
					unset($this->data['products'][$key]);
					// echo "<pre>";
					// print_r($product['product_name'] . 'unpass');
					// echo "</pre>";
				}
			}

			// 重新索引數組鍵，以確保數組的鍵是連續的
			$this->data['products'] = array_values($this->data['products']);

			$this->data['product_category'] = $this->menu_model->getSubMenuData(0, 1);
			$this->data['productCombine'] = $this->product_model->getProductCombine();
			$this->data['productCombineItem'] = $this->product_model->getProductCombineItem();
			$this->render('product/partnertoys_index');
		}
	}

	public function product_detail($product_id = null)
	{
		$this->data['page_title'] = '商品詳情';

		$this->data['product_category'] = $this->menu_model->getSubMenuData(0, 1);

		$this->data['product'] = $this->product_model->getSingleProduct($product_id);
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');

		// none setting
		$noneSetting = "0000-00-00 00:00:00";

		// 將字串轉換為 DateTime 物件
		$distributeAt = $this->data['product']['distribute_at'];
		$discontinuedAt = $this->data['product']['discontinued_at'];

		// 確認是否在上架期間
		if (
			($distributeAt <= $now && $discontinuedAt > $now) ||
			($distributeAt == $noneSetting && $discontinuedAt == $noneSetting) ||
			($distributeAt == $noneSetting && $discontinuedAt > $now) ||
			($distributeAt <= $now && $discontinuedAt == $noneSetting)
		) {
			// 在時間範圍內，可以保留該項目
		} else {
			// 不在時間範圍內，移除該項目
			return false;
		}


		// 找category_name
		foreach ($this->data['product_category'] as $self) {
			if ($self['sort'] == $this->data['product']['product_category_id']) {
				$this->data['product_category_name'] = $self['name'];
			}
		}
		// echo '<pre>';
		// print_r($this->data['product_category']);
		// echo '</pre>';

		$this->data['productCombine'] = $this->product_model->getProduct_Combine($product_id);

		$this->data['instructions'] = $this->auth_model->getStandardPageList('LogisticsAndPayment');

		$tmp = array();
		if (!empty($this->data['productCombine'])) {
			foreach ($this->data['productCombine'] as $self) {
				$tmp[] = [
					'id' =>  $self['id'],
					'name' => $self['name'],
					'current_price' => $self['current_price'],
					'description' => $self['description'],
					'limit_enable' => $self['limit_enable'],
					'limit_qty' => $self['limit_qty']
				];
			}
		}
		$this->data['combineName'] = $tmp;

		$this->data['productCombineItem'] = $this->product_model->get_product_combine_item($product_id);
		$this->render('product/product-detail');
	}

	function get_like()
	{
		$all_cookies = $this->input->cookie();
		$filtered_cookies = preg_grep('/^prefix_like_\d+$/', array_keys($all_cookies));
		$result = array(); // 用於存儲所有數據

		if (!empty($filtered_cookies)) {
			foreach ($filtered_cookies as $cookie_name) {
				$value = $all_cookies[$cookie_name];
				$decoded_value = json_decode($value, true);
				$result[] = $decoded_value; // 將數據添加到結果數組中
			}
		}

		// 返回所有數據
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	function add_like()
	{
		// 獲取所有的 cookie
		// $all_cookies = $this->input->cookie();
		// echo '<pre>';
		// print_r($all_cookies);
		// echo '</pre>';

		$combine_id = $this->input->post('combine_id');
		if (!empty($combine_id)) {
			$selectedCombine = $this->product_model->getProductCombine($combine_id);
			$selectedProduct = $this->product_model->getSingleProduct($selectedCombine['product_id']);

			// check repetity
			// 獲取所有的 cookie
			$all_cookies = $this->input->cookie();
			$filtered_cookies = preg_grep('/^prefix_like_\d+$/', array_keys($all_cookies));

			// 遍歷所有的 cookie
			if (!empty($filtered_cookies)) {
				foreach ($filtered_cookies as $cookie_name) {
					$value = $all_cookies[$cookie_name];
					$decoded_value = json_decode($value, true);
					if (!empty($decoded_value)) {
						// 檢查是否有相同 product_id 的 cookie
						if ($decoded_value['product_id'] == $selectedProduct['product_id']) {
							echo 'repetity';
							return;
						}
					}
				}
			}

			if (!empty($selectedCombine) && !empty($selectedProduct)) {
				$cookie_data = array(
					'name'          => 'like_' . $selectedProduct['product_id'], // 為每個產品建立唯一的 cookie 名稱
					'value'         => json_encode(array(
						'user_id'       => $this->session->userdata('user_id'),
						'product_id'    => $selectedProduct['product_id'],
						'product_name'  => $selectedProduct['product_name'],
						'product_image' => $selectedProduct['product_image'],
					)),
					'expire'        => time() + 31536000, // 1年後過期
					'domain'        => '', // 可以留空，由瀏覽器自動判斷
					'path'          => '/',
					'prefix'        => 'prefix_',
					'secure'        => TRUE,
				);
				$this->input->set_cookie($cookie_data);
				echo 'successful';
				return;
			}
		} else {
			echo 'unsuccessful';
			return;
		}
	}

	function delect_like($id)
	{
		// 設定 cookie 的過期時間為過去的時間
		$cookie_data = array(
			'name'   => 'like_' . $id,
			'value'  => json_encode(''),
			'expire' => time() - (31536000 * 10), // 過去的時間
			'domain' => '', // 可以留空，由瀏覽器自動判斷
			'path'   => '/',
			'prefix' => 'prefix_',
			'secure' => TRUE,
		);

		$this->input->set_cookie($cookie_data);
		// $all_cookies = $this->input->cookie();
		// echo '<pre>';
		// print_r($all_cookies);
		// echo '</pre>';

		echo "successful";
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
		$product_category = $this->input->get('product_category');

		$product_category_list = array();
		$product_category_list[] = $product_category;
		$count = 0;
		$isParentAvailable = true;
		while ($isParentAvailable) {
			$this->db->select('product_category_id');
			$this->db->where('product_category_parent', $product_category_list[$count]);
			$query = $this->db->get('product_category')->result_array();
			if (!empty($query)) {
				foreach ($query as $row) {
					$product_category_list[] = $row['product_category_id'];
				}
			} else {
				$isParentAvailable = false;
				break;
			}
			$count++;
			if ($count == 100) {
				$isParentAvailable = false;
				break;
			}
		}

		if (!empty($keywords)) {
			$conditions['search']['keywords'] = $keywords;
		}
		if (!empty($product_category)) {
			$conditions['search']['product_category_id'] = $product_category_list;
		}
		//total rows count
		$conditions['returnType'] = 'count';
		$totalRec = $this->product_model->getProducts($conditions);
		//pagination configuration
		$config['target'] = '#data';
		$config['base_url'] = base_url() . 'product/ajaxData';
		// $config['total_rows'] = $totalRec;
		// $config['per_page'] = $this->perPage;
		$config['link_func'] = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		//set start and limit
		$conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		//get posts data
		$conditions['returnType'] = '';
		$this->data['products'] = $this->product_model->getProducts($conditions);
		//load the view
		$this->load->view('product/ajax-data', $this->data, false);
	}

	public function view($id = 0)
	{
		if ($id == 0) {
			redirect(base_url() . 'product');
		}
		$this->data['product'] = $this->product_model->getSingleProduct($id);
		$this->data['specification'] = $this->product_model->getProduct_Specification($id);
		$this->data['product_combine'] = $this->mysql_model->_select('product_combine', 'product_id', $id);
		$this->data['product_combine_item'] = $this->mysql_model->_select('product_combine_item', 'product_id', $id);
		$this->data['page_title'] = $this->data['product']['product_name'];
		if ($this->is_liqun_food) {
			$this->render('product/liqun/view');
		} else {
			$this->render('product/view');
		}
	}
}
