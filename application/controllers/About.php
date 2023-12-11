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
		if ($this->is_liqun_food || $this->is_td_stuff) {
			$this->data['page_title'] = '關於' . get_setting_general('name');
			$this->load->view('pages/about', $this->data);
		}

		if ($this->is_partnertoys) {
			$this->render('about/partnertoys_index');
		}
	}
}
