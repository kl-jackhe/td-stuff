<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in())
		{
			redirect('admin/login', 'refresh');
		}

		$accessBackend = false;
		if ($this->ion_auth_model->in_group('admin') && !$accessBackend) {
			$accessBackend = true;
		}
		if ($this->ion_auth_model->in_group('franchisee') && !$accessBackend) {
			$accessBackend = true;
		}
		if (!$accessBackend)
		{
			redirect(base_url(), 'refresh');
		}
		$this->load->library('Ajax_pagination_admin');
		$this->lang->load('general', 'zh_tw');

		$this->data['current_user'] = $this->ion_auth->user()->row();
		$this->data['admin_user_menu'] = '';

		$this->current_user = $this->data['current_user'];

		$this->perPage = get_setting_general('per_page');

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