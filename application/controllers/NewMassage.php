<?php defined('BASEPATH') or exit('No direct script access allowed');

class NewMassage extends Public_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('newmessage_model');
    }

    public function get_news($slug = FALSE)
    {
        if ($slug === FALSE) {
            $query = $this->db->get('news');
            return $query->result_array();
        }

        $query = $this->db->get_where('news', array('slug' => $slug));
        return $query->row_array();
    }
}
