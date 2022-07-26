<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['page_title'] = '控制台';
        $this->render('admin/dashboard/index');
    }

    public function checkSession()
    {
        echo 1;
    }

}