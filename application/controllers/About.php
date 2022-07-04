<?php defined('BASEPATH') OR exit('No direct script access allowed');

class About extends Public_Controller {

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['page_title'] = '關於我們';
        $this->render('about/index');
    }

    public function brand()
    {
        $this->data['page_title'] = '品牌介紹';
        $this->data['about'] = $this->mysql_model->_select('about','about_target','brand','row');
        $this->render('about/brand');
    }

    public function history()
    {
        $this->data['page_title'] = '創業故事';
        $this->data['about'] = $this->mysql_model->_select('about','about_target','history','row');
        $this->render('about/history');
    }

    public function team()
    {
        $this->data['page_title'] = '車隊介紹';
        $this->data['about'] = $this->mysql_model->_select('about','about_target','team','row');
        $this->render('about/team');
    }

    public function shop_alliance()
    {
        $this->data['page_title'] = '店家合作';
        $this->data['about'] = $this->mysql_model->_select('about','about_target','shop_alliance','row');
        $this->render('about/shop_alliance');
    }

    public function cross_industry_alliance()
    {
        $this->data['page_title'] = '異業合作';
        $this->data['about'] = $this->mysql_model->_select('about','about_target','cross_industry_alliance','row');
        $this->render('about/cross_industry_alliance');
    }

    public function how_to_buy()
    {
        $this->data['page_title'] = '收費方式';
        $this->data['about'] = $this->mysql_model->_select('about','about_target','how_to_buy','row');
        $this->render('about/how_to_buy');
    }

    public function privacy_policy()
    {
        $this->data['page_title'] = '隱私權保護政策';
        $this->data['about'] = $this->mysql_model->_select('about','about_target','privacy_policy','row');
        $this->load->view('about/privacy_policy', $this->data);
        // $this->render('about/privacy_policy');
    }

    public function rule()
    {
        $this->data['page_title'] = '使用條款與條件';
        $this->data['about'] = $this->mysql_model->_select('about','about_target','rule','row');
        $this->load->view('about/rule', $this->data);
        // $this->render('about/rule');
    }

    public function contact()
    {
        $this->data['page_title'] = '聯絡我們';
        $this->render('about/contact');
    }

}