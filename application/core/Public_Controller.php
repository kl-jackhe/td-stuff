<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Public_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		// if(strpos($_SERVER['HTTP_HOST'],'localhost') !== false){
		// 	//
		// } else {
		// 	if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
		// 	    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		// 	    header('HTTP/1.1 301 Moved Permanently');
		// 	    header('Location: ' . $location);
		// 	    exit;
		// 	}
		// }

        $this->load->library('Ajax_pagination');
        $this->data['current_user'] = $this->ion_auth->user()->row();
        $this->data['admin_user_menu'] = '';

        $this->current_user = $this->data['current_user'];

        $this->perPage = get_setting_general('per_page');

        $this->session_id = '';
        if(!empty(get_cookie("session_id", true)) || get_cookie("session_id", true)!=''){
            $this->session_id = get_cookie("session_id", true);
		} else {
			$session_id = get_random_string(10);
			set_cookie("session_id", $session_id, 30 * 86400);
			$this->session_id = $session_id;
		}

		$this->my_cart = array(
			'items' => array(),
			'subtotal' => 0
		);
		$total=0;
		$this->db->where('session_id', $this->session_id);
		$query = $this->db->get('cart');
		if ($query->num_rows() > 0) {
			$this->my_cart['items'] = $query->result_array();
			foreach ($query->result_array() as $item) {
				$total+=$item['qty']*$item['price'];
			}
		}
		$this->my_cart['subtotal'] = $total;

		$this->data['include_style'] = $this->load->view('templates/_parts/style.php', NULL, TRUE);
		$this->data['include_script'] = $this->load->view('templates/_parts/script.php', NULL, TRUE);
	}
}