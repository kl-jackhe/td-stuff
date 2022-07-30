<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('home_model');
		$this->load->model('product_model');
	}

	public function index() {
		$this->load->helper('cookie');
		$this->data['page_title'] = '首頁';
		$this->data['products'] = $this->product_model->getHomeProducts();
		$this->data['banner'] = $this->home_model->GetBanner();
		$this->render('home/index');
	}

	function send_email() {
		$this->load->library('MY_phpmailer');
		if ($this->my_phpmailer->send('a0935756869@gmail.com', 'Subject', 'Content')) {
			echo '信件已發送。';
		} else {
			echo '無法發送通知信件。';
		}
	}

	function send_email2() {
		$this->load->library('email');
		$this->email->from('service1@bythewaytaiwan.com', get_setting_general('name'));
		$this->email->to('a093575669@gmail.com');
		$this->email->subject('TEST');
		$this->email->message('TEST!!!!!!!');
		if ($this->email->send()) {
			echo '信件已發送。';
		} else {
			echo '無法發送通知信件。';
		}
	}

}