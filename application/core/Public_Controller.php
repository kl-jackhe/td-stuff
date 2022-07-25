<?php defined('BASEPATH') OR exit('No direct script access allowed');

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

		$this->data['include_style'] = $this->load->view('templates/_parts/style.php', NULL, TRUE);
		$this->data['include_script'] = $this->load->view('templates/_parts/script.php', NULL, TRUE);
	}
}