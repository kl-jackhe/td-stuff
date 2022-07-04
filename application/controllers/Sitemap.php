<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
    {
        $query = $this->db->get("about");
        $this->data['abouts'] = $query->result();

        $this->load->view('sitemap', $this->data);
    }

}