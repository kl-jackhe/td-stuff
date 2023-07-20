<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SalesManage extends Admin_Controller {

	function __construct() {
		parent::__construct();
	}

    function index()
    {
        $this->data['page_title'] = 'SalesManage';
        $this->render('admin/sales_manage/index');
    }

    function createSalesPage() {

    }

    function editSalesPage() {

    }

    function updateSalesPage() {

    }
}