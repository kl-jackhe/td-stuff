<?php defined('BASEPATH') or exit('No direct script access allowed');

class About extends Public_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('about_model');
	}

	public function index()
	{
		$this->data['page_title'] = '關於' . get_setting_general('name');
		if ($this->is_td_stuff) {
			$this->load->view('pages/about', $this->data);
		}
		if ($this->is_liqun_food) {
			$this->render('about/liqun_index');
		}
		if ($this->is_partnertoys) {
			$this->load->model('menu_model');
			$this->data['page_title'] = '關於夥伴';
			$this->data['about_category'] = $this->menu_model->getSubMenuData(0, 2);

			// 類別分類
			$this->data['category'] = '';

			// 获取当前 URL
			$current_url = $_SERVER['REQUEST_URI'];

			// 使用 parse_url() 解析 URL 获取查询字符串部分
			$query_string = parse_url($current_url, PHP_URL_QUERY);

			// 对参数进行解码以获取您想要的内容
			// $decoded_data = $this->security_url->decryptData($query_string);
			$decoded_data = $this->security_url->fixedDecryptData($query_string);

			// 如果查询字符串不为空
			if (!empty($query_string)) {
				if (!empty($decoded_data) && !empty($decoded_data['category'])) {
					$this->data['category'] = $decoded_data['category'];
				}
			}

			$this->render('about/partnertoys/partnertoys_index');
		}
	}
}
