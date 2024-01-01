<?php defined('BASEPATH') or exit('No direct script access allowed');
class Cargo_intro extends Public_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->data['page_title'] = '產品介紹';
        $this->data['cargo_category'] = $this->menu_model->getSubMenuData(0, 7);
        $this->data['cargo_son_category'] = $this->menu_model->getSubSonMenuData(7);
        $this->render('cargo_intro/partnertoys_index');
    }
}
