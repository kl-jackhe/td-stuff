<?php defined('BASEPATH') or exit('No direct script access allowed');
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
        $data['page_title'] = '最新消息';

        // get news data
        $data['news_data'] = $this->latestNews_model->get_news_data();

        // get news_kind data
        $data['news_kind_data'] = $this->latestNews_model->get_news_kind_data();

        // set session
        $data['agentID'] = ($this->session->userdata('agent_id') != '' ? $this->session->userdata('agent_id') : $this->input->get('aid'));

        // transport frame
        $data['the_view_content'] = $this->load->view('latestNews/index', $data, TRUE);

        // called frame
        $this->load->view('templates/partnertoys_view', $data);

    }
}
