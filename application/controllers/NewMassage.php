<?php defined('BASEPATH') or exit('No direct script access allowed');

class NewMassage extends Public_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('newmessage_model');
    }

    public function index()
    {
        echo "test";
        return true;
    }
}
