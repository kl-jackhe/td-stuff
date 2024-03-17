<?php defined('BASEPATH') or exit('No direct script access allowed');
class LanguageSelector extends Public_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('language_model');
    }

    function language_switch()
    {
        $lang = $this->input->post('lang');
        $title = $this->input->post('title');
        $data = $this->language_model->getLanguageData($lang, $title);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
        return;
    }
}
