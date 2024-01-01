<?php defined('BASEPATH') or exit('No direct script access allowed');
class Cargo_intro extends Public_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index(){
        $this->data['page_title'] = '產品介紹';
		$this->render('artist/partnertoys_index');
    }
}
