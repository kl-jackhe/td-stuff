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

        // 類別分類
        $this->data['category'] = '';

        // 获取当前 URL
        $current_url = $_SERVER['REQUEST_URI'];

        // 使用 parse_url() 解析 URL 获取查询字符串部分
        $query_string = parse_url($current_url, PHP_URL_QUERY);

        // 对参数进行解码以获取您想要的内容
        $decoded_data = $this->security_url->decryptData($query_string);

        // 如果查询字符串不为空
        if (!empty($query_string)) {
            if (!empty($decoded_data) && !empty($decoded_data['category'])) {
                $this->data['category'] = $decoded_data['category'];
            }
        }

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
