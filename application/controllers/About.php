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
			$this->render('about/partnertoys_index');
		}
	}
}
