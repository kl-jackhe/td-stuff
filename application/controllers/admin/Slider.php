<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends Public_Controller {

    public function __construct() {
        Parent::__construct();
    }

    public function index()
    {
        $this->data['page_title'] = '行事曆';
        $this->render('calendar/index');
    }

    public function food()
    {
        $this->data['page_title'] = '餐點輪播';
        $this->data['slider'] = $this->mysql_model->_select('cart_slider','cart_slider_type','food','result','','cart_slider_sort','asc');
        //$this->data['slider'] = $this->mysql_model->_select('cart_slider');
        $this->load->view('pos/food_cart',$this->data);
    }

    public function drink()
    {
        $this->data['page_title'] = '飲料輪播';
        $this->data['slider'] = $this->mysql_model->_select('cart_slider','cart_slider_type','drink','result','','cart_slider_sort','asc');
        //$this->data['slider'] = $this->mysql_model->_select('cart_slider');
        $this->load->view('pos/drink_cart',$this->data);
    }

}