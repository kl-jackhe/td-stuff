<?php defined('BASEPATH') or exit('No direct script access allowed');
class Product_tag extends Public_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('product_tag_model');
    }

    function index($id = 0)
    {

        // 塞選類別分類
        $current_url = $_SERVER['REQUEST_URI'];
        $query_string = parse_url($current_url, PHP_URL_QUERY);
        $decoded_data = $this->security_url->decryptData($query_string);
        if (!empty($query_string)) {
            if (!empty($decoded_data) && !empty($decoded_data['tag'])) {
                $id = $decoded_data['tag'];
            }
        }

        // echo '<pre>';
        // print_r($id);
        // echo '</pre>';

        $this->data['product_tag'] = $this->product_tag_model->getSelectedProductTag($id);
        $this->data['page_title'] = $this->data['product_tag']['name'];

        $tag_arr = array();
        $selected = $this->product_tag_model->getTagsProductID($id);
        if (!empty($selected)) {
            foreach ($selected as $self) {
                $tag_arr[] = $this->product_model->getSingleProduct($self['product_id']);
            }
        }
        $this->data['products'] = $tag_arr;

        $this->render('product_tag/liqun/index');
    }
}
