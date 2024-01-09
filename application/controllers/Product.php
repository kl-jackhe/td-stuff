<?php defined('BASEPATH') or exit('No direct script access allowed');

class Product extends Public_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index($id = 1)
	{
		$this->data['page_title'] = '夥伴商城';

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

		if ($this->is_liqun_food || $this->is_td_stuff) {
			$this->render('product/index');
		}
		if ($this->is_partnertoys) {
			$this->data['current_page'] = $id;
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
		$this->data['productCategory'] = $this->product_model->get_product_category_name($this->data['product']['product_category_id']);

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

					// 檢查是否有相同 product_id 的 cookie
					if ($decoded_value['product_id'] == $selectedProduct['product_id']) {
						echo 'repetity';
						return;
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
					'expire'        => strtotime('+1 year'), // 1年後過期
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
		$this->render('product/view');
	}
}
