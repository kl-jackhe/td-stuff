<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Policy extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->load->helper('cookie');
		$this->data['page_title'] = '制式頁面';
		$this->db->select('id,page_name,page_title,page_info,page_img,page_lang');
	    $this->db->where('page_lang','zh_tw');
	    $this->data['standard_page_list'] = $this->db->get('standard_page_list')->result_array();
		$this->render('policy/index');
	}
}