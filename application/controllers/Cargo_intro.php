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
        $this->render('cargo_intro/partnertoys/partnertoys_index');
    }

    function selected_son($id)
    {
        $data = $this->menu_model->getSubSonMenuData(0, $id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    function selected_sub_son($id)
    {
        $data = $this->menu_model->getSubSubSonMenuData(0, $id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
