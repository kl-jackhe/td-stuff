<?php defined('BASEPATH') or exit('No direct script access allowed');
class Channels extends Public_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index(){
        $this->data['page_title'] = '經銷通路';
        $this->data['channels_category'] = $this->menu_model->getSubMenuData(0, 5);
		$this->render('channels/partnertoys_index');
    }

    function selected_son($id)
    {
        $data = $this->menu_model->getSubSonMenuData($id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
