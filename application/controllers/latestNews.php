<?php
class LatestNews extends Public_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("latestnews_model");     //接到model資料夾內的latestnews_model
    }
    public function index() {
        $this->load->view("latestNews/index");      //接到views資料夾內的latestNews/index.php
    }
}
?>