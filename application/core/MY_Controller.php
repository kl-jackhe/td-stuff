<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	protected $data = array();
	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->helper('custom');
		$this->load->model('mysql_model');
		$this->data['page_title'] = get_setting_general('name');
	}

	protected function render($the_view = NULL, $template = 'master')
	{
		if($template == 'json' || $this->input->is_ajax_request())
		{
			header('Content-Type: application/json');
			echo json_encode($this->data);
		}
		elseif(is_null($template))
		{
			$this->load->view($the_view,$this->data);
		}
		else
		{
			$this->data['the_view_content'] = (is_null($the_view)) ? '' : $this->load->view($the_view, $this->data, TRUE);
			$this->load->view('templates/' . $template . '_view', $this->data);
		}
	}
}

class Admin_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in())
		{
			redirect('admin/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin())
		{
			redirect(base_url(), 'refresh');
		}
		$this->load->library('Ajax_pagination_admin');
		$this->data['current_user'] = $this->ion_auth->user()->row();
		$this->data['admin_user_menu'] = '';
		$this->perPage = get_setting_general('per_page');
		$this->data['decimal_point'] = get_decimal_point();
		$this->lang->load('general', 'zh_tw');
		// if($this->ion_auth->in_group('admin'))
		// {
		// 	$this->data['admin_user_menu'] = $this->load->view('templates/_parts/admin_user_menu_view.php', NULL, TRUE);
		// }
		$this->data['include_style'] = $this->load->view('templates/_parts/style.php', NULL, TRUE);
		$this->data['include_script'] = $this->load->view('templates/_parts/script.php', NULL, TRUE);
		$this->data['admin_navbar_menu'] = $this->load->view('templates/_parts/admin_navbar_menu_view.php', NULL, TRUE);
		$this->data['admin_sidebar_menu'] = $this->load->view('templates/_parts/admin_sidebar_menu_view.php', $this->data, TRUE);
	}
	protected function render($the_view = NULL, $template = 'admin_master')
	{
		parent::render($the_view, $template);
	}
}

class Public_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		if(strpos($_SERVER['HTTP_HOST'],'localhost') !== false){
			//
		} else {
			if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
			    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			    header('HTTP/1.1 301 Moved Permanently');
			    header('Location: ' . $location);
			    exit;
			}
		}
		// if (!$this->ion_auth->logged_in())
		// {
		// 	$this->session->sess_destroy();
		// 	redirect('login', 'refresh');
		// }
        // $this->data['current_user'] = $this->ion_auth->user()->row();
        $this->load->library('Ajax_pagination');
        $this->data['admin_user_menu'] = '';
        // if ($this->ion_auth->logged_in()) {
        if(!empty($this->session->userdata('user_id'))){
        	$this->data['address'] = $this->mysql_model->_select('users_address', 'user_id', $this->session->userdata('user_id'));
        }
        // }
        $this->perPage = get_setting_general('per_page');

        if($this->input->get('botID')){
	        $data = array(
	           'botID' => $this->input->get('botID'),
	        );
	        $this->session->set_userdata($data);
        }

		$this->data['include_style'] = $this->load->view('templates/_parts/style.php', NULL, TRUE);
		$this->data['include_script'] = $this->load->view('templates/_parts/script.php', NULL, TRUE);
	}
}