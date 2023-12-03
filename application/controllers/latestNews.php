<?php
class LatestNews extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();

        // 載入 CodeIgniter 提供的輔助函數
        $this->load->helper('url');

        //接到model資料夾內的latestnews_model               
        $this->load->model("latestNews_model");
    }
    public function index()
    {
        // 獲取 news 的資料
        // $this->$data['news_data'] = $this->latestNews_model->get_news_data();

        // 獲取 news_kind 的資料
        // $this->$data['news_kind_data'] = $this->latestNews_model->get_news_kind_data();

		$this->load->view('latestNews/index');
    }
}
