<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	protected $data = array();
	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->helper('custom');
		$this->load->helper('general');
		$this->load->helper('product');
		$this->load->model('mysql_model');
		$this->load->model('posts_model');
		$this->load->model('product_model');
		$this->data['page_title'] = get_setting_general('name');

		$this->is_liqun_food = (strpos(base_url(), 'liqun-food') !== false ? true : false);
		$this->is_td_stuff = (strpos(base_url(), 'td-stuff') !== false ? true : false);
		$this->is_partnertoys = (strpos(base_url(), 'partnertoys') !== false ? true : false);
	}

	protected function render($the_view = NULL, $template = 'master')
	{
		$this->data['agentID'] = ($this->session->userdata('agent_id') != '' ? $this->session->userdata('agent_id') : $this->input->get('aid'));
		$this->data['post_category'] = $this->posts_model->getPostCategoryId();
		$this->data['product_category'] = $this->product_model->get_product_category();
		if ($template == 'json' || $this->input->is_ajax_request()) {
			header('Content-Type: application/json');
			echo json_encode($this->data);
		} elseif (is_null($template)) {
			$this->load->view($the_view, $this->data);
		} else {
			$this->data['the_view_content'] = (is_null($the_view)) ? '' : $this->load->view($the_view, $this->data, TRUE);
			if ($this->is_partnertoys && $template == 'master') {
				$template = 'partnertoys';
			}
			if ($this->is_liqun_food && $template == 'master') {
				$template = 'liqun';
			}
			$this->load->view('templates/' . $template . '_view', $this->data);
		}
	}
}
