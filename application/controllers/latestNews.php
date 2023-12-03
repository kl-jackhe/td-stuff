<?php
defined('BASEPATH') or exit('No direct script access allowed');
class LatestNews extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();

        //接到model資料夾內的latestnews_model               
        $this->load->model("latestNews_model");
    }
    public function index()
    {
        $this->data['page_title'] = '最新消息';

        // 獲取 news 的資料
        $data['news_data'] = $this->latestNews_model->get_news_data();

        // 獲取 news_kind 的資料
        $data['news_kind_data'] = $this->latestNews_model->get_news_kind_data();

        // return references
        $this->load->view('latestNews/index', $data);

        // 呼叫框架
        $this->render('latestNews/index');
    }
}
